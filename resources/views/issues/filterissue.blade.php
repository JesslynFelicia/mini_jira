@include('header')

<div class="container mx-auto p-6">
    <h2 class="text-3xl font-semibold text-center mb-6">All Issues</h2>

    <!-- Back to Home Button -->
    <div class="mb-6 text-center">
        <a href="{{ url('/home') }}" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
            Back to Home
        </a>
    </div>

    <!-- Display Success or Error Messages -->
    @if(session('success'))
        <div class="alert alert-success mb-4 bg-green-500 text-white p-4 rounded-lg shadow-md">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4 bg-red-500 text-white p-4 rounded-lg shadow-md">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tab Navigation for Filter -->
    <div class="mb-6">
        <ul class="flex space-x-4 border-b border-gray-300">
            <li class="cursor-pointer py-2 px-4 text-sm font-medium text-gray-600 hover:text-blue-500 transition-all duration-200 
                {{ request()->is('issues') ? 'border-b-2 border-blue-500 text-blue-500' : '' }}">
                <a href="{{ route('issue.index') }}">All</a>
            </li>
            <li class="cursor-pointer py-2 px-4 text-sm font-medium text-gray-600 hover:text-blue-500 transition-all duration-200 
                {{ request()->is('issues/accepted') ? 'border-b-2 border-blue-500 text-blue-500' : '' }}">
                <a href="{{ route('issue.filter', ['filter' => 'accepted']) }}">Accepted</a>
            </li>
            <li class="cursor-pointer py-2 px-4 text-sm font-medium text-gray-600 hover:text-blue-500 transition-all duration-200 
                {{ request()->is('issues/rejected') ? 'border-b-2 border-blue-500 text-blue-500' : '' }}">
                <a href="{{ route('issue.filter', ['filter' => 'rejected']) }}">Rejected</a>
            </li>
            <li class="cursor-pointer py-2 px-4 text-sm font-medium text-gray-600 hover:text-blue-500 transition-all duration-200 
                {{ request()->is('issues/pending') ? 'border-b-2 border-blue-500 text-blue-500' : '' }}">
                <a href="{{ route('issue.filter', ['filter' => 'pending']) }}">Pending</a>
            </li>
        </ul>
    </div>

    <!-- Table of Issues -->
    <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
        <div class="table-responsive">
            <table class="table table-bordered w-full table-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-sm font-medium text-gray-700">Issue Title</th>
                        <th class="px-6 py-3 text-sm font-medium text-gray-700">Filter</th>
                        <th class="px-6 py-3 text-sm font-medium text-gray-700">Project</th>
       
                        <th class="px-6 py-3 text-sm font-medium text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($issues as $issue)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $issue->issue_title }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-3 py-1 rounded-full
                                    @if($issue->filter == 'accepted') bg-green-500 text-white
                                    @elseif($issue->filter == 'rejected') bg-red-500 text-white
                                    @elseif($issue->filter == 'pending') bg-yellow-500 text-white
                                    @endif">
                                    {{ ucfirst($issue->filter) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $issue->project_title }}</td>

                            <td class="px-6 py-4 text-sm flex items-center space-x-2">
                                @if(session('curruser')->user_type == 'su')
                                    <form action="{{ route('issue.updateStatus', ['id' => $issue->id_issue, 'filter' => 'accepted']) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-200 ease-in-out">
                                            Accept
                                        </button>
                                    </form>

                                    <form action="{{ route('issue.updateStatus', ['id' => $issue->id_issue, 'filter' => 'rejected']) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-700 transition duration-200 ease-in-out">
                                            Reject
                                        </button>
                                    </form>

                                    <form action="{{ route('issue.updateStatus', ['id' => $issue->id_issue, 'filter' => 'pending']) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded-md hover:bg-yellow-700 transition duration-200 ease-in-out">
                                            Pending
                                        </button>
                                    </form>
                                @endif

                                <!-- Link for View Detail -->
                                <a href="{{route ('issue.viewissue',['issue_id'=>$issue->id_issue])}}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                                    View Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table th, .table td {
    padding: 12px 16px;
    text-align: left;
    vertical-align: middle;
}

.table thead {
    background-color: #f3f4f6;
    font-weight: bold;
}



.table tbody tr:hover {
    background-color: #f1f5f9;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin-top: 20px;
}

</style>