@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('notes.index') }}" class="btn btn-light border btn-sm fw-bold">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Jurnal
        </a>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-circle-info text-primary me-2"></i>Parameter Transaksi</h5>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-borderless align-middle fs-6">
                        <tr>
                            <td class="text-muted" style="width: 140px;">Pair Mata Uang</td>
                            <td class="fw-bold text-dark">: {{ $note->title }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tipe Posisi</td>
                            <td>:
                                @if(strtoupper($note->type) === 'BUY')
                                    <span class="badge bg-success text-white fw-bold">BUY</span>
                                @else
                                    <span class="badge bg-danger text-white fw-bold">SELL</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Trading Session</td>
                            <td class="fw-semibold text-dark">: {{ $note->session ?? 'London Session' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Entry Price</td>
                            <td class="fw-semibold text-dark">: {{ $note->entry_price ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Exit Price (Realita)</td>
                            <td class="fw-semibold text-dark">: {{ $note->exit_price ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Stop Loss (SL)</td>
                            <td class="fw-semibold text-danger">: {{ $note->stop_loss ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Take Profit (TP)</td>
                            <td class="fw-semibold text-success">: {{ $note->take_profit ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Input</td>
                            <td class="text-secondary">: {{ date('d M Y - H:i', strtotime($note->created_at)) }} WIB</td>
                        </tr>
                    </table>

                    <hr class="text-secondary opacity-25">

                    <label class="fw-bold text-dark d-block mb-2"><i class="fa-solid fa-brain text-warning me-2"></i>Alasan & Analisis Psikologi</label>
                    <div class="p-3 bg-light rounded text-secondary border" style="white-space: pre-line; min-height: 120px;">
                        {{ $note->content }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-chart-area text-primary me-2"></i>Screenshot Grafik Analisis</h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center pt-0">
                    @if(isset($note->file_attachment) && $note->file_attachment)
                        <div class="border rounded p-2 bg-light w-100">
                            <img src="{{ asset('storage/' . $note->file_attachment) }}" alt="Trading Chart" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: contain;">
                        </div>
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $note->file_attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold">
                                <i class="fa-solid fa-magnifying-glass-plus me-1"></i> Perbesar Gambar
                            </a>
                        </div>
                    @else
                        <div class="py-5 text-muted">
                            <i class="fa-solid fa-image-slash fs-1 d-block mb-3 text-secondary"></i>
                            <span class="fw-semibold">Tidak ada screenshot chart dilampirkan.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
