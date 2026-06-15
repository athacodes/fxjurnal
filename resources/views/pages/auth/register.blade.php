@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-4">
        <div class="card p-4 shadow-sm border-0 rounded-3">
            <h3 class="text-center fw-bold mb-3 text-primary">Daftar Akun</h3>

            <div class="alert alert-info py-2.5 px-3 small border-0 mb-4 bg-light text-dark shadow-sm rounded-3">
                <div class="d-flex gap-2">
                    <span>💡</span>
                    <div>
                        <strong>Pengingat Penting:</strong> Mohon catat dan ingat <u>Username</u> serta password Anda, karena kombinasi ini yang akan digunakan untuk mengakses masuk ke dashboard trading nanti.
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 small mb-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Buat username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Buat password minimal 6 karakter" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Ulangi Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password Anda" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Daftar Sebagai</label>

                    <select class="form-select bg-light text-muted border-secondary fw-semibold" disabled>
                        <option value="member" selected>🌐 Member (Trader biasa)</option>
                    </select>

                    <input type="hidden" name="role" value="member">

                    <small class="text-muted d-block mt-1" style="font-size: 11px;">
                        *Pendaftaran akun publik otomatis dikunci sebagai Member. Akun Admin/IB dikelola secara privat.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 fw-bold py-2">Registrasi</button>

                <p class="text-center small mb-0">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Masuk</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
