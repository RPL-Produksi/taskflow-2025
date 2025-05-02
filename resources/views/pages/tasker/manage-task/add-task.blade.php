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
@section('title', 'Tambah Task')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">
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
                            <label for="video">Link Embed Video Youtube (opsional)</label>
                            <input type="text" class="form-control" name="video">
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
