<!-- Main Layout -->
@include('header')



<!-- buat gambar -->
<div id="popup-container">

</div>

<!-- expand project -->




@if (!session('curruser'));
<div class="auth-buttons">
    <a href="/login" class="btn btn-primary">Login</a>
    <a href="/register" class="btn btn-secondary">Register</a>
</div>
@else
<div class="auth-buttons">
    <a href="/logout" class="btn btn-primary">Logout</a>

</div>
@endif

<div class="container">




    @if (session('curruser')->user_type =='su')
    <div id="filter-user-toggle" onclick="toggleFilterUser()">
        <h3>Filter User</h1>
    </div>
    @endif

    <form action="/home" method="POST" class="user-form">
        @csrf
        @if (session('curruser')->user_type =='su')
        <div id="filter-user" class="form-group" id="filter-user" style="display: none;">
            <label for="user-select">Select User:</label>
            <select id="user-select" name="user_id" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

        </div>
        @endif


        @if ($curruser)
        <div class="current-user">
            <p>You are accessing as <strong>{{ $curruser->name }}</strong></p>
        </div>
        @endif


        <div class="search">
            <!-- Search Section -->
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" placeholder="Enter keywords" class="form-control">

            <label for="filter" class="mr-2">Filter:</label>
            <select name="filter" id="filter" class="form-control mr-2">
                <option value="All" {{ old('filter', $filter) == 'All' ? 'selected' : '' }}>All</option>
                <option value="projects" {{ old('filter', $filter) == 'projects' ? 'selected' : '' }}>Project</option>
                <option value="otherprojects" {{ old('filter', $filter) == 'otherprojects' ? 'selected' : '' }}>Other Projects</option>
                <option value="notes" {{ old('filter', $filter) == 'notes' ? 'selected' : '' }}>Note</option>
            </select>
            <br>
            <button type="submit" class="btn btn-secondary">Search</button>
    </form>
</div>

<div class="add_stuff" style="display: flex;">
    @if (session('curruser')->user_type =='su')
    <!-- Add Project Section -->
    <div class="add-project">
        <a href="/insertprojectview" class="btn-primary btn">Add Project</a>
    </div>

    @endif

    <div class="add-notes">
        <a href="/insertnotes" class="btn btn-success btn">Add Notes</a>

        <br>
    </div>
</div>

<!-- Projects Section -->
<div class="projects-section">
    @if ($projects && !empty($projects->first()) )
    <h1 class="page-title">Programs</h1>

    @foreach ($projects->groupBy('id_project') as $projectId => $groupedIssues)
    <div class="project-card">
        @if ($expand == $projectId)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                toggleProject('{{ $projectId }}');
            });
        </script>
        @endif
        <div class="project-header" onclick="toggleProject('{{ $projectId }}')">
            <h2 class="project-title">{{ $groupedIssues[0]->project_title }}</h2>
            @if($groupedIssues[0]->issue_title)
            <span class="issue-count">({{ count($groupedIssues) }} Issues)</span>
            @else
            <span class="issue-count">(0 Issues)</span>
            @endif
            <div class="project-meta">
                <span><strong>Owner:</strong> {{ $groupedIssues[0]->owner }}</span>
                <span><strong>Project ID:</strong> {{ $groupedIssues[0]->id_project }}</span>
                <span><strong>PIC:</strong> {{ $groupedIssues[0]->pic_project }}</span>
                <span><strong>Date Created:</strong> {{ $groupedIssues[0]-> created_at}}</span>
                <span><strong>Due Date:</strong> {{ $groupedIssues[0]-> project_due_date}}</span>
            </div>

            <!-- dd{{$curruser}} -->
            @if ($curruser->user_type=='su')
            <div class="project-actions">
                <a href="/editprojectview/{{ $groupedIssues[0]->id_project }}" class="btn btn-primary">Edit</a>
                <form action="/delete/project/{{$groupedIssues[0]->id_project}}" method="POST" class="inline-form" onsubmit="return confirmDelete()">
                    @csrf
                    @method('DELETE')

                    <input type="hidden" id="curruser" name="curruser" value="{{$curruser->id}}">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            @endif

        </div>

        <!-- <button class="btn btn-toggle" onclick="toggleProject('{{ $projectId }}')">Expand</button> -->

        <div id="project-{{ $projectId }}" class="project-details" style="display:none;">
            @if($groupedIssues[0]->id_issue !=null)
            <table class="issues-table">
                <thead>
                    <tr>
                        <th onclick="sortTable(this, 'string')">Issue Title <span class="sort-arrow"></span></th>
                        <!-- <th onclick="sortTable(this, 'string')">Description <span class="sort-arrow"></span></th> -->
                        <th onclick="sortTable(this, 'string')">Type <span class="sort-arrow"></span></th>
                        <th onclick="sortTable(this, 'string')">Priority <span class="sort-arrow"></span></th>
                        <!-- <th onclick="sortTable(this, 'string')">Note <span class="sort-arrow"></span></th> -->
                        <th onclick="sortTable(this, 'string')">PIC <span class="sort-arrow"></span></th>
                        <th onclick="sortTable(this, 'string')">Date Created <span class="sort-arrow"></span></th>
                        <th onclick="sortTable(this, 'string')">Due Date <span class="sort-arrow"></span></th>
                        <th>Details</th>
                        <th>Status</th>
                        @if ($curruser->user_type=='su')
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedIssues as $issue)
                    <tr>
                        <td>{{ $issue->issue_title }}</td>
                        <!-- <td>{{ $issue->issue_desc }}</td> -->
                        <td>{{ $issue->issue_type }}</td>
                        <td>{{ $issue->priority }}</td>
                        <!-- <td>{{ $issue->note }}</td> -->
                        <td>{{ $issue->pic }}</td>
                        <td>{{$issue->created_at}}</td>
                        <td>{{$issue ->issue_due_date}}</td>


                        <td>
                            <button class="view-image" data-id="{{ $issue->id_issue }}">
                                View Image
                            </button>

                            <!-- <a href="/image/{{$issue->id_issue}}" class="view-details">
                                    View Image
                                </a> -->
                            <a href="/showissue/{{$issue->id_issue}}" class="view-details">
                                View Details
                            </a>
                        </td>

                        <td>{{$issue -> issue_status}}</td>
                        @if ($curruser->user_type=='su')
                        <td id="btn-issue">
                            <a href="/editissueview/{{$issue->id_issue}}" class="btn btn-primary">Edit</a>
                            <form action="/delete/issue/{{$issue->id_issue}}" method="POST" class="inline-form" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="expandedProject" name="expandedProject" value="{{$groupedIssues[0]->id_project}}">
                                <input type="hidden" id="curruser" name="curruser" value="{{$curruser->id}}">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="no-issues">No issues available for this project.</p>
            @endif

            @if ($curruser->user_type=='su')
            <div class="add-issue">
                <a href="insertissueview/{{$groupedIssues[0]->id_project}}" class="btn btn-success">Insert Issue</a>
            </div>
            @endif
        </div>
    </div>
    @endforeach

    @endif
</div>


@if($otherprojects)
@if (!empty($otherprojects->first()))
<h1 class="page-title">Other Projects</h1>
@foreach ($otherprojects->groupBy('id_project') as $projectId => $groupedIssues)
<div class="project-card">
    <div class="project-header" onclick="toggleProject('{{ $projectId }}')">
        <h2 class="project-title">{{ $groupedIssues[0]->project_title }}</h2>
        <span class="issue-count">({{ count($groupedIssues) }} Issues)</span>
        <div class="project-meta">
            <span><strong>PIC:</strong> {{ $groupedIssues[0]->pic_project }}</span>
            <span><strong>Project ID:</strong> {{ $groupedIssues[0]->id_project }}</span>
            <span><strong>Date Created:</strong> {{ $groupedIssues[0]-> created_at}}</span>
            <span><strong>Due Date:</strong> {{ $groupedIssues[0]-> project_due_date}}</span>
        </div>
    </div>

    <!-- <button class="btn btn-toggle" onclick="toggleProject('{{ $projectId }}')">Expand</button> -->

    <div id="project-{{ $projectId }}" class="project-details" style="display:none;">
        @if($groupedIssues[0]->id_issue !=null)
        <table class="issues-table">
            <thead>
                <tr>
                    <th onclick="sortTable(this, 'string')">Issue Title <span class="sort-arrow"></span></th>
                    <!-- <th onclick="sortTable(this, 'string')">Description <span class="sort-arrow"></span></th> -->
                    <th onclick="sortTable(this, 'string')">Type <span class="sort-arrow"></span></th>
                    <th onclick="sortTable(this, 'string')">Priority <span class="sort-arrow"></span></th>
                    <!-- <th onclick="sortTable(this, 'string')">Note <span class="sort-arrow"></span></th> -->
                    <th onclick="sortTable(this, 'string')">PIC <span class="sort-arrow"></span></th>
                    <th onclick="sortTable(this, 'string')">Date Created <span class="sort-arrow"></span></th>
                    <th onclick="sortTable(this, 'string')">Due Date <span class="sort-arrow"></span></th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedIssues as $issue)
                <tr>
                    <td>{{ $issue->issue_title }}</td>
                    <!-- <td>{{ $issue->issue_desc }}</td> -->
                    <td>{{ $issue->issue_type }}</td>
                    <td>{{ $issue->priority }}</td>
                    <!-- <td>{{ $issue->note }}</td> -->
                    <td>{{ $issue->pic }}</td>
                    <td>{{$issue->created_at}}</td>
                    <td>{{$issue ->issue_due_date}}</td>
                    <td>{{$issue -> issue_status}}</td>


                    <td>
                        <button class="view-image" data-id="{{ $issue->id_issue }}">
                            View Image
                        </button>

                        <!-- <a href="/image/{{$issue->id_issue}}" class="view-details">
                                    View Image
                                </a> -->

                        <a href="/showissue/{{$issue->id_issue}}" class="view-details">
                            View Details
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="no-issues">No issues available for this project.</p>
        @endif
    </div>
</div>
@endforeach

@endif

@endif

<div class="notes-section">
    @if ($notes && !empty($notes->first()))
    <h1 class="page-title">Notes</h1>

    @foreach ($notes as $note)
    <div class="project-card" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
        <div class="note-content">
            <!-- dd{{$note}} -->
            <p>{{ $note->notes }}</p>
        </div>
        <div class="note-actions" style="display: flex; gap: 10px;">
            <a href="/editnotes/{{$note->id_notes}}" class="btn btn-primary">Edit</a>
            <!-- <button class="btn btn-danger">Delete</button> -->

            <form action="/delete/notes/{{$note->id_notes}}" method="POST" class="inline-form" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <input type="hidden" id="curruser" name="curruser" value="{{$curruser->id}}">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

        </div>
    </div>
    @endforeach


    @endif
</div>



</div>