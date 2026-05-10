<x-app-layout>
    <style>
        :root {
            --sage-prime: #43643C;
            --sage-soft: #7A9375;
            --sage-light: #E9EFE3;
            --sage-surface: #F9FBF7;
        }

        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 32px;
            border: 1px solid var(--sage-light);
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(67, 100, 60, 0.03);
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(67, 100, 60, 0.06);
        }

        .section-header {
            margin-bottom: 2rem;
            border-left: 4px solid var(--sage-prime);
            padding-left: 1.5rem;
        }

        .section-header h3 {
            font-size: 1.25rem;
            font-weight: 900;
            color: #2C4027;
            letter-spacing: -0.02em;
        }

        .section-header p {
            font-size: 0.875rem;
            color: var(--sage-soft);
            margin-top: 0.25rem;
        }

        /* Override style untuk form di dalam include jika diperlukan */
        input:focus {
            border-color: var(--sage-prime) !important;
            box-shadow: 0 0 0 1px var(--sage-prime) !important;
        }
    </style>

    <div class="profile-container">
        <div class="mb-8">
            <h2 class="text-3xl font-black text-[#2C4027] tracking-tight">
                {{ __('Pengaturan Profil') }}
            </h2>
            <p class="text-sage-soft font-medium mt-1">Kelola informasi akun dan keamanan data Anda.</p>
        </div>

        {{-- Update Profile Information --}}
        <div class="profile-card">
            <div class="section-header">
                <h3>Informasi Profil</h3>
                <p>Perbarui informasi profil akun dan alamat email Anda.</p>
            </div>
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="profile-card">
            <div class="section-header">
                <h3>Kata Sandi</h3>
                <p>Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>
            </div>
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete User --}}
        <div class="profile-card" style="border-color: #FEE2E2;">
            <div class="section-header" style="border-left-color: #EF4444;">
                <h3 style="color: #991B1B;">Hapus Akun</h3>
                <p>Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
            </div>
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>