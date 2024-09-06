@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col d-flex align-items-stretch">
            <div class="card w-100 bg-light-info overflow-hidden shadow-none">
                <div class="card-body position-relative">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex align-items-center mb-7">
                                <div class="rounded-circle overflow-hidden me-6">
                                    <img src="
                                    @if (Auth::user()->hasRole('manager')) {{ asset('dist/images/profile/user-4.jpg') }}
                                    @else
                                        {{ asset('assets/images/no-profile.jpeg') }} @endif
                                    "
                                        alt="" width="40" height="40">
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-0 xfs-5">Selamat datang kembali {{ auth()->user()->name }}
                                    </h5>
                                    @if (Auth::user()->hasRole('manager') && Auth::user()->company)
                                        <p class="mb-0 text-dark">Perusahaan: {{ Auth::user()->company->name }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="border-end pe-4 border-muted border-opacity-10">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">{{ $project_done }}<i
                                            class="{{ $project_done
                                                ? 'ti ti-arrow-up-right fs-5 lh-base text-success'
                                                : 'ti ti-arrow-down-right fs-5 lh-base text-danger' }}"></i>
                                    </h3>
                                    <p class="mb-0 text-dark">Project Selesai</p>
                                </div>
                                <div class="ps-4">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">{{ $performance }}%<i
                                            class="{{ $performance
                                                ? 'ti ti-arrow-up-right fs-5 lh-base text-success'
                                                : 'ti ti-arrow-down-right fs-5 lh-base text-danger' }}"></i>
                                    </h3>
                                    <p class="mb-0 text-dark">Kinerja Keseluruhan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="welcome-bg-img mb-n7 text-end">
                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/welcome-bg.svg"
                                    alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row gx-3">
        <div class="col-md-6 col-lg-3 col-6">
            <div class="card text-white bg-primary rounded">
                <div class="card-body p-4">
                    <span>
                        <i class="ti ti-layout-grid fs-8"></i>
                    </span>
                    <h3 class="card-title mt-3 mb-0 text-white">{{ $project_count }}</h3>
                    <p class="card-text text-white-50 fs-3 fw-normal">
                        Total Proyek
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 col-6">
            <div class="card text-white bg-secondary rounded">
                <div class="card-body p-4">
                    <span>
                        <i class="ti ti-users fs-8"></i>
                    </span>
                    <h3 class="card-title mt-3 mb-0 text-white">{{ $employee_count }}</h3>
                    <p class="card-text text-white-50 fs-3 fw-normal">
                        Total Karyawan
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 col-6">
            <div class="card text-white bg-warning rounded">
                <div class="card-body p-4">
                    <span>
                        <i class="ti ti-category-2 fs-8"></i>
                    </span>
                    <h3 class="card-title mt-3 mb-0 text-white">{{ $department_count }}</h3>
                    <p class="card-text text-white-50 fs-3 fw-normal">
                        Total Departemen
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 col-6">
            <div class="card text-white bg-danger rounded">
                <div class="card-body p-4">
                    <span>
                        <i class="ti ti-user-cog fs-8"></i>
                    </span>
                    <h3 class="card-title mt-3 mb-0 text-white">{{ $applicant_count }}</h3>
                    <p class="card-text text-white-50 fs-3 fw-normal">
                        Menunggu Konfirmasi
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-{{ isset($departments) && $department_data ? '8' : '12' }}">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Projects</h5>
                    </div>
                    <div class="card-body">
                        <div id="projectsCompletedChart"></div>
                    </div>
                </div>
            </div>

            @if (isset($departments) && $department_data)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Department</h5>
                    </div>
                    <div class="card-body">
                        <div id="pieChart"></div>
                    </div>
                </div>
            </div>
            @endif
            @if (isset($departments) && $department_data)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pendapatan</h5>
                    </div>
                    <div class="card-body">
                        <div id="revenueChart"></div>
                    </div>
                </div>
            </div>
            @endif



            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Kehadiran Karyawan</h5>
                    </div>
                    <div class="card-body">
                        <div id="attendanceBarChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <h5 class="mt-4">Proyek Dengan Tenggat Waktu Terdekat</h5>
        <div class="list-group">
            @forelse ($projectsWithNearestDeadlines as $project)
                @php
                    $endDate = \Carbon\Carbon::parse($project->end_date);
                    $now = \Carbon\Carbon::now();

                    $daysRemaining = $now->diffInDays($endDate, false);

                    $isUrgent = $daysRemaining <= 20;
                    $cardClass = $isUrgent ? 'card-danger' : 'card-primary';
                @endphp
                <a href="{{ route('projects.show', ['project' => $project->id]) }}"
                    class="list-group-item list-group-item-action {{ $cardClass }}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $project->name }}</h5>
                        <small>{{ $endDate->locale('id')->diffForHumans() }}</small>
                    </div>
                    <small class="text-muted">Tenggat Waktu: {{ $endDate->format('d M Y') }}</small>
                </a>
            @empty
                <p class="list-group-item">Tidak ada proyek dengan tenggat waktu yang akan datang.</p>
            @endforelse
        </div>
    </div>
    @if (isset($project_data))
    <script>
        var projectData = @json($project_data);

        // Chart untuk Jumlah Proyek Selesai
        var projectCompletedOptions = {
            series: [{
                name: 'Jumlah Proyek Selesai',
                data: projectData.map(function(data) {
                    return {
                        x: data[0],
                        y: data[1]
                    };
                })
            }],
            chart: {
                type: 'line',
                height: 350
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json($months),
                title: {
                    text: 'Bulan'
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Proyek Selesai'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " proyek";
                    }
                }
            },
            markers: {
                size: 4
            },
            fill: {
                opacity: 1
            }
        };

        var projectCompletedChart = new ApexCharts(document.querySelector("#projectsCompletedChart"), projectCompletedOptions);
        projectCompletedChart.render();

        // Chart untuk Pendapatan
        var revenueOptions = {
            series: [{
                name: 'Pendapatan',
                data: projectData.map(function(data) {
                    return {
                        x: data[0],
                        y: data[2]
                    };
                })
            }],
            chart: {
                type: 'line',
                height: 350
            },
            stroke: {
                colors: ['#00ff00'], // Warna hijau untuk garis
                curve: 'smooth',
                width: 2
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json($months),
                title: {
                    text: 'Bulan'
                }
            },
            yaxis: {
                title: {
                    text: 'Pendapatan'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " pendapatan";
                    }
                }
            },
            markers: {
                size: 4
            },
            fill: {
                opacity: 1
            }
        };

        var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
        revenueChart.render();
    </script>
