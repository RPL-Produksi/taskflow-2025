@extends('main')
@push('css')
@endpush
@section('title', 'Edit Task')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4 mt-4">
                <div class="card border-0 shadow p-4">
                    <div class="d-flex justify-content-between">
                        <h5>Edit Task</h5>
                    </div>
                    <hr>
                    <form action="{{ route('update.task', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Judul Task</label>
                            <input type="text" value="{{ $task->title }}" class="form-control" name="title" required>
                        </div>
                        <div class="mt-3">
                            <label for="description">Deskripsi (opsional)</label>
                            <textarea name="description" class="form-control" id="">{{ $task->description }}</textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image (opsional)</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="mt-3">
                            <label for="video">Link Embed Video Youtube (opsional)</label>
                            <input type="text" class="form-control" value="{{ $task->video }}" name="video">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
