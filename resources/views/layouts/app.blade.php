<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FxJournals - Elite FX Trading Journal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #f4f6f9; min-height: 100vh; }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #1e293b;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        @auth
        <div class="sidebar d-flex flex-column justify-content-between py-4">
            <div>
                <div class="px-4 mb-4">
                    <h4 class="fw-bold text-white mb-0"><i class="fa-solid fa-chart-line text-primary me-2"></i>FxJournals</h4>
                    <small class="text-muted">Trading Log & Analytics</small>
                </div>
                <hr class="mx-3 text-secondary">

                <ul class="nav nav-pills flex-column mb-auto">
                    @if(strtolower(Auth::user()->role) === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                                <i class="fa-solid fa-chart-line"></i> Monitoring Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.signals.index') }}" class="nav-link {{ Route::is('admin.signals.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-satellite-dish"></i> Kelola Sinyal Trade
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-users"></i> Jurnal Semua Member
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                                <i class="fa-solid fa-gauge"></i> Dashboard Member
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('notes.index') }}" class="nav-link {{ Route::is('notes.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-note-sticky"></i> Jurnal Trading Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.signals') }}" class="nav-link {{ Route::is('member.signals') ? 'active' : '' }}">
                                <i class="fa-solid fa-bolt text-warning"></i> Sinyal IB Terbaru
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="px-3">
                <hr class="text-secondary">
                <form action="{{ route('logout') }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 fw-bold py-2 d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
        @endauth

        <div class="main-content flex-grow-1 @guest w-100 m-0 @endguest">

            @auth
            <div class="d-flex justify-content-end align-items-center mb-4 pb-3 border-bottom">
                <div class="d-flex align-items-center">

                    <div class="{{ strtolower(Auth::user()->role) === 'admin' ? 'bg-danger' : 'bg-primary' }} text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2 shadow-sm" style="width: 40px; height: 40px; user-select: none;">
                        {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->username, 0, 1)) }}
                    </div>

                    <div class="d-none d-sm-block text-start me-1">
                        <p class="mb-0 fw-bold lh-1 text-dark">{{ Auth::user()->name ?? 'User FxJournals' }}</p>
                        <div class="mt-1">
                            @if(strtolower(Auth::user()->role) === 'admin')
                                <span class="badge bg-danger text-white fw-extrabold px-2" style="font-size: 9px; letter-spacing: 0.5px;"><i class="fa-solid fa-user-shield me-1"></i>ADMIN IB</span>
                            @else
                                <span class="badge bg-success text-white fw-extrabold px-2" style="font-size: 9px; letter-spacing: 0.5px;"><i class="fa-solid fa-user text-white me-1"></i>TRADER MEMBER</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            @endauth

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function() {
                const passwordInput = this.closest('.input-group').querySelector('input');
                const icon = this.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
