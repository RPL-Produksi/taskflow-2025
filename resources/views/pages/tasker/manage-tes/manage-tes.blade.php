@extends('main')
@push('css')
@endpush
@section('title', 'Kelola Tes')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Kelola Tes</h5>
                        <a href="{{ route('add.tes') }}" class="btn btn-primary">Tambah Tes</a>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-4 shadow">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    @foreach ($tes as $item)
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
                                    <h3 class="card-title">{{ Str::limit($item->title, 16) }}</h3>
                                    <p>{{ Str::limit($item->description, 115) }}</p>
                                    <div class="d-flex">
                                        <a href="{{ route('manage.soal', $item->id) }}" class="btn btn-success me-1"><i
                                                class="fa-solid fa-sticky-note"></i></a>
                                        <a href="{{ route('manage.assign.siswa', $item->id) }}"
                                            class="btn btn-warning text-white me-1"><i class="fa-solid fa-user"></i></a>
                                        <a href="{{ route('edit.tes', $item->id) }}"
                                            class="btn btn-primary text-white me-1"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('delete.tes', $item) }}" class="me-1" method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus tes ini?')"
                                                class="btn btn-danger text-white"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                        <a href="{{ route('nilai.siswa', $item->id) }}" class="btn btn-secondary">Nilai Siswa</a>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
