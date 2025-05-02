@extends('main')
@push('css')
<style>
    @media(min-width: 1200px) {
        .wrap {
            padding-left: 250px;
        }
    }
</style>
@endpush
@section('title', 'Tambah Guru')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">
            @include('components.navbar')
            <div class="px-4 mt-4">
                <div class="card border-0 shadow p-4">
                    <div class="d-flex justify-content-between">
                        <h5>Tambah Guru</h5>
                    </div>
                    <hr>
                    <form action="{{ route('store.tasker') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mt-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mt-3">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" name="password" required>
                        </div>
                        <div class="mt-3">
                            <label for="avatar">Avatar (opsional)</label>
                            <input type="file" class="form-control" name="avatar">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
