<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Google Review Report</title>
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
</head>
<body>
<?php $today = date('d-m-Y'); ?>

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Google Review Report</h2>
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
                    <form action="<?php echo site_url('reports/re_assign_report/'); ?>" method="get">
                        <table style='border:none;'>
                            <tr>
                                <td style='border:none;'>
                                    <input autocomplete="off" name="date" type="text" value="<?php echo $today; ?>" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Date"/>
                                </td>
                                <td style="padding-left: 10px; border:none;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="ajx"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        init_datetime();

        function loadAjaxContent() {
            var dateValue = $('.dtpEnquiry').val(); 
            $("#ajx").html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> </center>');
            $.ajax({
                type: 'get',
                url: site_url + "google_reviews/google_rw_ajx",
                data: { date: dateValue }, 
                success: function(resp) {
                    var result = JSON.parse(resp);
                    $("#ajx").html(result.html);
                },
                error: function(error) {
                    console.error("Error fetching data", error);
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

    var img_url = '<?php echo base_url('assets/images/loading.gif'); ?>';

    function showEdit(editableObj) {
        $(editableObj).css("background", "#dbfc03");
    }

    function saveRating(editableObj, shrm, date) {
        var rating = parseFloat(editableObj.innerHTML);
        $(editableObj).css("background", "#FFF url(https://www.rdms.royaldrive.in/assets/images/loaderIcon.gif) no-repeat center right 5px");
        $.ajax({
            url: site_url + "google_reviews/store_google_rating",
            type: "POST",
            data: { 'shrm': shrm, 'rating': rating, 'date': date },
            success: function (data) {
                $(editableObj).css("background", "#42f57e");
            },
            error: function (error) {
                $(editableObj).css("background", "#f54242");
            }
        });
    }    function saveTodaysRwCount(editableObj, shrm, date) {//reiews count
        var rwCount = parseFloat(editableObj.innerHTML);
        $(editableObj).css("background", "#FFF url(https://www.rdms.royaldrive.in/assets/images/loaderIcon.gif) no-repeat center right 5px");
        $.ajax({
            url: site_url + "google_reviews/store_todays_rw_count",
            type: "POST",
            data: { 'shrm': shrm, 'rwCount': rwCount, 'date': date },
            success: function (data) {
                $(editableObj).css("background", "#42f57e");
            },
            error: function (error) {
                $(editableObj).css("background", "#f54242");
            }
        });
    }
    function saveTodaysNoOfRwsWithPhoto(editableObj, shrm, date) {
        var rwCount = parseFloat(editableObj.innerHTML);
        $(editableObj).css("background", "#FFF url(https://www.rdms.royaldrive.in/assets/images/loaderIcon.gif) no-repeat center right 5px");
        $.ajax({
            url: site_url + "google_reviews/store_todays_rws_with_photo",
            type: "POST",
            data: { 'shrm': shrm, 'rwCount': rwCount, 'date': date },
            success: function (data) {
                $(editableObj).css("background", "#42f57e");
            },
            error: function (error) {
                $(editableObj).css("background", "#f54242");
            }
        });
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
</body>
</html>
