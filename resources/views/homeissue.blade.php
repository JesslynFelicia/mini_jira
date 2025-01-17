<div id="issues-{{ $projectId }}" class="project-issues hidden">

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4 text-blue-700">{{ $groupedIssues[0]->project_title }} - Issues</h2>
        <p class="text-sm text-gray-500">PIC Project: {{ $groupedIssues[0]->pic_project ?? 'Not assigned' }}</p>
        <p class="text-sm text-gray-500">Owner : {{ $groupedIssues[0]->owner ?? 'Not assigned' }}</p>
        @if($groupedIssues[0]->owner == $curruser->name || $curruser->user_type == 'su')
        <a href="/editproject/{{ $groupedIssues[0]->id_project}}" class="text-blue-500">Edit</a>
        <form action="/delete/project/{{ $groupedIssues[0]->id_project}}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500">Delete</button>
        </form>
        @endif
        <!-- Search Bar untuk Issues -->
        <input type="text" id="issue-search" placeholder="Search Issues..." class="mb-4 p-2 rounded w-full text-gray-700">

        <!-- Deskripsi atau Placeholder jika tidak ada issues -->
        <div class="text-center mb-6 text-gray-600">
            <p>Project Description: <em>{{ $groupedIssues[0]->project_description ?? 'No description available' }}</em></p>
            <p class="mt-2 text-lg text-gray-500">Click "Add Issue" to start managing issues for this project.</p>
        </div>

        <!-- Tombol Add Issue untuk setiap project -->
        <div class="mb-4 text-center achild">
            <a href="/insertissue/{{ $projectId }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200">
                Add Issue
            </a>
        </div>

        <!-- Grid Issues -->
        <div class="grid grid-cols-3 gap-4 issue-section">

            <!-- Completed Issues -->
            <div>
                <h3 class="text-center font-bold text-blue-500 mb-2">Completed</h3>
                <div class="space-y-4">
                    @foreach ($groupedIssues as $issue)
                    @if ($issue->issue_status === 'completed' && $issue->filter == 'accepted')

                    <div class="bg-white border border-blue-300 rounded-lg p-4 shadow-md issue-card">
                        <h4 class="font-bold text-blue-700 issue-title">{{ $issue->issue_title }}</h4>
                        <p class="text-gray-500 text-sm issue-id">ID: {{ $issue->id_issue }}</p>

                        <p class="text-gray-600">Type: {{ $issue->issue_type }}</p>
                        <p class="text-gray-600">Priority: {{ $issue->priority }}</p>
                        <p class="text-gray-600">PIC: {{ $issue->pic }}</p>

                        <p class="text-gray-600">Due Date: {{ $issue->issue_due_date ?? 'Not Set' }}</p>

                        <!-- Created At and Updated At -->

                        <p class="text-gray-500 text-sm">Created At: {{ $issue->issue_created_at }}</p> <!-- Baris 23 -->
                        <p class="text-gray-500 text-sm">Updated At: {{ $issue->issue_updated_at }}</p> <!-- Baris 24 -->
                        <p>issue owner = {{$issue->issue_owner}}</p>


                        <div class="mt-2 flex space-x-4">
                            <a href="/viewissue/{{ $issue->id_issue }}" class="text-blue-500">View Details</a>
@if($curruser->user_type ==  'su' || $curruser->name == $issue->issue_owner )
                            <a href="/editissue/{{ $issue->id_issue }}" class="text-blue-500">Edit</a>
                            <form action="/delete/issue/{{ $issue->id_issue }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- On Progress Issues -->
            <div>
                <h3 class="text-center font-bold text-yellow-500 mb-2">On Progress</h3>
                <div class="space-y-4">
                    @foreach ($groupedIssues as $issue)
                    @if ($issue->issue_status === 'on_progress' && $issue->filter == 'accepted')
                    <div class="bg-white border border-yellow-300 rounded-lg p-4 shadow-md issue-card">
                        <h4 class="font-bold text-yellow-700 issue-title">{{ $issue->issue_title }}</h4>
                        <p class="text-gray-500 text-sm issue-id">ID: {{ $issue->id_issue }}</p>
                        <p class="text-gray-600">Type: {{ $issue->issue_type }}</p>
                        <p class="text-gray-600">Priority: {{ $issue->priority }}</p>
                        <p class="text-gray-600">PIC: {{ $issue->pic }}</p>

                        <p class="text-gray-600">Due Date: {{ $issue->issue_due_date ?? 'Not Set' }}</p>

                        <!-- Created At and Updated At -->


                        <p class="text-gray-500 text-sm">Created At: {{ $issue->issue_created_at }}</p> <!-- Baris 23 -->
                        <p class="text-gray-500 text-sm">Updated At: {{ $issue->issue_updated_at }}</p> <!-- Baris 24 -->

                        <div class="mt-2 flex space-x-4">
                            <a href="/viewissue/{{ $issue->id_issue }}" class="text-blue-500">View Details</a>
                            <a href="/editissue/{{ $issue->id_issue }}" class="text-blue-500">Edit</a>
                            <form action="/delete/issue/{{ $issue->id_issue }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Not Started Issues -->
            <div>
                <h3 class="text-center font-bold text-red-500 mb-2">Not Started</h3>
                <div class="space-y-4">

                    @foreach ($groupedIssues as $issue)

                    @if ($issue->issue_status === 'not_started' && $issue->filter == 'accepted')

                    <div class="bg-white border border-red-300 rounded-lg p-4 shadow-md issue-card">
                        <h4 class="font-bold text-red-700 issue-title">{{ $issue->issue_title }}</h4>
                        <p class="text-gray-500 text-sm issue-id">ID: {{ $issue->id_issue }}</p>
                        <p class="text-gray-600">Type: {{ $issue->issue_type }}</p>
                        <p class="text-gray-600">Priority: {{ $issue->priority }}</p>
                        <p class="text-gray-600">PIC: {{ $issue->pic }}</p>

                        <p class="text-gray-600">Due Date: {{ $issue->issue_due_date ?? 'Not Set' }}</p>

                        <!-- Created At and Updated At -->

                        <p class="text-gray-500 text-sm">Created At: {{ $issue->issue_created_at }}</p> <!-- Baris 23 -->
                        <p class="text-gray-500 text-sm">Updated At: {{ $issue->issue_updated_at }}</p> <!-- Baris 24 -->




                        <div class="mt-2 flex space-x-4">
                            <a href="/viewissue/{{ $issue->id_issue }}" class="text-blue-500">View Details</a>
                            <a href="/editissue/{{ $issue->id_issue }}" class="text-blue-500">Edit</a>
                            <form action="/delete/issue/{{ $issue->id_issue }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>