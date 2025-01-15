@include('header')
@include('form')
<div class="container">
    <h1>Edit Issue</h1>
    <form action="/editissue" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_issue" value="{{ $issue->id_issue }}">

        <div class="form-group">
            <label for="issue_title">Issue Title</label>
            <input type="text" id="issue_title" name="issue_title" value="{{ old('issue_title', $issue->issue_title) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="issue_type">Issue Type</label>
            <select id="issue_type" name="issue_type" class="form-control" required>
                <option value="new" {{ old('issue_type', $issue->issue_type) == 'new' ? 'selected' : '' }}>New</option>
                <option value="enhancement" {{ old('issue_type', $issue->issue_type) == 'enhancement' ? 'selected' : '' }}>Enhancement</option>
                <option value="bug" {{ old('issue_type', $issue->issue_type) == 'bug' ? 'selected' : '' }}>Bug</option>
            </select>
        </div>

        <div class="form-group">
            <label for="issue_desc">Issue Description</label>
            <textarea id="issue_desc" name="issue_desc" class="form-control">{{ old('issue_desc', $issue->issue_desc) }}</textarea>
        </div>

        <div class="form-group">
            <label for="user-select">Select User</label>
            <select id="user-select" name="pic" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->name }}" {{ $issue->pic == $user->name ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea id="note" name="note" class="form-control">{{ old('note', $issue->note) }}</textarea>
        </div>

        <div class="form-group">
            <label for="priority">Priority</label>
            <select id="priority" name="priority" class="form-control">
                <option value="low" {{ old('priority', $issue->priority) == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $issue->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority', $issue->priority) == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" class="form-control" required value="{{ old('due_date', $issue->due_date) }}">
        </div>

        <div class="form-group">
            <label for="status-select">Select Status</label>
            <select id="status-select" name="status" class="form-control">
                @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ $issue->status == $status ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
                @endforeach
            </select>
        </div>

        <div id="image-preview-container" class="image-preview-container">
            @if (isset($imagepaths))
                @foreach ($imagepaths as $index => $imagepath)
                    <div class="image-wrapper">
                        <input type="hidden" name="image_ids[]" value="{{ $imagepath->id }}">
                        <img src="data:image/jpeg;base64,{{ base64_encode($imagepath->image) }}" alt="Uploaded Image">
                        <button class="remove-btn" onclick="removeImage(this)">x</button>
                    </div>
                @endforeach
            @endif
            <div id="add-image-placeholder" class="add-image-placeholder" onclick="triggerFilePicker()">
                <span>+</span>
            </div>
        </div>

        <!-- Hidden file input -->
        <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*" style="display: none;" onchange="previewImages(event)">

        <button type="submit" class="btn-submit">Update Issue</button>
    </form>
</div>

<style>
/* General page styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9fafb;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    max-width: 1100px;
    margin: 40px auto;
    padding: 30px;
    background-color: #fff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    overflow: hidden;
}

h1 {
    text-align: center;
    color: #2c3e50;
    font-size: 2rem;
    margin-bottom: 30px;
    font-weight: bold;
}

/* Form group styling */
.form-group {
    margin-bottom: 20px;
}

label {
    font-size: 16px;
    font-weight: 600;
    color: #34495e;
    margin-bottom: 8px;
    display: block;
}

input[type="text"],
textarea,
select,
input[type="date"] {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
    font-size: 16px;

    transition: border-color 0.3s;
}

input[type="text"]:focus,
textarea:focus,
select:focus,
input[type="date"]:focus {
    border-color: #3498db;
    outline: none;
}

textarea {
    resize: vertical;
    min-height: 150px;
}

/* Button styling */
button,
.btn-submit {
    background-color: #3498db;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 6px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover,
.btn-submit:hover {
    background-color: #2980b9;
    transform: translateY(-3px);
}

button:focus,
.btn-submit:focus {
    outline: none;
}

/* Image preview styling */
.image-preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.image-wrapper {
    position: relative;
    display: inline-block;
}

img {
    max-width: 200px;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
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
}

.add-image-placeholder span {
    font-size: 48px;
    color: #ccc;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 15px;
    }

    h1 {
        font-size: 1.5rem;
    }

    input[type="text"],
    textarea,
    select,
    input[type="date"],
    button {
        font-size: 14px;
    }

    .image-wrapper {
        width: 100%;
    }
}
</style>
