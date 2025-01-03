@include('header')
@include('form')                                                         
    <div class="container">
        <h1>Insert Issue for Project: {{ $project->project_title }}</h1>

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

            <!-- Hidden field to pass project_id -->
            <input type="hidden" name="id_project" value="{{ $project->id_project }}">

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

            <!-- PIC -->
            <div class="form-group">
            <label for="pic">PIC:</label>
            <select id="pic" name="pic" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->name }}">{{ $user->name }}</option>
                @endforeach
            </select>
         
        </div>

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

            <div class="form-group">
            <label for="status-select">Select Status:</label>
            <select id="status-select" name="status" class="form-control">
                @foreach ($statuses as $status)
                <option value="{{ $status }}">
                    dd{{$status}}
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
        
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit Issue</button>
        </form>
    </div>

