<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    {{-- 🔥 Tempat style OSM/Leaflet masuk otomatis --}}
    @stack('styles')

    <title>Toko Online | {{ $title ?? 'Web'}} </title>
</head>

<body>
    <main>
        <header>
            @include('pelanggan.component.navbar')
        </header>

        <section>
            <div class="container">
                @yield('content')
            </div>
        </section>

        <footer>
            <div class="container">
                @include('pelanggan.component.footer')
            </div>
        </footer>
    </main>

    @include('pelanggan.modal.loginPelanggan')
    @include('pelanggan.modal.registerPelanggan')
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    {{-- 🔥 Script Leaflet & Map akan otomatis masuk di sini --}}
    @stack('scripts')

</body>
</html>
