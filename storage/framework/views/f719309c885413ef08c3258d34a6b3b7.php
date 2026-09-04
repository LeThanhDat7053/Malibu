<ul <?php echo BaseHelper::clean($options); ?>>
    <?php $__currentLoopData = $menu_nodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isRoomsNode = theme_is_rooms_menu_node($row);
            $roomTree = $isRoomsNode ? theme_rooms_menu_tree() : collect();
            $hasSub = $row->has_child || $roomTree->isNotEmpty();
        ?>
        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['has-sub' => $hasSub, $row->css_class]); ?>">
            <a class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => $row->active]); ?>" href="<?php echo e($row->url); ?>" target="<?php echo e($row->target); ?>">
                <?php if($iconImage = $row->getMetaData('icon_image', true)): ?>
                    <img src="<?php echo e(RvMedia::getImageUrl($iconImage)); ?>" alt="<?php echo e($row->title); ?>" loading="lazy"/>
                <?php elseif($row->icon_font): ?>
                    <i class="<?php echo e(trim($row->icon_font)); ?>"></i>
                <?php endif; ?>

                <?php echo e($row->title); ?>

            </a>
            <?php if($isRoomsNode && $roomTree->isNotEmpty()): ?>
                <ul class="sub-menu">
                    <?php $__currentLoopData = $roomTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['has-sub' => $group->children->isNotEmpty()]); ?>">
                            <a class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => $group->active]); ?>" href="<?php echo e($group->url); ?>"><?php echo e($group->title); ?></a>
                            <?php if($group->children->isNotEmpty()): ?>
                                <ul class="sub-menu">
                                    <?php $__currentLoopData = $group->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => $child->active]); ?>" href="<?php echo e($child->url); ?>"><?php echo e($child->title); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php elseif($row->has_child): ?>
                <?php echo Menu::renderMenuLocation('main-menu', [
                    'menu_nodes' => $row->child,
                    'view' => 'main-menu',
                    'options' => ['class' => 'sub-menu'],
                ]); ?>

            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\main\platform\themes/riorelax/partials/main-menu.blade.php ENDPATH**/ ?>