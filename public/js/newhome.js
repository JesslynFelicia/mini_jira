document.addEventListener("DOMContentLoaded", function () {
    // Menyembunyikan semua issue terlebih dahulu
    function hideAllIssues() {
        const issueSections = document.querySelectorAll('.project-issues');
        issueSections.forEach(section => {
            section.classList.add('hidden');
        });
    }

    // Menampilkan project yang dipilih berdasarkan ID
    function showProjectIssues(projectId) {

        const projectSection = document.getElementById(`issues-${projectId}`);

        if (projectSection) {
            projectSection.classList.remove('hidden');
        }
    }


    // hide project grid
    function hideprojectsgrid() {
        const placeholderSection = document.getElementById('projects-grid');
        placeholderSection.classList.add('hidden');
        const placeholderSection2 = document.getElementById('projects-grid2');
        placeholderSection2.classList.add('hidden');
        issueItems = document.querySelectorAll('.all-title');
        issueItems.forEach(item => {

            item.classList.add('hidden');

        });
        placeholderSection3 = document.getElementById('project-search');
        placeholderSection3.classList.add('hidden');
        placeholderSection3 = document.getElementById('issue-search');
        placeholderSection3.classList.remove('hidden');

    }

    function showprojectsgrid() {
        console.log('showprojects grid');
        const placeholderSection = document.getElementById('projects-grid');
        placeholderSection.classList.remove('hidden');
        const placeholderSection2 = document.getElementById('projects-grid2');
        placeholderSection2.classList.remove('hidden');
        issueItems.forEach(item => {

            item.classList.remove('hidden');

        });

        placeholderSection3 = document.getElementById('project-search');
        placeholderSection3.classList.remove('hidden');
        placeholderSection3 = document.getElementById('issue-search');
        placeholderSection3.classList.add('hidden');
    }
    // Event listener untuk klik project di sidebar
    const projectLinks = document.querySelectorAll('.project-link');
    projectLinks.forEach(link => {
        link.addEventListener('click', function () {

            hideprojectsgrid();
            // Ambil ID project yang dipilih
            const projectId = link.getAttribute('data-project-id');
            console.log(projectId);
            // Sembunyikan semua project terlebih dahulu
            hideAllIssues();

            // Tampilkan project yang dipilih
            showProjectIssues(projectId);

            // Sembunyikan placeholder jika project dipilih
            // hidePlaceholder();

            hideprojectsgrid();

            // Menampilkan tombol edit dan delete untuk project
            const projectControls = document.getElementById('project-controls');
            projectControls.classList.remove('hidden');
            const projectTitle = link.textContent;
            document.getElementById('project-title').textContent = projectTitle;
            document.getElementById('edit-link').href = `/editproject/${projectId}`;
            document.getElementById('delete-form').action = `/delete/project/${projectId}`;


        });
    });

    // Menampilkan placeholder ketika tidak ada project yang dipilih
    // showPlaceholder();

    // Fitur pencarian untuk Project di sidebar
    const searchInput = document.getElementById('project-search');
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.toLowerCase();
        const projectItems = document.querySelectorAll('.all-projects-view');
        projectItems.forEach(item => {
            const projectTitle = item.textContent.toLowerCase();
            // console.log(projectTitle);
            if (projectTitle.includes(query)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    });

    // Fitur pencarian untuk Issue dalam project
    const issueSearchInput = document.getElementById('issue-search');
    issueSearchInput.addEventListener('input', function () {
        const query = issueSearchInput.value.toLowerCase();
        const issueItems = document.querySelectorAll('.issue-card');
        issueItems.forEach(item => {
            const issueTitle = item.querySelector('.issue-title').textContent.toLowerCase();
            const issueId = item.querySelector('.issue-id').textContent.toLowerCase();
            if (issueTitle.includes(query) || issueId.includes(query)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    });

    // Fitur "All Projects"
    document.getElementById('all-projects').addEventListener('click', function () {
        console.log('showptesrojects grid');
        // Menyembunyikan semua issue terlebih dahulu

        hideAllIssues();
        showprojectsgrid();
        // Tampilkan semua project issues
        // document.querySelectorAll('.project-issues').forEach(function(section) {
        //     section.classList.remove('hidden');
        // });

        // Sembunyikan placeholder jika project dipilih
        // hidePlaceholder();

        // Menyembunyikan tombol edit dan delete
        const projectControls = document.getElementById('project-controls');
        projectControls.classList.add('hidden');
    });
});

function togglevisibility() {
    console.log('masuk');
    const parentDiv = document.getElementById('parent');
    console.log(parentDiv);
    const childDiv = document.getElementById('achild');
    if (parentDiv.style.display !== 'none') {
        childDiv.style.display = 'block';
    }
    else {
        childDiv.style.display = 'none';
    }
}