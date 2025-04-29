@extends('main')
@push('css')
@endpush
@section('title', 'Kelola Soal')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Soal {{ $tes->title }}</h5>
                    </div>
                </div>
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <form action="{{ route('import.soal') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label>Import Soal (TXT):</label>
                                <input type="file" class="form-control" name="file" accept=".txt" required>
                                <input type="hidden" name="tes_id" value="{{ $tes->id }}">
                                <button type="submit" class="btn btn-success mt-2 w-100">Import Soal Txt</button>
                            </form>
                        </div>
                        <div class="d-flex align-items-end">
                            <a href="{{ route('add.soal', $tes->id) }}" class="btn ml-auto btn-primary">Tambah Soal</a>
                        </div>
                    </div>
                    <hr>
                    @if (session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered text-secondary" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Soal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($soal as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item->pertanyaan }}</td>
                                    <td>
                                        <form action="{{ route('delete.soal', $item->id) }}" method="POST">
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
