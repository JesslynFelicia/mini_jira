@include('header')
@include('form')

<div class="container">
    <h1>Issue {{$issue->issue_title}}</h1>
    
    <div>
        <label for="issue_title">Due date</label>
        <p>{{ $issue->due_date }}</p>
    </div>
    
    <div>
        <label for="issue_title">Issue Title</label>
        <p>{{ $issue->issue_title }}</p>
    </div>

    <div>
        <label for="issue_type">Issue Type</label>
        <p>{{ $issue->issue_type }}</p>
    </div>

    <div>
        <label for="issue_desc">Issue Description</label>
        <p>{{ $issue->issue_desc }}</p>
    </div>

    <div>
        <label for="user-select">Owner</label>
        <p>{{ $issue->pic }}</p>
    </div>

    <div>
        <label for="note">Note</label>
        <p>{{ $issue->note }}</p>
    </div>

    <div>
        <label for="priority">Priority</label>
        <p>{{ ucfirst($issue->priority) }}</p>
    </div>

    <div>
        <label for="image">Image</label>
 <div class="image-wrapper"></div>
        <!-- Container for Image Preview -->
        <div id="image-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px;">
            @if ($imagepaths)
                @foreach ($imagepaths as $index => $imagepath)
                    <div class="image-wrapper" style="position: relative; display: inline-block;">
                        <img src="data:image/jpeg;base64,{{ base64_encode($imagepath->image) }}" alt="Previously Uploaded Image" style="max-width: 200px; height: auto; margin: 5px;">
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <button onclick="window.history.back();">Back</button>
</div>
