$(() => {
    $('.generate-thumbnails-trigger-button').on('click', (event) => {
        event.preventDefault()

        const currentTarget = $(event.currentTarget)

        const $form = currentTarget.closest('form')

        $httpClient
            .make()
            .withButtonLoading(currentTarget)
            .postForm($form.prop('action'), new FormData($form[0]))
            .then(({ data }) => {
                const $modal = $('#generate-thumbnails-modal')

                $modal.modal('show')
                $modal.data('total-files', data.data.files_count)
            })
    })

    $('#generate-thumbnails-button').on('click', (event) => {
        event.preventDefault()

        const currentTarget = $(event.currentTarget)

        const $modal = currentTarget.closest('.modal')
        const $form = currentTarget.closest('form')

        const totalFiles = $modal.data('total-files')
        let message = null

        Botble.showButtonLoading(currentTarget)

        function sendRequest(offset = 0, limit = $modal.data('chunk-limit')) {
            if (offset > totalFiles) {
                Botble.hideButtonLoading(currentTarget)
                $modal.modal('hide')

                Botble.showSuccess(message)

                return
            }

            $httpClient
                .make()
                .post($form.prop('action'), { total: totalFiles, offset, limit })
                .then(({ data }) => {
                    message = data.message

                    if (data.data.next) {
                        sendRequest(data.data.next, limit)
                    }
                })
                .finally(() => {
                    if (offset > totalFiles) {
                        Botble.hideButtonLoading(currentTarget)
                        $modal.modal('hide')
                    }
                })
        }

        sendRequest()
    })

    $(document).on('change', '.check-all', (event) => {
        const currentTarget = $(event.currentTarget)
        const set = currentTarget.attr('data-set')
        const checked = currentTarget.prop('checked')

        $(set).each((index, el) => {
            $(el).prop('checked', checked)
        })
    })

    const resizeTool = $('#media-resize-tool')

    if (! resizeTool.length) {
        return
    }

    const $scanButton = $('#media-resize-scan-button')
    const $startButton = $('#media-resize-start-button')
    const $status = $('#media-resize-status')
    const $progressText = $('#media-resize-progress-text')
    const $progressBar = $('#media-resize-progress-bar')
    const $log = $('#media-resize-log')

    const state = {
        running: false,
        totalCandidates: 0,
        processed: 0,
        optimized: 0,
        skipped: 0,
        failed: 0,
        savedBytes: 0,
    }

    const formatNumber = (value) => new Intl.NumberFormat().format(value || 0)

    const formatBytes = (bytes) => {
        if (! bytes) {
            return '0 MB'
        }

        const units = ['B', 'KB', 'MB', 'GB', 'TB']
        let value = bytes
        let unitIndex = 0

        while (value >= 1024 && unitIndex < units.length - 1) {
            value /= 1024
            unitIndex++
        }

        return `${value.toFixed(unitIndex === 0 ? 0 : 2)} ${units[unitIndex]}`
    }

    const collectOptions = () => ({
        max_width: Number($('#resize-max-width').val()) || null,
        max_height: Number($('#resize-max-height').val()) || null,
        quality: Number($('#resize-quality').val()) || 82,
        min_file_size_kb: Number($('#resize-min-size').val()) || 0,
        batch_size: Number($('#resize-batch-size').val()) || 20,
    })

    const appendLog = (message, replace = false) => {
        const currentValue = replace || $log.val() === 'No data yet.' ? '' : `${$log.val()}\n`
        $log.val(`${currentValue}${message}`)
        $log.scrollTop($log[0].scrollHeight)
    }

    const updateCounters = () => {
        $('#media-resize-optimized-count').text(formatNumber(state.optimized))
        $('#media-resize-skipped-count').text(formatNumber(state.skipped))
        $('#media-resize-failed-count').text(formatNumber(state.failed))
        $('#media-resize-saved-size').text(formatBytes(state.savedBytes))
    }

    const updateSummary = (data) => {
        $('#media-resize-total-images').text(formatNumber(data.total_images))
        $('#media-resize-candidate-images').text(formatNumber(data.candidate_images))
        $('#media-resize-candidate-size').text(formatBytes(data.candidate_size))
    }

    const updateProgress = () => {
        const percent = state.totalCandidates > 0
            ? Math.min(100, Math.round((state.processed / state.totalCandidates) * 100))
            : 0

        $progressText.text(`${formatNumber(state.processed)} / ${formatNumber(state.totalCandidates)}`)
        $progressBar.css('width', `${percent}%`).attr('aria-valuenow', percent)
    }

    const resetState = () => {
        state.processed = 0
        state.optimized = 0
        state.skipped = 0
        state.failed = 0
        state.savedBytes = 0
        updateCounters()
        updateProgress()
    }

    const scanCandidates = () => $httpClient
        .make()
        .post(resizeTool.data('scan-url'), collectOptions())
        .then(({ data }) => {
            const summary = data.data

            state.totalCandidates = summary.candidate_images || 0
            updateSummary(summary)
            updateProgress()

            const message = `Found ${formatNumber(summary.candidate_images)} eligible images out of ${formatNumber(summary.total_images)} supported images.`
            $status.text(message)
            appendLog(message, true)

            return summary
        })

    const finishResize = () => {
        state.running = false
        Botble.hideButtonLoading($startButton)
        Botble.hideButtonLoading($scanButton)

        const finalMessage = `Completed. Optimized ${formatNumber(state.optimized)} images, skipped ${formatNumber(state.skipped)}, failed ${formatNumber(state.failed)}.`

        $status.text(finalMessage)
        appendLog(finalMessage)
        Botble.showSuccess(finalMessage)
    }

    const processBatch = (lastId = 0) => {
        $status.text(`Processing... ${formatNumber(state.processed)} / ${formatNumber(state.totalCandidates)}`)

        return $httpClient
            .make()
            .post(resizeTool.data('process-url'), {
                ...collectOptions(),
                last_id: lastId,
            })
            .then(({ data }) => {
                const result = data.data

                state.processed += result.processed || 0
                state.optimized += result.optimized || 0
                state.skipped += result.skipped || 0
                state.failed += result.failed || 0
                state.savedBytes += result.saved_bytes || 0

                updateCounters()
                updateProgress()

                const batchMessage = `Batch complete: processed ${formatNumber(result.processed)} images, optimized ${formatNumber(result.optimized)}, skipped ${formatNumber(result.skipped)}, failed ${formatNumber(result.failed)}.`
                appendLog(batchMessage)

                if (Array.isArray(result.errors) && result.errors.length) {
                    result.errors.forEach((errorPath) => appendLog(`Failed file: ${errorPath}`))
                }

                if (result.has_more) {
                    return processBatch(result.next_id || 0)
                }

                finishResize()
            })
            .catch((error) => {
                state.running = false
                Botble.hideButtonLoading($startButton)
                Botble.hideButtonLoading($scanButton)
                $status.text('Stopped because an error occurred.')
                appendLog('Stopped because an error occurred.')
                throw error
            })
    }

    $scanButton.on('click', (event) => {
        event.preventDefault()

        if (state.running) {
            return
        }

        Botble.showButtonLoading($scanButton)

        scanCandidates().finally(() => {
            Botble.hideButtonLoading($scanButton)
        })
    })

    $startButton.on('click', (event) => {
        event.preventDefault()

        if (state.running) {
            return
        }

        state.running = true
        resetState()
        Botble.showButtonLoading($startButton)

        scanCandidates()
            .then((summary) => {
                if (! summary.candidate_images) {
                    state.running = false
                    Botble.hideButtonLoading($startButton)
                    $status.text('No images match the current conditions.')
                    appendLog('No images match the current conditions.', true)

                    return
                }

                appendLog('Starting bulk resize...')

                return processBatch(0)
            })
    })
})
