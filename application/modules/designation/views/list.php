<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Designation</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <a href="<?php echo site_url($controller . '/add'); ?>" class="btn btn-round btn-primary">
                            <i class="fa fa-pencil-square-o"></i> New designation
                        </a>
                    </div>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Own Cars Per Km</th>
                                <th>Own Two Wheeler per km</th>
                                <th>Breakfast</th>
                                <th>Lunch</th>
                                <th>Dinner</th>
                                <th>if above 15hrs</th>
                                <th>Room Tariff With in Kerala</th>
                                <th>Room Tariff Outside Kerala</th>
                                <!-- <th>Travel details</th> -->
                                <th>JD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                   if (!empty($data)) {
                                        foreach ($data as $key => $value) { ?>
                            <tr data-url="<?php echo site_url($controller . '/view/' . $value['desig_id']); ?>">
                                <td class="trVOE"><?php echo $value['desig_slug']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_title']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_own_cars_per_km']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_own_two_whelr_per_km']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_breakfast']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_lunch']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_dinner']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_abov_fiften_hrs']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_room_tariff_in_kl']; ?></td>
                                <td class="trVOE"><?php echo $value['desig_room_tariff_out_kl']; ?></td>
                                <!-- <td> -->
                                <?php /*$travelDetails = $this->designation->getDesignationTravelDetails($value['desig_id']); 
                                                       if($travelDetails) {
                                                       ?>
                                <i class="fa fa-globe" data-toggle="modal"
                                    data-target="#travelDetails<?php echo $value['desig_id']; ?>"></i>
                                <div class="modal fade" id="travelDetails<?php echo $value['desig_id']; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="float: left;" class="modal-title" id="exampleModalLabel">
                                                    Travel Details</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php 
                                                                                     if (!empty($travelDetails)) {
                                                                                     foreach ($travelDetails as $key => $value) {
                                                                                          ?>
                                                <div class="widget_summary" style="margin: 5px;">
                                                    <div class="w_left" style="width:60%;">
                                                        <span><i class="fa fa-automobile"></i>
                                                            <?php echo $value['tra_title']; ?></span>
                                                    </div>
                                                    <div style="font-size:13px;">
                                                        <span><?php echo $value['modes']; ?></span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <?php
                                                                                     }
                                                                                }
                                                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }*/ ?>
                                <!-- </td> -->
                                <td>
                                    <?php if(!empty($value['desig_jd'])) { ?>
                                    <a href="<?php echo 'https://rd-staff-jd.s3.ap-south-1.amazonaws.com/' . $value['desig_jd']; ?>"
                                        target="_blank">JD</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                                        }
                                   }
                                   ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>