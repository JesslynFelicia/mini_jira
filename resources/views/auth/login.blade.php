<!-- resources/views/auth/login.blade.php -->
@include('header')

    <div class="container">
        <h2>Login</h2>

        @if(session('login_failed'))
    <script type="text/javascript">
        alert('Login failed. Please try again!');
    </script>
    <!-- Clear the session flag after showing the alert -->
@endif

        <!-- Login Form -->
        <form method="POST" action="/login">
            @csrf
         
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" >
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>

            <!-- Remember Me Checkbox -->
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember Me</label>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit">Login</button>
            </div>

            <a href="/register">Register</a>
        </form>
    </div>

