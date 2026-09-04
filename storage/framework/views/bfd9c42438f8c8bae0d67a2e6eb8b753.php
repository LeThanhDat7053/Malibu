<?php ($fullWidth =  $fullWidth ?? false); ?>

<div class="header-top second-header d-none d-md-block">
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['container' => ! $fullWidth, 'container-fluid' => $fullWidth]); ?>">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 d-none d-lg-block header-top-left">
                <div class="header-cta">
                    <ul>
                        <?php if($openingHours = theme_option('opening_hours')): ?>
                            <li class="opening_hours">
                                <i class="far fa-clock"></i>
                                <span><?php echo BaseHelper::clean($openingHours); ?></span>
                            </li>
                        <?php endif; ?>

                        <?php if($phoneNumber = theme_option('hotline')): ?>
                            <li>
                                <i class="far fa-mobile"></i>
                                <strong><a href="tel:<?php echo e($phoneNumber); ?>"><?php echo e($phoneNumber); ?></a></strong>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 d-none d-lg-block text-end header-top-end">
                <div class="header-social">
                    <?php echo Theme::partial('language-switcher'); ?>

                    <?php if($socialLinks = json_decode(theme_option('social_links'))): ?>
                        <span class="social-links">
                            <?php $__currentLoopData = $socialLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php ($social = collect($social)->pluck('value', 'key')); ?>
                                <a target="_blank" href="<?php echo e($social->get('url')); ?>" title="<?php echo e($social->get('name')); ?>"><i class="<?php echo e($social->get('social-icon')); ?>"></i></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="language-switcher-mobile d-none">
    <?php echo Theme::partial('language-switcher-mobile'); ?>

</div>

<div class="currency-switcher-mobile d-none">
    <?php echo Theme::partial('currency-switcher-mobile'); ?>

</div>
<?php /**PATH C:\laragon\www\main\platform\themes/riorelax/partials/header-top.blade.php ENDPATH**/ ?>