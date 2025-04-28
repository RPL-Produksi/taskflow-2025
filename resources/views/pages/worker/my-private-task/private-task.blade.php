@extends('main')
@push('css')
@endpush
@section('title', 'Private Task')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Private Task</h5>
                        <a href="{{ route('add.private.task') }}" class="btn btn-primary">Tambah Task</a>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-4 shadow">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    @foreach ($task as $item)
                        <div class="col-3 mt-3">
                            <div class="card border-0 shadow">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" height="250"
                                        style="object-fit: cover" class="img-card-top" alt="">
                                @else
                                    <img src="{{ asset('images/default-image.avif') }}" height="250"
                                        style="object-fit: cover" class="img-card-top" alt="">
                                @endif
                                <div class="card-body">
                                    <h3 class="card-title">{{ Str::limit($item->title,  16) }}</h3>
                                    <p>{{ Str::limit($item->description, 115) }}</p>
                                    <div class="d-flex">
                                        <a href="{{ route('private.subtask', $item->id) }}" class="btn btn-success me-1"><i
                                            class="fa-solid fa-sticky-note"></i></a>
                                    <a href="{{ route('edit.private.task', $item->id) }}"
                                        class="btn btn-primary text-white me-1"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('delete.private.task', $item) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus task ini?')"
                                            class="btn btn-danger text-white"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('start.private.subtask', $item->id) }}" class="btn btn-info text-white ms-1"><i class="fa-solid fa-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
