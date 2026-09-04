<div id="button-contact-vr" class="d-none d-sm-block">
    <div id="gom-all-in-one" class="chat-icons-collapsible">
        @if($facebook = theme_option('chat_btn_facebook'))
            <div id="fanpage-vr" class="button-contact">
                <a target="_blank" href="{{$facebook}}">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/Facebook.png"
                                 alt="{{$facebook}}">

                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if($tiktok = theme_option('chat_btn_tiktok'))
            <div id="tiktok-vr" class="button-contact">
                <a target="_blank" href="{{ $tiktok }}">

                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/tiktok.png"
                                 alt="{{$tiktok}}">

                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if($zalo = theme_option('chat_btn_zalo'))
            <div id="zalo-vr" class="button-contact">
                <a target="_blank" href="{{$zalo}}">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">

                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/zalo.png"
                                 alt="{{$zalo}}">
                        </div>
                    </div>
                </a>

            </div>
        @endif
        @if($inta = theme_option('chat_btn_instagram'))
            <div id="instagram-vr" class="button-contact">
                <a target="_blank" href="{{ $inta }}">

                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/instagram.png"
                                 alt="{{$inta}}">

                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if($telegram = theme_option('chat_btn_telegram'))
            <div id="telegram-vr" class="button-contact">
                <a target="_blank" href="{{ $telegram }}">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/telegram.svg"
                                 alt="Telegram">
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if($whatsapp = theme_option('chat_btn_whatsapp'))
            <div id="whatsapp-vr" class="button-contact">
                <a target="_blank" href="{{ $whatsapp }}">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/whatsapp.svg"
                                 alt="WhatsApp">
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if ($hotline = theme_option('hotline'))
            <div id="phone-vr" class="button-contact">
                <a href="tel:{{ $hotline }}">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/phone.png"
                                 alt="{{$hotline}}">
                        </div>
                    </div>
                </a>
            </div>
        @endif

    </div>

    {{-- Contact toggle button --}}
    <div id="contact-toggle-vr" class="button-contact" onclick="toggleChatIcons(this)" style="cursor:pointer;margin-top:-5px">
        <div class="phone-vr">
            <div class="phone-vr-circle-fill"></div>
            <div class="phone-vr-img-circle">
                {{-- Chat icon (shown when closed) --}}
                <svg class="icon-contact-default" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="22" height="22" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
                </svg>
                {{-- Close icon (shown when open) --}}
                <svg class="icon-contact-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="20" height="20" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);display:none">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<style>
    #gom-all-in-one.chat-icons-collapsible {
        position: absolute;
        bottom: 100%;
        right: 0;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.5s ease, opacity 0.4s ease;
    }
    #gom-all-in-one.chat-icons-collapsible.chat-open {
        max-height: 1000px;
        opacity: 1;
    }
    #contact-toggle-vr .phone-vr-circle-fill {
        background-color: var(--primary-color);
        opacity: 0.75;
        box-shadow: 0 0 0 0 var(--primary-color);
    }
    #contact-toggle-vr .phone-vr-img-circle {
        background-color: var(--primary-color);
        transition: background-color 0.3s ease;
    }
    #contact-toggle-vr.chat-open .phone-vr-img-circle {
        background-color: #e53935;
    }
    #contact-toggle-vr.chat-open .phone-vr-circle-fill {
        background-color: rgba(229, 57, 53, 0.7);
        box-shadow: 0 0 0 0 #e53935;
    }
    #contact-toggle-vr.chat-open .icon-contact-default { display: none !important; }
    #contact-toggle-vr.chat-open .icon-contact-close   { display: block !important; }
</style>

<script>
    function toggleChatIcons(btn) {
        document.getElementById('gom-all-in-one').classList.toggle('chat-open');
        btn.classList.toggle('chat-open');
    }
</script>

