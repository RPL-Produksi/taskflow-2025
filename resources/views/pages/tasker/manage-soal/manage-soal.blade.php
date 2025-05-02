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
@section('title', 'Kelola Soal')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Soal {{ $tes->title }}</h5>
                    </div>
                </div>
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-xl-flex justify-content-between">
                        <div class="">
                            <form action="{{ route('import.soal') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label>Import Soal (TXT):</label>
                                <input type="file" class="form-control" name="file" accept=".txt" required>
                                <input type="hidden" name="tes_id" value="{{ $tes->id }}">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-success mt-2 w-100">Import Soal Txt</button>
                                    <a href="{{ route('download.format.soal') }}" class="btn btn-secondary ms-2 mt-2 w-100">Download Format</a>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex align-items-end mt-2 mt-xl-0">
                            <a href="{{ route('add.soal', $tes->id) }}" class="btn ml-auto btn-primary">Tambah Soal</a>
                        </div>
                    </div>
                    <hr>
                    @if (session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
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
                                        <td class="d-flex">
                                            <a href="{{ route('edit.soal', $item->id) }}" class="btn btn-primary me-2"><i class="fa-solid fa-pen-to-square"></i></a>
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
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
