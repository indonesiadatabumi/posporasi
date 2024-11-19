@extends('layouts.default')

@section('title', 'Dashboard')

@push('css')
    <link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="/assets/plugins/flot/source/jquery.canvaswrapper.js"></script>
    <script src="/assets/plugins/flot/source/jquery.colorhelpers.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.saturated.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.browser.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.drawSeries.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.uiConstants.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.time.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.resize.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.pie.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.crosshair.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.categories.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.navigate.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.touchNavigate.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.hover.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.touch.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.selection.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.symbol.js"></script>
    <script src="/assets/plugins/flot/source/jquery.flot.legend.js"></script>
    <script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="/assets/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
    <script src="/assets/plugins/jvectormap-content/world-mill.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    <script src="/assets/js/demo/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endpush

@section('content')
    <!-- BEGIN breadcrumb -->
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Dashboard <small></small></h1>
    <!-- END page-header -->
    <!-- BEGIN row -->
    <div class="row">
        @if (Auth::user()->hasRole('admin'))
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-primary">
                    <div class="stats-icon"><i class="fa fa-users"></i></div>
                    <div class="stats-info">
                        <h4>JUMLAH USER TERDAFTAR</h4>
                        <p>{{ $jumlahUser }}</p>
                    </div>
                    <div class="stats-link">
                        <a href="/liatuser">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-secondary">
                    <div class="stats-icon"><i class="fa fa-store"></i></div>
                    <div class="stats-info">
                        <h4>JUMLAH RESTO TERDAFTAR</h4>
                        <p>{{ $jumlahRestoran }}</p>
                    </div>
                    <div class="stats-link">
                        <a href="/restoran">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->hasRole('kasir') || Auth::user()->hasRole('owner') || Auth::user()->hasRole('kitchen'))
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-danger">
                    <div class="stats-icon"><i class="fa fa-star"></i></div>
                    <div class="stats-info">
                        <h4>PRODUK PALING LAKU BULAN INI</h4>
                        <p>
                            @if ($produkPalingLaku)
                                {{ $produkPalingLaku->produk->nama_produk }} ({{ $produkPalingLaku->total_jumlah }} terjual)
                            @else
                                Tidak ada transaksi
                            @endif
                        </p>
                    </div>
                    <div class="stats-link">
                        <a href="/lpenjualan">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-info">
                    <div class="stats-icon"><i class="fa fa-shopping-cart"></i></div>
                    <div class="stats-info">
                        <h4>TRANSAKSI HARI INI</h4>
                        <p>{{ $jumlahTransaksiHariIni }}</p>
                    </div>
                    <div class="stats-link">
                        <a href="/lpembayaran">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-success">
                    <div class="stats-icon"><i class="fa fa-calendar-alt"></i></div>
                    <div class="stats-info">
                        <h4>TRANSAKSI BULAN INI</h4>
                        <p>{{ $jumlahTransaksiBulanIni }}</p>
                    </div>
                    <div class="stats-link">
                        <a href="/lpembayaran">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->hasRole('owner'))
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-warning">
                    <div class="stats-icon"><i class="fa fa-money-bill-wave"></i></div>
                    <div class="stats-info">
                        <h4>PENDAPATAN BULAN INI</h4>
                        <p>Rp {{ number_format($pendapatanBulanIni, 2, ',', '.') }}</p>
                    </div>
                    <div class="stats-link">
                        <a href="/pemasukan">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- END row -->

    <!-- BEGIN row for monthly income chart -->
    <div class="row">
        @if (Auth::user()->hasRole('owner'))
            <div class="col-xl-12">
                <div class="panel panel-inverse" data-sortable-id="index-1">
                    <div class="panel-heading">
                        <h4 class="panel-title">Analisis Pemasukan</h4>
                    </div>
                    <div class="panel-body">
                        <canvas id="pemasukanBulananChart" width="200" height="60"></canvas>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- END row -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $.ajax({
                url: '/dashboard/monthly-income',
                method: 'GET',
                success: function(data) {
                    var bulan = [];
                    var pemasukanBulanan = [];

                    data.forEach(function(item) {
                        bulan.push(moment().month(item.bulan - 1).format("MMMM"));
                        pemasukanBulanan.push(item.total_pemasukan);
                    });

                    var ctx1 = document.getElementById("pemasukanBulananChart").getContext("2d");
                    new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: bulan,
                            datasets: [{
                                label: 'Pemasukan Bulanan',
                                data: pemasukanBulanan,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + new Intl.NumberFormat('id-ID')
                                                .format(value);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });

        });
    </script>
@endpush
