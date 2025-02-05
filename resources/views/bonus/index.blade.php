@extends('layouts.main')

@section('title', 'List Bonus')

@section('content')
<div>
    <a href="{{ route('bonus_add') }}" class="btn btn-primary btn-sm mb-3">+ Add</a>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Total Bonus (Rp)</th>
                <th>Jumlah Buruh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bonus as $bns)
                <tr>
                    <td>{{ $bns->id }}</td>
                    <td>Rp {{ number_format($bns->total_amount, 2, ',', '.') }}</td>
                    <td>{{ $bns->buruh->count() }}</td>
                    <td>
                        <a href="{{ route('bonus_detail', $bns->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('bonus_edit', $bns->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('bonus_delete', $bns->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus Data?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection