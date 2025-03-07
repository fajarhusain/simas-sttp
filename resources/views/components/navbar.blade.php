<nav class="layout-navbar container-xxl zindex-5 navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme shadow-sm rounded-3" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-center me-3 d-xl-none">
        <a class="nav-item nav-link px-2 d-flex align-items-center justify-content-center rounded-circle bg-light text-dark shadow-sm" href="javascript:void(0)" style="width: 40px; height: 40px;">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>



    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Nama Aplikasi -->
        <li class="nav-item me-3 d-none d-md-block">
            <span class="fw-semibold text-dark fs-5">Sistem Administrasi Surat</span>
        </li>
       
        <ul class="navbar-nav flex-row align-items-center ms-auto">
                  <!-- Search --> 
            
            <div class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Search -->
                <div class="nav-item d-none d-md-flex me-3">
                    <input type="text" class="form-control border-0 shadow-sm rounded-pill px-3" placeholder="Cari..." style="max-width: 200px;">
                </div>
        
                
            </div>
             <!-- Running Text Surat Terbaru -->
             <div class="d-flex align-items-center ms-3 d-none d-md-block">
                <i class='bx bx-envelope bx-tada text-primary me-2'></i>
                <marquee class="text-muted" behavior="scroll" direction="left" scrollamount="9">
                    @if(isset($latestLetters) && $latestLetters->count())
                        @foreach($latestLetters as $letter)
                            <span class="me-4">
                                <small>
                                    <i class='bx bx-time-five'></i> 
                                    {{ $letter->created_at->diffForHumans() }}: 
                                    <strong>{{ $letter->subject }}</strong> 
                                    ({{ $letter->type }})
                                </small>
                            </span>
                        @endforeach
                    @else
                        <small>{{ __('Tidak ada Surat Baru') }}</small>
                    @endif
                </marquee>
            </div>
            
            <!-- User -->
            
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                   data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ auth()->user()->profile_picture }}" alt
                             class="w-px-40 h-auto rounded-circle"/>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ auth()->user()->profile_picture }}" alt
                                             class="w-px-40 h-auto rounded-circle"/>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                    <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">{{ __('navbar.profile.profile') }}</span>
                        </a>
                    </li>
                    @if(auth()->user()->role == 'admin')
                    <li>
                        <a class="dropdown-item" href="{{ route('settings.show') }}">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">{{ __('navbar.profile.settings') }}</span>
                        </a>
                    </li>
                    @endif
                                       <li>
                                           <a class="dropdown-item" href="#">
                                                            <span class="d-flex align-items-center align-middle">
                                                              <i class="flex-shrink-0 bx bx-bell me-2"></i>
                                                             <span class="flex-grow-1 align-middle">{{ __('navbar.profile.notifications') }}</span>
                                                              <span
                                                                 class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">0</span>
                                                            </span>
                                            </a>
                                        </li> 
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item cursor-pointer">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">{{ __('navbar.profile.logout') }}</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
            <!--/ User -->
        </ul>
    </div>
</nav>
