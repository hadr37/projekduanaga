@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Dashboard Admin</h1>
@stop

@section('content')
<div class="row">
    <!-- Total Barang -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalBarang }}</h3>
                <p>Total Barang</p>
            </div>
            <div class="icon"><i class="fas fa-box"></i></div>
        </div>
    </div>

    <!-- Total User -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalUser }}</h3>
                <p>Total User</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalKategori }}</h3>
                <p>Total Kategori</p>
            </div>
            <div class="icon"><i class="fas fa-tags"></i></div>
        </div>
    </div>

    <!-- Total Stok -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalStok }}</h3>
                <p>Total Stok</p>
            </div>
            <div class="icon"><i class="fas fa-cubes"></i></div>
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="row">
    <!-- Chart Barang per Kategori (Line) -->
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Jumlah Barang per Kategori</h3></div>
            <div class="card-body">
                <canvas id="kategoriChart" style="height:300px; max-height:300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Stok per Barang (Bar) -->
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header"><h3 class="card-title">Stok per Barang</h3></div>
            <div class="card-body">
                <canvas id="barangChart" style="height:300px; max-height:300px;"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart: Jumlah Barang per Kategori
    new Chart(document.getElementById('kategoriChart'), {
        type: 'line',
        data: {
            labels: @json($kategoriLabels),
            datasets: [{
                label: 'Jumlah Barang',
                data: @json($kategoriData),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Bar Chart: Stok per Barang
    new Chart(document.getElementById('barangChart'), {
        type: 'bar',
        data: {
            labels: @json($barangLabels),
            datasets: [{
                label: 'Stok',
                data: @json($barangStok),
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@stop
