@extends('pelanggan.layout.index')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 text-center">
                    <h4 class="mb-0">Lupa Password</h4>
                    <small class="text-muted">Masukkan email untuk menerima link reset password</small>
                </div>
                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('customer.password.email') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Kirim Link Reset Password
                        </button>
                    </form>

                    <hr>
                    <p class="text-center mb-0">
                        Kembali ke
                        <a href="{{ route('customer.login') }}">halaman login</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
