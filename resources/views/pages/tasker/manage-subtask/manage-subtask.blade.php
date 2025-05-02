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
@section('title', 'Kelola Subtask')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>{{ $task->title }} Subtask</h5>
                    </div>
                </div>
                <div class="card border-0 shadow p-3 mt-4">
                    <h5>Tambah Subtask</h5>
                    <hr>
                    <form action="{{ route('store.subtask') }}" method="POST">
                        @csrf
                        <div class="d-flex">
                            <input type="text" placeholder="Masuk judul subtask" name="title"
                                class="form-control me-2 w-100">
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered text-secondary" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subtask as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <form action="{{ route('delete.subtask', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus subtask ini?')"
                                                class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
