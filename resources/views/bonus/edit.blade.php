@extends('layouts.main')

@section('title', 'Edit Bonus')

@section('content')
<a href="{{ route('bonus_list') }}" class="btn btn-primary btn-sm mb-3">< Kembali</a>

<form action="{{ route('bonus_update', $bonus->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Total Bonus (Rp)</label>
        <input type="number" id="total_bonus" name="total_amount" class="form-control" value="{{ $bonus->total_amount }}" required>
    </div>

    <h4>Daftar Buruh</h4>
    <div id="buruh-container">
        @foreach ($bonus->buruh as $index => $buruh)
            <div class="buruh-item mb-3">
                <input type="hidden" name="buruh[{{ $index }}][id]" value="{{ $buruh->id }}">
                <input type="text" name="buruh[{{ $index }}][name]" class="form-control mb-2" placeholder="Nama Buruh" value="{{ $buruh->name }}" required>
                <input type="number" name="buruh[{{ $index }}][percentage]" class="form-control buruh-percentage mb-2" placeholder="Persentase Bonus (%)" value="{{ $buruh->percentage }}" required>
                <input type="text" class="form-control buruh-amount" value="Rp {{ number_format(($bonus->total_amount * $buruh->percentage) / 100, 2, ',', '.') }}" readonly>
                <button type="button" class="btn btn-danger btn-sm remove-buruh mt-2">Hapus</button>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-success" id="add-buruh">Tambah Buruh</button>
    <button type="submit" class="btn btn-dark">Update</button>
</form>

<script>
    let buruhIndex = {{ $bonus->buruh->count() }};

    document.getElementById('add-buruh').addEventListener('click', function () {
        const container = document.getElementById('buruh-container');
        const newBuruh = document.createElement('div');
        newBuruh.classList.add('buruh-item', 'mb-3');

        newBuruh.innerHTML = `
            <input type="hidden" name="buruh[${buruhIndex}][id]" value="">
            <input type="text" name="buruh[${buruhIndex}][name]" class="form-control mb-2" placeholder="Nama Buruh" required>
            <input type="number" name="buruh[${buruhIndex}][percentage]" class="form-control buruh-percentage mb-2" placeholder="Persentase Bonus (%)" required>
            <input type="text" class="form-control buruh-amount" value="Rp 0,00" readonly>
            <button type="button" class="btn btn-danger btn-sm remove-buruh mt-2">Hapus</button>
        `;

        container.appendChild(newBuruh);
        buruhIndex++;
    });

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-buruh')) {
            event.target.parentElement.remove();
        }
    });

    function updateBuruhAmount() {
        const totalBonus = parseFloat(document.getElementById('total_bonus').value) || 0;

        document.querySelectorAll('.buruh-item').forEach(item => {
            const percentageField = item.querySelector('.buruh-percentage');
            const amountField = item.querySelector('.buruh-amount');
            const percentage = parseFloat(percentageField.value) || 0;
            const amount = (totalBonus * percentage) / 100;
            amountField.value = "Rp " + amount.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        });
    }

    document.getElementById('total_bonus').addEventListener('input', updateBuruhAmount);
    document.addEventListener('input', function (event) {
        if (event.target.classList.contains('buruh-percentage')) {
            updateBuruhAmount();
        }
    });

    updateBuruhAmount();
</script>
@endsection