@extends('main')
@push('css')
@endpush
@section('title', 'Kelola Task')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>My Task</h5>
                        <a href="{{ route('add.task') }}" class="btn btn-primary">Tambah Task</a>
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
                                    <h3 class="card-title">{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                    <div class="d-flex">
                                        <a href="{{ route('manage.subtask', $item->id) }}" class="btn btn-success me-1"><i
                                                class="fa-solid fa-sticky-note"></i></a>
                                        <a href="{{ route('manage.taskworker', $item->id) }}"
                                            class="btn btn-warning text-white me-1"><i class="fa-solid fa-user"></i></a>
                                        <a href="{{ route('edit.task', $item->id) }}"
                                            class="btn btn-primary text-white me-1"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('delete.task', $item) }}" class="me-1" method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus task ini?')"
                                                class="btn btn-danger text-white"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                        <button type="button" class="btn btn-secondary text-white" data-bs-toggle="modal"
                                            data-bs-target="#progressModal-{{ $item->id }}"><i
                                                class="fa-solid fa-chart-pie"></i> Progress
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Progress -->
                        <div class="modal fade" id="progressModal-{{ $item->id }}" tabindex="-1"
                            aria-labelledby="progressModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="progressModalLabel">Progress Task: {{ $item->title }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <canvas id="progressChart-{{ $item->id }}" width="400"
                                            height="400"></canvas>
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
        @foreach ($taskProgress as $progress)
            var ctx = document.getElementById('progressChart-{{ $progress['task']->id }}').getContext('2d');
            var progressChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Pending', 'In Progress', 'In Review', 'Done', 'Rejected'],
                    datasets: [{
                        label: 'Progress',
                        data: [
                            {{ $progress['statusPercent']['pending'] }},
                            {{ $progress['statusPercent']['in_progress'] }},
                            {{ $progress['statusPercent']['in_review'] }},
                            {{ $progress['statusPercent']['done'] }},
                            {{ $progress['statusPercent']['rejected'] }},
                        ],
                        backgroundColor: ['#f44336', '#ffc107', '#0dcaf0', '#4caf50', '#f44336'],
                        borderColor: ['#fff', '#fff', '#fff', '#fff', '#fff'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        datalabels: {
                            formatter: (value) => {
                                return value > 0 ? value + '%' : '';
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }
                    }

                },
                plugins: [ChartDataLabels]
            });
        @endforeach
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
