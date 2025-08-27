@extends('adminlte::page')

@section('title', 'Kelola Pesanan')

@section('content_header')
    <h1>Kelola Pesanan</h1>
@stop

@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Status</th>
            <th>Ubah Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pesanan as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->user->name }}</td>
            <td>Rp {{ number_format($p->total,0,',','.') }}</td>
            <td><span class="badge bg-info">{{ ucfirst($p->status) }}</span></td>
            <td>
                {{-- <form action="{{ route('admin.pesanan.updateStatus', $p->id) }}" method="POST"> --}}
                    @csrf
                    <select name="status" onchange="this.form.submit()" class="form-select">
                        <option value="pemrosesan" {{ $p->status=='pemrosesan'?'selected':'' }}>Pemrosesan</option>
                        <option value="dikirim" {{ $p->status=='dikirim'?'selected':'' }}>Dikirim</option>
                        <option value="diterima" {{ $p->status=='diterima'?'selected':'' }}>Diterima</option>
                        <option value="dibatalkan" {{ $p->status=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
                        <option value="refund" {{ $p->status=='refund'?'selected':'' }}>Refund</option>
                    </select>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
