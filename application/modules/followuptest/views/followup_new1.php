<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Follow up details of <?php echo $enqInfo['enq_cus_name']; ?> </h2>
                    &nbsp;
                    <?php if (check_permission('purchase', 'add')) { ?>
                        <a href="<?php echo site_url('purchase/create/' . encryptor($enqInfo['enq_id'])); ?>" class="btn btn-success"> <i class="fa fa-plus"></i> Purchase</a>
                    <?php } ?>

                    <?php if (check_permission($controller, 'setenquirypreference')) { ?>
                        <button type="button" class="prefrence btn btn-success" data-toggle="modal" data-target="#popPreferences">Preference</button>
                    <?php }
                    if (check_permission($controller, 'submitprocrmntreq')) { ?>
                        <button type="button" class="proc btn btn-success" data-toggle="modal" data-target="#procModal">Procurement Req.</button>
                    <?php }
                    if (check_permission('homevisit', 'hw_can_add_request')) { ?>
                        <button type="button" class="homeVisit btn btn-success" data-toggle="modal" data-target="#homeVisit">Home Visit</button>
                    <?php }
                    if (check_permission($controller, 'submittestdrive')) { ?>
                        <button type="button" class="testDrive btn btn-success" data-toggle="modal" data-target="#testDrive">Test Drive</button>
                    <?php } ?>

                    <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown" style="float: right;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a target="blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($enqInfo['enq_id'])); ?>">View
                                        tracking card</a></li>
                                <?php if ($this->usr_grp == 'SE' || $this->usr_grp == 'TC') {
                                    if ($enqInfo['enq_se_id'] == $this->uid) {
                                ?> <li><a target="blank" href="<?php echo site_url('enquiry/view_change/' . encryptor($enqInfo['enq_id'])); ?>">Edit
                                                enquiry</a></li>
                                    <?php
                                    }
                                } else { ?>
                                    <li><a target="blank" href="<?php echo site_url('enquiry/view_change/' . encryptor($enqInfo['enq_id'])); ?>">Edit
                                            enquiry.</a></li>
                                <?php }
                                if (check_permission($controller, 'setenquirypreference')) { ?>
                                    <li><a data-toggle="modal" data-target="#popPreferences" href="javascript:void(0);">Preference</a></li>
                                <?php }
                                if (check_permission($controller, 'submitprocrmntreq')) { ?>
                                    <li><a data-toggle="modal" data-target="#procModal" href="javascript:void(0);">Procurement Req.</a></li>
                                <?php }
                                if (check_permission('homevisit', 'hw_can_add_request')) { ?>
                                    <li><a data-toggle="modal" data-target="#homeVisit" href="javascript:void(0);">Home
                                            Visit</a></li>
                                <?php }
                                if (check_permission($controller, 'submittestdrive')) { ?>
                                    <li><a data-toggle="modal" data-target="#testDrive" href="javascript:void(0);">Test
                                            Drive</a></li>
                                <?php } ?>

                            </ul>
                        </li>
                    </ul>

                    <div class="clearfix" style="color: #fff;"><?php echo $enqInfo['enq_id']; ?></div>
                    <i>
                        <b>
                            <?php
                            echo isset($enqInfo['sts_title']) ? 'Current inquiry status : ' . $enqInfo['sts_des'] : '';
                            $type = unserialize(FOLLOW_UP_STATUS);

                            echo isset($type[$enqInfo['enq_cus_when_buy']]) ? ', Inquiry type : ' . $type[$enqInfo['enq_cus_when_buy']] : '';

                            $mods = unserialize(MODE_OF_CONTACT);
                            echo isset($mods[$enqInfo['enq_mode_enq']]) ? ', Mode of contact : ' . $mods[$enqInfo['enq_mode_enq']] : '';
                            ?>
                        </b>
                    </i>
                </div>

                <div id="ajx">
                    <!--  -->

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="float: left;">Customer feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body viewFollowUp"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnCloseModel" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btnSaveFollowUpFeedBack" data-url="<?php echo site_url('followup/editFollowUp'); ?>">Save changes</button>
                <!--btn-->
            </div>
        </div>
    </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.cmbFollStatus').change(function() {
            if ($(this).val() == 6) {
                $('.divBookingDetails').html($('.temVehicleAndPrice').html());
                //$('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
                $('.select2').select2();
                $('.divReason').html('');
                $('.divOtherReason').html('');
            } else if ($(this).val() == 4 || $(this).val() == 2) { //jsk
                $('.divReason').html($('.reason_for_lost_drop').html());
                $('.divBookingDetails').html('');
            } else {
                $('.divBookingDetails').html('');
                $('.divReason').html('');
                $('.divOtherReason').html('');
            }
        });
    });
