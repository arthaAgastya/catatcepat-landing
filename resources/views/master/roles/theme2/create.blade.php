@extends('layouts.main2')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-12">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <h2>Form Role</h2>
                                </div>
                                <div class="card-toolbar">
                                    <a href="{{ route('master.role.index') }}" class="btn btn-warning btn-sm">Batal</a>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('master.role.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label required">Role</label>
                                                <input type="text" id="name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="permission" class="form-label required">Permission</label>
                                                <div class="form-check">
                                                    @foreach ($permission as $value)
                                                        <div class="form-check mb-3">
                                                            <input type="checkbox" name="permission[{{ $value->id }}]"
                                                                value="{{ $value->id }}"
                                                                id="permission_{{ $value->id }}" class="form-check-input"
                                                                {{ in_array($value->id, old('permission', [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="permission_{{ $value->id }}">
                                                                {{ $value->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('permission')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
