@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-4">
        <div class="card p-4">
            <h3 class="text-center fw-bold mb-4 text-primary">Login</h3>

            {{-- Alert Pesan Sukses --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alert Pesan Error Login --}}
            @if($errors->has('loginError'))
                <div class="alert alert-danger">
                    {{ $errors->first('loginError') }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 fw-bold">Masuk</button>

                <p class="text-center small mb-0">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
