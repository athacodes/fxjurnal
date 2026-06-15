@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 p-4">
        <div class="mb-4">
            <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-plus-circle text-primary me-2"></i>Buat Jurnal Trading Baru</h4>
            <p class="text-muted small">Masukkan detail transaksi Forex Anda untuk keperluan dokumentasi dan analisis psikologi.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Currency Pair / Simbol</label>
                    <select name="title" class="form-select" required>
                        <option value="">-- Pilih Pair Mata Uang --</option>
                        <option value="EURUSD">EUR/USD</option>
                        <option value="GBPUSD">GBP/USD</option>
                        <option value="USDJPY">USD/JPY</option>
                        <option value="XAUUSD">XAU/USD (Gold)</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tipe Posisi</label>
                    <div class="d-flex gap-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="buy" value="BUY" checked>
                            <label class="form-check-label text-success fw-bold" for="buy">BUY</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="sell" value="SELL">
                            <label class="form-check-label text-danger fw-bold" for="sell">SELL</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Entry Price</label>
                    <input type="text" name="entry_price" class="form-control" placeholder="Contoh: 1.2550 atau 2350.00" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Exit Price (Realita Tutup)</label>
                    <input type="text" name="exit_price" class="form-control" placeholder="Contoh: 1.2600 atau 2340.00" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Stop Loss (SL)</label>
                    <input type="text" name="stop_loss" class="form-control" placeholder="Contoh: 1.2500" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Take Profit (TP)</label>
                    <input type="text" name="take_profit" class="form-control" placeholder="Contoh: 1.2650" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Lot Size</label>
                    <input type="number" name="lot" step="0.01" min="0.01" class="form-control" placeholder="Misal: 0.10" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Trading Session</label>
                    <select name="trading_session" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Session --</option>
                        <option value="Asian (Tokyo/Sydney)">🌏 Asian Session</option>
                        <option value="London (Europe)">🇪🇺 London Session</option>
                        <option value="New York (US)">🇺🇸 New York Session</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Alasan Analisis & Catatan Psikologi</label>
                    <textarea name="content" class="form-control" rows="4" placeholder="Tuliskan alasan teknikal/fundamental Anda masuk pasar..." required></textarea>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label fw-semibold">Upload Screenshot Chart (Grafik)</label>
                    <input type="file" name="file_attachment" class="form-control" accept="image/*">
                    <small class="text-muted">Format yang didukung: PNG, JPG, JPEG (Maks. 5MB)</small>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('notes.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Jurnal</button>
            </div>
        </form>
    </div>
</div>
@endsection
