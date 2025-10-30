@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Pesanan Saya</h2>

    <!-- Tabs Filter Status -->
    <ul class="nav nav-tabs mb-4" id="statusTabs">
        @php
            $statuses = [
                'all' => 'Semua',
                'pemrosesan' => 'Diproses',
                'dikirim' => 'Dikirim',
                'diterima' => 'Diterima',
                'dibatalkan' => 'Dibatalkan'
            ];
        @endphp
        @foreach($statuses as $key => $label)
            <li class="nav-item">
                <a class="nav-link {{ request('status')==$key || (request('status')==null && $key=='all') ? 'active':'' }}" 
                   href="{{ route('katalog.pesanan', ['status'=>$key]) }}">
                   {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Container Pesanan -->
    <div id="pesanan-content">
        @if($pesanan->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada pesanan</h4>
                <a href="{{ route('katalog.shop') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($pesanan as $order)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0">Pesanan #{{ $order->id }}</h6>
                                    <span class="badge bg-{{ 
                                        $order->status=='pemrosesan'?'warning':($order->status=='dikirim'?'primary':($order->status=='diterima'?'success':'danger')) 
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <small class="text-muted mb-3">{{ $order->created_at->format('d M Y, H:i') }}</small>

                                <!-- Produk -->
                                <div class="mb-3">
                                    @foreach($order->details as $detail)
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ asset('storage/' . $detail->product->gambar) }}" 
                                                 alt="{{ $detail->product->nama_barang }}" 
                                                 class="rounded" style="width:50px;height:50px;object-fit:cover;">
                                            <div class="ms-2 flex-grow-1">
                                                <small>{{ $detail->product->nama_barang }} x {{ $detail->jumlah }}</small>
                                            </div>
                                            <div class="text-end">
                                                <small>Rp {{ number_format($detail->harga*$detail->jumlah,0,',','.') }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>Total:</strong>
                                        <strong class="text-success">Rp {{ number_format($order->total,0,',','.') }}</strong>
                                    </div>

                                    <div class="mt-3 d-flex justify-content-between">
                                        @if($order->status=='pemrosesan')
                                            <form action="{{ route('pesanan.cancel',$order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengajukan pembatalan?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 me-1">
                                                    <i class="fas fa-times me-1"></i>Ajukan Pembatalan
                                                </button>
                                            </form>
                                            <button class="btn btn-success btn-sm w-100 ms-1" data-bs-toggle="modal" data-bs-target="#bayarModal{{ $order->id }}">
                                                <i class="fas fa-money-bill-wave me-1"></i>Bayar Sekarang
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Bayar -->
                    @if($order->status=='pemrosesan')
                    <div class="modal fade" id="bayarModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Silakan lakukan pembayaran sesuai detail berikut:</p>
                                    <ul class="list-unstyled">
                                        <li><strong>Bank:</strong> {{ $order->bank }}</li>
                                        <li><strong>Nama Rekening:</strong> {{ $order->nama_rekening }}</li>
                                        @if($order->no_rekening)
                                            <li><strong>No. Rekening:</strong> {{ $order->no_rekening }}</li>
                                        @endif
                                        <li><strong>Total:</strong> Rp {{ number_format($order->total,0,',','.') }}</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Sudah Bayar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const tabs = document.querySelectorAll('#statusTabs a');
    tabs.forEach(tab=>{
        tab.addEventListener('click', function(e){
            e.preventDefault();
            const status = this.dataset.status;

            tabs.forEach(t=>t.classList.remove('active'));
            this.classList.add('active');

            fetch("{{ route('katalog.pesanan') }}?status=" + status, {
                headers: {'X-Requested-With':'XMLHttpRequest'}
            })
            .then(res=>res.json())
            .then(data=>{
                document.getElementById('pesanan-content').innerHTML = data.html;
            });
        });
    });
});
</script>
@endsection
