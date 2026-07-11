<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Transaksi - Lavanaya Madinah Travel</title>
    
    <!-- Bootstrap 5 CDN & FontAwesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css'])
</head>
<body class="lavanaya-premium-bg">

    <div class="container d-flex justify-content-center align-items-center min-vh-screen px-2 px-md-4">
        <div class="main-split-box">
            <div class="row g-0">
                
                <!-- SISI KIRI: WELCOME MESSAGE (Akan bersembunyi rapi ke atas di HP) -->
                <div class="col-md-6 welcome-side text-white">
                    <!-- Mini Logo -->
                    <div class="d-flex align-items-center gap-2 mb-3 small-logo">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19,4H5A2,2 0 0,0 3,6V18A2,2 0 0,0 5,20H19A2,2 0 0,0 21,18V6A2,2 0 0,0 19,4M19,7.5L12,13L5,7.5V6L12,11.5L19,6V7.5Z" fill="#c5a85a"/>
                        </svg>
                        <span class="fw-bold tracking-wider" style="font-size: 0.85rem;">LAVANAYA TRAVEL</span>
                    </div>
                    
                    <h1>Welcome!</h1>
                    <div class="welcome-line"></div>
                    <p class="text-white-50 mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                        Selamat datang di Sistem Pengajuan Transaksi Internal. Silakan masuk menggunakan kredensial akun terdaftar Anda untuk memproses administrasi pembayaran operasional.
                    </p>
                    <a href="#" class="btn btn-learn-more">Panduan Sistem</a>
                </div>

                <!-- SISI KANAN: FORM SIGN IN (GLASSMORPHISM EFFECT) -->
                <div class="col-md-6 form-glass-side text-white">
                    <div class="text-center mb-4">
                        <h2 class="fs-3 text-white">Login</h2>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success py-2 small bg-success text-white border-0 rounded-3 mb-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small bg-danger text-white border-0 rounded-3 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Username / Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-white-50 ps-2">User Name</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control input-glass shadow-none" 
                                   placeholder="nama@lavanaya.com" 
                                   value="{{ old('email') }}" required autofocus autocomplete="username">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold text-white-50 ps-2">Password</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control input-glass shadow-none" 
                                   placeholder="••••••••" required autocomplete="current-password">
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input bg-transparent border-secondary" id="remember_me" name="remember">
                                <label class="form-check-label small text-white-50" for="remember_me">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="small text-white-50 text-decoration-none hover:text-white">
                                    Lupa sandi?
                                </a>
                            @endif
                        </div>

                        <!-- Button Submit -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-submit-premium shadow">
                                Submit
                            </button>
                        </div>

                        <!-- Social Icons (Variasi dekoratif pelengkap seperti gambar) -->
                        <div class="d-flex justify-content-center gap-3 text-white-50 mt-2 small">
                            <i class="fab fa-facebook-f btn-outline-light"></i>
                            <i class="fab fa-instagram"></i>
                            <i class="fab fa-pinterest-p"></i>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>