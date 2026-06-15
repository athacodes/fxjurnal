@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Trading Signals</h3>
        <p class="text-muted small">Pantau sinyal trading terbaru langsung dari Admin bray.</p>
    </div>

    <div class="card border-0 shadow-sm p-4 rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle border-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Pair</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Tipe</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Entry Price</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Waktu Sinyal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($signals as $signal)
                    <tr>
                        <td><span class="fw-bold text-dark">{{ $signal->pair ?? $signal->title ?? '-' }}</span></td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2">
                                {{ strtoupper($signal->type ?? 'BUY') }}
                            </span>
                        </td>
                        <td class="fw-semibold text-secondary">{{ $signal->entry_price ?? '-' }}</td>
                        <td class="text-muted">{{ date('d M Y - H:i', strtotime($signal->created_at)) }} WIB</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            Tidak ada sinyal aktif saat ini bray.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
