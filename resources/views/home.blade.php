@include('header')

<body class="bg-white">




    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-gradient-to-r from-blue-700 to-blue-800 shadow-lg p-6 overflow-y-auto">
            <!-- Search Bar untuk Project -->
            <ul>
                <li class="mb-3">
                    <a href="#" id="all-projects" class="text-white hover:bg-blue-600 p-2 rounded-lg block transition duration-300 ease-in-out">
                        All Projects
                    </a>
                </li>
            </ul>


            <!-- <h2 class="text-xl font-bold mb-4 text-white">Projects</h2> -->
            <!-- <ul>

                @if ($projects && !empty($projects->first()))
                @foreach ($projects->groupBy('id_project') as $projectId => $groupedIssues)
                <li class="mb-3" onclick="togglevisibility()">
                    <a href="#" data-project-id="{{ $projectId }}" class="project-link text-white hover:bg-blue-600 p-2 rounded-lg block transition duration-300 ease-in-out">
                        {{ $groupedIssues[0]->project_title }}
                    </a>


                </li>
                @endforeach
                @endif
            </ul> -->

            <!-- @if ($otherprojects && !empty($otherprojects->first()))
            <h2 class="text-xl font-bold mb-4 text-white">Other Projects</h2>
            <ul>
                @foreach ($otherprojects->groupBy('id_project') as $projectId => $groupedIssues)
                <li class="mb-3">
                    <a href="#" data-project-id="{{ $projectId }}" class="project-link text-white hover:bg-blue-600 p-2 rounded-lg block transition duration-300 ease-in-out">
                        {{ $groupedIssues[0]->project_title }}
                    </a>

                </li>
                @endforeach
            </ul>
            @endif -->

            <!-- Tombol logout dan add project -->
            <div class="mt-6">
                <a href="/logout" class="block bg-blue-600 text-white text-center py-2 px-4 rounded-lg">Logout</a>
            </div>
            <div class="mt-4">
                <a href="/insertprojectview" class="block bg-blue-600 text-white text-center py-2 px-4 rounded-lg">Add Project</a>
            </div>
            <div class="mt-4" id="achild">
                <a href="/insertissue" class="block bg-blue-600 text-white text-center py-2 px-4 rounded-lg">Add Issue</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-6 overflow-y-auto">

            <input type="text" id="project-search" placeholder="Search Projects..." class="mb-4 p-2 rounded w-full text-gray-700">

            <!-- Kontrol Project (Edit, Delete) -->



            <!-- Isi project dan issue -->
            <div class="space-y-6">
                <a href="/insertprojectview" class="mt-6 inline-block bg-green-500 text-white py-2 px-4 rounded-lg">Create New Project</a>
                <a href="/issues" class="mt-6 inline-block bg-green-500 text-white py-2 px-4 rounded-lg">Show your pending issues</a>

                <div id='parent'>
                    <h1 class='all-title'>Projects</h1>
                    <div id="projects-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">

                        @if ($projects && !empty($projects->first()))
                        @foreach ($projects->groupBy('id_project') as $projectId => $groupedIssues)


                        <div class="bg-white shadow-md rounded-lg overflow-hidden all-projects-view">
                            <div class="p-4">
                                <h2 class="text-xl font-bold text-gray-800">{{ $groupedIssues[0]->project_title }}</h2>
                                <p class="text-gray-600">PIC: {{ $groupedIssues[0]->pic_project }}</p> <!-- Assuming you have a 'pic' field -->
                                <button class="bg-blue-600 text-white py-2 px-4 mt-4 rounded project-link" data-project-id="{{ $projectId }}">View Issues</button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <h1 class='all-title'>Other Projects</h2>
                        <div id="projects-grid2" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
                            @if ($otherprojects && !empty($otherprojects->first()))
                            @foreach ($otherprojects->groupBy('id_project') as $projectId => $groupedIssues)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden all-projects-view">
                                <div class="p-4">
                                    <h2 class="text-xl font-bold text-gray-800">{{ $groupedIssues[0]->project_title }}</h2>
                                    <p class="text-gray-600">PIC: {{ $groupedIssues[0]->pic_project }}</p> <!-- Assuming you have a 'pic' field -->
                                    <button class="bg-blue-600 text-white py-2 px-4 mt-4 rounded project-link" data-project-id="{{ $projectId }}">View Issues</button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                </div>

                @if ($projects && !empty($projects->first()))
                @foreach ($projects->groupBy('id_project') as $projectId => $groupedIssues)
                <!-- Setiap project punya id unik berdasarkan projectId -->

              
                @include('homeissue')
                @endforeach
                @endif
            </div>

            <div class="space-y-6">
               
                @if ($otherprojects && !empty($otherprojects->first()))
         
                @foreach ($otherprojects->groupBy('id_project') as $projectId => $groupedIssues)
                <!-- Setiap project punya id unik berdasarkan projectId -->
           
               
                @include('homeissue')
                @endforeach
                @endif
            </div>
        </main>
    </div>

</body>