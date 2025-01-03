document.addEventListener("DOMContentLoaded", function() {
    console.log('masuk');
    // Get the expanded project ID from the session (passed from the server)
    var expandedProjectId = "{{ session('expanded_project') }}";

    if (expandedProjectId) {
        // If the expanded project ID exists, expand the corresponding project section
        toggleProject(expandedProjectId);
    }
});



    // Toggle visibility of project details
function toggleProject(projectId) {
    var projectDetails = document.getElementById("project-" + projectId);
    // Toggle display property: jika project-detail sedang tampil, disembunyikan, sebaliknya jika disembunyikan maka tampilkan.
    if (projectDetails.style.display === "none" || projectDetails.style.display === "") {
        projectDetails.style.display = "block";
    } else {
        projectDetails.style.display = "none";
    }
}

// Menambahkan event listener klik untuk setiap project-card agar ketika diklik bisa expand
document.querySelectorAll('.project-card').forEach(function(card) {
    card.addEventListener('click', function(event) {
        // Prevent collapsing if the click happened inside the table
        if (event.target.closest('.issues-table')) {
            return; // Stop the toggle action if click is inside the table
        }

        var projectId = this.getAttribute('data-project-id');
        toggleProject(projectId);
    });
});

// Handle sorting inside the table
function sortTable(thElement, dataType) {
    const table = thElement.closest('table'); // Get the table
    const tbody = table.querySelector('tbody'); // Get the table body
    const rows = Array.from(tbody.querySelectorAll('tr')); // Get all rows

    // Get the column index
    const columnIndex = Array.from(thElement.parentElement.children).indexOf(thElement);

    // Determine the sorting order (ascending or descending)
    const isAscending = thElement.dataset.sortOrder === 'asc' || !thElement.dataset.sortOrder;
    thElement.dataset.sortOrder = isAscending ? 'desc' : 'asc';

    // Remove previous arrow from all headers
    document.querySelectorAll('.issues-table th .sort-arrow').forEach(function (arrow) {
        arrow.textContent = ''; // Clear all arrows
    });

    // Add an arrow to the clicked header
    const arrow = thElement.querySelector('.sort-arrow');
    if (isAscending) {
        arrow.textContent = '▲'; // Ascending arrow
    } else {
        arrow.textContent = '▼'; // Descending arrow
    }

    // Sort the rows based on the data type (number or string)
    rows.sort((rowA, rowB) => {
        const cellA = rowA.children[columnIndex].textContent.trim();
        const cellB = rowB.children[columnIndex].textContent.trim();

        if (dataType === 'number') {
            return isAscending
                ? parseFloat(cellA) - parseFloat(cellB)
                : parseFloat(cellB) - parseFloat(cellA);
        } else {
            return isAscending
                ? cellA.localeCompare(cellB)
                : cellB.localeCompare(cellA);
        }
    });

    // Append the sorted rows back to the tbody
    rows.forEach(row => tbody.appendChild(row));
}

// Toggle filter form visibility
function toggleFilterUser() {
    var form = document.getElementById("filter-user");
    form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
}

function confirmDelete() {
    // Show a confirmation dialog
    return confirm("Are you sure you want to delete this item?");
}


document.addEventListener("DOMContentLoaded", function () {
    const popupContainer = document.getElementById("popup-container");

    document.querySelectorAll(".view-image").forEach(button => {
        button.addEventListener("click", function () {
            const issueid = this.getAttribute("data-id");
           
            // Fetch the popup content via AJAX
            fetch(`image/${issueid}`)
                .then(response => response.text())
                .then(html => {
                    // console.log(response);
                    popupContainer.innerHTML = html; // Load the popup HTML
                    const modal = document.getElementById("imageModal");
                    const closeModal = modal.querySelector(".close");

                    modal.style.display = "flex";
                  

                    // Close modal on click
                    closeModal.addEventListener("click", function () {
                        modal.style.display = "none";
                    });

                    window.addEventListener("click", function (event) {
                        if (event.target === modal) {
                            modal.style.display = "none";
                        }
                    });
                })
                .catch(error => console.error("Error fetching popup:", error));
        });
    });
});




