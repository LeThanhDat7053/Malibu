<ul {!! BaseHelper::clean($options) !!}>
    @foreach ($menu_nodes as $row)
        @php
            $isRoomsNode = theme_is_rooms_menu_node($row);
            $roomTree = $isRoomsNode ? theme_rooms_menu_tree() : collect();
            $hasSub = $row->has_child || $roomTree->isNotEmpty();
        @endphp
        <li class="nav-item">
            <a href="{{ $row->url }}"
               @class(['nav-link collapsed', 'has-sub' => $hasSub, 'active' => $row->active])
               target="{{ $row->target }}"
               @if($hasSub)
                   data-bs-toggle="collapse"
                   data-bs-target="#menu-collapse-{{ $row->id }}"
                   aria-expanded="false"
                   aria-controls="menu-collapse-{{ $row->id }}"
               @endif
            >{{ $row->title }}</a>
        </li>

        @if ($isRoomsNode && $roomTree->isNotEmpty())
            <div class="collapse" id="menu-collapse-{{ $row->id }}">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
                    @foreach($roomTree as $groupIndex => $group)
                        @php($groupId = 'menu-collapse-' . $row->id . '-cat-' . $groupIndex)
                        <li class="nav-item">
                            <a href="{{ $group->url }}"
                               @class(['nav-link collapsed', 'has-sub' => $group->children->isNotEmpty(), 'active' => $group->active])
                               target="_self"
                               @if($group->children->isNotEmpty())
                                   data-bs-toggle="collapse"
                                   data-bs-target="#{{ $groupId }}"
                                   aria-expanded="false"
                                   aria-controls="{{ $groupId }}"
                               @endif
                            >{{ $group->title }}</a>
                        </li>
                        @if($group->children->isNotEmpty())
                            <div class="collapse" id="{{ $groupId }}">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
                                    @foreach($group->children as $child)
                                        <li class="nav-item">
                                            <a href="{{ $child->url }}" @class(['nav-link collapsed', 'active' => $child->active]) target="_self">{{ $child->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </ul>
            </div>
        @elseif ($row->has_child)
            <div class="collapse" id="menu-collapse-{{ $row->id }}">
                {!! Menu::renderMenuLocation('main-menu', [
                    'menu_nodes' => $row->child,
                    'view' => 'menu-mobile',
                    'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0 ms-3'],
                ]) !!}
            </div>
        @endif
    @endforeach
</ul>
