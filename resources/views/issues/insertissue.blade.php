@include('header')
@include('form')
<div class="container">
    @if($project != 'default')
    <h1 class="page-title">Insert Issue for Project: {{ $project->project_title }}</h1>
    @endif
    <!-- Show any error or success messages -->
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Issue form -->
    <form action="{{ url('/insertissue') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($project != 'default')
        <!-- Hidden field to pass project_id -->
        <input type="hidden" name="id_project" value="{{ $project->id_project }}">
        

@else
        <!-- Project Title -->
        <div class="form-group">
            <label for="project_id">Project Title:</label>
            <select id="project_id" name="id_project" class="form-control" required>
                <option value="" disabled selected>Select a project</option>
                @foreach ($allproject as $project)
                <option value="{{ $project->id_project }}">{{ $project->project_title }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Issue Title -->
        <div class="form-group">
            <label for="issue_title">Issue Title:</label>
            <input type="text" id="issue_title" name="issue_title" class="form-control" required>
        </div>

        <!-- Issue Type -->
        <div class="form-group">
            <label for="issue_type">Issue Type:</label>
            <select id="issue_type" name="issue_type" class="form-control" required>
                <option value="new">New</option>
                <option value="enhancement">Enhancement</option>
                <option value="bug">Bug</option>
            </select>
        </div>

        <!-- Issue Description -->
        <div class="form-group">
            <label for="issue_desc">Issue Description:</label>
            <textarea id="issue_desc" name="issue_desc" class="form-control" required></textarea>
        </div>

        <!-- <p>{{$curruser}}</p> -->
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
        <input type="hidden" name="owner" value="{{ $curruser->name }}">

        <!-- Notes -->
        <div class="form-group">
            <label for="note">Notes:</label>
            <textarea id="note" name="note" class="form-control"></textarea>
        </div>

        <!-- Priority -->
        <div class="form-group">
            <label for="priority">Priority:</label>
            <select id="priority" name="priority" class="form-control" required>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="status-select">Select Status:</label>
            <select id="status-select" name="status" class="form-control">
                @foreach ($statuses as $status)
                <option value="{{ $status }}">
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Image Preview Section -->
        <div id="image-preview-container" class="image-preview-container">
            @if (isset($imagepaths))
            @foreach ($imagepaths as $index => $imagepath)
            <div class="image-wrapper">
                <input type="hidden" name="image_ids[]" value="{{ $imagepath->id }}">
                <img src="data:image/jpeg;base64,{{ base64_encode($imagepath->image) }}" alt="Previously Uploaded Image">
                <button type="button" class="remove-btn" onclick="removeImage(this)">x</button>
            </div>
            @endforeach
            @endif

            <!-- "Add More Images" placeholder -->
            <div id="add-image-placeholder" class="add-image-placeholder" onclick="triggerFilePicker()">
                <span class="plus-icon">+</span>
            </div>
        </div>

        <!-- Hidden file input -->
        <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*" style="display: none;" onchange="previewImages(event)">

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Submit Issue</button>
    </form>
</div>

<style>
    /* General Styling */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f7fa;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 900px;
        width: 100%;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .page-title {
        font-size: 2rem;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Alert messages */
    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .alert-danger {
        background-color: #e74c3c;
        color: white;
    }

    .alert-success {
        background-color: #2ecc71;
        color: white;
    }

    /* Form Styling */
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

    input[type="text"],
    input[type="date"],
    select,
    textarea {
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 15px;
        background-color: #f8f8f8;
        transition: border 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    select:focus,
    textarea:focus {
        border-color: #3498db;
        outline: none;
    }

    /* Image Preview */
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: space-between;
    }

    .image-wrapper {
        position: relative;
        display: inline-block;
    }

    .image-wrapper img {
        max-width: 200px;
        height: auto;
        margin: 5px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .add-image-placeholder {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 200px;
        border: 2px dashed #ccc;
        cursor: pointer;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .add-image-placeholder:hover {
        background-color: #f1f1f1;
    }

    .plus-icon {
        font-size: 48px;
        color: #ccc;
    }

    /* Submit Button */
    .btn-submit {
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

    .btn-submit:hover {
        background-color: #2980b9;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            width: 90%;
            padding: 20px;
        }

        .page-title {
            font-size: 1.8rem;
        }

        .btn-submit {
            width: 100%;
            font-size: 18px;
            padding: 15px;
        }
    }
</style>