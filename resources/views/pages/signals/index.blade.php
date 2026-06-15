@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-0">Sinyal IB Terbaru</h4>
        <p class="text-muted small mb-0">Ikuti rekomendasi sinyal trading harian langsung dari Introducing Broker (IB) Anda.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small fw-bold text-uppercase">
                        <tr>
                            <th class="ps-3" style="width: 60px;">No</th>
                            <th>Pair Mata Uang</th>
                            <th>Tipe Posisi</th>
                            <th>Entry Price</th>
                            <th>Take Profit (TP)</th>
                            <th>Stop Loss (SL)</th>
                            <th class="pe-3">Tanggal Rilis</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($signals as $index => $signal)
                            <tr>
                                <td class="ps-3 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $signal->pair }}</td>
                                <td>
                                    @if(strtoupper($signal->type) === 'BUY')
                                        <span class="badge bg-success fw-bold px-2 py-1">BUY</span>
                                    @else
                                        <span class="badge bg-danger fw-bold px-2 py-1">SELL</span>
                                    @endif
                                </td>
                                <td class="fw-semibold text-dark">{{ $signal->entry_price }}</td>
                                <td class="text-success fw-bold">{{ $signal->take_profit }}</td>
                                <td class="text-danger fw-bold">{{ $signal->stop_loss }}</td>
                                <td class="text-muted pe-3">{{ date('d M Y - H:i', strtotime($signal->created_at)) }} WIB</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-satellite-dish fs-2 d-block mb-2 text-secondary"></i>
                                    <span class="fw-semibold">Belum ada sinyal trading yang dirilis oleh IB.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
