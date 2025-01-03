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


        <div class="form-group">
            <label for="pic">PIC:</label>
            <select id="pic" name="pic" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->name }}"
                    {{ $project->PIC ==  $user->name ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        <!-- Person In Charge (PIC) Field - Read-Only -->
        <div class="form-group">
            <label for="pic">Owner</label>
            <input type="text" id="pic" class="form-control" value="{{ $project->owner }}" disabled>
        </div>

        <label for="due_date">Due date:</label>
        <input type="date" id="date" name="due_date"> <br>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Project</button>
        </div>
    </form>
</div>