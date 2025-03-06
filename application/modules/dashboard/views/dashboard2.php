<div class="right_col" role="main">
    <?php if ($this->usr_grp != 'SEO') { ?>

    <!-- top tiles -->
    <div class="row tile_count">
        <?php if (isset($enquiresAnalysis['active_enquires'])) { ?>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Enquires</span>
            <div class="count"><?php echo number_format($enquiresAnalysis['active_enquires']); ?></div>
        </div>
        <?php }
               if (isset($enquiresAnalysis['dropped_vehicles'])) { ?>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-trash"></i> Dropped Vehicles</span>
            <div class="count"><?php echo number_format($enquiresAnalysis['dropped_vehicles']); ?></div>
        </div>
        <?php }
               /*if (isset($enquiresAnalysis['deleted_vehicles'])) { ?>
        <!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                         <span class="count_top"><i class="fa fa-close"></i> Deleted Vehicles</span>
                         <div class="count purple"><?php //echo number_format($enquiresAnalysis['deleted_vehicles']); 
                                                       ?></div>
                    </div> -->
        <?php }*/
               if (isset($enquiresAnalysis['soled_vehicles'])) { ?>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-car"></i> Sold Vehicles</span>
            <div class="count green"><?php echo number_format($enquiresAnalysis['soled_vehicles']); ?></div>
        </div>
        <?php }
               if (isset($enquiresAnalysis['stock_vehicle'])) { ?>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-bus"></i> Stock Vehicles</span>
            <div class="count">
                <a
                    href="<?php echo check_permission('evaluation', 'stock') ? site_url('evaluation/stock') : 'jayavascript:void(0);'; ?>">
                    <?php echo number_format($enquiresAnalysis['stock_vehicle']); ?>
                </a>
            </div>
        </div>
        <?php }
               if (isset($enquiresAnalysis['total_assigned'])) { ?>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Assigned Enquires</span>
            <div class="count"><?php echo number_format($enquiresAnalysis['total_assigned']); ?></div>
        </div>
        <?php } ?>
    </div>

    <div id="ajx">

    </div>


    <?php } ?>
</div>
<!-- /page content -->

<script>
$(document).ready(function() { // alert(313);
    $("#ajx").html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> </center>');
    init_chart_doughnut();
    $.ajax({
        type: 'get',
        "url": site_url + "dashboard/load_data",
        success: function(resp) {
            $("#ajx").html(resp);
        }
    });
});
</script>