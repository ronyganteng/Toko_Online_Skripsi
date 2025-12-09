@extends('pelanggan.layout.index')

@section('content')

{{-- ========== STYLE KHUSUS HALAMAN LOGIN ========== --}}
<style>
    .auth-wrapper {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-card {
        max-width: 980px;
        width: 100%;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.18);
        background: #ffffff;
    }

    .auth-left {
        position: relative;
        background: linear-gradient(135deg, #5d1010, #b71c1c);
        color: #fff;
        padding: 32px 28px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .auth-left::before {
        content:"";
        position:absolute;
        inset:0;
        background: url("{{ asset('assets/images/Login.jpg') }}") center/cover no-repeat;
        opacity: .25;
    }

    .auth-left-inner{
        position:relative;
        z-index:1;
    }

    .auth-badge {
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:6px 12px;
        border-radius:999px;
        background:rgba(255,255,255,.15);
        font-size:12px;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .auth-badge i{
        font-size:14px;
    }

    .auth-title {
        margin-top:20px;
        font-size:28px;
        font-weight:700;
        line-height:1.2;
    }

    .auth-subtitle {
        margin-top:10px;
        font-size:13px;
        opacity:.9;
        max-width:260px;
    }

    .auth-stats {
        margin-top:30px;
        display:flex;
        flex-direction:column;
        gap:6px;
        font-size:13px;
        opacity:.9;
    }

    .auth-stats span i{
        margin-right:6px;
    }

    .auth-bottom-note{
        position:relative;
        z-index:1;
        font-size:11px;
        opacity:.8;
        margin-top:28px;
    }

    .auth-right {
        padding:32px 32px 28px;
        background:#fafafa;
    }

    .auth-right h4{
        font-weight:700;
        color:#333;
    }

    .auth-right small{
        color:#777;
    }

    .auth-form-label {
        font-size:13px;
        font-weight:500;
        color:#555;
    }

    .auth-input {
        border-radius:10px;
        font-size:14px;
    }

    .auth-input:focus{
        box-shadow:0 0 0 2px rgba(33,150,243,.25);
    }

    .auth-btn-primary{
        background:#0056ff;
        border:none;
        border-radius:999px;
        font-weight:600;
        font-size:15px;
        padding:8px 0;
        transition:.2s;
    }

    .auth-btn-primary:hover{
        background:#003fc7;
    }

    .auth-helper-links a{
        font-size:13px;
    }

    .auth-register{
        font-size:13px;
    }

    @media (max-width: 991.98px){
        .auth-left{
            display:none;
        }
        .auth-right{
            padding:28px 22px 24px;
        }
        .auth-card{
            max-width:480px;
        }
    }
</style>

<div class="container auth-wrapper">
    <div class="auth-card row g-0">

        {{-- KIRI: FOTO TOKO + BRANDING --}}
        <div class="col-md-5 auth-left">
            <div class="auth-left-inner">
                <div class="auth-badge">
                    <i class="fa fa-cross"></i> ST. BENEDICTUS STORE
                </div>

                <h2 class="auth-title">
                    Toko Perlengkapan<br> Rohani Keluarga Anda
                </h2>
                <p class="auth-subtitle">
                    Temukan salib, rosario, dan perlengkapan rohani lain yang indah dan bermakna. 
                    Belanja dengan tenang, kami kirim dengan penuh perhatian.
                </p>

                <div class="auth-stats">
                    <span><i class="fa fa-check-circle"></i> Pelanggan aktif &gt; 300 orang</span>
                    <span><i class="fa fa-shield-alt"></i> Transaksi aman & terpercaya</span>
                    <span><i class="fa fa-truck"></i> Pengiriman ke seluruh Indonesia</span>
                </div>

                <div class="auth-bottom-note">
                    “Di mana hartamu berada, di situ juga hatimu berada.” – Matius 6:21
                </div>
            </div>
        </div>

        {{-- KANAN: FORM LOGIN --}}
        <div class="col-md-7 auth-right">
            <div class="mb-3 text-center">
                <h4 class="mb-0">Login Pelanggan</h4>
                <small>Masuk untuk melanjutkan belanja dan mengecek pesanan Anda</small>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customer.login.post') }}" method="POST" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label for="email" class="auth-form-label">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           class="form-control auth-input" required autofocus>
                </div>

                <div class="mb-2">
                    <label for="password" class="auth-form-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="form-control auth-input" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label" style="font-size:13px;">
                            Remember me
                        </label>
                    </div>
                    <div class="auth-helper-links">
                        <a href="{{ route('customer.password.request') }}">Forgot Password?</a>
                    </div>
                </div>

                <button type="submit" class="btn auth-btn-primary w-100">
                    Login
                </button>
            </form>

            <hr class="mt-4 mb-3">

            <div class="text-center auth-register">
                Belum punya akun?
                <a href="{{ route('customer.register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
</div>

@endsection
