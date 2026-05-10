<x-guest-layout>
<style>
    /* Menggunakan font yang sama dengan landing page untuk konsistensi */
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #F8FAF7; /* Latar belakang abu-abu kehijauan yang sangat lembut */
    }

    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .auth-card {
        background: #ffffff;
        border-radius: 40px;
        border: 1px solid #E9EFE3;
        box-shadow: 0 25px 50px -12px rgba(44, 64, 39, 0.08);
        padding: 3rem 2.5rem;
        max-width: 480px;
        width: 100%;
        position: relative;
    }

    /* Dekorasi tanaman di atas judul */
    .brand-icon {
        width: 60px;
        height: 60px;
        background: #F2F5EB;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }

    .f-label-custom {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #2C4027;
        margin-bottom: 0.5rem;
        margin-left: 1rem;
    }

    .f-input-custom {
        width: 100%;
        padding: 0.85rem 1.5rem;
        border: 2px solid #F0F4E8;
        border-radius: 99px; /* Bentuk pill sempurna */
        background: #F9FBF6;
        color: #2C4027;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        outline: none;
    }

    .f-input-custom:focus {
        border-color: #43643C;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(67, 100, 60, 0.08);
    }

    /* Role Selection Styling */
    .role-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .role-card-custom {
        cursor: pointer;
        border: 2px solid #F0F4E8;
        border-radius: 24px;
        padding: 1.25rem 0.75rem;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #F9FBF6;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
    }

    .role-opt-input:checked + .role-card-custom {
        border-color: #43643C;
        background: #F2F5EB;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(67, 100, 60, 0.1);
    }

    .role-emoji { font-size: 1.75rem; margin-bottom: 0.25rem; }
    .role-name { font-weight: 800; color: #2C4027; font-size: 0.9rem; }
    .role-desc { font-size: 0.7rem; color: #7A9375; line-height: 1.2; }

    .btn-register-custom {
        width: 100%;
        padding: 1.1rem;
        background: #43643C;
        color: white;
        border-radius: 99px;
        font-weight: 800;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
        box-shadow: 0 10px 25px rgba(67, 100, 60, 0.25);
    }

    .btn-register-custom:hover {
        background: #354E2D;
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(67, 100, 60, 0.35);
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #F0F4E8;
    }
</style>

<div class="register-container">
    <div class="auth-card">
        <div class="text-center mb-8">
            <img src="/storage/icon.png" alt="Sisa Guna Logo" class="w-16 h-16 aspect-square object-cover rounded-2xl shadow-lg shadow-[#43643C]/20 mx-auto mb-4">
            <h1 class="text-2xl font-black text-[#2C4027] tracking-tight mb-1">Bergabung Sekarang</h1>
            <p class="text-[#7A9375] font-medium text-sm">Mulai berbagi kebaikan di Sisa Guna</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-2xl text-red-700 text-xs">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="f-label-custom">Nama Lengkap</label>
                <input class="f-input-custom" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
            </div>

            <div class="mb-4">
                <label class="f-label-custom">Alamat Email</label>
                <input class="f-input-custom" type="email" name="email" value="{{ old('email') }}" placeholder="kamu@email.com" required>
            </div>

            <div class="mb-4">
                <label class="f-label-custom">Daftar Sebagai</label>
                <div class="role-grid">
                    <label class="relative">
                        <input type="radio" name="role" value="donatur" class="role-opt-input absolute opacity-0" {{ old('role')=='donatur'?'checked':'' }} required>
                        <div class="role-card-custom">
                            <span class="role-emoji">🎁</span>
                            <span class="role-name">Donatur</span>
                            <span class="role-desc">Saya punya barang berlebih</span>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="role" value="penerima" class="role-opt-input absolute opacity-0" {{ old('role')=='penerima'?'checked':'' }}>
                        <div class="role-card-custom">
                            <span class="role-emoji">🙏</span>
                            <span class="role-name">Penerima</span>
                            <span class="role-desc">Saya butuh barang</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="f-label-custom">Kota Domisili</label>
                <input class="f-input-custom" type="text" name="kota" value="{{ old('kota') }}" placeholder="Contoh: Kebumen" required>
            </div>

            <div class="mb-4">
                <label class="f-label-custom">Nomor Telepon/WhatsApp</label>
                <input class="f-input-custom" type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="mb-4">
                <label class="f-label-custom">Deskripsi Singkat (Bio)</label>
                <textarea class="f-input-custom" name="bio" rows="2" placeholder="Ceritakan sedikit tentang Anda..." required style="border-radius: 20px;">{{ old('bio') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <div>
                    <label class="f-label-custom">Password</label>
                    <input class="f-input-custom" type="password" name="password" placeholder="••••••••" required>
                </div>
                <div>
                    <label class="f-label-custom">Konfirmasi</label>
                    <input class="f-input-custom" type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-register-custom">
                Buat Akun Sekarang →
            </button>
        </form>

        <div class="auth-footer">
            <p class="text-sm text-[#7A9375] font-medium">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-[#43643C] font-extrabold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
</x-guest-layout>