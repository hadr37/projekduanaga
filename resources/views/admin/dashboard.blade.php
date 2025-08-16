@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Dashboard</h1>
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
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="{{ route('barang.index') }}" class="small-box-footer">
                Lihat Barang <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalKategori }}</h3>
                <p>Total Kategori</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
            </div>
            <a href="{{ route('kategori.index') }}" class="small-box-footer">
                Lihat Kategori <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total User -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalUser }}</h3>
                <p>Total User</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                Lihat User <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Stok -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalStok }}</h3>
                <p>Total Stok</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
            <a href="{{ route('barang.index') }}" class="small-box-footer">
                Lihat Stok <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    
    <!-- Line Chart -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Jumlah Barang per Kategori</h3>
            </div>
            <div class="card-body" style="height:250px; max-height:250px;">
                <canvas id="barangChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title">Total Stok per Kategori</h3>
            </div>
            <div class="card-body" style="height:250px; max-height:250px;">
                <canvas id="stokChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart: Jumlah Barang
    const barangCtx = document.getElementById('barangChart').getContext('2d');
    new Chart(barangCtx, {
        type: 'line',
        data: {
            labels: @json($kategoriLabels),
            datasets: [{
                label: 'Jumlah Barang',
                data: @json($kategoriData),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // Bar Chart: Total Stok
    const stokCtx = document.getElementById('stokChart').getContext('2d');
    new Chart(stokCtx, {
        type: 'bar',
        data: {
            labels: @json($kategoriLabels),
            datasets: [{
                label: 'Total Stok',
                data: @json($stokData),
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@stop
