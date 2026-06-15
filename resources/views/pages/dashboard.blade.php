@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Welcome Back, {{ Auth::user()->name ?? Auth::user()->username }}!</h3>
            <p class="text-muted small mb-0">Pantau ringkasan performa dan statistik trading Forex Anda secara real-time.</p>
        </div>

        <div class="d-flex flex-wrap align-items-end gap-2">
            <div style="min-width: 180px;">
                <form action="{{ route('dashboard') }}" method="GET" id="filterForm">
                    <label class="form-label small fw-bold text-secondary mb-1"><i class="fa-solid fa-calendar-days me-1"></i> Periode Analisis</label>
                    <select name="filter" class="form-select border-primary fw-semibold select-sm" onchange="document.getElementById('filterForm').submit();">
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>All Time (Semua)</option>
                        <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="weekly" {{ $filter === 'weekly' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="yearly" {{ $filter === 'yearly' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </form>
            </div>
            <a href="{{ route('notes.create') }}" class="btn btn-primary fw-bold d-flex align-items-center gap-2 shadow-sm rounded-3" style="height: 38px;">
                <i class="fa-solid fa-plus"></i> Tulis Jurnal
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-primary border-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Total Trades</span>
                        <h2 class="fw-extrabold text-dark mb-0">{{ $totalTrades }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="fa-solid fa-chart-line fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-success border-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Profit Trades</span>
                        <h2 class="fw-extrabold text-success mb-0">${{ number_format($filteredNotes->where('profit_loss', '>', 0)->sum('profit_loss'), 2) }}</h2>
                        <span class="fs-6 text-muted fw-normal">{{ $filteredNotes->where('profit_loss', '>', 0)->count() }} Wins</span>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="fa-solid fa-arrow-trend-up fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-danger border-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Loss Trades</span>
                        <h2 class="fw-extrabold text-danger mb-0">-${{ number_format(abs($filteredNotes->where('profit_loss', '<', 0)->sum('profit_loss')), 2) }}</h2>
                        <span class="fs-6 text-muted fw-normal">{{ $filteredNotes->where('profit_loss', '<', 0)->count() }} Losses</span>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-3">
                        <i class="fa-solid fa-arrow-trend-down fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-info border-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Total Pips Growth</span>
                        <h2 class="fw-extrabold text-info mb-0">{{ $filteredNotes->sum('pips') >= 0 ? '+' : '' }}{{ number_format($filteredNotes->sum('pips'), 1) }} <span class="fs-6 fw-normal text-muted">Pips</span></h2>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded p-3">
                        <i class="fa-solid fa-calculator fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-3 rounded-3 mb-4 bg-primary text-white">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="fs-4">📢</span>
                <div>
                    <strong class="d-block">Sinyal Trading Admin Terkini</strong>
                    <span class="small opacity-75">Pantau setup analisa pasar tervalidasi langsung dari ruang kendali admin.</span>
                </div>
            </div>
            <a href="/member/signals" class="btn btn-light btn-sm text-primary fw-bold px-3 rounded-2 shadow-sm">
                Buka Menu Sinyal <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 rounded-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clock-history text-secondary me-2"></i>Log Transaksi Terfilter</h5>
            <span class="badge bg-light text-dark border fw-normal py-2 px-3">Menampilkan {{ $filteredNotes->count() }} Transaksi</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle border-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 text-muted small text-uppercase fw-bold" style="width: 60px;">No</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Pair</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Tipe</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Lot</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold">Trading Session & Time</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold text-center">Pips</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold text-end">Net Profit/Loss</th>
                        <th class="border-0 text-muted small text-uppercase fw-bold" style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filteredNotes as $index => $item)
                    <tr>
                        <td class="fw-bold text-secondary">{{ $index + 1 }}</td>
                        <td><span class="fw-bold text-dark">{{ $item->title }}</span></td>
                        <td>
                            @if(isset($item->type) && strtoupper($item->type) === 'BUY')
                                <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2">BUY</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger fw-bold px-3 py-2">SELL</span>
                            @endif
                        </td>
                        <td><span class="fw-bold text-dark">{{ number_format($item->lot ?? 0.01, 2) }}</span></td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->session ?? 'London Session' }}</div>
                            <div class="text-muted small">{{ date('H:i', strtotime($item->created_at)) }} - {{ $item->exit_time ?? '18:45' }} WIB</div>
                        </td>
                        <td class="text-center fw-bold {{ ($item->pips ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ ($item->pips ?? 0) >= 0 ? '+' : '' }}{{ $item->pips ?? '0' }} Pips
                        </td>
                        <td class="text-end fw-bold {{ ($item->profit_loss ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ ($item->profit_loss ?? 0) >= 0 ? '+$' : '-$' }}{{ number_format(abs($item->profit_loss ?? 0), 2) }}
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('notes.show', $item->id) }}" class="btn btn-outline-primary btn-sm rounded-2">
                                <i class="fa-solid fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fs-2 d-block mb-2 text-secondary"></i>
                            Tidak ada aktivitas trading yang tercatat pada periode ini bray.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
