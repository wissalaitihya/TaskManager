<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskManager – Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem 2.5rem;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-box {
            width: 56px;
            height: 56px;
            background: #059669;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .icon-box svg {
            width: 28px;
            height: 28px;
            color: #fff;
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .card-header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .card-header p {
            font-size: 0.95rem;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #9ca3af;
            pointer-events: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #111827;
            background: #f9fafb;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #059669;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #d1d5db;
        }

        .btn {
            width: 100%;
            padding: 0.875rem;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background: #059669;
            color: #fff;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary svg {
            width: 18px;
            height: 18px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: #d1d5db;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider-text {
            font-size: 0.75rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid #e5e7eb;
            color: #111827;
            margin-bottom: 0;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .btn-secondary:hover {
            border-color: #d1d5db;
            background: #f9fafb;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.4rem;
        }

        .error-input {
            border-color: #ef4444 !important;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="card">
            <!-- Icon -->
            <div class="icon-box">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>

            <!-- Header -->
            <div class="card-header">
                <h1>Create Account</h1>
                <p>Join TaskManager and start organizing your work</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M12 12a4 4 0 100-8 4 4 0 000 8z">
                            </path>
                        </svg>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe"
                            required autofocus class="{{ $errors->has('name') ? 'error-input' : '' }}">
                    </div>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required
                            class="{{ $errors->has('email') ? 'error-input' : '' }}">
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        <input type="password" id="password" name="password" placeholder="••••••••" required
                            class="{{ $errors->has('password') ? 'error-input' : '' }}">
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="••••••••" required
                            class="{{ $errors->has('password_confirmation') ? 'error-input' : '' }}">
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Create Account
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span class="divider-text">ALREADY HAVE AN ACCOUNT?</span>
            </div>

            <!-- Sign In Button -->
            <a href="{{ route('login') }}" class="btn btn-secondary">Sign in</a>
        </div>
    </div>
</body>

</html>