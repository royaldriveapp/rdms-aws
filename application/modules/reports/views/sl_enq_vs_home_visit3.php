
<style>
		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 8px;
			text-align: center;
		}
	</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
  <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <!-- <div class="x_title">
                        <h2>Sales Enquires </h2>
                         <button class="btn btn-primary" onclick="exportToExcel()">Export to Excel</button>
                        <div class="clearfix"></div>
                    </div> -->
                    <div class="x_title">
                    <h2>Sales Enquires </h2>
                         <ul class="nav navbar-right panel_toolbox">
                                                                 <li style="float: right;">
                                                                 <button onclick="exportToExcel()">
    <img width="28" title="Export to excel" src="images/excel-export.png">
</button>


                                   </li>
                                                            
                                                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="overflow-x: auto;">
              
<!-- Table -->
<table id="myTable">
				<tr class="header-row">
					<th rowspan="2" style="background-color: #B9DDEB;">SM</th>
					<th rowspan="2" style="background-color: #B9DDEB;">ASM</th>
					<th rowspan="2" style="background-color: #B9DDEB;">Sales Consultant</th>
					<th rowspan="2" style="background-color: #CEC1DB;">Total Enq. Punched</th>
					<th colspan="2" style="background-color: #CEC1DB;">Enq.</th>
					<th colspan="4" style="background-color: #CEC1DB;">Present status of this month live enq.</th>
					<th rowspan="2" style="background-color: #545454; color : #ffffff;">Drop</th>
					<th rowspan="2" style="background-color: #545454; color : #ffffff;">Lost</th>
					<th rowspan="2" style="background-color: #CEC1DB;">Remarks ASM/SM for Hot & Hot Cases.etc</th>
                    <th colspan="8" style="background-color: #CEC1DB;">Home Visit Live.</th>
                    <th rowspan="2" style="background-color: #fad6b4;">Warm</th>
					<th rowspan="2" style="background-color: #fad6b4;">Cold</th>
                    <th rowspan="2" style="background-color: #fcffff;">Home visit done</th>
                    <th rowspan="2" style="background-color: #feff03;">Pending Register</th>
                    <th rowspan="2" style="background-color: #f5c113;">Missed followup</th>
                    <th rowspan="2" style="background-color: #34849b; color:#ffffff">Booked Enq</th>
				</tr>
				<tr class="sub-headerj">
					<th style="background-color: #CEC1DB;">RD</th>
					<th style="background-color: #CEC1DB;">Self</th>
					<th style="background-color: #CEC1DB;">HOT +</th>
					<th style="background-color: #CEC1DB;">HOT</th>
					<th style="background-color: #CEC1DB;">Warm</th>
					<th style="background-color: #CEC1DB;">Cold</th>
                    <th style="background-color: #9a4705; color: white;">Hot+</th>
