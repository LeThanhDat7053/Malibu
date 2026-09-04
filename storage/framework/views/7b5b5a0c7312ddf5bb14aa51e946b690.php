<div id="button-contact-vr" class="d-none d-sm-block">
    <div id="gom-all-in-one" class="chat-icons-collapsible">
        <?php if($facebook = theme_option('chat_btn_facebook')): ?>
            <div id="fanpage-vr" class="button-contact">
                <a target="_blank" href="<?php echo e($facebook); ?>">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/Facebook.png"
                                 alt="<?php echo e($facebook); ?>">

                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if($tiktok = theme_option('chat_btn_tiktok')): ?>
            <div id="tiktok-vr" class="button-contact">
                <a target="_blank" href="<?php echo e($tiktok); ?>">

                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/tiktok.png"
                                 alt="<?php echo e($tiktok); ?>">

                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if($zalo = theme_option('chat_btn_zalo')): ?>
            <div id="zalo-vr" class="button-contact">
                <a target="_blank" href="<?php echo e($zalo); ?>">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">

                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/zalo.png"
                                 alt="<?php echo e($zalo); ?>">
                        </div>
                    </div>
                </a>

            </div>
        <?php endif; ?>
        <?php if($inta = theme_option('chat_btn_instagram')): ?>
            <div id="instagram-vr" class="button-contact">
                <a target="_blank" href="<?php echo e($inta); ?>">

                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/instagram.png"
                                 alt="<?php echo e($inta); ?>">

                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if($telegram = theme_option('chat_btn_telegram')): ?>
            <div id="telegram-vr" class="button-contact">
                <a target="_blank" href="<?php echo e($telegram); ?>">
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
        <?php endif; ?>
        <?php if($whatsapp = theme_option('chat_btn_whatsapp')): ?>
            <div id="whatsapp-vr" class="button-contact">
                <a target="_blank" href="<?php echo e($whatsapp); ?>">
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
        <?php endif; ?>
        <?php if($hotline = theme_option('hotline')): ?>
            <div id="phone-vr" class="button-contact">
                <a href="tel:<?php echo e($hotline); ?>">
                    <div class="phone-vr">
                        <div class="phone-vr-circle-fill"></div>
                        <div class="phone-vr-img-circle">
                            <img data-bb-lazy="true" width="200" height="200" loading="lazy"
                                 src="/vendor/core/plugins/popup-chat/images/phone.png"
                                 alt="<?php echo e($hotline); ?>">
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

    </div>

    
    <div id="contact-toggle-vr" class="button-contact" onclick="toggleChatIcons(this)" style="cursor:pointer;margin-top:-5px">
        <div class="phone-vr">
            <div class="phone-vr-circle-fill"></div>
            <div class="phone-vr-img-circle">
                
                <svg class="icon-contact-default" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="22" height="22" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
                </svg>
                
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

<?php /**PATH C:\laragon\www\main\platform\plugins\botble-popup-chat-icon/resources/views/show.blade.php ENDPATH**/ ?>