@else
    <p>Data tidak ditemukan.</p>
@endif


    <!-- Script untuk Attendance Bar Chart -->
@if (isset($attendanceData))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var attendanceOptions = {
            series: [
                {
                    name: 'Present',
                    data: @json($attendanceData['present'])
                },
                {
                    name: 'Absent',
                    data: @json($attendanceData['absent'])
                },
                {
                    name: 'Alpha',
                    data: @json($attendanceData['alpha'])
                },
                {
                    name: 'Late',
                    data: @json($attendanceData['late'])
                }
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false, // Set horizontal ke false jika ingin bar vertical
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    reverse: true
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($months) // Data bulan untuk sumbu x
            },
            yaxis: {
                title: {
                    text: 'Jumlah Kehadiran'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Karyawan";
                    }
                }
            }
        };

        var attendanceBarChart = new ApexCharts(document.querySelector("#attendanceBarChart"), attendanceOptions);
        attendanceBarChart.render();
    });
</script>
@else
<p>Data kehadiran tidak ditemukan.</p>
@endif


    @if (isset($departments))
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            // Data untuk pie chart
            var pieData = [1, 5, 5,
                2
            ] // Format data: [{ name: 'Kategori A', value: 20 }, { name: 'Kategori B', value: 30 }, ...]

            // Opsi konfigurasi pie chart
            var pieOptions = {
                // series: pieData.map(function(item) {
                //     return item.value;
                // }),
                // labels: pieData.map(function(item) {
                //     return item.name;
                // }),
                series: @json($department_data),
                labels: @json($departments),
                chart: {
                    type: 'pie',
                    height: 350
                },
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " orang";
                        }
                    }
                }
            };

            // Membuat dan merender pie chart
            var pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);
            pieChart.render();
        </script>
    @else
        <p>Data tidak ditemukan.</p>
    @endif

    <style>
        .card-danger {
            border: 2px solid #dc3545;
            /* Red color for urgent deadlines */
            background-color: #f8d7da;
            /* Light red background */
            border-radius: 4px;
            /* Optional: for rounded corners */
            padding: 10px;
            /* Optional: for inner spacing */
            margin-bottom: 10px;
            /* Spacing between cards */
        }

        .card-primary {
            border: 2px solid #007bff;
            /* Blue color for non-urgent deadlines */
            background-color: #cce5ff;
            /* Light blue background */
            border-radius: 4px;
            /* Optional: for rounded corners */
            padding: 10px;
            /* Optional: for inner spacing */
            margin-bottom: 10px;
            /* Spacing between cards */
        }
    </style>
@endsection
