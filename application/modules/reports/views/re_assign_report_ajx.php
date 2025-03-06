
                <div class="x_content" style="overflow-x: auto;">

<!-- Table -->
<table id="myTable">
    <tr class="header-row">
        <th rowspan="2" style="background-color: #B9DDEB;">SM</th>
        <th rowspan="2" style="background-color: #B9DDEB;">ASM</th>
        <th rowspan="2" style="background-color: #B9DDEB;">FTD</th>
        <th rowspan="2" style="background-color: #B9DDEB;">MTD</th>
        <th rowspan="2" style="background-color: #B9DDEB;">Sales Consultant</th>
        <th rowspan="2" style="background-color: #CEC1DB;">FTD</th>

        <th rowspan="2" style="background-color: #CEC1DB;">MTD</th>


    </tr>
    <tr class="sub-headerj">


    </tr>

    <?php
    $asmTodayTotal = [];
    $asmThisMonthTotal=[];

    foreach ($infos as $info) {
        $is_empty_sales_consultant = true;
        $sales_managers = $info['sales_managers'];
        foreach ($sales_managers as $sales_manager_key => $sales_manager) {
            if (!empty($sales_manager->asm)) {
                foreach ($sales_manager->asm as $asm_key => $asm) {
                    $asmData = $this->reports->getAsmData($asm->usr_id,$date);
                   $asmTodayTotal[$info['name']] += $asmData->TodayCountAsm;
                   $asmTodayGrandTotal +=  $asmData->TodayCountAsm;

                   $asmThisMonthTotal[$info['name']] += $asmData->ThisMonthCountAsm;
                   $asmThisMonthGrandTotal +=  $asmData->ThisMonthCountAsm;
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
                                    
                                    echo '<td rowspan="' . count($asm->sales_consultants) . '">' . $asm->usr_username . '
                           
                            </td>';

                                    echo '<td rowspan="' . count($asm->sales_consultants) . '">' . ($asmData->TodayCountAsm ?: 0) . '
                           
                            </td>';

                                    echo '<td rowspan="' . count($asm->sales_consultants) . '">' . ($asmData->ThisMonthCountAsm ?: 0) . '
                           
                            </td>';
                                }

                                ?>
                                <!-- $sales_consultant->usr_id -->
                                <!-- $sales_consultant->addedBy -->
                                <td> <?= $sales_consultant->usr_username ?> </td>
                                <td style="background-color: #E2E0ED;"> <a href="<?php echo site_url('reports/re_assign_ftd/' . $sales_consultant->usr_id); ?>"> <?= $sales_consultant->today_count ?: '' ?> </a> </td>



                                <td><a href="<?php echo site_url('reports/re_assign_mtd/' . $sales_consultant->usr_id); ?>"> <?= $sales_consultant->this_month_count ?: '' ?> </a></td>


                                <?php
                                $hot_plus_hmv_pending = 0;
                                $hot_hmv_pending = 0;
                                $hot_plus_hmv_pending = $total_count_info['home_visit_hot_plus_count'] - $total_count_info['home_visit_hot_plus_achieved_count'];
                                $hot_hmv_pending = $total_count_info['home_visit_hot_count'] - $total_count_info['home_visit_hot_achieved_count'];
                                ?>
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
                        
                                    echo '<td rowspan="' . count($asm->sales_consultants) . '">' . $asm->usr_username . '
                           
                            </td>';

                                    echo '<td rowspan="' . count($asm->sales_consultants) . '">' . ($asmData->TodayCountAsm ?: 0) . '
                           
                            </td>';

                                    echo '<td rowspan="' . count($asm->sales_consultants) . '">' . ($asmData->ThisMonthCountAsm ?: 0) . '
                           
                            </td>';
                                }

                                ?>

                                <td></td>

                                <td style="background-color: #E2E0ED;"></td>


                                <td></td>




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
<td colspan="2" style="background-color: #E0D8C3;">' . $info['name'] . '</td>
<td style="background-color: #E2E0ED;">' . ( $asmTodayTotal[$info['name']] ?: '') . '</td>
<td style="background-color: #E2E0ED;">' . ( $asmThisMonthTotal[$info['name']] ?: '') . '</td>
<td style="background-color: #E2E0ED;"> </td>

<td style="background-color: #E2E0ED;"> ' . ($info['today_count'] ?: '') . '</td>



<td style="background-color: #E2E0ED;"> ' . ($info['this_month_count'] ?: '') . '</td>





</tr>';
        }
    }

    echo '<tr class="total-row">
<td colspan="2" style="background-color: #E0D8C3;">Total</td>
<td style="background-color: #E2E0ED;"> ' . ($asmTodayGrandTotal ?: '') . '</td>
<td style="background-color: #E2E0ED;"> ' . ($asmThisMonthGrandTotal ?: '') . '</td>
<td style="background-color: #E2E0ED;"></td>
<td style="background-color: #E2E0ED;"> ' . ($total_count_info['today_count'] ?: '') . ' </td>



<td style="background-color: #E2E0ED;"> ' . ($total_count_info['this_month_count'] ?: '') . ' </td>





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

var wb = XLSX.utils.table_to_book(table, {
sheet: "Sheet1"
});
var sheet = wb.Sheets[wb.SheetNames[0]];
var range = XLSX.utils.decode_range(sheet['!ref']);

setTimeout(function() {
for (var rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
for (var colNum = range.s.c; colNum <= range.e.c; colNum++) {
try {
    var cellAddress = XLSX.utils.encode_cell({
        r: rowNum,
        c: colNum
    });
    var cell = sheet[cellAddress];
    if (!cell) continue;

    var cellElement = table.rows[rowNum].cells[colNum];
    var style = window.getComputedStyle(cellElement);
    cell.s = {
        fill: {
            fgColor: {
                rgb: style.backgroundColor
            }
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