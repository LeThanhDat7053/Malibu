'use strict';

$(function () {

    // ---------------------------------------------------------------
    // State: which item is being edited (null = adding new)
    // ---------------------------------------------------------------
    var editingEl = null;

    // ---------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------
    function getContainer()  { return document.getElementById('room-videos-items'); }
    function getHiddenInput(){ return document.getElementById('room-videos-data'); }

    function saveItems() {
        var container  = getContainer();
        var hiddenInput = getHiddenInput();
        if (!container || !hiddenInput) return;
        var items = [];
        container.querySelectorAll('.room-video-item').forEach(function (el) {
            var item = { img: el.dataset.img, type: 'video', description: el.dataset.description || '' };
            if (el.dataset.thumb) item.thumb = el.dataset.thumb;
            items.push(item);
        });
        hiddenInput.value = JSON.stringify(items);
    }

    function getYtThumb(url) {
        var m = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
        return m ? 'https://img.youtube.com/vi/' + m[1] + '/hqdefault.jpg' : null;
    }

    function buildThumbnailHtml(url, thumb) {
        var ytThumb = getYtThumb(url);
        if (ytThumb) {
            return '<img src="' + ytThumb + '" alt="video" loading="lazy" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:4px;">';
        } else if (thumb) {
            return '<img src="' + thumb + '" alt="video" loading="lazy" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:4px;">';
        }
        return '<div class="room-video-placeholder" style="width:100%;aspect-ratio:1;background:#1a1a2e;display:flex;align-items:center;justify-content:center;border-radius:4px;"><i class="fas fa-video" style="font-size:28px;color:#0d6efd;"></i></div>';
    }

    function buildVideoItem(idx, url, description, thumb) {
        var urlShort = url.length > 30 ? url.substring(0, 27) + '...' : url;
        var div = document.createElement('div');
        div.className = 'col-md-2 col-sm-3 col-4 room-video-item';
        div.dataset.id  = idx;
        div.dataset.img = url;
        div.dataset.description = description || '';
        div.dataset.thumb = thumb || '';
        div.innerHTML =
            '<div class="gallery_image_wrapper position-relative" style="cursor:pointer;">'
            + buildThumbnailHtml(url, thumb)
            + '<span class="position-absolute top-0 start-0 badge bg-primary" style="font-size:9px;z-index:2;pointer-events:none;">VIDEO</span>'
            // Overlay: pointer-events:none when hidden, auto when visible (CSS switches it)
            + '<div class="room-video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-1">'
            + '<button type="button" class="btn-edit-room-video btn btn-sm btn-light px-2 py-1" style="font-size:11px;"><i class="fas fa-edit me-1"></i>Edit</button>'
            + '<button type="button" class="btn-remove-room-video btn btn-sm btn-danger px-2 py-1" style="font-size:11px;"><i class="fas fa-trash me-1"></i>Remove</button>'
            + '</div>'
            + '</div>'
            + '<div class="mt-1" style="font-size:10px;color:#666;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%;" title="' + url + '">' + urlShort + '</div>';
        return div;
    }

    function updateVideoItem(el, url, description, thumb) {
        el.dataset.img = url;
        el.dataset.description = description || '';
        el.dataset.thumb = thumb || '';
        var wrapper = el.querySelector('.gallery_image_wrapper');
        wrapper.innerHTML =
            buildThumbnailHtml(url, thumb)
            + '<span class="position-absolute top-0 start-0 badge bg-primary" style="font-size:9px;z-index:2;pointer-events:none;">VIDEO</span>'
            + '<div class="room-video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-1">'
            + '<button type="button" class="btn-edit-room-video btn btn-sm btn-light px-2 py-1" style="font-size:11px;"><i class="fas fa-edit me-1"></i>Edit</button>'
            + '<button type="button" class="btn-remove-room-video btn btn-sm btn-danger px-2 py-1" style="font-size:11px;"><i class="fas fa-trash me-1"></i>Remove</button>'
            + '</div>';
        var label = el.querySelector('.mt-1');
        if (label) { label.textContent = url.length > 30 ? url.substring(0, 27) + '...' : url; label.title = url; }
    }

    // ---------------------------------------------------------------
    // Open media browser  uses RvMediaStandalone.open() for instant open
    // ---------------------------------------------------------------
    function openMediaBrowser(options) {
        if (typeof RvMediaStandalone !== 'undefined') {
            new RvMediaStandalone('room-video-media-' + Date.now(), {
                filter: options.filter || '',
                view_in: 'all_media',
                onSelectFiles: options.onSelectFiles
            }).open();
        } else if (typeof $.fn.rvMedia === 'function') {
            // Fallback via temporary element
            var $tmp = $('<span style="display:none">').appendTo('body');
            $tmp.rvMedia({
                filter: options.filter || '',
                view_in: 'all_media',
                onSelectFiles: function(files) {
                    options.onSelectFiles(files);
                    $tmp.remove();
                }
            });
            $tmp.trigger('click');
        }
    }

    // ---------------------------------------------------------------
    // Remove item (delegated  items may be dynamic)
    // ---------------------------------------------------------------
    $(document).on('click', '.btn-remove-room-video', function (e) {
        e.stopPropagation();
        $(this).closest('.room-video-item').remove();
        saveItems();
    });

    // ---------------------------------------------------------------
    // Edit item (delegated)
    // ---------------------------------------------------------------
    $(document).on('click', '.btn-edit-room-video', function (e) {
        e.stopPropagation();
        editingEl = $(this).closest('.room-video-item')[0];
        prefillModal(editingEl.dataset.img || '', editingEl.dataset.description || '', editingEl.dataset.thumb || '');
        document.getElementById('room-add-video-modal-label').textContent = 'Edit Video';
        document.getElementById('room-video-confirm-btn').textContent = 'Update';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('room-add-video-modal')).show();
    });

    // ---------------------------------------------------------------
    // Open modal for NEW video
    // ---------------------------------------------------------------
    $(document).on('click', '#room-video-open-modal-btn', function (e) {
        e.preventDefault();
        editingEl = null;
        document.getElementById('room-add-video-modal-label').textContent = 'Add Video URL';
        document.getElementById('room-video-confirm-btn').textContent = 'Add';
        prefillModal('', '', '');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('room-add-video-modal')).show();
    });

    function prefillModal(url, description, thumb) {
        document.getElementById('room-video-url-input').value = url;
        document.getElementById('room-video-description-input').value = description;
        document.getElementById('room-video-thumb-input').value = thumb;
        var preview = document.getElementById('room-video-thumb-preview');
        var clearBtn = document.getElementById('room-video-thumb-clear-btn');
        if (thumb) {
            preview.style.display = 'block';
            preview.querySelector('img').src = thumb;
            clearBtn.style.display = 'inline-block';
        } else {
            preview.style.display = 'none';
            preview.querySelector('img').src = '';
            clearBtn.style.display = 'none';
        }
    }

    // ---------------------------------------------------------------
    // Confirm: add or update
    // ---------------------------------------------------------------
    $(document).on('click', '#room-video-confirm-btn', function () {
        var url = document.getElementById('room-video-url-input').value.trim();
        if (!url) { document.getElementById('room-video-url-input').focus(); return; }
        var description = document.getElementById('room-video-description-input').value.trim();
        var thumb = document.getElementById('room-video-thumb-input').value.trim();

        if (editingEl) {
            updateVideoItem(editingEl, url, description, thumb);
        } else {
            var container = getContainer();
            if (container) container.appendChild(buildVideoItem(container.querySelectorAll('.room-video-item').length, url, description, thumb));
        }
        saveItems();
        editingEl = null;
        bootstrap.Modal.getInstance(document.getElementById('room-add-video-modal')).hide();
    });

    // ---------------------------------------------------------------
    // Browse video/all media  opens immediately on first click
    // ---------------------------------------------------------------
    $(document).on('click', '#room-video-browse-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();
        openMediaBrowser({
            onSelectFiles: function (files) {
                if (files && files.length > 0) {
                    document.getElementById('room-video-url-input').value = files[0].full_url || files[0].url;
                }
            }
        });
    });

    // ---------------------------------------------------------------
    // Browse thumbnail  opens immediately on first click
    // ---------------------------------------------------------------
    $(document).on('click', '#room-video-thumb-browse-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();
        openMediaBrowser({
            filter: 'image',
            onSelectFiles: function (files) {
                if (files && files.length > 0) {
                    var displayUrl = files[0].full_url || files[0].thumb || files[0].url;
                    document.getElementById('room-video-thumb-input').value = displayUrl;
                    var preview = document.getElementById('room-video-thumb-preview');
                    if (preview) { preview.style.display = 'block'; preview.querySelector('img').src = displayUrl; }
                    document.getElementById('room-video-thumb-clear-btn').style.display = 'inline-block';
                }
            }
        });
    });

    // ---------------------------------------------------------------
    // Clear thumbnail
    // ---------------------------------------------------------------
    $(document).on('click', '#room-video-thumb-clear-btn', function (e) {
        e.stopPropagation();
        document.getElementById('room-video-thumb-input').value = '';
        var preview = document.getElementById('room-video-thumb-preview');
        if (preview) { preview.style.display = 'none'; preview.querySelector('img').src = ''; }
        $(this).hide();
    });

    // Reset editingEl if modal closed without confirming
    $(document).on('hidden.bs.modal', '#room-add-video-modal', function () {
        editingEl = null;
    });

});