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
                    <h2>Re-Assign Report</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <button onclick="exportToExcel()">
                                <img width="28" title="Export to excel" src="images/excel-export.png">
                            </button>


                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                         <form action="<?php echo site_url('reports/re_assign_report/');?>" method="get">
                              <table style='border:none;'>
                                   <td style='border:none;'>
                                        <input autocomplete="off" name="date" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date"/>
                                   </td>
                                
                              
                                 
                                  
                                   <td style="padding-left: 10px;border:none;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                              </table>
                         </form>
                    </div>

<div id="ajx">

</div>


<script>
           $(document).ready(function () {
init_datetime();

function loadAjaxContent() {
            var dateValue = $('.dtpEnquiry').val();
            $("#ajx").html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> </center>');
            $.ajax({
                type: 'get',
                url: site_url + "reports/re_assign_report_ajx",
                data: { date: dateValue }, 
                success: function(resp) {
                    $("#ajx").html(resp);
                }
            });
        }

        // Load AJAX content on page load
        loadAjaxContent();

        $('form').submit(function(event) {
            event.preventDefault(); 
            loadAjaxContent(); 
        });

});



</script> 
