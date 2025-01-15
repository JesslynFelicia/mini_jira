@include('header')

<div class="container">
    <h1>Edit Project</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/editproject" method="POST">
        @csrf

        <input type="hidden" name="id_project" value="{{ $project->id_project }}">

        <!-- Project Title Input -->
        <div class="form-group">
            <label for="project_title">Project Title</label>
            <input type="text" name="project_title" id="project_title" class="form-control" value="{{ old('project_title', $project->project_title) }}" required>
        </div>

        <!-- Project Description Input -->
        <div class="form-group">
            <label for="project_description">Project Description</label>
            <textarea name="project_description" id="project_description" class="form-control" rows="4" required>{{ old('project_description', $project->project_description) }}</textarea>
        </div>

        <!-- Person In Charge (PIC) Field -->
        <div class="form-group">
            <label for="pic">PIC:</label>
            <select id="pic" name="pic" class="form-control"
                @if($curruser->user_type !== 'su') disabled @endif>
                @foreach ($users as $user)
                <option value="{{ $user->name }}" {{ $project->PIC == $user->name ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        @if($curruser->user_type !== 'su')
        <input type="hidden" name="pic" value="{{ $curruser->name }}">
        @endif

        <!-- Person In Charge (PIC) Field - Read-Only -->
        <div class="form-group">
            <label for="pic">Owner</label>
            <input type="text" id="pic" class="form-control" value="{{ $project->owner }}" disabled>
        </div>

        <!-- Due Date Input -->
        <div class="form-group">
            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date', $project->due_date) }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Project</button>
        </div>
    </form>
</div>