</script>
<!-- jsk-->
<script type="text/template" class="reason_for_lost_drop">

    <div class="form-group">
     <div class="col-md-12 col-sm-6 col-xs-12">
     <select onchange="otherReason()" name="enh_reason_for_lost_drop" id="reason_for_lost_drop"
     class="select2_group form-control select2 cmbReason" required="required">
     <option value="">Select Reason</option>
     <?php
        foreach (unserialize(lostDrop) as $key => $value) {
            $veh = $value;
        ?>
            <option data-reason="<?php echo $key; ?>" 
            value="<?php echo $key; ?>"><?php echo $veh; ?></option>
       <?php } ?>
     </select>
     </div>
     </div>
</script>
<script type="text/template" class="otherReason">

    <div class="form-group">
     <div class="col-md-12 col-sm-6 col-xs-12">
     <input type="text" placeholder="Enter other Reason" required="required" name="enh_reason_for_lost_drop_other" 
     class="txtotherReason form-control col-md-7 col-xs-12 text-left"/>
     </div>
     </div>
</script><!-- @jsk-->
<script type="text/template" class="temVehicleAndPrice">

    <div class="form-group">
     <div class="col-md-12 col-sm-6 col-xs-12">
     <select onchange="$('.txtBookingAmt').val($('option:selected', this).attr('data-rdprice'));" name="enh_booked_vehicle"
     class="select2_group form-control select2" required="required">
     <option value="">Select vehicle</option>
     <?php
        foreach ((array) $stockVehicles as $key => $value) {
            $veh = $value['val_veh_no'] . ' (' . $value['brd_title'] . ', ' . $value['mod_title'] . ')';
        ?>
            <option data-rdprice="<?php echo $value['val_price_rd_to']; ?>" 
            value="<?php echo $value['val_id']; ?>"><?php echo $veh; ?></option>
       <?php } ?>
     </select>
     </div>
     </div>

     <div class="form-group">
     <div class="col-md-12 col-sm-6 col-xs-12">
     <input type="text" placeholder="Booking amount" required="required" name="enh_booking_amt" 
     class="txtBookingAmt form-control col-md-7 col-xs-12 text-left"/>
     </div>
     </div>

</script>
<script>
    function validateForm($this) {
        var text = $($this).getElementById('txtFollRemarks').value.trim();
        if (text.length < 10) {
            alert('Please enter atleast 30 characters in customer feedback');
            return false;
        } else {
            return true;
        }
    }
</script>

