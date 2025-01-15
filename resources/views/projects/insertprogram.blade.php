@include('header')
<div class="container">
    <h1>Insert Project</h1>
    <form action="/insertproject" method="POST">
        @csrf <!-- CSRF Protection -->
        
        <!-- Project Title -->
        <div class="form-group">
            <label for="project_title">Project Title:</label>
            <input type="text" id="project_title" name="project_title" required class="form-control">
        </div>

        <!-- Project Description -->
        <div class="form-group">
            <label for="project_description">Project Description:</label>
            <textarea id="project_description" name="project_description" rows="4" class="form-control" placeholder="Describe your project here..."></textarea>
        </div>

        <!-- Owner (disabled) -->
        <div class="form-group">
            <label for="owner">Owner:</label>
            <input type="text" id="owner" name="owner" value="{{ $curruser->name }}" disabled class="form-control">
        </div>

        <!-- PIC -->
        <div class="form-group">
            <label for="pic">PIC:</label>
           
            <select id="pic" name="pic" class="form-control" 
            @if($curruser->user_type !== 'su') disabled @endif>
            @foreach ($users as $user)
                <option value="{{ $user->name }}" {{ $user->name == $curruser->name ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        @if($curruser->user_type !== 'su')
        <input type="hidden" name="pic" value="{{ $curruser->name }}">
        @endif

        <!-- Due Date -->
        <div class="form-group">
            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" class="form-control">
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="owner" value="{{ $curruser->name }}">
        <input type="hidden" name="curruser" value="{{ $curruser->id }}">

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Submit</button>
    </form>
</div>

<style>
/* General styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    width: 100%;
    margin: 40px auto;
    padding: 30px;
    background-color: white;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

h1 {
    font-size: 2rem;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 20px;
}

/* Form styling */
form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 16px;
    color: #34495e;
    margin-bottom: 8px;
}

input[type="text"], input[type="date"], select, textarea {
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 6px;
    margin-bottom: 15px;
    background-color: #f8f8f8;
    transition: border 0.3s ease;
}

input[type="text"]:focus, input[type="date"]:focus, select:focus, textarea:focus {
    border-color: #3498db;
    outline: none;
}

/* Disabled input (Owner) */
input[disabled] {
    background-color: #e3e3e3;
    cursor: not-allowed;
}

/* Submit button */
button {
    background-color: #3498db;
    color: white;
    font-size: 16px;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}

button:hover {
    background-color: #2980b9;
}

/* Responsive design */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    h1 {
        font-size: 1.8rem;
    }

    button {
        width: 100%;
        font-size: 18px;
        padding: 15px;
    }
}
</style>
