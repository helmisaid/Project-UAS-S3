<div id="kt_aside" class="aside aside-dark aside-hoverable">
    <!-- Logo -->
    <div class="aside-logo d-flex align-items-center justify-content-between" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="/">
            <img src="{{ asset('assets/media/logos/logo-putih.png') }}" class="logo img-fluid" alt="Logo">
        </a>
        <!--end::Logo-->

        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black" />
                </svg>
            </span>
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Aside Logo-->

    <!-- Menu -->
    <div class="aside-menu mt-5" id="kt_aside_menu">
        <ul class="menu menu-column" data-kt-menu="true">
            @if(auth()->check()) <!-- Static Dashboard Menu -->
            <li class="menu-item">
                <a href="{{ url('/dashboard') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            @endif

            @foreach($menus->where('level_id', 1) as $menu)
                @php $hasChild = $menus->where('parent_id', $menu->menu_id)->isNotEmpty(); @endphp

                @if($hasChild)
                <li data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="{{ $menu->menu_icon }}"></i></span>
                        <span class="menu-title">{{ $menu->menu_name }}</span>
                        <span class="menu-arrow"></span>
                    </span>

                    <!-- Submenu -->
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <ul class="submenu">
                            @foreach($menus->where('parent_id', $menu->menu_id) as $submenu)
                                @php $hasSubChild = $menus->where('parent_id', $submenu->menu_id)->isNotEmpty(); @endphp

                                @if($hasSubChild)
                                <li data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon"><i class="{{ $submenu->menu_icon }}"></i></span>
                                        <span class="menu-title">{{ $submenu->menu_name }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <ul class="submenu">
                                            @foreach($menus->where('parent_id', $submenu->menu_id) as $childmenu)
                                            <li class="menu-item">
                                                <a href="{{ url($childmenu->menu_link) }}" class="menu-link">
                                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                    <span class="menu-title">{{ $childmenu->menu_name }}</span>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                @else
                                <li class="menu-item">
                                    <a href="{{ url($submenu->menu_link) }}" class="menu-link">
                                        <span class="menu-icon"><i class="{{ $submenu->menu_icon }}"></i></span>
                                        <span class="menu-title">{{ $submenu->menu_name }}</span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                @else
                <li class="menu-item">
                    <a href="{{ url($menu->menu_link) }}" class="menu-link">
                        <span class="menu-icon"><i class="{{ $menu->menu_icon }}"></i></span>
                        <span class="menu-title">{{ $menu->menu_name }}</span>
                    </a>
                </li>
                @endif
            @endforeach
        </ul>
    </div>
    <!--end::Menu-->
</div>
<!--end::Aside-->
