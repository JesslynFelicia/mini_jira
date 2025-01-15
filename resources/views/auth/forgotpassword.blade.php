  <!-- resources/views/auth/passwords/email.blade.php -->
  @include('header')
<div>


<div class="container">
    <h2>Forgot Password</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Forgot Password Form -->
    <form method="POST" action="#">
        @csrf

        <!-- Email Address Field -->
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit">Send Password Reset Link</button>
        </div>
    </form>
</div>


<!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
</div>
