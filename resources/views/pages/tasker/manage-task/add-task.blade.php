@extends('main')
@push('css')
@endpush
@section('title', 'Tambah Task')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4 mt-4">
                <div class="card border-0 shadow p-4">
                    <div class="d-flex justify-content-between">
                        <h5>Tambah Task</h5>
                    </div>
                    <hr>
                    <form action="{{ route('store.task') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Judul Task</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mt-3">
                            <label for="description">Deskripsi (opsional)</label>
                            <textarea name="description" class="form-control" id=""></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image (opsional)</label>
                            <input type="file" class="form-control" name="image">
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
