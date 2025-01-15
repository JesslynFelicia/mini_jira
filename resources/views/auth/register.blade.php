@include('header')

<!-- Container for register form -->
<div class="container">
    <div class="register-form">
        <h2 class="text-center">Register</h2>

        <!-- Flash message alert for registration failure -->
        @if(session('register_failed'))
            <div class="alert alert-danger text-center">
                <strong>Registration failed. Please try again!</strong>
            </div>
        @endif

        <!-- Registration Form -->
        <form method="POST" action="/register">
            @csrf

            <!-- Name Field -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

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
                <button type="submit" class="btn btn-primary">Register</button>
            </div>

            <div class="text-center">
                <a href="/login">Already have an account? Login</a>
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

    .register-form {
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
