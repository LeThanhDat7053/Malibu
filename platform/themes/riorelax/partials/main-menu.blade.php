<ul {!! BaseHelper::clean($options) !!}>
    @foreach ($menu_nodes as $row)
        @php
            $isRoomsNode = theme_is_rooms_menu_node($row);
            $roomTree = $isRoomsNode ? theme_rooms_menu_tree() : collect();
            $hasSub = $row->has_child || $roomTree->isNotEmpty();
        @endphp
        <li @class(['has-sub' => $hasSub, $row->css_class])>
            <a @class(['active' => $row->active]) href="{{ $row->url }}" target="{{ $row->target }}">
                @if($iconImage = $row->getMetaData('icon_image', true))
                    <img src="{{ RvMedia::getImageUrl($iconImage) }}" alt="{{ $row->title }}" loading="lazy"/>
                @elseif($row->icon_font)
                    <i class="{{ trim($row->icon_font) }}"></i>
                @endif

                {{ $row->title }}
            </a>
            @if($isRoomsNode && $roomTree->isNotEmpty())
                <ul class="sub-menu">
                    @foreach($roomTree as $group)
                        <li @class(['has-sub' => $group->children->isNotEmpty()])>
                            <a @class(['active' => $group->active]) href="{{ $group->url }}">{{ $group->title }}</a>
                            @if($group->children->isNotEmpty())
                                <ul class="sub-menu">
                                    @foreach($group->children as $child)
                                        <li>
                                            <a @class(['active' => $child->active]) href="{{ $child->url }}">{{ $child->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @elseif($row->has_child)
                {!! Menu::renderMenuLocation('main-menu', [
                    'menu_nodes' => $row->child,
                    'view' => 'main-menu',
                    'options' => ['class' => 'sub-menu'],
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
