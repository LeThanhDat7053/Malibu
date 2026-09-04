<?php echo SeoHelper::render(); ?>

<link
    rel="sitemap"
    title="Sitemap"
    href="<?php echo e(rescue(fn() => route('public.sitemap'), report: false)); ?>"
    type="application/xml"
>

<?php
    $themeFavicon = theme_option('favicon');
    $faviconUrl = $themeFavicon ? RvMedia::getImageUrl($themeFavicon) : asset('favicon.ico');
    $faviconExtension = strtolower(pathinfo(parse_url($faviconUrl, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION));
    $faviconType = match ($faviconExtension) {
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
        'gif' => 'image/gif',
        'jpg', 'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        default => 'image/x-icon',
    };
?>

<link rel="icon" href="<?php echo e($faviconUrl); ?>" type="<?php echo e($faviconType); ?>">
<link rel="shortcut icon" href="<?php echo e($faviconUrl); ?>" type="<?php echo e($faviconType); ?>">
<link rel="apple-touch-icon" href="<?php echo e($faviconUrl); ?>">

<?php if(Theme::has('headerMeta')): ?>
    <?php echo Theme::get('headerMeta'); ?>

<?php endif; ?>

<?php echo apply_filters('theme_front_meta', null); ?>


<?php echo Theme::typography()->renderCssVariables(); ?>


<?php echo Theme::asset()->container('before_header')->styles(); ?>

<?php echo Theme::asset()->styles(); ?>

<?php echo Theme::asset()->container('after_header')->styles(); ?>

<?php echo Theme::asset()->container('header')->scripts(); ?>


<?php echo apply_filters(THEME_FRONT_HEADER, null); ?>


<?php echo SeoHelper::meta()->getAnalytics()->render(); ?>


<script>
    window.siteUrl = "<?php echo e(rescue(fn() => BaseHelper::getHomepageUrl())); ?>";
</script>
<?php /**PATH C:\laragon\www\main\platform\packages\theme\/resources/views/partials/header.blade.php ENDPATH**/ ?>