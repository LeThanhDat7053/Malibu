@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div
        id="media-resize-tool"
        data-scan-url="{{ route('settings.media.resize-images.scan') }}"
        data-process-url="{{ route('settings.media.resize-images.process') }}"
    >
        <x-core::card>
            <x-core::card.header>
                <x-core::card.title>Resize old images in Media</x-core::card.title>
            </x-core::card.header>

            <div class="card-body">
                <div class="alert alert-warning">
                    This tool processes existing images stored on the server, overwrites the original file in place,
                    and keeps the same filename, path, and extension. After optimizing an original image, the system
                    will regenerate its thumbnails to keep displayed sizes consistent.
                </div>

                <div class="alert alert-info">
                    Back up your media directory before running a full batch. For safety, scan first and then start
                    the bulk resize process.
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label" for="resize-max-width">Max width</label>
                        <input
                            id="resize-max-width"
                            class="form-control"
                            type="number"
                            min="500"
                            max="10000"
                            value="{{ $defaultMaxWidth }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="resize-max-height">Max height</label>
                        <input
                            id="resize-max-height"
                            class="form-control"
                            type="number"
                            min="500"
                            max="10000"
                            value="{{ $defaultMaxHeight }}"
                        >
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="resize-quality">Quality</label>
                        <input
                            id="resize-quality"
                            class="form-control"
                            type="number"
                            min="40"
                            max="100"
                            value="{{ $defaultQuality }}"
                        >
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="resize-min-size">Min size (KB)</label>
                        <input
                            id="resize-min-size"
                            class="form-control"
                            type="number"
                            min="0"
                            value="{{ $defaultMinFileSizeKb }}"
                        >
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="resize-batch-size">Batch size</label>
                        <input
                            id="resize-batch-size"
                            class="form-control"
                            type="number"
                            min="1"
                            max="100"
                            value="{{ $defaultBatchSize }}"
                        >
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <x-core::button
                        type="button"
                        color="info"
                        id="media-resize-scan-button"
                    >
                        Scan eligible images
                    </x-core::button>

                    <x-core::button
                        type="button"
                        color="primary"
                        id="media-resize-start-button"
                    >
                        Start bulk resize
                    </x-core::button>

                    <x-core::button
                        tag="a"
                        type="button"
                        color="secondary"
                        href="{{ route('settings.media') }}"
                    >
                        Back to Media settings
                    </x-core::button>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-secondary small mb-1">Total supported images</div>
                            <div class="fs-4 fw-semibold" id="media-resize-total-images">0</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-secondary small mb-1">Eligible images</div>
                            <div class="fs-4 fw-semibold" id="media-resize-candidate-images">0</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-secondary small mb-1">Total size of eligible images</div>
                            <div class="fs-4 fw-semibold" id="media-resize-candidate-size">0 MB</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-2">
                        <span id="media-resize-status">Not started.</span>
                        <span id="media-resize-progress-text">0 / 0</span>
                    </div>
                    <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div
                            id="media-resize-progress-bar"
                            class="progress-bar progress-bar-striped"
                            style="width: 0%;"
                        ></div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="border rounded p-3 h-100">
                            <div class="text-secondary small mb-1">Optimized</div>
                            <div class="fs-4 fw-semibold text-success" id="media-resize-optimized-count">0</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3 h-100">
                            <div class="text-secondary small mb-1">Skipped</div>
                            <div class="fs-4 fw-semibold" id="media-resize-skipped-count">0</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3 h-100">
                            <div class="text-secondary small mb-1">Failed</div>
                            <div class="fs-4 fw-semibold text-danger" id="media-resize-failed-count">0</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3 h-100">
                            <div class="text-secondary small mb-1">Space saved</div>
                            <div class="fs-4 fw-semibold text-primary" id="media-resize-saved-size">0 MB</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label mb-2" for="media-resize-log">Processing log</label>
                    <textarea
                        id="media-resize-log"
                        class="form-control font-monospace"
                        rows="10"
                        readonly
                    >No data yet.</textarea>
                </div>
            </div>
        </x-core::card>
    </div>
@stop
