<ul <?php echo BaseHelper::clean($options); ?>>
    <?php $__currentLoopData = $menu_nodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isRoomsNode = theme_is_rooms_menu_node($row);
            $roomTree = $isRoomsNode ? theme_rooms_menu_tree() : collect();
            $hasSub = $row->has_child || $roomTree->isNotEmpty();
        ?>
        <li class="nav-item">
            <a href="<?php echo e($row->url); ?>"
               class="<?php echo \Illuminate\Support\Arr::toCssClasses(['nav-link collapsed', 'has-sub' => $hasSub, 'active' => $row->active]); ?>"
               target="<?php echo e($row->target); ?>"
               <?php if($hasSub): ?>
                   data-bs-toggle="collapse"
                   data-bs-target="#menu-collapse-<?php echo e($row->id); ?>"
                   aria-expanded="false"
                   aria-controls="menu-collapse-<?php echo e($row->id); ?>"
               <?php endif; ?>
            ><?php echo e($row->title); ?></a>
        </li>

        <?php if($isRoomsNode && $roomTree->isNotEmpty()): ?>
            <div class="collapse" id="menu-collapse-<?php echo e($row->id); ?>">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
                    <?php $__currentLoopData = $roomTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupIndex => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($groupId = 'menu-collapse-' . $row->id . '-cat-' . $groupIndex); ?>
                        <li class="nav-item">
                            <a href="<?php echo e($group->url); ?>"
                               class="<?php echo \Illuminate\Support\Arr::toCssClasses(['nav-link collapsed', 'has-sub' => $group->children->isNotEmpty(), 'active' => $group->active]); ?>"
                               target="_self"
                               <?php if($group->children->isNotEmpty()): ?>
                                   data-bs-toggle="collapse"
                                   data-bs-target="#<?php echo e($groupId); ?>"
                                   aria-expanded="false"
                                   aria-controls="<?php echo e($groupId); ?>"
                               <?php endif; ?>
                            ><?php echo e($group->title); ?></a>
                        </li>
                        <?php if($group->children->isNotEmpty()): ?>
                            <div class="collapse" id="<?php echo e($groupId); ?>">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
                                    <?php $__currentLoopData = $group->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e($child->url); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['nav-link collapsed', 'active' => $child->active]); ?>" target="_self"><?php echo e($child->title); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php elseif($row->has_child): ?>
            <div class="collapse" id="menu-collapse-<?php echo e($row->id); ?>">
                <?php echo Menu::renderMenuLocation('main-menu', [
                    'menu_nodes' => $row->child,
                    'view' => 'menu-mobile',
                    'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0 ms-3'],
                ]); ?>

            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\main\platform\themes/riorelax/partials/menu-mobile.blade.php ENDPATH**/ ?>