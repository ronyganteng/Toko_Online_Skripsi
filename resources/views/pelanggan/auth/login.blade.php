@extends('pelanggan.layout.index')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Login Pelanggan</h4>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.login.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email') }}"
                                   class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember"
                                   class="form-check-input">
                            <label for="remember" class="form-check-label">
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Login
                        </button>
                    </form>

                    <p class="text-center mt-2">
   <a href="{{ route('customer.password.request') }}">Forgot Password?</a>

</p>


                    

                    <hr>

                    <div class="text-center">
                        Belum punya akun?
                        <a href="{{ route('customer.register') }}">Daftar sekarang</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
