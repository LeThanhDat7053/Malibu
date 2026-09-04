/**
 * AI Translator - Botble CMS Dashboard Integration
 * Single "Translate All" button that translates name, description, content at once.
 */
'use strict';

(function ($) {
    var AiTranslator = {
        config: null,
        initialized: false,
        isBlogPostPage: false,
        isProductPage: false,
        currentModel: null,
        // Translatable fields to detect
        targetFields: ['name', 'title', 'description', 'content', 'custom_html'],

        // Supported models for the generic "Translate All" button
        supportedModels: {
            'Botble\\Hotel\\Models\\Room': { label: 'Room', category: 'hotel' },
            'Botble\\Hotel\\Models\\Amenity': { label: 'Amenity', category: 'hotel' },
            'Botble\\Hotel\\Models\\Service': { label: 'Service', category: 'hotel' },
            'Botble\\Page\\Models\\Page': { label: 'Page', category: 'page' },
            'Botble\\Gallery\\Models\\Gallery': { label: 'Gallery', category: 'gallery' },
            'Botble\\Product\\Models\\Product': { label: 'Product', category: 'product' },
        },

        init: function () {
            this.config = window.aiTranslatorConfig;
            if (!this.config) return;
            if (this.initialized) return;
            this.initialized = true;

            this.isBlogPostPage = this.detectBlogPostPage();
            this.isProductPage = this.detectProductPage();
            this.currentModel = this.detectCurrentModel();

            this.injectButton();
            this.bindEvents();
        },

        hasApiKey: function () {
            return this.config && this.config.hasApiKey;
        },

        detectBlogPostPage: function () {
            var model = $('input[name="model"]').val() || '';
            return model.indexOf('Botble\\Blog\\Models\\Post') !== -1;
        },

        detectProductPage: function () {
            var model = $('input[name="model"]').val() || '';
            if (model.indexOf('Botble\\Product\\Models\\Product') !== -1) {
                return true;
            }

            return window.location.pathname.indexOf('/product/products/') !== -1;
        },

        getCurrentLanguageCode: function () {
            var $languageField = $('[name="language"]').first();
            var currentLanguage = $languageField.val() || '';

            if (!currentLanguage) {
                currentLanguage = $('meta[name="ref_lang"]').attr('content') || '';
            }

            return currentLanguage;
        },

        shouldShowBlogTranslateAll: function () {
            if (!this.isBlogPostPage || !this.config.blogAutoTranslateUrl) {
                return false;
            }

            if (!this.getBlogSourceId()) {
                return false;
            }

            return this.getCurrentLanguageCode() === this.config.defaultSourceLanguage;
        },

        shouldShowProductTranslateAll: function () {
            var isCurrentProductModel = this.currentModel && this.currentModel.type === 'Botble\\Product\\Models\\Product';

            if (!(this.isProductPage || isCurrentProductModel) || !this.config.modelAutoTranslateUrl) {
                return false;
            }

            if (!this.getProductSourceId()) {
                return false;
            }

            return this.getCurrentLanguageCode() === this.config.defaultSourceLanguage;
        },

        /**
         * Detect if current page is editing a supported model (Room, Amenity, Service, Page, Gallery, Product).
         * Returns { type: 'Botble\\...', label: '...', category: '...' } or null.
         */
        detectCurrentModel: function () {
            var modelVal = $('input[name="model"]').val() || '';
            for (var key in this.supportedModels) {
                if (modelVal.indexOf(key) !== -1) {
                    return $.extend({ type: key }, this.supportedModels[key]);
                }
            }

            // Fallback: detect from URL pattern (for models without slug field like Amenity)
            var path = window.location.pathname;
            var urlPatterns = {
                '/hotel/rooms/': 'Botble\\Hotel\\Models\\Room',
                '/hotel/amenities/': 'Botble\\Hotel\\Models\\Amenity',
                '/hotel/services/': 'Botble\\Hotel\\Models\\Service',
                '/pages/': 'Botble\\Page\\Models\\Page',
                '/galleries/': 'Botble\\Gallery\\Models\\Gallery',
                '/product/products/': 'Botble\\Product\\Models\\Product',
            };

            for (var pattern in urlPatterns) {
                if (path.indexOf(pattern) !== -1) {
                    var modelType = urlPatterns[pattern];
                    if (this.supportedModels[modelType]) {
                        return $.extend({ type: modelType }, this.supportedModels[modelType]);
                    }
                }
            }

            return null;
        },

        /**
         * Check if we should show the generic model "Translate All" button.
         */
        shouldShowModelTranslateAll: function () {
            if (!this.currentModel || !this.config.modelAutoTranslateUrl) {
                return false;
            }

            if (this.currentModel.type === 'Botble\\Product\\Models\\Product') {
                return false;
            }

            if (!this.getModelSourceId()) {
                return false;
            }

            return this.getCurrentLanguageCode() === this.config.defaultSourceLanguage;
        },

        /**
         * Get the source model ID (works for any model page).
         */
        getModelSourceId: function () {
            var refFrom = $('input[name="ref_from"]').val() || $('#reference_id').val();
            if (!refFrom) {
                refFrom = $('meta[name="ref_from"]').attr('content');
            }
            if (refFrom && parseInt(refFrom, 10)) return parseInt(refFrom, 10);

            var action = $('form.js-base-form, form.form-edit, form[method="POST"]').first().attr('action') || '';
            var match = action.match(/\/(\d+)(?:\?|$)/);
            return match ? parseInt(match[1], 10) : null;
        },

        /**
         * Detect which translatable fields exist on the current page.
         * Returns array of {name, type} objects.
         */
        detectFields: function () {
            var found = [];
            var self = this;
            this.targetFields.forEach(function (fieldName) {
                var $el = $('[name="' + fieldName + '"]');
                if ($el.length || self.hasEditor(fieldName)) {
                    var type = 'text';
                    if (fieldName === 'content' || fieldName === 'custom_html') {
                        type = 'html';
                    }
                    found.push({ name: fieldName, type: type });
                }
            });
            return found;
        },

        hasEditor: function (fieldName) {
            // Botble CKEditor 5: window.EDITOR.CKEDITOR[fieldName]
            if (window.EDITOR && window.EDITOR.CKEDITOR && window.EDITOR.CKEDITOR[fieldName]) return true;
            // CKEditor 4 fallback
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances[fieldName]) return true;
            // TinyMCE
            if (typeof tinymce !== 'undefined' && tinymce.get(fieldName)) return true;
            return false;
        },

        /**
         * Inject ONE translate button at the top of the form.
         */
        injectButton: function () {
            var self = this;
            var currentRefLang = this.config.currentRefLang;
            var languages = this.config.languages || [];
            var defaultLang = this.config.defaultSourceLanguage;

            // Blog post on source language: inject next to language selector
            if (this.shouldShowBlogTranslateAll()) {
                this.injectBlogLanguageButton();
                setTimeout(function () {
                    AiTranslator.injectBlogLanguageButton();
                }, 1500);
                return;
            }

            if (this.shouldShowProductTranslateAll()) {
                this.injectProductLanguageButton();
                setTimeout(function () {
                    AiTranslator.injectProductLanguageButton();
                }, 1500);
                return;
            }

            // Supported model on source language (Room, Amenity, Service, Page, Gallery):
            // inject a "Translate All Languages" block at the top of the form
            if (this.shouldShowModelTranslateAll()) {
                this.injectModelTranslateAllBlock();
                // Also try to inject next to language box as secondary
                this.injectModelLanguageButton();
                setTimeout(function () {
                    AiTranslator.injectModelLanguageButton();
                }, 1500);
                return;
            }

            // Detect available fields
            var fields = this.detectFields();

            // Even if no fields detected now, still inject (fields will be re-detected on click)

            var fieldList = fields.map(function (f) { return f.name; }).join(', ');

            // Build button/dropdown
            var $btn;
            if (currentRefLang) {
                // Translation page: single direct button (source=default → target=refLang)
                var targetName = '';
                languages.forEach(function (l) {
                    if (l.lang_code === currentRefLang) targetName = l.lang_name;
                });
                $btn = $(
                    '<button type="button" class="btn btn-info btn-sm ai-t-translate-all-btn" ' +
                    'data-source-lang="' + defaultLang + '" data-target-lang="' + currentRefLang + '">' +
                    '<i class="fa fa-language me-1"></i> AI Translate All' +
                    (targetName ? ' → ' + targetName : '') +
                    '</button>'
                );
            } else {
                // Default language page: dropdown to pick target language
                var menuItems = '';
                languages.forEach(function (lang) {
                    if (!lang.lang_is_default) {
                        menuItems += '<li><a class="dropdown-item ai-t-batch-item" href="#" ' +
                            'data-source-lang="' + defaultLang + '" data-target-lang="' + lang.lang_code + '">' +
                            '<i class="fa fa-globe me-1"></i> Translate → ' + lang.lang_name +
                            '</a></li>';
                    }
                });
                if (!menuItems) return;
                $btn = $(
                    '<div class="btn-group">' +
                    '<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown"' +
                    (this.hasApiKey() ? '' : ' disabled') + '>' +
                    '<i class="fa fa-language me-1"></i> AI Translate All' +
                    '</button>' +
                    '<ul class="dropdown-menu dropdown-menu-end">' + menuItems + '</ul>' +
                    '</div>'
                );
            }

            var $block = $(
                '<div class="ai-translator-batch-block mb-3 p-3" ' +
                'style="background: linear-gradient(135deg, #e8f4f8 0%, #f0e6ff 100%); border-radius: 8px; border: 1px solid #d0e8f0;">' +
                '<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">' +
                '<div>' +
                '<strong><i class="fa fa-robot me-1"></i> AI Translator</strong> ' +
                (this.hasApiKey()
                    ? '<span class="text-muted small">Fields: ' + fieldList + '</span>'
                    : '<span class="badge bg-warning text-dark">API Key not configured</span>') +
                '</div>' +
                '<div class="ai-t-btn-wrap"></div>' +
                '</div>' +
                (!this.hasApiKey()
                    ? '<div class="mt-2 small"><a href="' + this.config.settingsUrl + '">Configure API Key in Settings</a></div>'
                    : '') +
                '<div class="ai-t-progress" style="display:none;">' +
                '<div class="progress mt-2" style="height: 4px;"><div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width:0%"></div></div>' +
                '<div class="ai-t-status text-muted small mt-1"></div>' +
                '</div>' +
                '</div>'
            );

            $block.find('.ai-t-btn-wrap').append($btn);

            // Insert at top of the Botble main form's first card body
            // Priority: js-base-form (Botble's form class) first, then fallbacks
            var $form = $('form.js-base-form').first();
            if (!$form.length) $form = $('form.dirty-check').first();
            if (!$form.length) $form = $('form[method="POST"]').has('[name="name"], [name="title"]').first();
            if (!$form.length) $form = $('form[method="POST"]').first();

            if ($form.length) {
                var $firstCard = $form.find('.card-body').first();
                if (!$firstCard.length) $firstCard = $form.find('.widget-body').first();
                if ($firstCard.length) {
                    $firstCard.prepend($block);
                } else {
                    // Try to insert before the first form field group
                    var $firstField = $form.find('.form-body, .form-group, .mb-3').first();
                    if ($firstField.length) {
                        $firstField.before($block);
                    } else {
                        $form.prepend($block);
                    }
                }
            }
        },

        injectBlogLanguageButton: function () {
            var postId = this.getBlogSourceId();
            var $langWrap = $('#select-post-language');
            var $list = $('#list-others-language');

            if (!postId || !$langWrap.length || !$list.length) {
                if (postId && $list.length) {
                    this.injectBlogLanguageButtonToHeader($list);
                }
                return;
            }
            if ($langWrap.find('.ai-t-blog-translate-all').length) return;

            var $btn = $(
                '<button type="button" class="btn btn-info btn-sm ai-t-blog-translate-all">' +
                '<i class="fa fa-language me-1"></i> AI Translate All' +
                '</button>'
            );

            if (!this.hasApiKey()) {
                $btn.prop('disabled', true).attr('title', 'Configure API key first');
            }

            var $status = $('<span class="ai-t-lang-status text-muted small"></span>');
            var $toolbar = $('<div class="ms-auto d-flex align-items-center gap-2 flex-wrap ai-t-lang-toolbar"></div>');
            $toolbar.append($btn).append($status);
            $langWrap.addClass('flex-wrap').append($toolbar);
        },

        injectBlogLanguageButtonToHeader: function ($list) {
            var $box = $list.closest('.meta-boxes');
            if (!$box.length) return;

            var $header = $box.find('.card-header, .widget-title').first();
            if (!$header.length) return;
            if ($header.find('.ai-t-blog-translate-all').length) return;

            var $btn = $(
                '<button type="button" class="btn btn-info btn-sm ai-t-blog-translate-all">' +
                '<i class="fa fa-language me-1"></i> AI Translate All' +
                '</button>'
            );

            if (!this.hasApiKey()) {
                $btn.prop('disabled', true).attr('title', 'Configure API key first');
            }

            var $status = $('<span class="ai-t-lang-status text-muted small ms-2"></span>');
            var $toolbar = $('<div class="ms-auto d-flex align-items-center gap-2 ai-t-lang-toolbar"></div>');
            $toolbar.append($btn).append($status);

            $header.addClass('d-flex align-items-center justify-content-between flex-wrap gap-2');
            $header.append($toolbar);
        },

        getProductSourceId: function () {
            var refFrom = $('input[name="ref_from"]').val() || $('#reference_id').val();
            if (!refFrom) {
                refFrom = $('meta[name="ref_from"]').attr('content');
            }
            if (refFrom && parseInt(refFrom, 10)) return parseInt(refFrom, 10);

            var action = $('form.js-base-form, form.form-edit, form[method="POST"]').first().attr('action') || '';
            var match = action.match(/\/(\d+)(?:\?|$)/);
            return match ? parseInt(match[1], 10) : null;
        },

        injectProductLanguageButton: function () {
            var productId = this.getProductSourceId();
            var $langWrap = $('#select-post-language');
            var $list = $('#list-others-language');

            if (!productId || !$langWrap.length || !$list.length) {
                if (productId && $list.length) {
                    this.injectProductLanguageButtonToHeader($list);
                }
                return;
            }

            if ($langWrap.find('.ai-t-product-translate-all').length) return;

            var $btn = $(
                '<button type="button" class="btn btn-info btn-sm ai-t-product-translate-all">' +
                '<i class="fa fa-language me-1"></i> AI Translate All' +
                '</button>'
            );

            if (!this.hasApiKey()) {
                $btn.prop('disabled', true).attr('title', 'Configure API key first');
            }

            var $status = $('<span class="ai-t-product-lang-status text-muted small"></span>');
            var $toolbar = $('<div class="ms-auto d-flex align-items-center gap-2 flex-wrap ai-t-product-lang-toolbar"></div>');
            $toolbar.append($btn).append($status);
            $langWrap.addClass('flex-wrap').append($toolbar);
        },

        injectProductLanguageButtonToHeader: function ($list) {
            var $box = $list.closest('.meta-boxes');
            if (!$box.length) $box = $list.closest('.card');
            if (!$box.length) return;

            var $header = $box.find('.card-header, .widget-title').first();
            if (!$header.length) return;
            if ($header.find('.ai-t-product-translate-all').length) return;

            var $btn = $(
                '<button type="button" class="btn btn-info btn-sm ai-t-product-translate-all">' +
                '<i class="fa fa-language me-1"></i> AI Translate All' +
                '</button>'
            );

            if (!this.hasApiKey()) {
                $btn.prop('disabled', true).attr('title', 'Configure API key first');
            }

            var $status = $('<span class="ai-t-product-lang-status text-muted small ms-2"></span>');
            var $toolbar = $('<div class="ms-auto d-flex align-items-center gap-2 ai-t-product-lang-toolbar"></div>');
            $toolbar.append($btn).append($status);

            $header.addClass('d-flex align-items-center justify-content-between flex-wrap gap-2');
            $header.append($toolbar);
        },

        collectProductLanguages: function () {
            var languages = this.config.languages || [];
            var targets = [];

            $('#list-others-language a').each(function () {
                var $link = $(this);
                var href = $link.attr('href') || '';
                var text = $.trim($link.text());
                var code = null;

                var match = href.match(/ref_lang=([\w-]+)/);
                if (match) code = match[1];

                if (!code) {
                    languages.forEach(function (lang) {
                        if (text.indexOf(lang.lang_name) !== -1) code = lang.lang_code;
                    });
                }

                if (code) {
                    targets.push({ code: code, link: $link });
                }
            });

            return targets;
        },

        collectProductSourceFields: function () {
            var self = this;
            var fields = {};
            this.targetFields.forEach(function (field) {
                var value = self.getFieldValue(field);
                if (value && value.trim()) {
                    fields[field] = {
                        value: value,
                        type: (field === 'content' || field === 'custom_html') ? 'html' : 'text',
                    };
                }
            });
            return fields;
        },

        runProductAutoTranslate: function () {
            if (!this.config.modelAutoTranslateUrl) {
                Botble.showError('Product translate endpoint is missing.');
                return;
            }

            var productId = this.getProductSourceId();
            var targets = this.collectProductLanguages();

            if (!productId) {
                Botble.showError('Cannot detect the source product.');
                return;
            }

            if (!targets.length) {
                Botble.showError('No target languages found for this product.');
                return;
            }

            var self = this;
            this.setProductLangStatus('Translating ' + targets.length + ' languages...');
            this.toggleProductButton(true);

            var codes = targets.map(function (target) {
                return target.code;
            });

            $.post(this.config.modelAutoTranslateUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                model_type: 'Botble\\Product\\Models\\Product',
                model_id: productId,
                languages: codes,
                fields: this.collectProductSourceFields(),
            })
                .done(function (res) {
                    if (res.error) {
                        Botble.showError(res.message || 'Translation failed.');
                        self.setProductLangStatus('Translation failed. Please try again.');
                        return;
                    }

                    var results = (res.data && res.data.results) || [];
                    var successCount = 0;

                    results.forEach(function (item) {
                        var target = targets.find(function (lang) {
                            return lang.code === item.lang_code;
                        });

                        if (!target) {
                            return;
                        }

                        if (item.success) {
                            successCount++;
                            self.markLanguageDone(target, item);
                        } else {
                            self.markLanguageError(target, item.message || 'Failed');
                        }
                    });

                    self.setProductLangStatus(successCount + '/' + targets.length + ' languages translated.');

                    if (successCount === targets.length) {
                        Botble.showSuccess('All product translations finished successfully.');
                    }
                })
                .fail(function (xhr) {
                    Botble.showError(xhr.responseJSON?.message || 'Translation failed.');
                    self.setProductLangStatus('Translation failed. Please try again.');
                })
                .always(function () {
                    self.toggleProductButton(false);
                });
        },

        /**
         * Inject the "AI Translate All" button for supported models (Room, Amenity, Service, Page, Gallery, Product).
         * Same visual pattern as the blog button.
         */
        injectModelLanguageButton: function () {
            var modelId = this.getModelSourceId();
            var $langWrap = $('#select-post-language');
            var $list = $('#list-others-language');

            if (!modelId || !$langWrap.length || !$list.length) {
                if (modelId && $list.length) {
                    this.injectModelLanguageButtonToHeader($list);
                }
                return;
            }
            if ($langWrap.find('.ai-t-model-translate-all').length) return;

            var label = this.currentModel ? this.currentModel.label : 'Model';
            var $btn = $(
                '<button type="button" class="btn btn-info btn-sm ai-t-model-translate-all">' +
                '<i class="fa fa-language me-1"></i> AI Translate All' +
                '</button>'
            );

            if (!this.hasApiKey()) {
                $btn.prop('disabled', true).attr('title', 'Configure API key first');
            }

            var $status = $('<span class="ai-t-model-lang-status text-muted small"></span>');
            var $toolbar = $('<div class="ms-auto d-flex align-items-center gap-2 flex-wrap ai-t-model-lang-toolbar"></div>');
            $toolbar.append($btn).append($status);
            $langWrap.addClass('flex-wrap').append($toolbar);
        },

        injectModelLanguageButtonToHeader: function ($list) {
            var $box = $list.closest('.meta-boxes');
            if (!$box.length) $box = $list.closest('.card');
            if (!$box.length) return;

            var $header = $box.find('.card-header, .widget-title').first();
            if (!$header.length) return;
            if ($header.find('.ai-t-model-translate-all').length) return;

            var $btn = $(
                '<button type="button" class="btn btn-info btn-sm ai-t-model-translate-all">' +
                '<i class="fa fa-language me-1"></i> AI Translate All' +
                '</button>'
            );

            if (!this.hasApiKey()) {
                $btn.prop('disabled', true).attr('title', 'Configure API key first');
            }

            var $status = $('<span class="ai-t-model-lang-status text-muted small ms-2"></span>');
            var $toolbar = $('<div class="ms-auto d-flex align-items-center gap-2 ai-t-model-lang-toolbar"></div>');
            $toolbar.append($btn).append($status);

            $header.addClass('d-flex align-items-center justify-content-between flex-wrap gap-2');
            $header.append($toolbar);
        },

        /**
         * Inject a guaranteed-visible "Translate All Languages" block at the top of the form.
         * This is the PRIMARY injection point for model translate-all.
         */
        injectModelTranslateAllBlock: function () {
            if ($('.ai-t-model-block').length) return;

            var self = this;
            var targets = this.collectModelLanguages();
            var langNames = [];
            targets.forEach(function (t) {
                var lang = (self.config.languages || []).find(function (l) { return l.lang_code === t.code; });
                if (lang) langNames.push(lang.lang_name);
            });

            var label = this.currentModel ? this.currentModel.label : 'Model';

            var $block = $(
                '<div class="ai-t-model-block mb-3 p-3" ' +
                'style="background: linear-gradient(135deg, #e8f4f8 0%, #f0e6ff 100%); border-radius: 8px; border: 1px solid #d0e8f0;">' +
                '<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">' +
                '<div>' +
                '<strong><i class="fa fa-robot me-1"></i> AI Translator</strong> ' +
                (this.hasApiKey()
                    ? '<span class="text-muted small">' + label + ' → ' + (langNames.join(', ') || 'all languages') + '</span>'
                    : '<span class="badge bg-warning text-dark">API Key not configured</span>') +
                '</div>' +
                '<div class="ai-t-model-btn-wrap"></div>' +
                '</div>' +
                (!this.hasApiKey()
                    ? '<div class="mt-2 small"><a href="' + this.config.settingsUrl + '">Configure API Key in Settings</a></div>'
                    : '') +
                '<div class="ai-t-model-progress" style="display:none;">' +
                '<div class="progress mt-2" style="height: 4px;"><div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width:0%"></div></div>' +
                '<div class="ai-t-model-status text-muted small mt-1"></div>' +
                '</div>' +
                '</div>'
            );

            var $btn = $(
                '<button type="button" class="btn btn-info btn-sm ai-t-model-translate-all"' +
                (this.hasApiKey() ? '' : ' disabled') + '>' +
                '<i class="fa fa-language me-1"></i> Translate All Languages' +
                '</button>'
            );

            $block.find('.ai-t-model-btn-wrap').append($btn);

            // Insert at top of Botble main form's first card body
            var $form = $('form.js-base-form').first();
            if (!$form.length) $form = $('form.dirty-check').first();
            if (!$form.length) $form = $('form[method="POST"]').has('[name="name"], [name="title"]').first();
            if (!$form.length) $form = $('form[method="POST"]').first();

            if ($form.length) {
                var $firstCard = $form.find('.card-body').first();
                if (!$firstCard.length) $firstCard = $form.find('.widget-body').first();
                if ($firstCard.length) {
                    $firstCard.prepend($block);
                } else {
                    var $firstField = $form.find('.form-body, .form-group, .mb-3').first();
                    if ($firstField.length) {
                        $firstField.before($block);
                    } else {
                        $form.prepend($block);
                    }
                }
            }
        },

        /**
         * Collect target languages from the language list (generic, works for any model).
         */
        collectModelLanguages: function () {
            var languages = this.config.languages || [];
            var targets = [];

            $('#list-others-language a').each(function () {
                var $link = $(this);
                var href = $link.attr('href') || '';
                var text = $.trim($link.text());
                var code = null;

                var match = href.match(/ref_lang=([\w-]+)/);
                if (match) code = match[1];

                if (!code) {
                    languages.forEach(function (lang) {
                        if (text.indexOf(lang.lang_name) !== -1) code = lang.lang_code;
                    });
                }

                if (code) {
                    targets.push({ code: code, link: $link });
                }
            });

            return targets;
        },

        /**
         * Collect source fields from the current form for model translation.
         */
        collectModelSourceFields: function () {
            var self = this;
            var fields = {};
            this.targetFields.forEach(function (field) {
                var value = self.getFieldValue(field);
                if (value && value.trim()) {
                    fields[field] = {
                        value: value,
                        type: (field === 'content' || field === 'custom_html') ? 'html' : 'text',
                    };
                }
            });
            return fields;
        },

        /**
         * Run auto-translate for any supported model via the generic endpoint.
         */
        runModelAutoTranslate: function () {
            if (!this.config.modelAutoTranslateUrl) {
                Botble.showError('Model translate endpoint is missing.');
                return;
            }

            var modelId = this.getModelSourceId();
            var targets = this.collectModelLanguages();

            if (!modelId || !this.currentModel) {
                Botble.showError('Cannot detect the source record.');
                return;
            }

            if (!targets.length) {
                Botble.showError('No target languages found.');
                return;
            }

            var self = this;
            var statusText = 'Translating ' + targets.length + ' languages...';
            this.setModelLangStatus(statusText);
            this.setModelProgress(10, statusText);
            this.toggleModelButton(true);

            var codes = targets.map(function (t) { return t.code; });

            $.post(this.config.modelAutoTranslateUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                model_type: this.currentModel.type,
                model_id: modelId,
                languages: codes,
                fields: this.collectModelSourceFields(),
            })
            .done(function (res) {
                if (res.error) {
                    Botble.showError(res.message || 'Translation failed.');
                    self.setModelLangStatus('Translation failed: ' + (res.message || 'Unknown error'));
                    self.setModelProgress(0, 'Translation failed: ' + (res.message || 'Unknown error'));
                    return;
                }

                var results = (res.data && res.data.results) || [];
                var successCount = 0;

                results.forEach(function (item) {
                    var target = targets.find(function (t) { return t.code === item.lang_code; });
                    if (!target) return;

                    if (item.success) {
                        successCount++;
                        self.markLanguageDone(target, item);
                    } else {
                        self.markLanguageError(target, item.message || 'Failed');
                    }
                });

                var doneText = successCount + '/' + targets.length + ' languages translated.';
                self.setModelLangStatus(doneText);
                self.setModelProgress(100, doneText);

                if (successCount === targets.length) {
                    Botble.showSuccess('All translations finished successfully.');
                } else if (successCount > 0) {
                    Botble.showSuccess(doneText);
                }
            })
            .fail(function (xhr) {
                var msg = xhr.responseJSON?.message || 'Translation failed.';
                Botble.showError(msg);
                self.setModelLangStatus('Translation failed: ' + msg);
                self.setModelProgress(0, 'Translation failed: ' + msg);
            })
            .always(function () {
                self.toggleModelButton(false);
            });
        },

        setModelLangStatus: function (text) {
            $('.ai-t-model-lang-status').text(text || '');
            $('.ai-t-model-status').text(text || '');
        },

        setModelProgress: function (percent, text) {
            var $block = $('.ai-t-model-block');
            if (!$block.length) return;

            var $progress = $block.find('.ai-t-model-progress');
            var $bar = $progress.find('.progress-bar');
            var $status = $block.find('.ai-t-model-status');

            if (percent >= 0) {
                $progress.show();
                $bar.css('width', percent + '%');
            }
            if (text) $status.text(text);
            if (percent >= 100) {
                $bar.removeClass('progress-bar-animated');
            } else {
                $bar.addClass('progress-bar-animated');
            }
        },

        toggleModelButton: function (isLoading) {
            var $btn = $('.ai-t-model-translate-all');
            if (!$btn.length) return;

            if (isLoading) {
                $btn.data('orig-html', $btn.html());
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Translating...');
            } else {
                var html = $btn.data('orig-html') || '<i class="fa fa-language me-1"></i> Translate All Languages';
                $btn.prop('disabled', false).html(html);
            }
        },

        getBlogSourceId: function () {
            var refFrom = $('input[name="ref_from"]').val() || $('#reference_id').val();
            if (!refFrom) {
                refFrom = $('meta[name="ref_from"]').attr('content');
            }
            if (refFrom && parseInt(refFrom, 10)) return parseInt(refFrom, 10);

            var action = $('form.js-base-form, form.form-edit, form[method="POST"]').first().attr('action') || '';
            var match = action.match(/\/(\d+)(?:\?|$)/);
            return match ? parseInt(match[1], 10) : null;
        },

        collectBlogLanguages: function () {
            var languages = this.config.languages || [];
            var targets = [];

            $('#list-others-language a').each(function () {
                var $link = $(this);
                var href = $link.attr('href') || '';
                var text = $.trim($link.text());
                var code = null;

                var match = href.match(/ref_lang=([\w-]+)/);
                if (match) code = match[1];

                if (!code) {
                    languages.forEach(function (lang) {
                        if (text.indexOf(lang.lang_name) !== -1) code = lang.lang_code;
                    });
                }

                if (code) {
                    targets.push({ code: code, link: $link });
                }
            });

            return targets;
        },

        collectBlogSourceFields: function () {
            var self = this;
            var fields = {};
            this.targetFields.forEach(function (field) {
                var value = self.getFieldValue(field);
                if (value && value.trim()) {
                    fields[field] = {
                        value: value,
                        type: (field === 'content' || field === 'custom_html') ? 'html' : 'text',
                    };
                }
            });
            return fields;
        },

        runBlogAutoTranslate: function () {
            if (!this.config.blogAutoTranslateUrl) {
                Botble.showError('Blog translate endpoint is missing.');
                return;
            }

            var postId = this.getBlogSourceId();
            var targets = this.collectBlogLanguages();

            if (!postId) {
                Botble.showError('Cannot detect the source blog post.');
                return;
            }

            if (!targets.length) {
                Botble.showError('No target languages found for this blog post.');
                return;
            }

            var self = this;
            this.setLangStatus('Translating ' + targets.length + ' languages...');
            this.toggleBlogButton(true);

            var codes = targets.map(function (target) {
                return target.code;
            });

            $.post(this.config.blogAutoTranslateUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                post_id: postId,
                languages: codes,
                fields: this.collectBlogSourceFields(),
            })
                .done(function (res) {
                    if (res.error) {
                        Botble.showError(res.message || 'Translation failed.');
                        self.setLangStatus('Translation failed. Please try again.');
                        return;
                    }

                    var results = (res.data && res.data.results) || [];
                    var successCount = 0;

                    results.forEach(function (item) {
                        var target = targets.find(function (lang) {
                            return lang.code === item.lang_code;
                        });

                        if (!target) {
                            return;
                        }

                        if (item.success) {
                            successCount++;
                            self.markLanguageDone(target, item);
                        } else {
                            self.markLanguageError(target, item.message || 'Failed');
                        }
                    });

                    self.setLangStatus(successCount + '/' + targets.length + ' languages translated.');

                    if (successCount === targets.length) {
                        Botble.showSuccess('All blog translations finished successfully.');
                    }
                })
                .fail(function (xhr) {
                    Botble.showError(xhr.responseJSON?.message || 'Translation failed.');
                    self.setLangStatus('Translation failed. Please try again.');
                })
                .always(function () {
                    self.toggleBlogButton(false);
                });
        },

        triggerBlogAutoTranslate: function () {
            if (!this.config.blogAutoTranslateUrl) {
                Botble.showError('Blog translate endpoint is missing.');
                return;
            }

            var postId = this.getBlogSourceId();
            var targets = this.collectBlogLanguages();

            if (!postId) {
                Botble.showError('Không xác định được bài viết nguồn.');
                return;
            }

            if (!targets.length) {
                Botble.showError('Không tìm thấy ngôn ngữ cần dịch.');
                return;
            }

            var self = this;
            this.setLangStatus('Đang dịch ' + targets.length + ' ngôn ngữ...');
            this.toggleBlogButton(true);

            var codes = targets.map(function (t) { return t.code; });
            var sourceFields = this.collectBlogSourceFields();

            $.post(this.config.blogAutoTranslateUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                post_id: postId,
                languages: codes,
                fields: sourceFields,
            })
            .done(function (res) {
                if (res.error) {
                    Botble.showError(res.message || 'Translation failed.');
                    self.setLangStatus('Không thể dịch. Vui lòng thử lại.');
                    return;
                }

                var results = (res.data && res.data.results) || [];
                var successCount = 0;

                results.forEach(function (item) {
                    var target = targets.find(function (t) { return t.code === item.lang_code; });
                    if (!target) return;

                    if (item.success) {
                        successCount++;
                        self.markLanguageDone(target, item);
                    } else {
                        self.markLanguageError(target, item.message || 'Failed');
                    }
                });

                self.setLangStatus(successCount + '/' + targets.length + ' ngôn ngữ đã dịch.');

                if (successCount === targets.length) {
                    Botble.showSuccess('Đã dịch xong tất cả ngôn ngữ.');
                }
            })
            .fail(function (xhr) {
                Botble.showError(xhr.responseJSON?.message || 'Translation failed.');
                self.setLangStatus('Không thể dịch. Vui lòng thử lại.');
            })
            .always(function () {
                self.toggleBlogButton(false);
            });
        },

        setLangStatus: function (text) {
            $('.ai-t-lang-status').text(text || '');
        },

        setProductLangStatus: function (text) {
            $('.ai-t-product-lang-status').text(text || '');
        },

        toggleBlogButton: function (isLoading) {
            var $btn = $('.ai-t-blog-translate-all');
            if (!$btn.length) return;

            if (isLoading) {
                $btn.data('orig-html', $btn.html());
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Translating...');
            } else {
                var html = $btn.data('orig-html') || '<i class="fa fa-language me-1"></i> AI Translate All';
                $btn.prop('disabled', false).html(html);
            }
        },

        toggleProductButton: function (isLoading) {
            var $btn = $('.ai-t-product-translate-all');
            if (!$btn.length) return;

            if (isLoading) {
                $btn.data('orig-html', $btn.html());
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Translating...');
            } else {
                var html = $btn.data('orig-html') || '<i class="fa fa-language me-1"></i> AI Translate All';
                $btn.prop('disabled', false).html(html);
            }
        },

        markLanguageDone: function (target, item) {
            if (!target || !target.link) return;

            target.link.find('.ai-t-check, .ai-t-error').remove();
            var $check = $('<span class="ai-t-check text-success ms-1"><i class="fa fa-check-circle"></i></span>');
            target.link.append($check);

            if (item.edit_url) target.link.attr('href', item.edit_url);
            var $icon = target.link.find('.ti-plus');
            if ($icon.length) $icon.removeClass('ti-plus').addClass('ti-edit');
        },

        markLanguageError: function (target, message) {
            if (!target || !target.link) return;
            target.link.find('.ai-t-check, .ai-t-error').remove();
            var $err = $('<span class="ai-t-error text-danger ms-1" title="' + message + '"><i class="fa fa-exclamation-circle"></i></span>');
            target.link.append($err);
        },

        bindEvents: function () {
            var self = this;

            $(document).on('click', '.ai-t-blog-translate-all', function (e) {
                e.preventDefault();
                if (!self.hasApiKey()) {
                    Botble.showError('API Key not configured. Go to AI Translator Settings.');
                    return;
                }
                self.runBlogAutoTranslate();
            });

            $(document).on('click', '.ai-t-product-translate-all', function (e) {
                e.preventDefault();
                if (!self.hasApiKey()) {
                    Botble.showError('API Key not configured. Go to AI Translator Settings.');
                    return;
                }
                self.runProductAutoTranslate();
            });

            // Generic model translate-all button (Room, Amenity, Service, Page, Gallery, Product)
            $(document).on('click', '.ai-t-model-translate-all', function (e) {
                e.preventDefault();
                if (!self.hasApiKey()) {
                    Botble.showError('API Key not configured. Go to AI Translator Settings.');
                    return;
                }
                self.runModelAutoTranslate();
            });

            // Direct button click (translation page)
            $(document).on('click', '.ai-t-translate-all-btn', function (e) {
                e.preventDefault();
                if (!self.hasApiKey()) {
                    Botble.showError('API Key not configured. Go to AI Translator Settings.');
                    return;
                }
                var sourceLang = $(this).data('source-lang');
                var targetLang = $(this).data('target-lang');
                self.translateAllFields(sourceLang, targetLang);
            });

            // Dropdown item click (default page)
            $(document).on('click', '.ai-t-batch-item', function (e) {
                e.preventDefault();
                if (!self.hasApiKey()) {
                    Botble.showError('API Key not configured. Go to AI Translator Settings.');
                    return;
                }
                var sourceLang = $(this).data('source-lang');
                var targetLang = $(this).data('target-lang');
                self.translateAllFields(sourceLang, targetLang);
            });
        },

        /**
         * Translate all detected fields at once.
         */
        translateAllFields: function (sourceLang, targetLang) {
            var self = this;
            var detectedFields = this.detectFields();

            // On translation pages (ref_lang set), form shows EXISTING translation data,
            // not the source language content. Always fetch original from server.
            if (this.config.currentRefLang) {
                var fieldNames = detectedFields.map(function (f) { return f.name; });
                if (fieldNames.length > 0) {
                    this.fetchAndTranslate(fieldNames, sourceLang, targetLang);
                    return;
                }
            }

            var fields = {};
            var emptyFieldNames = [];

            detectedFields.forEach(function (f) {
                var value = self.getFieldValue(f.name);
                if (value && value.trim()) {
                    fields[f.name] = { value: value, type: f.type };
                } else {
                    emptyFieldNames.push(f.name);
                }
            });

            // All fields empty — try to fetch original content (translation page)
            if (Object.keys(fields).length === 0 && emptyFieldNames.length > 0) {
                this.fetchAndTranslate(emptyFieldNames, sourceLang, targetLang);
                return;
            }

            // Some fields empty — also fetch originals for those
            if (emptyFieldNames.length > 0) {
                this.fetchMissingAndTranslate(fields, emptyFieldNames, sourceLang, targetLang);
                return;
            }

            this.executeBatchTranslate(fields, sourceLang, targetLang);
        },

        /**
         * Fetch original content from the default-language model, then translate.
         */
        fetchAndTranslate: function (fieldNames, sourceLang, targetLang) {
            var self = this;
            var modelInfo = this.getModelInfo();

            if (!modelInfo) {
                Botble.showError('No content found. Save the original language first.');
                return;
            }

            this.showProgress(15, 'Fetching original content...');

            $.post(this.config.fetchOriginalUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                model_type: modelInfo.type,
                model_id: modelInfo.id,
                fields: fieldNames,
            })
            .done(function (res) {
                if (res.error) {
                    Botble.showError(res.message || 'Failed to fetch original.');
                    self.hideProgress();
                    return;
                }

                var data = res.data || {};
                var fields = {};
                Object.keys(data).forEach(function (name) {
                    if (data[name] && data[name].trim()) {
                        fields[name] = {
                            value: data[name],
                            type: (name === 'content' || name === 'custom_html') ? 'html' : 'text'
                        };
                    }
                });

                if (Object.keys(fields).length === 0) {
                    Botble.showError('Original content is empty. Save the default language first.');
                    self.hideProgress();
                    return;
                }

                self.showProgress(30, 'Translating ' + Object.keys(fields).length + ' fields...');
                self.executeBatchTranslate(fields, sourceLang, targetLang);
            })
            .fail(function (xhr) {
                Botble.showError(xhr.responseJSON?.message || 'Failed to fetch original.');
                self.hideProgress();
            });
        },

        /**
         * We have some fields with content but some are empty. Fetch originals for empty ones, merge, then translate all.
         */
        fetchMissingAndTranslate: function (existingFields, missingNames, sourceLang, targetLang) {
            var self = this;
            var modelInfo = this.getModelInfo();

            if (!modelInfo) {
                // Can't fetch, just translate what we have
                this.executeBatchTranslate(existingFields, sourceLang, targetLang);
                return;
            }

            this.showProgress(15, 'Fetching missing fields...');

            $.post(this.config.fetchOriginalUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                model_type: modelInfo.type,
                model_id: modelInfo.id,
                fields: missingNames,
            })
            .done(function (res) {
                var data = res.data || {};
                Object.keys(data).forEach(function (name) {
                    if (data[name] && data[name].trim()) {
                        existingFields[name] = {
                            value: data[name],
                            type: (name === 'content' || name === 'custom_html') ? 'html' : 'text'
                        };
                    }
                });
                self.showProgress(30, 'Translating ' + Object.keys(existingFields).length + ' fields...');
                self.executeBatchTranslate(existingFields, sourceLang, targetLang);
            })
            .fail(function () {
                // Fallback: translate what we already have
                self.executeBatchTranslate(existingFields, sourceLang, targetLang);
            });
        },

        /**
         * Get model type and ID from hidden form inputs (for fetchOriginal).
         */
        getModelInfo: function () {
            var $model = $('input[name="model"]');
            var modelType = $model.length ? $model.val() : null;

            // Fallback: use detected model type from URL pattern
            if (!modelType && this.currentModel) {
                modelType = this.currentModel.type;
            }

            var refFrom = $('meta[name="ref_from"]').attr('content') || $('input[name="ref_from"]').val();

            // Also try the form action URL to extract model ID
            if (!refFrom) {
                var action = $('form[method="POST"]').first().attr('action') || '';
                var match = action.match(/\/(\d+)(?:\/|$)/);
                if (match) refFrom = match[1];
            }

            if (modelType && refFrom) {
                return { type: modelType, id: refFrom };
            }
            return null;
        },

        /**
         * Execute batch translation API call.
         */
        executeBatchTranslate: function (fields, sourceLang, targetLang) {
            var self = this;

            // Disable button during translation
            var $btn = $('.ai-t-translate-all-btn, .ai-t-btn-wrap .dropdown-toggle');
            var origHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Translating...');

            this.showProgress(40, 'Translating ' + Object.keys(fields).length + ' fields...');

            $.post(this.config.batchTranslateUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                fields: fields,
                target_language: targetLang,
                source_language: sourceLang,
            })
            .done(function (res) {
                if (res.error) {
                    Botble.showError(res.message || 'Translation failed.');
                    self.showProgress(0, 'Failed: ' + (res.message || ''));
                    return;
                }

                self.showProgress(80, 'Applying translations...');

                var translations = res.data.translations || {};
                var count = 0;
                Object.keys(translations).forEach(function (fieldName) {
                    if (translations[fieldName]) {
                        self.setFieldValue(fieldName, translations[fieldName]);
                        count++;
                    }
                });

                var costText = res.data.cost ? ' ($' + res.data.cost.toFixed(6) + ')' : '';
                self.showProgress(100, count + ' fields translated!' + costText);
                Botble.showSuccess(count + ' fields translated!' + costText);

                // Auto-hide progress after 5s
                setTimeout(function () { self.hideProgress(); }, 5000);
            })
            .fail(function (xhr) {
                Botble.showError(xhr.responseJSON?.message || 'Translation failed.');
                self.showProgress(0, 'Failed');
            })
            .always(function () {
                $btn.prop('disabled', false).html(origHtml);
            });
        },

        showProgress: function (percent, text) {
            var $p = $('.ai-t-progress');
            $p.show();
            $p.find('.progress-bar').css('width', percent + '%');
            if (percent >= 100) {
                $p.find('.progress-bar').removeClass('progress-bar-animated');
            }
            $p.find('.ai-t-status').text(text);
        },

        hideProgress: function () {
            var $p = $('.ai-t-progress');
            $p.find('.progress-bar').css('width', '0%').addClass('progress-bar-animated');
            $p.slideUp(300);
        },

        /**
         * Get value from a field, with CKEditor / TinyMCE support.
         */
        getFieldValue: function (fieldName) {
            // Botble CKEditor 5 — primary method
            if (window.EDITOR && window.EDITOR.CKEDITOR && window.EDITOR.CKEDITOR[fieldName]) {
                return window.EDITOR.CKEDITOR[fieldName].getData();
            }

            // CKEditor 4 fallback
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances[fieldName]) {
                return CKEDITOR.instances[fieldName].getData();
            }

            // TinyMCE
            if (typeof tinymce !== 'undefined' && tinymce.get(fieldName)) {
                return tinymce.get(fieldName).getContent();
            }

            // Regular input/textarea
            return $('[name="' + fieldName + '"]').val() || '';
        },

        /**
         * Set value to a field, with CKEditor / TinyMCE support.
         */
        setFieldValue: function (fieldName, value) {
            // Botble CKEditor 5 — primary method
            if (window.EDITOR && window.EDITOR.CKEDITOR && window.EDITOR.CKEDITOR[fieldName]) {
                window.EDITOR.CKEDITOR[fieldName].setData(value);
                // Also sync to hidden textarea
                var $ta = $('[name="' + fieldName + '"]');
                if ($ta.length) $ta.val(value);
                return;
            }

            // CKEditor 4 fallback
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances[fieldName]) {
                CKEDITOR.instances[fieldName].setData(value);
                return;
            }

            // TinyMCE
            if (typeof tinymce !== 'undefined' && tinymce.get(fieldName)) {
                tinymce.get(fieldName).setContent(value);
                return;
            }

            // Regular input/textarea
            var $field = $('[name="' + fieldName + '"]');
            $field.val(value).trigger('change').trigger('input');
        },
    };

    // Initialize after DOM + editors loaded
    $(function () {
        setTimeout(function () { AiTranslator.init(); }, 1000);
    });

})(jQuery);
