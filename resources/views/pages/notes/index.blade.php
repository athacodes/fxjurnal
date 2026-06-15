@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Dashboard Member</h4>
            <p class="text-muted small mb-0">Kelola analisis jurnal trading Anda dan pantau sinyal dari IB terpercaya.</p>
        </div>
        <a href="{{ route('notes.create') }}" class="btn btn-primary fw-bold">
            <i class="fa-solid fa-plus me-1"></i> Buat Jurnal Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 small mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-9 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-book text-primary me-2"></i>Jurnal Trading Saya</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small fw-bold text-uppercase">
                            <tr>
                                <th class="ps-3" style="width: 60px;">No</th>
                                <th>Pair</th>
                                <th>Posisi</th>
                                <th>Session & Time</th>
                                <th>Entry Price</th>
                                <th>Pips</th>
                                <th>Net Profit/Loss</th>
                                <th class="text-end pe-3" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse($notes as $index => $item)
                                <tr>
                                    <td class="ps-3 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $item->title }}</td>
                                    <td>
                                        @if(strtoupper($item->type) === 'BUY')
                                            <span class="badge bg-success-subtle text-success fw-bold px-2 py-1">BUY</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fw-bold px-2 py-1">SELL</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $item->session }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ date('d M Y - H:i', strtotime($item->created_at)) }} WIB</div>
                                    </td>
                                    <td class="fw-semibold text-secondary">{{ $item->entry_price ?? '-' }}</td>
                                    <td>
                                        <span class="fw-bold {{ $item->pips >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $item->pips >= 0 ? '+' : '' }}{{ $item->pips }} Pips
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold {{ $item->profit_loss >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $item->profit_loss >= 0 ? '+$' : '-$' }}{{ abs($item->profit_loss) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('notes.show', $item->id) }}" class="btn btn-sm btn-light border">
                                                <i class="fa-solid fa-eye text-primary"></i>
                                            </a>
                                            <a href="{{ route('notes.edit', $item->id) }}" class="btn btn-sm btn-light border">
                                                <i class="fa-solid fa-pen-to-square text-warning"></i>
                                            </a>
                                            <form action="{{ route('notes.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jurnal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-2 d-block mb-2 text-secondary"></i>
                                        <span class="fw-semibold">Belum ada data jurnal trading.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-signal text-warning me-2"></i>Sinyal IB Terbaru</h5>
                </div>
                <div class="card-body pt-0">
                    @forelse($signals as $signal)
                        <div class="p-3 mb-3 border rounded bg-light shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark fs-6">{{ $signal->pair }}</span>
                                @if(strtoupper($signal->type) === 'BUY')
                                    <span class="badge bg-success fw-bold text-white px-2 py-0.5">BUY</span>
                                @else
                                    <span class="badge bg-danger fw-bold text-white px-2 py-0.5">SELL</span>
                                @endif
                            </div>
                            <div class="small text-secondary mb-1">
                                <strong>Entry:</strong> {{ $signal->entry_price }}
                            </div>
                            <div class="small text-success mb-1">
                                <strong>TP:</strong> {{ $signal->take_profit }}
                            </div>
                            <div class="small text-danger mb-2">
                                <strong>SL:</strong> {{ $signal->stop_loss }}
                            </div>
                            <div class="text-muted" style="font-size: 0.70rem;">
                                <i class="fa-regular fa-clock me-1"></i>{{ date('d M Y - H:i', strtotime($signal->created_at)) }} WIB
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-satellite-dish fs-2 d-block mb-2 text-secondary"></i>
                            <span class="small fw-semibold">Belum ada sinyal aktif.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
