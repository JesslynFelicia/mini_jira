@include('header')

<!-- Container for login form -->
<div class="container">
    <div class="login-form">
        <h2 class="text-center">Login</h2>

        <!-- Flash message alert for login failure -->
        @if(session('login_failed'))
            <div class="alert alert-danger text-center">
                <strong>Login failed. Please try again!</strong>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="/login">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <!-- Remember Me Checkbox -->
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="form-check-label">Remember Me</label>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>

            <!-- Additional Links -->
            <div class="text-center">
                <a href="/forgotpassword">Forgot Your Password?</a><br>
                <a href="/register">Create an Account</a>
            </div>
        </form>
    </div>
</div>

<!-- Additional CSS for styling -->
<style>
    .container {
        max-width: 400px;
        margin-top: 50px;
    }

    .login-form {
        background: #f7f7f7;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: bold;
    }

    .form-control {
        margin-top: 8px;
        padding: 10px;
        width: 100%;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 4px;
    }

    .form-check-label {
        font-size: 14px;
    }

    .alert {
        margin-bottom: 20px;
    }

    a {
        text-decoration: none;
        color: #007bff;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
