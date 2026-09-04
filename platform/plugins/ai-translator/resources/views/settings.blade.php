@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title">OpenAI API Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('ai-translator.settings.save') }}" method="POST" id="ai-translator-settings-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="ai_translator_api_key">OpenAI API Key</label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control"
                                       name="ai_translator_api_key"
                                       id="ai_translator_api_key"
                                       value="{{ setting('ai_translator_api_key') }}"
                                       placeholder="sk-...">
                                <button type="button" class="btn btn-outline-secondary" id="toggle-api-key">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Get your API key from <a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener">OpenAI Platform</a></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ai_translator_model">AI Model</label>
                            <select class="form-select" name="ai_translator_model" id="ai_translator_model">
                                @php $currentModel = setting('ai_translator_model', 'gpt-4o-mini'); @endphp
                                <optgroup label="🟢 Recommended">
                                    <option value="gpt-4.1-nano" {{ $currentModel === 'gpt-4.1-nano' ? 'selected' : '' }}>GPT-4.1 Nano — Cheapest ($0.10/1M input)</option>
                                    <option value="gpt-4o-mini" {{ $currentModel === 'gpt-4o-mini' ? 'selected' : '' }}>GPT-4o Mini — Fast & Cheap ($0.15/1M input)</option>
                                    <option value="gpt-4.1-mini" {{ $currentModel === 'gpt-4.1-mini' ? 'selected' : '' }}>GPT-4.1 Mini — Balanced ($0.40/1M input)</option>
                                </optgroup>
                                <optgroup label="⭐ High Quality">
                                    <option value="gpt-4.1" {{ $currentModel === 'gpt-4.1' ? 'selected' : '' }}>GPT-4.1 — Smart ($2.00/1M input)</option>
                                    <option value="gpt-4o" {{ $currentModel === 'gpt-4o' ? 'selected' : '' }}>GPT-4o — Great Quality ($2.50/1M input)</option>
                                    <option value="gpt-4.5-preview" {{ $currentModel === 'gpt-4.5-preview' ? 'selected' : '' }}>GPT-4.5 Preview — Best Quality ($75.00/1M input)</option>
                                </optgroup>
                                <optgroup label="🧠 Reasoning (o-series)">
                                    <option value="o4-mini" {{ $currentModel === 'o4-mini' ? 'selected' : '' }}>O4 Mini — Fast Reasoning ($1.10/1M input)</option>
                                    <option value="o3-mini" {{ $currentModel === 'o3-mini' ? 'selected' : '' }}>O3 Mini — Reasoning ($1.10/1M input)</option>
                                    <option value="o3" {{ $currentModel === 'o3' ? 'selected' : '' }}>O3 — Deep Reasoning ($2.00/1M input)</option>
                                    <option value="o1" {{ $currentModel === 'o1' ? 'selected' : '' }}>O1 — Advanced Reasoning ($15.00/1M input)</option>
                                    <option value="o1-mini" {{ $currentModel === 'o1-mini' ? 'selected' : '' }}>O1 Mini — Reasoning ($1.10/1M input)</option>
                                </optgroup>
                                <optgroup label="📜 Legacy">
                                    <option value="gpt-4-turbo" {{ $currentModel === 'gpt-4-turbo' ? 'selected' : '' }}>GPT-4 Turbo ($10.00/1M input)</option>
                                    <option value="gpt-4" {{ $currentModel === 'gpt-4' ? 'selected' : '' }}>GPT-4 ($30.00/1M input)</option>
                                    <option value="gpt-3.5-turbo" {{ $currentModel === 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo ($0.50/1M input)</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ai_translator_prompt">Translation Prompt</label>
                            <textarea
                                class="form-control"
                                name="ai_translator_prompt"
                                id="ai_translator_prompt"
                                rows="8"
                                placeholder="Write the fixed instructions you want applied to every translation request."
                            >{{ setting('ai_translator_prompt') }}</textarea>
                            <small class="text-muted">
                                This prompt is shared across all models and will stay intact when you switch models.
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Settings
                            </button>
                            <button type="button" class="btn btn-outline-info" id="test-connection-btn">
                                <i class="fa fa-plug"></i> Test Connection
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Quick Translation Test</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">Source Language</label>
                                <select class="form-select" id="test-source-lang">
                                    <option value="en">English</option>
                                    <option value="vi">Vietnamese</option>
                                    <option value="ko">Korean</option>
                                    <option value="zh">Chinese</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Text to translate</label>
                                <textarea class="form-control" id="test-source-text" rows="5" placeholder="Enter text to translate..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-success" id="test-translate-btn">
                                <i class="fa fa-language"></i> Translate
                            </button>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">Target Language</label>
                                <select class="form-select" id="test-target-lang">
                                    <option value="vi">Vietnamese</option>
                                    <option value="ko">Korean</option>
                                    <option value="en">English</option>
                                    <option value="zh">Chinese</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Translation Result</label>
                                <textarea class="form-control" id="test-result-text" rows="5" readonly placeholder="Translation will appear here..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="test-translation-info" class="text-muted small" style="display:none;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title">Usage This Month</h4>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Total Requests:</strong>
                        <span class="float-end">{{ number_format($stats['total_requests']) }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>Input Tokens:</strong>
                        <span class="float-end">{{ number_format($stats['total_input_tokens']) }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>Output Tokens:</strong>
                        <span class="float-end">{{ number_format($stats['total_output_tokens']) }}</span>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <strong>Estimated Cost:</strong>
                        <span class="float-end text-primary">${{ number_format($stats['total_cost'], 4) }}</span>
                    </div>
                </div>
                <div class="card-footer">
                    @if(($stats['source'] ?? 'local') === 'openai_api')
                        <span class="badge bg-success mb-2"><i class="fa fa-check-circle"></i> Data from OpenAI API (accurate)</span>
                    @else
                        <span class="badge bg-warning text-dark mb-2"><i class="fa fa-info-circle"></i> Local tracking (estimated)</span>
                    @endif
                    <div class="d-flex gap-2 align-items-center">
                        <a href="https://platform.openai.com/usage" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-external-link-alt"></i> OpenAI Usage Dashboard
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="reset-usage-btn">
                            <i class="fa fa-trash"></i> Reset Local Stats
                        </button>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title">Pricing Reference</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr><th>Model</th><th>Input</th><th>Output</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>GPT-4.1 Nano</td><td>$0.10/1M</td><td>$0.40/1M</td></tr>
                            <tr><td>GPT-4o Mini</td><td>$0.15/1M</td><td>$0.60/1M</td></tr>
                            <tr><td>GPT-3.5 Turbo</td><td>$0.50/1M</td><td>$1.50/1M</td></tr>
                            <tr><td>O4 Mini / O3 Mini</td><td>$1.10/1M</td><td>$4.40/1M</td></tr>
                            <tr><td>GPT-4.1 Mini</td><td>$0.40/1M</td><td>$1.60/1M</td></tr>
                            <tr><td>GPT-4.1 / O3</td><td>$2.00/1M</td><td>$8.00/1M</td></tr>
                            <tr><td>GPT-4o</td><td>$2.50/1M</td><td>$10.00/1M</td></tr>
                            <tr><td>GPT-4 Turbo</td><td>$10.00/1M</td><td>$30.00/1M</td></tr>
                            <tr><td>O1</td><td>$15.00/1M</td><td>$60.00/1M</td></tr>
                            <tr><td>GPT-4</td><td>$30.00/1M</td><td>$60.00/1M</td></tr>
                            <tr><td>GPT-4.5 Preview</td><td>$75.00/1M</td><td>$150.00/1M</td></tr>
                        </tbody>
                    </table>
                    <small class="text-muted mt-1 d-block">1 page of text ≈ 500 tokens. Translating 100 pages ≈ $0.01-$0.25 depending on model.</small>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('footer')
<script>
    'use strict';
    $(function() {
        // Toggle API key visibility
        $('#toggle-api-key').on('click', function() {
            var input = $('#ai_translator_api_key');
            var icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Save settings
        $('#ai-translator-settings-form').on('submit', function(e) {
            e.preventDefault();
            var btn = $(this).find('button[type=submit]');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    Botble.showSuccess(res.message || 'Settings saved!');
                },
                error: function(xhr) {
                    Botble.showError(xhr.responseJSON?.message || 'Failed to save settings.');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Settings');
                }
            });
        });

        // Test connection
        $('#test-connection-btn').on('click', function() {
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Testing...');

            $.post('{{ route("ai-translator.test-connection") }}', {_token: '{{ csrf_token() }}'})
                .done(function(res) {
                    Botble.showSuccess(res.message || 'Connection OK!');
                })
                .fail(function(xhr) {
                    Botble.showError(xhr.responseJSON?.message || 'Connection failed.');
                })
                .always(function() {
                    btn.prop('disabled', false).html('<i class="fa fa-plug"></i> Test Connection');
                });
        });

        // Quick translation test
        $('#test-translate-btn').on('click', function() {
            var btn = $(this);
            var text = $('#test-source-text').val().trim();
            if (!text) { Botble.showError('Please enter text to translate.'); return; }

            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $('#test-result-text').val('Translating...');

            $.post('{{ route("ai-translator.translate") }}', {
                _token: '{{ csrf_token() }}',
                text: text,
                source_language: $('#test-source-lang').val(),
                target_language: $('#test-target-lang').val(),
                field_type: 'text'
            })
            .done(function(res) {
                if (res.error) {
                    $('#test-result-text').val('Error: ' + (res.message || 'Unknown error'));
                } else {
                    $('#test-result-text').val(res.data.translated);
                    $('#test-translation-info')
                        .show()
                        .html('Tokens: ' + (res.data.tokens?.input || 0) + ' in / ' + (res.data.tokens?.output || 0) + ' out | Cost: $' + (res.data.cost || 0).toFixed(6));
                }
            })
            .fail(function(xhr) {
                $('#test-result-text').val('Error: ' + (xhr.responseJSON?.message || 'Request failed'));
            })
            .always(function() {
                btn.prop('disabled', false).html('<i class="fa fa-language"></i> Translate');
            });
        });

        // Reset usage stats (uses GET redirect to avoid 401)
        $('#reset-usage-btn').on('click', function() {
            if (!confirm('Are you sure you want to reset local usage statistics?')) {
                return;
            }
            window.location.href = '{{ route("ai-translator.settings") }}?reset_usage=1';
        });
    });
</script>
@endpush
