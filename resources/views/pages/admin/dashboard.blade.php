@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark">IB Monitoring Dashboard</h3>
        <p class="text-muted small">Halo Admin, berikut adalah statistik pertumbuhan ekosistem FxJournals Anda.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="fa-solid fa-users fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Traders</span>
                        <h2 class="fw-bold mb-0">{{ $totalMembers }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="fa-solid fa-book fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Jurnal</span>
                        <h2 class="fw-bold mb-0">{{ $totalJournals }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="fa-solid fa-bolt fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Sinyal Aktif</span>
                        <h2 class="fw-bold mb-0">{{ $totalSignals }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <h5 class="fw-bold mb-3"><i class="fa-solid fa-clock-history me-2"></i>Aktivitas Jurnal Member Terbaru</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Trader</th>
                        <th>Pair</th>
                        <th>Type</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestJournals as $j)
                    <tr>
                        <td class="fw-bold text-primary">{{ $j->username }}</td>
                        <td>{{ $j->title }}</td>
                        <td>
                            <span class="badge {{ $j->type == 'BUY' ? 'bg-success' : 'bg-danger' }}">{{ $j->type }}</span>
                        </td>
                        <td class="small text-muted">{{ date('d M H:i', strtotime($j->created_at)) }}</td>
                        <td><a href="#" class="btn btn-sm btn-light border">Pantau</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
