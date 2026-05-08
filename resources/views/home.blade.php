@extends('layouts.main')

@section('content')
    {{-- Toolbar --}}
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Dashboard</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500">Dashboard Koperasi</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row">
                {{-- Dashboard Content --}}
                <div class="col-12">
                    <p class="text-center fs-6 pb-5">
                        <span class="badge badge-light-danger fs-8">Catatan:</span>&nbsp; Sprint saat ini memerlukan
                        persetujuan dari pemangku kepentingan
                        <br>terhadap kebijakan yang telah diperbarui.
                        <br>Sistem akan diperbarui secara berkala untuk memastikan kinerja dan keamanan tetap optimal.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
