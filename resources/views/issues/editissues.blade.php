@include('header')
@include('form')
<div class="container">
    <h1>Edit Issues</h1>
    <form action="/editissue" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_issue" value="{{ $issue->id_issue }}">

        <div>
            <label for="issue_title">Issue Title</label>
            <input type="text" id="issue_title" name="issue_title" value="{{ old('issue_title', $issue->issue_title) }}">
        </div>

        <div class="form-group">
                <label for="issue_type">Issue Type:</label>
                <select id="issue_type" name="issue_type" class="form-control" required>
                    <option value="new">New</option>
                    <option value="enhancement">Enhancement</option>
                    <option value="bug">Bug</option>
                </select>
            </div>

        <div>
            <label for="issue_desc">Issue Description</label>
            <textarea id="issue_desc" name="issue_desc">{{ old('issue_desc', $issue->issue_desc) }}</textarea>
        </div>

        <!-- <div>
        <label for="pic">Owner</label>
        <input type="text" id="pic" name="pic" value="{{ old('owner', $issue->owner) }}" disabled>
    </div> -->

     

    <div class="form-group">
            <label for="user-select">Select User:</label>
            <select id="user-select" name="pic" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->name }}"
                    {{ $issue->pic ==  $user->name ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>

        </div>

        <div>
            <label for="note">Note</label>
            <textarea id="note" name="note">{{ old('note', $issue->note) }}</textarea>
        </div>

        <div>
            <label for="priority">Priority</label>
            <select id="priority" name="priority">
                <option value="low" {{ old('priority', $issue->priority) == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $issue->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority', $issue->priority) == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <label for="due_date">Due date:</label>
        <input type="date" id="date" name="due_date" required value="{{ old('due_date', $issue->due_date) }}"> <br>

    

        <div class="form-group">
            <label for="status-select">Select Status:</label>
            <select id="status-select" name="status" class="form-control">
                @foreach ($statuses as $status)
                <option value="{{ $status }}"
                    {{ $issue->status == $status ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
                @endforeach
            </select>
        </div>

        <div id="image-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px;">
            <!-- Show previously uploaded images if available -->

            @if (isset($imagepaths) )
            @foreach ($imagepaths as $index => $imagepath)



            <div class="image-wrapper" style="position: relative; display: inline-block;">
                <input type="hidden" name="image_ids[]" value="{{  $imagepath->id }}">
                <img src="data:image/jpeg;base64,{{ base64_encode($imagepath->image) }}" alt="Previously Uploaded Image" style="max-width: 200px; height: auto; margin: 5px;">
                <button class="remove-btn" style="position: absolute; top: 5px; right: 5px; background-color: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;" onclick="removeImage(this)">x</button>
            </div>
            @endforeach

            @endif


            <!-- "Add More Images" placeholder -->
            <div id="add-image-placeholder" style="display: flex; justify-content: center; align-items: center; width: 200px; height: 200px; border: 2px dashed #ccc; cursor: pointer;" onclick="triggerFilePicker()">
                <span style="font-size: 48px; color: #ccc;">+</span>
            </div>
        </div>


        <!-- Hidden file input -->
        <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*" style="display: none;" onchange="previewImages(event)">

        <button type="submit">Update Issue</button>
    </form>
</div>



<style>

</style>