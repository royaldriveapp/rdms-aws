<style>
       
        .pagination {
            margin: 20px 0;
            text-align: center;
        }
        .pagination button {
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #ddd;
            background-color: #fff;
            cursor: pointer;
        }
        .pagination button.active {
            background-color: #337ab7;
            color: white;
            border: 1px solid #337ab7;
        }
        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        #searchBox {
            width: 15%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
    </style>
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Vehicle Enquiries</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

<!-- s -->
<input type="text" id="searchBox" placeholder="Search" oninput="fetchData()">

<!-- Data Table -->
<table id="enquiriesTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <!-- <th>State</th>
            <th>District</th> -->
            <th>Vehicle</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <!-- data will be dynamically inserted here -->
    </tbody>
</table>

<!-- Pagination controls -->
<div class="pagination" id="paginationControls">
    <!-- pgntion dynamically inserted here -->
</div>
<!-- ss -->
                
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const apiUrl = 'https://royaldrivesmart.in/api/rdms/vehicle-enquiries.php';
    let currentPage = 1;
    const limit = 10;

    async function fetchData(page = 1) {
    currentPage = page;
    const search = document.getElementById('searchBox').value;
    const url = `${apiUrl}?page=${currentPage}&limit=${limit}&search=${encodeURIComponent(search)}`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.status === 'success') {
            renderTable(data.data);
            renderPagination(data.pagination); // Pass pagination data here
        } else {
            console.error(data.message);
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}


    function renderTable(enquiries) {
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = ''; // clr  prev content

        if (enquiries.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="7">No enquiries found.</td></tr>';
            return;
        }

        enquiries.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.phone}</td>
                <td>${item.email}</td>
               
                <td>${item.productTitle}</td>
                <td>${item.created}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    function renderPagination(pagination) {
    const paginationControls = document.getElementById('paginationControls');
    paginationControls.innerHTML = ''; // Clear previous content

    const totalPages = pagination.total_pages;
    const currentPage = pagination.current_page;

    // Previous button
    const prevButton = document.createElement('button');
    prevButton.textContent = 'Previous';
    prevButton.disabled = currentPage === 1;
    prevButton.onclick = () => fetchData(currentPage - 1);
    paginationControls.appendChild(prevButton);

    // Page number buttons
    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.classList.toggle('active', i === currentPage);
        button.onclick = () => fetchData(i);
        paginationControls.appendChild(button);
    }

    // Next button
    const nextButton = document.createElement('button');
    nextButton.textContent = 'Next';
    nextButton.disabled = currentPage === totalPages;
    nextButton.onclick = () => fetchData(currentPage + 1);
    paginationControls.appendChild(nextButton);
}


    // Ftch data on page load
    fetchData();
</script>