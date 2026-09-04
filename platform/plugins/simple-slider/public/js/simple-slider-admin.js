class SimpleSliderAdminManagement {
    init(tableId) {
        const $table = $(document).find(`#${tableId}_wrapper`)

        $.each($table.find('tbody'), (index, el) => {
            Sortable.create(el, {
                group: el + '_' + index, // or { name: "...", pull: [true, false, clone], put: [true, false, array] }
                sort: true, // sorting inside list
                delay: 0, // time in milliseconds to define when the sorting should start
                disabled: false, // Disables the sortable if set to true.
                store: null, // @see Store
                animation: 150, // ms, animation speed moving items when sorting, `0` — without animation
                handle: 'tr',
                ghostClass: 'sortable-ghost', // Class name for the drop placeholder
                chosenClass: 'sortable-chosen', // Class name for the chosen item
                dataIdAttr: 'data-id',

                forceFallback: false, // ignore the HTML5 DnD behaviour and force the fallback to kick in
                fallbackClass: 'sortable-fallback', // Class name for the cloned DOM Element when using forceFallback
                fallbackOnBody: false, // Appends the cloned DOM Element into the Document's Body

                scroll: true, // or HTMLElement
                scrollSensitivity: 30, // px, how near the mouse must be to an edge to start scrolling.
                scrollSpeed: 10, // px

                // dragging ended
                onEnd: () => {
                    $(document).find('.btn-save-sort-order').addClass('sort-button-active btn-warning').show()

                    const $box = $(el).closest('.card')

                    $.each($box.find('tbody tr'), (index, sort) => {
                        $(sort)
                            .find('.order-column')
                            .text(index + 1)
                    })
                },
            })
        })

        const $sortButton = $(document).find('.btn-save-sort-order')

        $sortButton.off('click').on('click', (event) => {
            event.preventDefault()
            const _self = $(event.currentTarget)

            let items = []
            $.each(_self.closest('.card').find('tbody tr'), (index, sort) => {
                items.push(parseInt($(sort).find('td:first-child').text()))
                $(sort)
                    .find('.order-column')
                    .text(index + 1)
            })

            Botble.showButtonLoading(_self)

            $httpClient
                .make()
                .post($sortButton.data('url'), {
                    items,
                })
                .then(({ data }) => {
                    Botble.showSuccess(data.message)
                })
                .finally(() => {
                    Botble.hideButtonLoading(_self)
                    _self.hide()
                })
        })
    }
}

$(() => {
    const getCurrentRefLang = () =>
        new URLSearchParams(window.location.search).get('ref_lang') ||
        $('meta[name="ref_lang"]').attr('content') ||
        ''

    const appendRefLangToUrl = (href) => {
        const refLang = getCurrentRefLang()

        if (!href || !refLang) {
            return href
        }

        const url = new URL(href, window.location.origin)

        if (!url.searchParams.get('ref_lang')) {
            url.searchParams.set('ref_lang', refLang)
        }

        return `${url.pathname}${url.search}${url.hash}`
    }

    const toggleApplyAllButton = (modal, data = {}) => {
        const applyAllButton = modal.find('#simple-slider-item-apply-all')
        const aiTranslateAllButton = modal.find('#simple-slider-item-ai-translate-all')

        if (!data.canApplyAll) {
            applyAllButton.hide().data('confirm-message', '')
            aiTranslateAllButton.hide().data('confirm-message', '')

            return
        }

        applyAllButton
            .show()
            .data('confirm-message', data.applyAllConfirmMessage || '')

        aiTranslateAllButton
            .show()
            .data('confirm-message', data.aiTranslateAllConfirmMessage || '')
    }

    document.addEventListener('core-table-init-completed', function (event) {
        new SimpleSliderAdminManagement().init(event.detail.table.prop('id'))
    })

    $(document)
        .on('show.bs.modal', '#simple-slider-item-modal', (e) => {
            const modal = $(e.currentTarget)
            const href = appendRefLangToUrl($(e.relatedTarget).prop('href'))

            $httpClient
                .make()
                .withLoading(modal.find('.modal-content'))
                .get(href)
                .then(({ data }) => {
                    modal.find('.modal-header .modal-title').text(data.data.title)
                    modal.find('.modal-body').html(data.data.content)
                    toggleApplyAllButton(modal, data.data)

                    Botble.initMediaIntegrate()

                    Botble.initResources()
                })
        })
        .on('hidden.bs.modal', '#simple-slider-item-modal', (e) => {
            const modal = $(e.currentTarget)

            modal.find('.modal-body').empty()
            toggleApplyAllButton(modal)
        })
        .on('click', '#simple-slider-item-apply-all', (e) => {
            e.preventDefault()

            const button = $(e.currentTarget)
            const modal = button.closest('.modal')
            const form = modal.find('form')
            const confirmMessage = button.data('confirm-message')

            if (!form.length) {
                return
            }

            if (confirmMessage && !window.confirm(confirmMessage)) {
                return
            }

            const payload = {
                ...Object.fromEntries(new URLSearchParams(form.serialize())),
                simple_slider_id: form.find('input[name="simple_slider_id"]').val(),
                language: form.find('input[name="language"]').val(),
                title: form.find('input[name="title"]').val(),
                description: form.find('textarea[name="description"]').val(),
                apply_all: 1,
            }

            $httpClient
                .make()
                .withLoading(form)
                .withButtonLoading(button)
                .post(form.prop('action'), payload)
                .then(({ data }) => {
                    Botble.showSuccess(data.message)

                    $('#botble-simple-slider-tables-simple-slider-item-table').DataTable().draw(false)
                })
        })
        .on('click', '#simple-slider-item-ai-translate-all', (e) => {
            e.preventDefault()

            const button = $(e.currentTarget)
            const modal = button.closest('.modal')
            const form = modal.find('form')
            const confirmMessage = button.data('confirm-message')

            if (!form.length) {
                return
            }

            if (confirmMessage && !window.confirm(confirmMessage)) {
                return
            }

            const payload = {
                ...Object.fromEntries(new URLSearchParams(form.serialize())),
                simple_slider_id: form.find('input[name="simple_slider_id"]').val(),
                language: form.find('input[name="language"]').val(),
                title: form.find('input[name="title"]').val(),
                description: form.find('textarea[name="description"]').val(),
                ai_translate_all: 1,
            }

            $httpClient
                .make()
                .withLoading(form)
                .withButtonLoading(button)
                .post(form.prop('action'), payload)
                .then(({ data }) => {
                    Botble.showSuccess(data.message)

                    $('#botble-simple-slider-tables-simple-slider-item-table').DataTable().draw(false)
                })
        })

        .on('click', '#simple-slider-item-modal button[type="submit"]', (e) => {
            e.preventDefault()

            const button = $(e.currentTarget)
            const modal = button.closest('.modal')
            const form = modal.find('form')

            $httpClient
                .make()
                .withLoading(form)
                .withButtonLoading(button)
                .post(form.prop('action'), form.serialize())
                .then(({ data }) => {
                    Botble.showSuccess(data.message)

                    modal.modal('hide')

                    $('#botble-simple-slider-tables-simple-slider-item-table').DataTable().draw()
                })
        })
})
