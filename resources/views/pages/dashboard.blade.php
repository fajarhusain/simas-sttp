@extends('layout.main')

@push('style')
    <link rel="stylesheet" href="{{asset('sneat/vendor/libs/apex-charts/apex-charts.css')}}" />
    <style>
        /* Background utama */
        .content-bg {
            background: linear-gradient(135deg, #81bcf7 0%, #f0efb5 100%);
            border-radius: 50px;
            padding: 2rem;
            min-height: calc(100vh - 100px);
        }

        /* Efek card */
        .card-stats {
            transition: transform 0.3s, box-shadow 0.9s;
            border: none;
            border-radius: 12px;
        }
        
        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Container chart */
        .chart-container {
            position: relative;
            height: 320px;
        }

        /* Legenda chart */
        .chart-legend {
            position: absolute;
            bottom: -40px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 25px;
        }

        .chart-legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
        }

        .bullet {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
    </style>
@endpush

@push('script')
    <script src="{{asset('sneat/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script>
        const options = {
            chart: {
                type: 'area',
                height: 320,
                toolbar: { show: true },
                zoom: { enabled: false }
            },
            colors: ['#28C76F', '#EA5455', '#7367F0'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 5 },
            series: [{
                name: '{{ __('dashboard.letter_transaction') }}',
                data: [{{ $todayIncomingLetter }}, {{ $todayOutgoingLetter }}, {{ $todayDispositionLetter }}]
            }],
            xaxis: {
                categories: [
                    '{{ __('dashboard.incoming_letter') }}',
                    '{{ __('dashboard.outgoing_letter') }}',
                    '{{ __('dashboard.disposition_letter') }}'
                ],
                axisBorder: { show: false },
                labels: { style: { fontSize: '15px' } }
            },
            yaxis: { show: false },
            grid: { show: false },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                marker: { show: false },
                fixed: { enabled: false },
                y: { formatter: (val) => val }
            }
        }

        const chart = new ApexCharts(document.querySelector("#today-graphic"), options);
        chart.render();
    </script>
@endpush

@section('content')
    <div class="content-bg">
        <div class="row">
            <div class="col-lg-8 mb-4 order-1">
                <!-- Greeting Card -->
                <div class="card card-stats mb-4 p-4 shadow-lg border-0" 
                     style="background: linear-gradient(135deg, #1e293b 0%, #4f46e5 100%); border-radius: 16px;">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-7">
                            <h4 class="text-white fw-bold mb-2">Assalamualaikum, </h4>
                            <h4 class="text-white fw-bold mb-2">{{ $greeting }}</h4>
                            <p class="text-white fs-5 mb-3">{{ $currentDate }}</p>
                        </div>
                        <div class="col-md-5 text-center">
                            <img src="{{asset('sneat/img/man-with-laptop-light.png')}}" 
                                class="img-fluid" 
                                style="max-height: 180px; filter: drop-shadow(0px 5px 10px rgba(174, 243, 44, 0.2));"
                                alt="Illustration">
                        </div>
                    </div>
                </div>

                <!-- Chart Card -->
                <div class="card card-stats h-90 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                        <small class="text-muted d-block">*) {{ __('dashboard.today_report') }}</small>
                        <h5 class="mb-0">{{ __('dashboard.today_graphic') }}</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded fs-4"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body chart-container">
                        <div id="today-graphic"></div>
                        <div class="chart-legend">
                            <div class="chart-legend-item">
                                <span class="bullet" style="background: #4845f7"></span>
                                {{ __('dashboard.incoming_letter') }}
                            </div>
                            <div class="chart-legend-item">
                                <span class="bullet" style="background: #EA5455"></span>
                                {{ __('dashboard.outgoing_letter') }}
                            </div>
                            <div class="chart-legend-item">
                                <span class="bullet" style="background: #7367F0"></span>
                                {{ __('dashboard.disposition_letter') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4 col-md-4 order-0">
                <div class="row g-3">
                    @foreach([
                        ['label' => __('dashboard.incoming_letter'), 'value' => $todayIncomingLetter, 'color' => 'success', 'icon' => 'bx-envelope-open', 'percentage' => $percentageIncomingLetter],
                        ['label' => __('dashboard.outgoing_letter'), 'value' => $todayOutgoingLetter, 'color' => 'danger', 'icon' => 'bx-send', 'percentage' => $percentageOutgoingLetter],
                        ['label' => __('dashboard.disposition_letter'), 'value' => $todayDispositionLetter, 'color' => 'primary', 'icon' => 'bx-git-merge', 'percentage' => $percentageDispositionLetter],
                        ['label' => __('dashboard.active_user'), 'value' => $activeUser, 'color' => 'info', 'icon' => 'bx-group', 'percentage' => 0]
                    ] as $card)
                    <div class="col-12">
                        <x-dashboard-card-simple
                            :label="$card['label']"
                            :value="$card['value']"
                            :daily="isset($card['percentage'])"
                            :color="$card['color']"
                            :icon="$card['icon']"
                            :percentage="$card['percentage']"
                        />
                    </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
@endsection