<nav class="navbar navbar-dark navbar-expand-lg navbar-main">
    <div class="container">
        {{-- BRAND --}}
        <a class="navbar-brand navbar-brand-stb" href="/">
            <span class="logo-icon">
                <i class="fa-solid fa-cross"></i>
            </span>
            <div class="d-flex flex-column">
                <span>St. Benedictus</span>
                <span class="logo-text-small">DEVOTIONAL STORE</span>
            </div>
        </a>

        {{-- TOGGLER MOBILE --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- NAV MENU --}}
        <div class="collapse navbar-collapse justify-content-end gap-4" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-lg-center gap-3">
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == '/' ? 'active' : '' }}" aria-current="page"
                        href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'shop' ? 'active' : '' }}" href="/shop">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'contact' ? 'active' : '' }}" href="/contact">
                        Contact Us
                    </a>
                </li>

                {{-- KERANJANG --}}
                <li class="nav-item position-relative ms-lg-2">
                    <a href="/transaksi" class="icon-nav">
                        <i class="fa fa-bag-shopping"></i>
                    </a>
                    @if(isset($count) && $count)
                        <div class="circle">{{ $count }}</div>
                    @endif
                </li>

                {{-- LOGIN / PROFIL --}}
                @if(Auth::guard('customer')->check())
                    @php $cust = Auth::guard('customer')->user(); @endphp
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                           id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if($cust->photo)
                                <img src="{{ asset('storage/customer/'.$cust->photo) }}"
                                     alt="Foto Profil"
                                     class="rounded-circle"
                                     style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center"
                                     style="width: 32px; height: 32px; font-size: 14px;">
                                     {{ strtoupper(substr($cust->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="d-none d-md-inline">{{ $cust->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.profile') }}">
                                    Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('customer.logout') }}" method="POST" class="px-3">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('customer.login') }}" class="btn btn-success btn-nav-auth">
                            Login | Register
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
