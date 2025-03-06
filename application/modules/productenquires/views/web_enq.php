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
                    <h2>Web Enquiries</h2>
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
<?php if (check_permission('productenquires', 'quickassign_web_enq')) { ?>
<!-- assign -->
<div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel tile fixed_height_320" style="overflow: scroll;">
                                <div class="x_title">
                                    <h2>Assign to CRE</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dashboard-widget-content">
                                    <div class="x_content">
                                        <form class="frmQuickAssign"
                                            data-url="<?php echo site_url('productenquires/quickassign_web_enq'); ?>" method="get">
                                            <input type="hidden" name="searchValues"
                                                value='<?php echo !empty($_GET) ? serialize($_GET) : ''; ?>' />
                                            <input type="hidden" name="source" value="web_enquires" />
                                            <table>
                                                <tr>
                                                    <td style="padding-left: 10px;">
                                                        <!-- muliSelectCombo -->
                                                        <select multiple="multiple" style="float: left;width: auto;"
                                                            class="cmbMultiSelect select2_group form-control cmbSalesExecutives"
                                                            name="executive[]">
                                                            <?php
                                                            foreach ((array) $teleCallers as $key => $value) {
                                                                /*if (!empty($showroom)) {
                                                                                     if ($showroom == $value['usr_showroom']) {
                                                                                          ?>
                                                        <option value="<?php echo $value['col_id'];?>"
                                                            <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : '';?>>
                                                            <?php echo $value['col_title'];?></option>
                                                        <?php
                                                                                     }
                                                                                } else {*/
                                                            ?>
                                                                <option
                                                                    <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                                    value="<?php echo $value['col_id']; ?>">
                                                                    <?php echo $value['col_title']; ?></option>
                                                            <?php
                                                                /*}*/
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:10px;">
                                                        <?php
                                                        $enq_date_from_se = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                        $enq_date_to_se = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                        ?>
                                                        <textarea placeholder="Description" name="desc"
                                                            class="select2_group form-control"
                                                            required><?php echo $enq_date_from_se . $enq_date_to_se; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 10px;">
                                                        <button type="submit"
                                                            class="btn btn-round btn-primary">Assign</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- End assign -->
    <?php } ?>            
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const apiUrl = 'https://royaldrivesmart.in/api/rdms//website-enquiries';
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
               
                <td>${item.vehicleTitle}</td>
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