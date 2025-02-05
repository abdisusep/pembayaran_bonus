@extends('layouts.main')

@section('title', 'Detail Bonus')

@section('content')
<a href="{{ route('bonus_list') }}" class="btn btn-primary btn-sm mb-3">< Kembali</a>
<p><strong>Total Bonus:</strong> Rp {{ number_format($bonus->total_amount, 2, ',', '.') }}</p>

<h4>Daftar Buruh</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Persentase Bonus (%)</th>
            <th>Jumlah Bonus (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bonus->buruh as $buruh)
            <tr>
                <td>{{ $buruh->name }}</td>
                <td>{{ $buruh->percentage }}%</td>
                <td>Rp {{ number_format($buruh->amount, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection