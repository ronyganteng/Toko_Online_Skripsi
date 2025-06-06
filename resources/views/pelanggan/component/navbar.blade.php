<nav class="navbar navbar-dark navbar-expand-lg " style="background-color: brown">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">St. Benedictus</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end gap-4" id="navbarSupportedContent">
            <ul class="navbar-nav gap-4">
                <li class="nav-item">
                    <a class="nav-link  {{ Request::path() == '/' ? 'active' : '' }}" aria-current="page"
                        href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ Request::path() == 'shop' ? 'active' : '' }}" href="/shop">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ Request::path() == 'contact' ? 'active' : '' }}" href="/contact">Contact
                        Us</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Login | Register</button>
                </li>
                <li class="nav-item">
                    <a href="/transaksi" class="fs-5 icon-nav">
                        <i class="fa fa-bag-shopping"></i>
                    </a>
                    @if($count)
                    <div class="circle">{{$count}}</div>
                    @endif
                </li>
            </ul>

        </div>
    </div>
</nav>
