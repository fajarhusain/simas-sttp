<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme shadow-lg rounded">
    <!-- Brand Logo -->
    <div class="app-brand demo d-flex align-items-center justify-content-between p-3">
        <a href="{{ route('home') }}" class="app-brand-link d-flex align-items-center text-decoration-none">
            <!-- Logo dengan animasi hover -->
            <img src="{{ asset('logo-black.png') }}" alt="{{ config('app.name') }}" width="50"
                 class="me-3 logo animated-logo">
            
            <!-- Nama aplikasi dengan efek gradient dan animasi -->
            <span class="app-brand-text demo fw-bold fs-3 text-gradient glow-text">
                {{ config('app.name') }}
            </span>
        </a>
        
        <!-- Tombol Toggle Sidebar dengan animasi -->
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link d-block d-xl-none">
            <i class="bx bx-menu bx-sm align-middle toggle-icon"></i>
        </a>
    </div>
    
    <!-- Tambahkan CSS untuk efek -->
    <style>
        /* Efek hover pada logo */
        .animated-logo {
            transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
        }
    
        .animated-logo:hover {
            transform: scale(1.1);
            filter: drop-shadow(2px 2px 5px rgba(0, 0, 0, 0.2));
        }
    
        /* Animasi dan efek glow pada teks brand */
        .glow-text {
            background: linear-gradient(45deg, #32CD32, #008000); /* Warna hijau khas NU */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: glow 1.5s infinite alternate;
        }
    
        @keyframes glow {
            from {
                text-shadow: 0 0 5px rgba(50, 205, 50, 0.6);
            }
            to {
                text-shadow: 0 0 15px rgba(50, 205, 50, 1);
            }
        }
    
        /* Efek smooth pada ikon menu toggle */
        .toggle-icon {
            transition: transform 0.3s ease-in-out;
        }
    
        .toggle-icon:hover {
            transform: rotate(90deg);
            color: #32CD32;
        }
    </style>
    
    <!-- Bagian Atas Sidebar -->
    <div class="menu-top flex-grow-1">
        <ul class="menu-inner py-3">
            <!-- Home -->
            <li class="menu-item {{ Route::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="menu-link d-flex align-items-center">
                    <i class="menu-icon tf-icons bx bx-home-circle text-primary"></i>
                    <span class="ms-2">{{ __('menu.home') }}</span>
                </a>
            </li>

            <li class="menu-item {{ Route::is('transaction.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center">
                    <i class="menu-icon tf-icons bx bx-mail-send text-success"></i>
                    <span class="ms-2">{{ __('menu.transaction.menu') }}</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::is('transaction.incoming.*') ? 'active' : '' }}">
                        <a href="{{ route('transaction.incoming.index') }}" class="menu-link">
                            <span>{{ __('menu.transaction.incoming_letter') }}</span>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::is('transaction.outgoing.*') ? 'active' : '' }}">
                        <a href="{{ route('transaction.outgoing.index') }}" class="menu-link">
                            <span>{{ __('menu.transaction.outgoing_letter') }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item {{ Route::is('agenda.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center">
                    <i class="menu-icon tf-icons bx bx-book text-info"></i>
                    <span class="ms-2">{{ __('menu.agenda.menu') }}</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::is('agenda.incoming') ? 'active' : '' }}">
                        <a href="{{ route('agenda.incoming') }}" class="menu-link">
                            <span>{{ __('menu.agenda.incoming_letter') }}</span>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::is('agenda.outgoing') ? 'active' : '' }}">
                        <a href="{{ route('agenda.outgoing') }}" class="menu-link">
                            <span>{{ __('menu.agenda.outgoing_letter') }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            @if(auth()->user()->role == 'admin')
                <li class="menu-item {{ Route::is('reference.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center">
                        <i class="menu-icon tf-icons bx bx-analyse text-danger"></i>
                        <span class="ms-2">{{ __('menu.reference.menu') }}</span>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Route::is('reference.classification.*') ? 'active' : '' }}">
                            <a href="{{ route('reference.classification.index') }}" class="menu-link">
                                <span>{{ __('menu.reference.classification') }}</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('reference.status.*') ? 'active' : '' }}">
                            <a href="{{ route('reference.status.index') }}" class="menu-link">
                                <span>{{ __('menu.reference.status') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>

    <!-- User Management di Pojok Bawah -->
    @if(auth()->user()->role == 'admin')
        <div class="menu-bottom">
            <ul class="menu-inner">
                <li class="menu-item {{ Route::is('user.*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="menu-link d-flex align-items-center">
                        <i class="menu-icon tf-icons bx bx-user-pin text-dark"></i>
                        <span class="ms-2">{{ __('menu.users') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    @endif
</aside>