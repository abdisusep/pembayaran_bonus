@extends('layouts.main')

@section('title', 'Add Bonus')

@section('content')
<a href="{{ route('bonus_list') }}" class="btn btn-primary btn-sm mb-3">< Kembali</a>
<form action="{{ route('bonus_post') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Total Bonus (Rp)</label>
        <input type="number" id="total_bonus" name="total_amount" class="form-control" required>
    </div>

    <h4>Daftar Buruh</h4>
    <div id="buruh-container">
        <div class="buruh-item mb-3">
            <input type="text" name="buruh[0][name]" class="form-control mb-2" placeholder="Nama Buruh" required>
            <input type="number" name="buruh[0][percentage]" class="form-control buruh-percentage mb-2" placeholder="Persentase Bonus (%)" required>
            <input type="text" class="form-control buruh-amount" placeholder="Bonus (Rp)" readonly>
            <button type="button" class="btn btn-danger btn-sm remove-buruh mt-2">Hapus</button>
        </div>
    </div>

    <button type="button" class="btn btn-success" id="add-buruh">Tambah Buruh</button>
    <button type="submit" class="btn btn-dark">Simpan</button>
</form>

<script>
    let buruhIndex = 1;

    document.getElementById('add-buruh').addEventListener('click', function () {
        const container = document.getElementById('buruh-container');
        const newBuruh = document.createElement('div');
        newBuruh.classList.add('buruh-item', 'mb-3');

        newBuruh.innerHTML = `
            <input type="text" name="buruh[${buruhIndex}][name]" class="form-control mb-2" placeholder="Nama Buruh" required>
            <input type="number" name="buruh[${buruhIndex}][percentage]" class="form-control buruh-percentage mb-2" placeholder="Persentase Bonus (%)" required>
            <input type="text" class="form-control buruh-amount" placeholder="Bonus (Rp)" readonly>
            <button type="button" class="btn btn-danger remove-buruh mt-2">Hapus</button>
        `;

        container.appendChild(newBuruh);
        buruhIndex++;
    });

    document.addEventListener('input', function (event) {
        if (event.target.classList.contains('buruh-percentage')) {
            const totalBonus = parseFloat(document.getElementById('total_bonus').value) || 0;
            const percentage = parseFloat(event.target.value) || 0;
            const amountField = event.target.parentElement.querySelector('.buruh-amount');
            amountField.value = (totalBonus * percentage / 100).toFixed(2);
        }
    });

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-buruh')) {
            event.target.parentElement.remove();
        }
    });
</script>
@endsection