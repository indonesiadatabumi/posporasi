@php
    $appSidebarClass = (!empty($appSidebarTransparent)) ? 'app-sidebar-transparent' : '';
    $role = Auth::user()->role; 
    $sidebarConfigFile = 'sidebar' . strtolower($role); 
    $menuItems = config($sidebarConfigFile . '.menu', []); 
@endphp

<style>
    .menu-profile-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
    }

    .menu-profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

</style>

<div id="sidebar" class="app-sidebar {{ $appSidebarClass }}">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <div class="menu">
            @if (!$appSidebarSearch)
            <div class="menu-profile">
                <a href="{{ route('profile.index') }}" class="menu-profile-link">

                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-image">
                        @if(Auth::user()->foto)
                            <img src="{{ Auth::user()->foto }}" alt="User Image" />
                        @endif
                    </div>
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                {{ Auth::user()->nama }}
                            </div>
                        </div>
                        <small>{{ Auth::user()->role }}</small>
                    </div>
                </a>
                
            </div>
            @endif

            <div class="menu-header">Navigation</div>

            @php
                $currentUrl = (Request::path() != '/') ? '/'. Request::path() : '/';
                
                function renderSubMenu($value, $currentUrl) {
                    $subMenu = '';
                    $GLOBALS['sub_level'] += 1;
                    $GLOBALS['active'][$GLOBALS['sub_level']] = '';
                    $currentLevel = $GLOBALS['sub_level'];
                    foreach ($value as $key => $menu) {
                        $GLOBALS['subparent_level'] = '';
                        
                        $subSubMenu = '';
                        $hasSub = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
                        $hasCaret = (!empty($menu['sub_menu'])) ? '<div class="menu-caret"></div>' : '';
                        $hasHighlight = (!empty($menu['highlight'])) ? '<i class="fa fa-paper-plane text-theme ms-1"></i>' : '';
                        $hasTitle = (!empty($menu['title'])) ? '<div class="menu-text">'. $menu['title'] . $hasHighlight .'</div>' : '';
                        
                        if (!empty($menu['sub_menu'])) {
                            $subSubMenu .= '<div class="menu-submenu">';
                            $subSubMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
                            $subSubMenu .= '</div>';
                        }
                        
                        $active = (!empty($menu['route-name']) && (Route::currentRouteName() == $menu['route-name'])) ? 'active' : '';
                        
                        if ($active) {
                            $GLOBALS['parent_active'] = true;
                            $GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
                        }
                        if (!empty($GLOBALS['active'][$currentLevel])) {
                            $active = 'active';
                        }
                        $subMenu .= '
                            <div class="menu-item '. $hasSub .' '. $active .'">
                                <a href="'. $menu['url'] .'" class="menu-link">' . $hasTitle . $hasCaret .'</a>
                                '. $subSubMenu .'
                            </div>
                        ';
                    }
                    return $subMenu;
                }
                
                foreach ($menuItems as $key => $menu) {
                    $GLOBALS['parent_active'] = '';
                    
                    $hasSub = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
                    $hasCaret = (!empty($menu['caret'])) ? '<div class="menu-caret"></div>' : '';
                    $hasIcon = (!empty($menu['icon'])) ? '<div class="menu-icon"><i class="'. $menu['icon'] .'"></i></div>' : '';
                    $hasImg = (!empty($menu['img'])) ? '<div class="menu-icon-img"><img src="'. $menu['img'] .'" /></div>' : '';
                    $hasLabel = (!empty($menu['label'])) ? '<span class="menu-label">'. $menu['label'] .'</span>' : '';
                    $hasTitle = (!empty($menu['title'])) ? '<div class="menu-text">'. $menu['title'] . $hasLabel .'</div>' : '';
                    $hasBadge = (!empty($menu['badge'])) ? '<div class="menu-badge">'. $menu['badge'] .'</div>' : '';
                    
                    $subMenu = '';
                    
                    if (!empty($menu['sub_menu'])) {
                        $GLOBALS['sub_level'] = 0;
                        $subMenu .= '<div class="menu-submenu">';
                        $subMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
                        $subMenu .= '</div>';
                    }
                    $active = (!empty($menu['route-name']) && (Route::currentRouteName() == $menu['route-name'])) ? 'active' : '';
                    $active = (empty($active) && !empty($GLOBALS['parent_active'])) ? 'active' : $active;
                    echo '
                        <div class="menu-item '. $hasSub .' '. $active .'">
                            <a href="'. $menu['url'] .'" class="menu-link">
                                '. $hasImg .'
                                '. $hasIcon .'
                                '. $hasTitle .'
                                '. $hasBadge .'
                                '. $hasCaret .'
                            </a>
                            '. $subMenu .'
                        </div>
                    ';
                }
            @endphp
            <!-- BEGIN minify-button -->
            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
            </div>
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
<!-- END #sidebar -->
