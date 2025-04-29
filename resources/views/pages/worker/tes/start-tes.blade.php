@extends('main')
@push('css')
@endpush
@section('title', 'Start Tes')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Mulai Tes</h5>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-4 shadow">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card p-4 border-0 shadow mt-3">
                    <form action="" method="POST">
                        @csrf
                        @foreach ($soals as $soal)
                            <div class="mb-3">
                                <strong>{{ $loop->iteration }}. {{ $soal->pertanyaan }}</strong>
                                @if($soal->image)
                                    <img src="{{ asset('storage/' . $soal->image) }}" width="200">
                                @endif
                                @foreach ($soal->pilihan as $pilihan)
                                    <div>
                                        <label>
                                            <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $pilihan->opsi }}" required>
                                            {{ $pilihan->opsi }}. {{ $pilihan->isi_pilihan }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-success">Selesai</button>
                    </form>
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
