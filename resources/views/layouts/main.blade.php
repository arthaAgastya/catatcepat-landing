<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        $titles = [
            'dashboard' => 'Dashboard',
            'master.pengelola.index' => 'Pengelola',
            'master.anggota.index' => 'Anggota',
            'master.pinjaman.index' => 'Pinjaman',
            'master.simpanan.index' => 'Data Simpanan',
            'master.angsuran.index' => 'Angsuran',
            'laporan.simpanan' => 'Laporan Simpanan',
            'laporan.pinjaman' => 'Laporan Pinjaman',
            'laporan.shu' => 'Laporan SHU',
            // tambahkan route lain jika perlu
        ];

        $pageTitle = $titles[$routeName] ?? 'Sistem Informasi Koperasi';
        $pageDescription = 'Sistem informasi koperasi untuk mengelola anggota, simpanan, pinjaman, dan laporan SHU.';
        $appName = config('app.name', 'Koperasi');
    @endphp

    <title>{{ $appName }} - {{ $pageTitle }}</title>

    <!-- Meta SEO -->
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="koperasi, simpan pinjam, sistem koperasi, anggota koperasi, laporan SHU">
    <meta name="author" content="Koperasi Digital">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/sidek.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('') }}assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('') }}assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    {{-- Sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

    <!-- Select2 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('layouts.header')
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="black" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="black" />
            </svg>
        </span>
    </div>
    <script>
        var hostUrl = "{{ asset('') }}assets/";
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6'
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: '{{ session('warning') }}',
                    confirmButtonColor: '#f0ad4e'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33'
                });
            @endif
        });
    </script>
    <script src="{{ asset('') }}assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('') }}assets/js/scripts.bundle.js"></script>
    <script src="{{ asset('') }}assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="{{ asset('') }}assets/js/custom/widgets.js"></script>
    <script src="{{ asset('') }}assets/js/custom/apps/chat/chat.js"></script>
    <script src="{{ asset('') }}assets/js/custom/modals/create-app.js"></script>
    <script src="{{ asset('') }}assets/js/custom/modals/upgrade-plan.js"></script>
</body>

</html>
