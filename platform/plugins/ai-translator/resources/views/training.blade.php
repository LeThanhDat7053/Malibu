@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">AI Translation Prompt</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Write custom instructions for the AI translator below. These instructions are injected into every translation request to improve accuracy and consistency.
                    </p>

                    <form id="training-prompt-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="ai_translator_prompt"><strong>Translation Instructions</strong></label>
                            <textarea class="form-control" id="ai_translator_prompt" name="ai_translator_prompt" rows="14"
                                      placeholder="Write your translation rules here...&#10;&#10;Examples:&#10;- Keep brand name 'Boton Blue' untranslated in all languages.&#10;- Use formal/polite tone for Korean translations.&#10;- 'Deluxe Room' should be translated as 'Phòng Deluxe' in Vietnamese.&#10;- 'Check-in' should be translated as '체크인' in Korean.&#10;- Do not translate technical terms like 'WiFi', 'GPS', 'VR360'.&#10;- For Vietnamese: use 'Phòng' instead of 'Buồng' for room types.&#10;- Always preserve HTML tags and structure, only translate text content.">{{ setting('ai_translator_prompt') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Prompt
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title">How It Works</h4>
                </div>
                <div class="card-body">
                    <p class="small text-muted">The instructions you write here are included in every AI translation request as part of the system prompt.</p>

                    <h6>What to include:</h6>
                    <ul class="small text-muted">
                        <li><strong>Brand names</strong> that should NOT be translated</li>
                        <li><strong>Glossary terms</strong> with preferred translations</li>
                        <li><strong>Tone/style</strong> preferences per language</li>
                        <li><strong>Technical terms</strong> to keep as-is</li>
                        <li><strong>Formatting rules</strong> for specific content types</li>
                    </ul>

                    <div class="alert alert-info small mb-0">
                        <i class="fa fa-lightbulb me-1"></i>
                        Tip: Be specific. Instead of "translate properly", write exact rules like "Always translate 'Resort' as 'Khu nghỉ dưỡng' in Vietnamese."
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('footer')
<script>
    'use strict';
    $(function() {
        $('#training-prompt-form').on('submit', function(e) {
            e.preventDefault();
            var btn = $(this).find('button[type=submit]');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            $.post('{{ route("ai-translator.settings.save") }}', {
                _token: '{{ csrf_token() }}',
                ai_translator_prompt: $('#ai_translator_prompt').val(),
                ai_translator_api_key: '{{ setting("ai_translator_api_key") }}',
                ai_translator_model: '{{ setting("ai_translator_model", "gpt-4o-mini") }}'
            })
            .done(function(res) {
                Botble.showSuccess(res.message || 'Prompt saved!');
            })
            .fail(function(xhr) {
                Botble.showError(xhr.responseJSON?.message || 'Failed to save.');
            })
            .always(function() {
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Prompt');
            });
        });
    });
</script>
@endpush
