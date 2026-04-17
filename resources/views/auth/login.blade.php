<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bert Car Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Perfect Centering */
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center; /* Vertical Center */
            justify-content: center; /* Horizontal Center */
            font-family: 'Inter', 'Segoe UI', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.05); /* Softer border */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 420px;
            transition: transform 0.2s ease;
        }

        .logo-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .btn-primary-custom {
            background-color: #4169e1;
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #3558c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(65, 105, 225, 0.3);
        }

        .form-control {
            border: 2px solid #f0f0f2;
            padding: 0.75rem 1rem;
            background-color: #f9fafb;
            border-radius: 0.75rem;
        }

        .form-control:focus {
            border-color: #4169e1;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(65, 105, 225, 0.1);
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            background: none;
            border: none;
            display: flex;
            align-items: center;
        }

        .demo-note {
            background-color: #eff6ff;
            border: 1px dashed #bfdbfe;
            border-radius: 0.75rem;
            padding: 0.85rem;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: #1e40af;
            text-align: center;
        }

        /* Error styling */
        .error-text {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center">
       <img src="{{ asset('image/Bert_Car_Logo.png') }}" alt="Bert Car Logo" class="logo-img">
    </div>

    <h1 class="text-center h4 fw-bold mb-1" style="color: #1a1f37;">Bert Car Management</h1>
    <p class="text-center text-muted mb-4" style="font-size: 0.9rem;">Please sign in to your account</p>

    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-4" style="font-size: 0.85rem; border-radius: 0.75rem;">
            <ul class="mb-0 list-unstyled">
                @foreach ($errors->all() as $error)
                    <li><i data-lucide="alert-circle" style="width: 14px; margin-right: 5px;"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Password</label>
            <div class="position-relative">
                <input type="password" name="password" id="password" class="form-control" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i data-lucide="eye" id="eyeIcon" style="width: 20px;"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 text-white rounded-3 shadow-sm">
            Sign In
        </button>
    </form>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        // Re-render icons
        lucide.createIcons();
    }
</script>

</body>
</html>