
@include('header')

    <div class="container">
        <h2>Register</h2>

 

        <!-- Login Form -->
        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
            </div>
            <!-- Email Field -->
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
                <button type="submit">Register</button>
            </div>

       
        </form>
    </div>

