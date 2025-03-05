<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiINFO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px 30px;
        }
        .card-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.9);
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(102,126,234,0.25);
            border-color: #667eea;
        }
        .btn-primary {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: #666;
        }
        .alert {
            border-radius: 10px;
        }
        .hospital-info {
            text-align: center;
            color: white;
            margin-bottom: 2rem;
        }
        .hospital-logo {
            max-width: 80px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <!-- Hospital Info -->
                <div class="hospital-info mb-4">
                    @php
                        $setting = DB::table('setting')->where('aktifkan', 'Yes')->first();
                    @endphp
                    @if($setting)
                        <h4 class="mb-2">{{ $setting->nama_instansi }}</h4>
                        <p class="mb-0 opacity-75">{{ $setting->alamat_instansi }}</p>
                        <p class="opacity-75">{{ $setting->kabupaten }}, {{ $setting->propinsi }}</p>
                    @endif
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center mb-0">Login SiINFO</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class='bx bx-error-circle me-2'></i>
                                <div>{{ $errors->first() }}</div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">ID User</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='bx bx-user'></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           name="id_user" 
                                           required 
                                           autofocus
                                           placeholder="Masukkan ID User">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='bx bx-lock-alt'></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           name="password" 
                                           required
                                           placeholder="Masukkan password">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-3">
                                    <i class='bx bx-log-in-circle me-2'></i>
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-white opacity-75 small mb-0">
                        &copy; {{ date('Y') }} {{ $setting->nama_instansi ?? 'SiINFO' }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 