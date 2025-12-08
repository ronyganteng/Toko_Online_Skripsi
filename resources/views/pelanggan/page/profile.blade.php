@extends('pelanggan.layout.index')

@section('content')
<div class="container py-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Profil Saya</h4>
                        <small class="text-muted">Data akun pelanggan</small>
                    </div>
                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-sm btn-primary">
                        Edit Profil
                    </a>
                </div>

                <div class="card-body">

                    <div class="d-flex align-items-center mb-4 gap-3">
                        @if($customer->photo)
                            <img src="{{ asset('storage/customer/'.$customer->photo) }}"
                                 alt="Foto Profil"
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px; font-size: 32px;">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <h5 class="mb-1">{{ $customer->name }}</h5>
                            <p class="mb-0 text-muted">{{ $customer->email }}</p>
                            <p class="mb-0 text-muted">Telp: {{ $customer->phone }}</p>
                        </div>
                    </div>

                    <hr>

                    <dl class="row mb-0">
                        <dt class="col-sm-3">Alamat 1</dt>
                        <dd class="col-sm-9">{{ $customer->address1 ?? '-' }}</dd>

                        <dt class="col-sm-3">Alamat 2</dt>
                        <dd class="col-sm-9">{{ $customer->address2 ?? '-' }}</dd>

                        <dt class="col-sm-3">Tanggal Lahir</dt>
                        <dd class="col-sm-9">{{ $customer->birth_date ?? '-' }}</dd>

                        <dt class="col-sm-3">Koordinat</dt>
                        <dd class="col-sm-9">
                            @if($customer->lat && $customer->lng)
                                {{ $customer->lat }}, {{ $customer->lng }}
                            @else
                                -
                            @endif
                        </dd>
                    </dl>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
