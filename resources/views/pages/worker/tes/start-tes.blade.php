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
@section('title', 'Start Tes')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">
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
                    <form action="{{ route('submit.tes', $tes->id) }}" method="POST" id="tesForm">
                        @csrf
                        <div id="soal-container">
                            @foreach ($soals as $index => $soal)
                                <div class="soal-item" data-id="{{ $soal->id }}" style="display:none;">
                                    <div class="mb-2 d-flex align-items-start">
                                        <strong class="me-1">
                                            {{ $index + 1 }}.
                                        </strong>
                                        <div>
                                            <strong>{{ $soal->pertanyaan }}</strong>
                                        </div>
                                    </div>
                                    @if ($soal->image)
                                        <img src="{{ asset('storage/' . $soal->image) }}" width="200">
                                    @endif
                                    @foreach ($soal->pilihan as $pilihan)
                                        <div class="mt-3">
                                            <label>
                                                <input type="radio" name="jawaban[{{ $soal->id }}]"
                                                    value="{{ $pilihan->opsi }}">
                                                {{ $pilihan->opsi }}. {{ $pilihan->isi_pilihan }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="prevBtn"
                                onclick="navigate(-1)">Sebelumnya</button>
                            <button type="button" class="btn btn-primary" id="nextBtn"
                                onclick="navigate(1)">Selanjutnya</button>
                        </div>

                        <div class="mt-3">
                            <!-- Tombol Selesai hanya muncul saat soal terakhir -->
                            <button type="submit" class="btn btn-success mt-3" id="finishBtn"
                                style="display: none;">Selesai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let currentSoalIndex = 0;
        const soalItems = document.querySelectorAll('.soal-item');
        const finishBtn = document.getElementById('finishBtn');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');

        // Menampilkan soal pertama saat halaman dimuat
        soalItems[currentSoalIndex].style.display = 'block';

        function navigate(direction) {
            // Menyembunyikan soal saat ini
            soalItems[currentSoalIndex].style.display = 'none';

            // Mengubah index soal berdasarkan tombol
            currentSoalIndex += direction;

            // Pastikan index berada dalam rentang yang valid
            if (currentSoalIndex < 0) currentSoalIndex = 0;
            if (currentSoalIndex >= soalItems.length) currentSoalIndex = soalItems.length - 1;

            // Menampilkan soal yang baru
            soalItems[currentSoalIndex].style.display = 'block';

            // Menampilkan tombol "Selesai" jika soal terakhir
            finishBtn.style.display = currentSoalIndex === soalItems.length - 1 ? 'block' : 'none';
        }

        // Cek apakah ada jawaban tersimpan di localStorage
soalItems.forEach((item, index) => {
    const soalId = item.dataset.id;
    const savedAnswer = localStorage.getItem(`jawaban_${soalId}`);
    if (savedAnswer) {
        const radio = item.querySelector(`input[value="${savedAnswer}"]`);
        if (radio) {
            radio.checked = true;
        }
    }

    // Setiap kali user memilih jawaban, simpan ke localStorage
    const radios = item.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            localStorage.setItem(`jawaban_${soalId}`, radio.value);
        });
    });
});
document.getElementById('tesForm').addEventListener('submit', () => {
    soalItems.forEach(item => {
        const soalId = item.dataset.id;
        localStorage.removeItem(`jawaban_${soalId}`);
    });
});

    </script>
@endpush