<th style="background-color: #9a4705; color: white;">Achvd %</th>
<th style="background-color: #9a4705; color: white;">Achvd</th>
<th style="background-color: #9a4705; color: white;">HV Pending</th>
<th style="background-color: #1f487c; color: white;">Hot</th>
<th style="background-color: #1f487c; color: white;">Achvd %</th>
<th style="background-color: #1f487c; color: white;">Achvd</th>
<th style="background-color: #1f487c; color: white;">HV Pending</th>

				</tr>

				<?php
                   
				foreach ($infos as $info) {
					$is_empty_sales_consultant = true;
					$sales_managers = $info['sales_managers'];
					foreach ($sales_managers as $sales_manager_key => $sales_manager) {
						if (!empty($sales_manager->asm)) {
							foreach ($sales_manager->asm as $asm_key => $asm) {
								foreach ($asm->sales_consultants as $sales_consultant_key => $sales_consultant) {
									if (!empty($sales_consultant)) {
										$is_empty_sales_consultant = false;

				?>

										<tr>
											<?php
											if ($asm_key == 0 && $sales_consultant_key == 0) {
												echo '<td rowspan="' . $sales_manager->total_sales_consultants . '">' . $sales_manager->usr_username . '</td>';
											}
											if ($sales_consultant_key == 0) {
												echo '<td rowspan="' . count($asm->sales_consultants) . '">' . $asm->usr_username . '</td>';
											}
											?>
											<td> <?= $sales_consultant->usr_username ?></td>
											<td style="background-color: #E2E0ED;"><?= $sales_consultant->enquiry_count ?: '' ?></td>
											<td style="background-color: #E2E0ED;"><?= $sales_consultant->enquiry_company_count ?: '' ?></td>
											<td style="background-color: #E2E0ED;"><?= $sales_consultant->enquiry_self_count ?: '' ?></td>
											<td style="background-color: #E2E0ED;"><?= $sales_consultant->enquiry_status_hot_plus ?: '' ?></td>
											<td style="background-color: #E2E0ED;"><?= $sales_consultant->enquiry_status_hot ?: '' ?></td>
											<td style="background-color: #E2E0ED;"><?= $sales_consultant->enquiry_status_warm ?: '' ?></td>
											<td style="background-color: #E2E0ED;"><?= $sales_consultant->enquiry_status_cold ?: '' ?></td>
											<td style="background-color: #545454; color : #ffffff;"><?= $sales_consultant->enquiry_status_drop ?: '' ?></td>
											<td style="background-color: #545454; color : #ffffff;"><?= $sales_consultant->enquiry_status_lost ?: '' ?></td>
											<td></td>
                                            <td><?= $sales_consultant->enquiry_status_hot_plus ?: '' ?></td>
                                            <td><?= findPercentage($sales_consultant->home_visit_hot_plus_count,0,$sales_consultant->enquiry_status_hot_plus)?></td>
                                            <td><?= $sales_consultant->home_visit_hot_plus_count ?: '' ?></td>
                                            <td><?= $sales_consultant->enquiry_status_hot_plus-$sales_consultant->home_visit_hot_plus_count ?: '' ?></td>

                                            <td><?= $sales_consultant->enquiry_status_hot ?: '' ?></td>
                                            <td><?= findPercentage($sales_consultant->home_visit_hot_count,0,$sales_consultant->enquiry_status_hot)?></td>
                                            <td><?= $sales_consultant->home_visit_hot_count ?: '' ?></td>
                                            <td><?= $sales_consultant->enquiry_status_hot-$sales_consultant->home_visit_hot_count ?: '' ?></td>
                                            <td><?= $sales_consultant->home_visit_warm_count ?: '' ?></td>
                                            <td><?= $sales_consultant->home_visit_cold_count ?: '' ?></td>
                                            <td><?= $sales_consultant->home_visit_hot_plus_count+$sales_consultant->home_visit_hot_count+$sales_consultant->home_visit_warm_count+$sales_consultant->home_visit_cold_count ?: '' ?></td>

                                            <td  style="background-color: #feff03;"><?= $sales_consultant->pending_reg ?: '' ?></td>
                                            <td  style="background-color: #f5c113;"><?= $sales_consultant->missed_followup_count ?: '' ?></td> 
                                            <td  style="background-color: #34849b; color:#ffffff"><?= $sales_consultant->booking_enq ?: '' ?></td>
										</tr>
									<?php
									} else {
									?>
										<tr>
											<?php
											if ($asm_key == 0 && $sales_consultant_key == 0) {
												echo '<td rowspan="' . $sales_manager->total_sales_consultants . '">' . $sales_manager->usr_username . '</td>';
											}
											if ($sales_consultant_key == 0) {
												echo '<td rowspan="' . count($asm->sales_consultants) . '">' . $asm->usr_username . '</td>';
											}
											?>
											<td></td>
											<td style="background-color: #E2E0ED;"></td>
											<td style="background-color: #E2E0ED;"></td>
											<td style="background-color: #E2E0ED;"></td>
											<td style="background-color: #E2E0ED;"></td>
											<td style="background-color: #E2E0ED;"></td>
											<td style="background-color: #E2E0ED;"></td>
											<td style="background-color: #E2E0ED;"></td>
											<td style="background-color: #545454; color : #ffffff;"></td>
											<td style="background-color: #545454; color : #ffffff;"></td>
											<td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="background-color: #feff03;"></td>
                                            <td  style="background-color: #f5c113;"></td>
                                            <td style="background-color: #34849b; color:#ffffff"></td>

										</tr>
				<?php
									}
								}
							}
						}
					}

					//showroom
					if ($is_empty_sales_consultant == false) {
						echo '<tr class="total-row">
                <td colspan="3" style="background-color: #E0D8C3;">' . $info['name'] . '</td>
                <td style="background-color: #E2E0ED;">' . ($info['enquiry_count'] ?: '') . '</td>
                <td style="background-color: #E2E0ED;">' . ($info['enquiry_company_count'] ?: '') . '</td>
                <td style="background-color: #E2E0ED;">' . ($info['enquiry_self_count'] ?: '') . '</td>
                <td style="background-color: #E2E0ED;">' . ($info['enquiry_status_hot_plus'] ?: '') . '</td>
                <td style="background-color: #E2E0ED;">' . ($info['enquiry_status_hot'] ?: '') . '</td>
                <td style="background-color: #E2E0ED;">' . ($info['enquiry_status_warm'] ?: '') . '</td>
                <td style="background-color: #E2E0ED;">' . ($info['enquiry_status_cold'] ?: '') . '</td>
                <td style="background-color: #545454; color : #ffffff;">' . ($info['enquiry_status_drop'] ?: '') . '</td>
                <td style="background-color: #545454; color : #ffffff;">' . ($info['enquiry_status_lost'] ?: '') . '</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="background-color: #feff03;"></td>
                <td  style="background-color: #f5c113;"></td>
                <td  style="background-color: #34849b; color:#ffffff"></td>
                </tr>';
					}
				}

				echo '<tr class="total-row">
        <td colspan="3" style="background-color: #E0D8C3;">Group</td>
        <td style="background-color: #E2E0ED;">' . ($total_count_info['enquiry_count'] ?: '') . ' </td>
        <td style="background-color: #E2E0ED;">' . ($total_count_info['enquiry_company_count'] ?: '') . '</td>
        <td style="background-color: #E2E0ED;">' . ($total_count_info['enquiry_self_count'] ?: '') . '</td>
        <td style="background-color: #E2E0ED;">' . ($total_count_info['enquiry_status_hot_plus'] ?: '') . '</td>
        <td style="background-color: #E2E0ED;">' . ($total_count_info['enquiry_status_hot'] ?: '') . '</td>
        <td style="background-color: #E2E0ED;">' . ($total_count_info['enquiry_status_warm'] ?: '') . '</td>
        <td style="background-color: #E2E0ED;">' . ($total_count_info['enquiry_status_cold'] ?: '') . '</td>
        <td style="background-color: #545454; color : #ffffff;">' . ($total_count_info['enquiry_status_drop'] ?: '') . '</td>
        <td style="background-color: #545454; color : #ffffff;">' . ($total_count_info['enquiry_status_lost'] ?: '') . '</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>df</td>
        <td></td>
        <td></td>
        <td></td>
        <td>df</td>
        <td>df</td>
        <td></td>
        <td></td>
        <td style="background-color: #feff03;"></td>
        <td  style="background-color: #f5c113;"></td>
        <td  style="background-color: #34849b; color:#ffffff"></td>
        
        
        </tr>';

				?>


			</table>
<!-- End table -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
                function exportToExcel() {
    var table = document.getElementById("myTable");
    if (!table) {
        console.error("Table not found");
        return;
    }

    var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
    var sheet = wb.Sheets[wb.SheetNames[0]];
    var range = XLSX.utils.decode_range(sheet['!ref']);

    setTimeout(function() {
        for (var rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
            for (var colNum = range.s.c; colNum <= range.e.c; colNum++) {
                try {
                    var cellAddress = XLSX.utils.encode_cell({r: rowNum, c: colNum});
                    var cell = sheet[cellAddress];
                    if (!cell) continue;

                    var cellElement = table.rows[rowNum].cells[colNum];
                    var style = window.getComputedStyle(cellElement);
                    cell.s = {
                        fill: {
                            fgColor: {rgb: style.backgroundColor}
                        }
                    };
                } catch (error) {
                    console.error("Error processing cell:", error);
                }
            }
        }

        XLSX.writeFile(wb, 'exported_data.xlsx');
    }, 0);
}

                    </script>
