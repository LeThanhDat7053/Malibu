<ul {!! BaseHelper::clean($options) !!}>
    @foreach ($menu_nodes as $row)
        @php
            // Một node có thể được tự động đổ nội dung từ Phòng hoặc từ Nhà hàng.
            // Hai cây có cùng cấu trúc { title, url, active, children } nên dùng
            // chung một đoạn hiển thị bên dưới.
            $autoTree = collect();

            if (theme_is_rooms_menu_node($row)) {
                $autoTree = theme_rooms_menu_tree();
            } elseif (function_exists('theme_is_restaurants_menu_node') && theme_is_restaurants_menu_node($row)) {
                $autoTree = theme_restaurants_menu_tree();
            }

            $hasSub = $row->has_child || $autoTree->isNotEmpty();
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
            @if($autoTree->isNotEmpty())
                <ul class="sub-menu">
                    @foreach($autoTree as $group)
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