<div class="modal fade" id="popPreferences" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <?php echo form_open_multipart("followup/submit_preference", array('id' => "frmOfferPrice", 'class' => "submitPrefrnc modal-content form-horizontal form-label-left")) ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Preference &nbsp; <span style="cursor: pointer;" class="glyphicon glyphicon-plus Addbtn"></span> <span class="msg"></span></h4>
        </div>
        <div class="modal-body">
            <div class="mdl_div">
                <div class='fld'>
                    <div class="row">
                        <div class="col-md-3">
                            <i class=" prefix grey-text"></i>
                            <select data-placeholder="Preference" class="select2_groupj form-control cmbMultiSelectj prfSel">
                                <option selected>-Select-</option>
                                <?php
                                $preferences = unserialize(PREFERENCE_KEYS);
                                foreach ($preferences as $key => $value) {
                                ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="prf_fld_ajx"></div>
                        <input type="hidden" name="enq_id" value="<?php echo $enqInfo['enq_id']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
    </div>
</div>

<!-- Procurement model -->

<!-- @Procurement model -->

<!-- Home visit -->

<!-- @Home visit -->
<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <strong>Enq Status Updated successfully!</strong>
</div>

<div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <strong>Error:Could not be submitted successfully!</strong>
</div>
<style>
    .prefrence {
        position: absolute;
        margin-left: 407px;
        top: 10px;
    }

    .proc {
        position: absolute;
        margin-left: 507px;
        top: 10px;
    }

    .msg-alert {
        width: 42% !important;
        margin-bottom: 18px !important;
        position: absolute;
        margin-right: 224px !important;
    }

    .Rmvbtn {
        color: #e33e19 !important;
        font-size: 19px !important;
        line-height: 2;
    }

    .homeVisit {
        position: absolute;
        margin-left: 652px;
        top: 10px;
    }

    .testDrive {
        position: absolute;
        margin-left: 797px;
        top: 10px;
    }

    .lbl {
        color: black !Important;
    }

    .dialog {
        width: 746px !important;
        margin: 30px auto !important;
    }

    .bg-gray {
        background-color: #cacaca !important;
    }

    .brd-radi {
        border-radius: 0px !important;
        border-top-left-radius: 0px !important;
        border-top-right-radius: 0px !important;
        border-bottom-right-radius: 35px !important;
        border-bottom-left-radius: 35px !important;
    }

    .h-brd-radi {
        border-radius: 0px !important;
        border-top-left-radius: 35px !important;
        border-top-right-radius: 35px !important;
        border-bottom-right-radius: 0px !important;
        border-bottom-left-radius: 0px !important;

    }

    .modal-content {
        border: 7px solid rgba(0, 0, 0, .2) !important;
        border-radius: 42px !important;
    }

    .cus-fdbk-content {
        border: 7px solid rgb(205 204 199 / 26%) !important;
    }

    .modal-dialog.test_drive {

        width: 837px !important;

    }

    .radio-btn {
        border-radius: 50% !important;
        width: 25px !important;
        height: 25px !important;

        border: 2px solid lightskyblue !important;
        transition: 0.2s all linear !important;
        position: relative !important;
        top: 8px !important;
    }

    .slctwidth {
        width: 270px !important;
    }

    .multiselect {
        width: 269px !important;
    }
</style>

<script>
     $(document).ready(function() {
     $("#ajx").html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
     $.ajax({
          type: 'GET',
          url: site_url + "followuptest/get_followups_new/" + "<?php echo $enqInfo['enq_id']; ?>", 
          success: function(resp) {
               $("#ajx").html(resp);
          },
          error: function(xhr, status, error) {  // Error handling
               $("#ajx").html('<p>Error loading data</p>');
               console.error('Error:', error);
          }
     });
     });
     </script>
<script>
    $(document).ready(function() {
        <?php if ($enqInfo['enq_cus_when_buy'] == 1) { ?>
            $("#homeVisit").modal("show");
        <?php } ?>
        $(document).on('change', '.travel_mod', function() {
            $('.by_fleet').prop('selectedIndex', 0);
            $('.com_veh').prop('selectedIndex', 0);
            $('.stk_veh').prop('selectedIndex', 0);
            $('.reg').val('');
            $('.search-txt').val('');
            // search-txt
            // $('cmbStock')[1].sumo.reload();
            // $('stk_veh')[0].sumo.reload();
            //  $('.stk_veh')[0].sumo.unSelectAll();

            //reg
            if (this.value === '13') {
                $('.fleet_veh').show();
            } else {
                $('.fleet_veh').hide();
                $('.vehicle').hide();
            }

        });
        $(document).on('change', '.by_fleet', function() {
            if (this.value === '1') {
                $('.company_vehicle').show();
                $('.stock_vehicle').hide();
                $('.vehicle_no').hide();
            } else if (this.value === '2') {
                $('.company_vehicle').hide();
                $('.stock_vehicle').show();
                $('.vehicle_no').hide();
            } else if (this.value === '3') {
                $('.company_vehicle').hide();
                $('.stock_vehicle').hide();
                $('.vehicle_no').show();
            }

        });
        $('.BindDistirct').val(18).change();
    }); //@jsk

    function validateForm($this) {
        var text = $($this).getElementById('txtFollRemarks').value.trim();
        if (text.length < 10) {
            alert('Please enter atleast 30 characters in customer feedback');
            return false;
        } else {
            return true;
        }
    }
    //jsk
    var count = 0;
    $(document).on('click', '.Addbtn', function() {
        count = count + 1;
        $.ajax({
            type: 'get',
            "url": site_url + "followup/add_preference",
            data: {
                count: count
            },
            success: function(resp) {
                $(".fld").append(resp);
            }
        });
    });
    $(document).on('click', '.Rmvbtn', function() {
        $(".cls_" + $(this).data("id")).remove();
        $(this).parent('div').remove();
    });

    $('.prfSel').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        $.ajax({
            type: 'get',
            "url": site_url + "followup/append_pref_flds",
            data: {
                prefernce: valueSelected,
                count: 0
            },
            success: function(resp) {
                $(".prf_fld_ajx").html(resp);
            }
        });
    });
    //@jsk
</script>


    

    