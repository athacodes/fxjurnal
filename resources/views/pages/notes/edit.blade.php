@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 p-4">
        <div class="mb-4">
            <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Edit Jurnal Trading</h4>
            <p class="text-muted small">Perbarui data transaksi atau analisis psikologi trading Anda di bawah ini.</p>
        </div>

        <form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Currency Pair / Simbol</label>
                    <select name="title" class="form-select" required>
                        <option value="EURUSD" {{ $note->title === 'EURUSD' ? 'selected' : '' }}>EUR/USD</option>
                        <option value="GBPUSD" {{ $note->title === 'GBPUSD' ? 'selected' : '' }}>GBP/USD</option>
                        <option value="USDJPY" {{ $note->title === 'USDJPY' ? 'selected' : '' }}>USD/JPY</option>
                        <option value="XAUUSD" {{ $note->title === 'XAUUSD' ? 'selected' : '' }}>XAU/USD (Gold)</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tipe Posisi</label>
                    <div class="d-flex gap-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="buy" value="BUY" {{ strtoupper($note->type) === 'BUY' ? 'checked' : '' }}>
                            <label class="form-check-label text-success fw-bold" for="buy">BUY</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="sell" value="SELL" {{ strtoupper($note->type) === 'SELL' ? 'checked' : '' }}>
                            <label class="form-check-label text-danger fw-bold" for="sell">SELL</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Trading Session</label>
                    <input type="text" name="trading_session" class="form-control" value="{{ $note->session ?? 'London Session' }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Entry Price</label>
                    <input type="text" name="entry_price" class="form-control" value="{{ $note->entry_price ?? '' }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Exit Price (Biarkan kosong jika posisi masih running)</label>
                    <input type="text" name="exit_price" class="form-control" value="{{ $note->exit_price ?? '' }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Stop Loss (SL)</label>
                    <input type="text" name="stop_loss" class="form-control" value="{{ $note->stop_loss ?? '' }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Take Profit (TP)</label>
                    <input type="text" name="take_profit" class="form-control" value="{{ $note->take_profit ?? '' }}" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Lot Size</label>
                    <input type="number" step="0.01" name="lot" class="form-control" value="{{ $note->lot ?? 0.01 }}" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Alasan Analisis & Catatan Psikologi</label>
                    <textarea name="content" class="form-control" rows="4" required>{{ $note->content }}</textarea>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label fw-semibold">Ganti Screenshot Chart (Biarkan kosong jika tidak ingin diubah)</label>
                    <input type="file" name="file_attachment" class="form-control" accept="image/*">
                    @if(isset($note->file_path) && $note->file_path)
                        <div class="mt-2 text-muted small">
                            <i class="fa-solid fa-paperclip"></i> File saat ini: <span class="text-primary">{{ $note->file_name ?? 'Attachment' }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('notes.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4 fw-bold">Update Jurnal</button>
            </div>
        </form>
    </div>
</div>
@endsection
