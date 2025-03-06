<style>
.multiselect {
    width: 310px !important;
}

.vehDetailsBuy {
    background-color: #c76a285e;
    border: 4px dotted #fffffff2;
}

th {
    color: black !important;
}

tr {
    color: black !important;
}

/*     .tb1{
         border: 7px dotted #8b7d7f73!important;
     box-shadow: inset -1px -7px 20px 5px #605b5b, inset 9px 10px 47px -16px #3a68be;
          }*/
.tb1 {
    border: 6px solid#a7baa7 !important;
    /* box-shadow: inset -1px -7px 20px 5px #605b5b, inset 9px 10px 47px -16px #3a68be52; */
}

.top-tb {
    border: 7px dotted #8b7d7f73 !important;
}

.bg-clr {
    background-color: #414141d4 !important;

    border: 1px solid #7a808b !important;
    padding: 20px !important;
    box-shadow: 14px 1px 14px 3px #6f81a8f5 !important;
}

labelk {
    color: white !important;
}

.lbl-blk {
    color: black !important;
}

.tb-man,
th {
    color: white !important;
}

.tbl-blk {
    background-color: #98cdd9;
    border: 3px dotted #fffffff2;
}

.tbl-pitch {
    background-color: #474a56;
    border: 4px dotted #fffffff2;
}

.SumoSelect {
    display: inline-block !important;
    position: relative !important;
    outline: 0 !important;
    color: #57705a !important;
}

.x_panel {
    width: 100% !important;
    padding: 10px 7px !important;
    display: inline-block !important;
    background: #a9aaac42 !important;
    border: 7px dotted #fffffff2 !important;
    -webkit-column-break-inside: avoid !important;
    -moz-column-break-inside: avoid !important;
    column-break-inside: avoid !important;
    opacity: 1;
    transition: all .2s ease !important;
}

.form-control-enq {
    display: block;
    width: 100% !important;
    height: 34px !important;
    padding: 6px 12px !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
    color: #f7f7f7;
    background-color: #7f80998a !important;
    background-image: none !important;
    border: 1px dotted #191b24 !important;
    border-radius: 4px !important;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: 1px 1px 0px 12px rgb(138 146 149 / 15%);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color cubic-bezier(0.76, -0.21, 0.58, -0.23) .15s, box-shadow ease-in-out .15s;
}

.bg-clr {
    background-color: #ddcfcf00 !important;
    border: 1px solid #dfe1e6 !important;
    padding: 20px !important;
    box-shadow: 14px 1px 14px 3px #6f81a8f5 !important;
}

.lbl {
    color: #1c1a1a !important;
    font-family: ui-monospace !important;
}

.tb-man {
    color: #222020 !important;
}

#flex {
    height: 2% !important;
}

<!--text area size enq_cus_remarks-->
select.decorated option:hover {
    box-shadow: 0 0 10px 100px #1882A8 inset !important;
}

.SumoSelect {
    display: inline-block !important;
    position: relative !important;
    outline: 0 !important;
    color: #ffffff !important;

    /*     color: #f7f7f7;*/
    background-color: #7f80998a !important;
    background-image: none !important;
    border: 1px dotted #191b24 !important;
    border-radius: 4px !important;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: 1px 1px 0px 12px rgb(138 146 149 / 15%);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color cubic-bezier(0.76, -0.21, 0.58, -0.23) .15s, box-shadow ease-in-out .15s;
}

.SumoSelect>.CaptionCont {
    position: relative !important;
    border: 1px solid #A4A4A4 !important;
    min-height: 14px !important;
    background-color: #adadbc !important;
    border-radius: 2px !important;
    margin: 0 !important;
}

.SumoSelect>.optWrapper {
    color: black !important;
}

select option:hover,
select option:focus,
select option:active {
    background: linear-gradient(#000000, #000000);
    background-color: #000000 !important;
    /* for IE */
    color: #ffed00 !important;
}

select option:checked {
    background: linear-gradient(#d6d6d6, #d6d6d6);
    background-color: #d6d6d6 !important;
    /* for IE */
    color: #000000 !important;
}

select:hover {

    background-color: #000 !important;

}

input:read-only {
    background-color: #bfbfbff2 !important;
    color: black !important;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>New enquiry </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                           $kms = get_km_ranges();
                           $price_ranges = get_price_ranges();
                           $vehicleColors = getVehicleColors();
                           $questions = array_map('array_filter', $questions);
                           $questions = array_filter($questions);
                           $defRegAnswer[5] = isset($datas['vreg_existing_vehicle']) ? $datas['vreg_existing_vehicle'] : '';
                         ?>
                    <!-- Smart Wizard -->
                    <!--<p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>-->
                    <form id="wizard" data-url="<?php echo site_url('enquiry_1/punchEnquiry');?>"
                        class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator"
                        method="post" accept-charset="utf-8">
                        <input type="hidden" value="<?php echo isset($datas['vreg_id']) ? $datas['vreg_id'] : '';?>"
                            name="vreg_id" />
                        <input type="hidden"
                            value="<?php echo isset($datas['vreg_assigned_to']) ? $datas['vreg_assigned_to'] : '';?>"
                            name="vreg_assigned_to" />
                        <ul class="wizard_steps">
                            <li>
                                <a href="#step-1">
                                    <span class="step_no">1</span>
                                    <span class="step_descr">
                                        Step 1<br />
                                        <small>Customer enquiry</small>
                                    </span>
                                </a>
                            </li>
                            <?php if (!empty($questions)) {?>
                            <li>
                                <a href="#step-2">
                                    <span class="step_no">2</span>
                                    <span class="step_descr">
                                        Step 2<br />
                                        <small>Inquiry Questions</small>
                                    </span>
                                </a>
                            </li>
                            <?php }?>
                            <li>
                                <a href="#step-3">
                                    <span class="step_no">3</span>
                                    <span class="step_descr">
                                        Step 3<br />
                                        <small>Vehicle details</small>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-4">
                                    <span class="step_no">4</span>
                                    <span class="step_descr">
                                        Step 4<br />
                                        <small>Mode of payment</small>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-5">
                                    <span class="step_no">5</span>
                                    <span class="step_descr">
                                        Step 5<br />
                                        <small>Followup</small>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div id="step-1">


                            <div class="form-horizontal form-label-left">



                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="tb1">
                                        <div class="row bg-clr top-tb">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl"
                                                        for="first-name">Customer Grade<span
                                                            class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="true"
                                                            class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_customer_grade]">
                                                            <option value="">Customer grade</option>
                                                            <?php foreach ($customerGrades as $key => $value) {?>
                                                            <option value="<?php echo $value['sgrd_id'];?>">
                                                                <?php echo $value['sgrd_grade'];?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_status"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Type<span
                                                            class="required">*</span></label>
                                                    <?php //print_r($datas['vreg_department'])?>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="true"
                                                            class="select2_group form-control cmbEnqStatus form-control-enq"
                                                            name="enquiry[enq_cus_status]">
                                                            <option value="">-Select-</option>
                                                            <option
                                                                <?php echo $datas['vreg_department'] == 4 ? 'selected="selected"' : '';?>
                                                                value="1">Sales</option>
                                                            <option
                                                                <?php echo $datas['vreg_department'] == 7 ? 'selected="selected"' : '';?>
                                                                value="2">Purchase</option>
                                                            <option value="3">Exchange</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--                                                            <div class="form-group">
                                                                 <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Lead status<span class="required">*</span></label>
                                                                 <?php $leadStatus= unserialize(LEAD_STATUS)?>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <select required="true" class="select2_group form-control cmbEnqStatus form-control-enq" name="enquiry[enq_lead_status]">
                                                                           <option value="">-Select-</option>
                                                                           <?php foreach ($leadStatus as $key => $value) {
                                                                                                           
                                                                                                    ?>
                                                              <option  value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                           <?php } ?>
                                                                          
                                                                      </select>
                                                                 </div>
                                                            </div>-->
                                                <?php
                                                              if (check_permission('enquiry', 'assignenquires') && !empty($salesExe)) {
                                                                   ?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl"
                                                        for="first-name">Sales Executive
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="true"
                                                            class="select2_group form-control enq_se_id cmbSearchList form-control-enq"
                                                            name="enquiry[enq_se_id]">
                                                            <option value="">Assign to sales executive</option>
                                                            <?php foreach ($salesExe as $key => $value) {?>
                                                            <option
                                                                <?php echo (isset($datas['vreg_assigned_to']) == $value['usr_id']) ? 'selected="selected"' : '';?>
                                                                value="<?php echo $value['usr_id'];?>">
                                                                <?php echo $value['usr_first_name'];?></option>
                                                            <?php }
                                                                                       ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php
                                                              }
                                                            ?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl"
                                                        for="enq_cus_name"> Enquiry Date
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input name="enquiry[enq_entry_date]" type="text"
                                                            class="dtpEnquiry form-control col-md-7 col-xs-12 form-control-enq"
                                                            required="true" value="<?php echo date('d-m-Y');?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl"
                                                        for="enq_cus_name">Name
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input
                                                            value="<?php echo isset($datas['vreg_cust_name']) ? $datas['vreg_cust_name'] : '';?>"
                                                            name="enquiry[enq_cus_name]" type="text" id="enq_cus_name"
                                                            class="form-control form-control-enq col-md-7 col-xs-12 enq_cus_name"
                                                            required="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="enq_cus_address"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Address<span
                                                            class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required="true" id="enq_cus_address"
                                                            value="<?php echo $datas['vreg_address'];?>"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="enquiry[enq_cus_address]">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_ofc_address"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Address(Office)
                                                        <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required="true" id="enq_cus_ofc_address" value=""
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="enquiry[enq_cus_ofc_address]">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="enq_cus_mobile"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Mobile
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input
                                                            value="<?php echo isset($datas['vreg_cust_phone']) ? $datas['vreg_cust_phone'] : '';?>"
                                                            id="enq_cus_mobile"
                                                            class="form-control form-control-enq col-md-7 col-xs-12 numOnly enq_cus_mobile"
                                                            type="text" name="enquiry[enq_cus_mobile]">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_mobile"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Office No
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 lbl">
                                                        <input
                                                            value="<?php echo isset($datas['enq_cus_office_no']) ? $datas['enq_cus_office_no'] : '';?>"
                                                            id="enq_cus_office_no"
                                                            class="form-control form-control-enq col-md-7 col-xs-12 numOnly enq_cus_office_no"
                                                            type="text" name="enquiry[enq_cus_office_no]">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="enq_cus_city"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Place<span
                                                            class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input
                                                            value="<?php echo isset($datas['vreg_cust_place']) ? $datas['vreg_cust_place'] : '';?>"
                                                            id="enq_cus_city"
                                                            class="autoComCity form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="enquiry[enq_cus_city]">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="enq_cus_email"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Email</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="enq_cus_email"
                                                            class="form-control form-control-enq col-md-7 col-xs-12 emailOnly"
                                                            type="text" name="enquiry[enq_cus_email]">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_whatsapp"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Whatsapp</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="enq_cus_whatsapp"
                                                            class="form-control form-control-enq col-md-7 col-xs-12 numOnly enq_cus_whatsapp"
                                                            type="text" name="enquiry[enq_cus_whatsapp]">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_fbid"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Customer
                                                        FB Id</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="enq_cus_fbid"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="enquiry[enq_cus_fbid]">
                                                    </div>
                                                </div>

                                                <!--                                                            <div class="form-group">
                                                                 <label for="enq_cus_age" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Age</label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <input  class="form-control form-control-enq col-md-7 col-xs-12 numOnly" type="text" name="enquiry[enq_cus_age]">
                                                                 </div>
                                                            </div>-->
                                                <div class="form-group">
                                                    <label for="enq_cus_age_group"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Age
                                                        group</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_cus_age_group]">
                                                            <option value="20-30">20-30</option>
                                                            <option value="30-40">30-40</option>
                                                            <option value="40-50">40-50</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_gender"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Gender</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_cus_gender]">
                                                            <option value="">- Select-</option>
                                                            <?php foreach (unserialize(GENDER) as $key => $value) {?>
                                                            <option value="<?php echo $key;?>"><?php echo $value;?>
                                                            </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--                                             <div class="form-group">
                                                                                                              <label for="enq_cus_occu" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                                                                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                   <input id="enq_cus_occu" value="<?php echo isset($datas['vreg_occupation']);?>" class="autoComOccupation form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_occu]">
                                                                                                              </div>
                                                                                                         </div>-->


                                            </div><!-- @col1 -->
                                            <div class="col-md-6">

                                                <div class="form-group"><?php // print_r($Profession); ?>
                                                    <label for="enq_cus_age_group"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Profession</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_cus_occu]">
                                                            <option value="">-Select-</option>
                                                            <?php foreach ((array) $Profession as $value) {?>
                                                            <option value="<?php echo $value['occ_id'];?>">
                                                                <?php echo $value['occ_name'];?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_age_group"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Category</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_cus_occu_category]">
                                                            <option value="">-Select-</option>
                                                            <?php foreach ((array) $Profession_cat as $value) {?>
                                                            <option value="<?php echo $value['occ_cat_id'];?>">
                                                                <?php echo $value['occ_cat_name'];?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="enq_cus_company"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Company</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="enq_cus_company"
                                                            value="<?php echo $datas['vreg_company'];?>"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="enquiry[enq_cus_company]">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_phone_res"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Resi
                                                        phone</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="enq_cus_phone_res"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="enquiry[enq_cus_phone_res]">
                                                    </div>
                                                </div>
                                                <!--                                                            <div class="form-group">
                                                                                                                             <label for="enq_cus_state" class="control-label col-md-3 col-sm-3 col-xs-12 lbl"><span class="required">*</span>Country</label>
                                                                                                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                  <select required data-placeholder="Select Country" name="enquiry[enq_cus_country]" id="country" class="BindState jselect2_group form-control cmbMultiSelect" data-url="<?php echo site_url('enquiry_1/bindState');?>" >
                                                            <?php //foreach ($countries as $country) {?>
                                                                                                                                                            <option <?php //echo $country['id'] == '101' ? 'selected' : ''?> value="<?php echo $country['id']?>"><?php echo $country['name']?></option>
                                                              <?php //}?>
                                                                                                                                  </select>
                                                                                                                             </div>
                                                                                                                        </div>   -->
                                                <!--                                                            <div class="form-group india">
                                                                                                                             <label for="enq_cus_state" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">State</label>
                                                                                                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                  <select   data-placeholder="Select State" name="enquiry[enq_cus_state]" class="BindDistirct select2_group form-control cmbMultiSelect" data-url="<?php echo site_url('enquiry_1/bindDistrict');?>" >
                                                                                                                                       <option selected>-Select State-</option>
                                                            <?php //foreach ($states as $state) {?>
                                                                                                                                                            <option value="<?php //echo $state['sts_id']?>"><?php echo $state['sts_name']?></option>
                                                              <?php //}?>
                                                                                                                                  </select>
                                                                                                                             </div>
                                                                                                                        </div>-->
                                                <div class="form-group india">
                                                    <label
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">District</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12" id="distict">
                                                        <select class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_cus_dist]">

                                                            <option value="">--</option>
                                                            <?php foreach ($districts as $district) {?>
                                                            <option value="<?php echo $district['std_id']?>"
                                                                <?php echo $datas['vreg_district'] == $district['std_id'] ? 'selected' : ''?>>
                                                                <?php echo $district['std_district_name']?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="enq_cus_pin"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Pin</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="enq_cus_pin"
                                                            class="form-control form-control-enq col-md-7 col-xs-12 numOnly"
                                                            type="number" name="enquiry[enq_cus_pin]">
                                                    </div>
                                                </div>

                                                <!--                                                       <div class="form-group">
                                                                                                                        <label for="enq_budget" class="control-label col-md-3 col-sm-3 col-xs-12">Budget</label>
                                                                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                             <input type="text" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                                                                                    name="enquiry[enq_budget]" value="<?php echo isset($datas['vreg_investment']);?>" required gtrzro="true"/>
                                                                                                                        </div>
                                                                                                                   </div>-->
                                                <!--                                                            <div class="form-group">
                                                                                                                             <label for="enq_vehicle_type" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Vehicle type</label>
                                                                                                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                  <select class="select2_group form-control enq_cus_when_buy" name="enquiry[enq_vehicle_type]" required>
                                                                                                                                       <option value="">Select one</option>
                                                            <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                                                                                                            <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php }?>
                                                                                                                                  </select>
                                                                                                                             </div>
                                                                                                                        </div>-->

                                                <div class="form-group">
                                                    <label for="enq_cus_status"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Mode of
                                                        enquiry</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required
                                                            class="select2_group form-control form-control-enq enq_mode_enq cmbModeOfContact"
                                                            name="enquiry[enq_mode_enq]" disabled>
                                                            <option value="">Select one</option>
                                                            <optgroup label="RD Mode of Enquiry">
                                                                <?php
                                                                                  foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                                       if (!in_array($key, array(18, 17, 6, 19, 20))) {
                                                                                            ?>
                                                                <option
                                                                    <?php echo ($datas['vreg_contact_mode'] == $key) ? 'selected="selected"' : '';?>
                                                                    value="<?php echo $key;?>"><?php echo $value;?>
                                                                </option>
                                                                <?php
                                                                                            }
                                                                                       }
                                                                                     ?>
                                                            </optgroup>
                                                            <optgroup label="Own Mode of Enquiry">
                                                                <?php
                                                                                  foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                                       if (in_array($key, array(18, 17, 6, 19, 20))) {
                                                                                            ?>
                                                                <option
                                                                    <?php echo ($datas['vreg_contact_mode'] == $key) ? 'selected' : '';?>
                                                                    value="<?php echo $key;?>"><?php echo $value;?>
                                                                </option>
                                                                <?php
                                                                                            }
                                                                                       }
                                                                                     ?>
                                                            </optgroup>
                                                        </select>
                                                        <!--                                                                      <input type="hidden" name="enquiry[enq_mode_enq]" value="<?php echo $datas['vreg_contact_mode'];?>"/>-->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_remarks"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Referral
                                                        type</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
                                                                                  if($datas['vreg_referal_type']==4){
                                                                                  $staff = $this->enquiry->getStaffNameById($datas['vreg_referal_name']);
                                                                                  $datas['vreg_referal_name']=$staff['usr_first_name'];
                                                                                 // print_r($staff['usr_first_name']);
                                                                                  } ?>
                                                        <input readonly placeholder="Referral type" type="text"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            value="<?php echo @unserialize(REFERAL_TYPES)[$datas['vreg_referal_type']]; ?>" />
                                                        <input type="hidden"
                                                            value="<?php echo @$datas['vreg_referal_type']; ?>"
                                                            name="enquiry[enq_ref_type]" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_remarks"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Referral
                                                        name</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input readonly placeholder="Referal name" type="text"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            value="<?php echo $datas['vreg_referal_name']; ?>"
                                                            name="enquiry[enq_ref_name]" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enq_cus_remarks"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Referral
                                                        phone</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input readonly placeholder="Referal phone" type="text"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            value="<?php echo $datas['vreg_referal_phone']; ?>"
                                                            name="enquiry[enq_ref_phone]" />
                                                        <input type="hidden"
                                                            value="<?php echo $datas['vreg_referal_enq_id']; ?>"
                                                            name="enquiry[enq_ref_enq_id]" />
                                                    </div>
                                                </div>
                                                <!--                                                            <div class="divReferral">
                                                                 <?php if (isset($datas['vreg_contact_mode']) && $datas['vreg_contact_mode'] == 6) {?>
                                                                        <div class="form-group">
                                                                             <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Referral contact no *</label>
                                                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                  <input required="true" placeholder="Referral contact no" type="text" class="form-control form-control-enq col-md-7 col-xs-12" name="enquiry[enq_ref_phone]"/>
                                                                             </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                             <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Referral name</label>
                                                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                  <input placeholder="Referral name" type="text" class="form-control form-control-enq col-md-7 col-xs-12" name="enquiry[enq_ref_name]"/>
                                                                             </div>
                                                                        </div>
                                                                   <?php }?>
                                                            </div>-->
                                                <div class="form-group">
                                                    <label for="enq_cus_remarks"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Remarks</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            id="flex" rows="8" cols="50"
                                                            name="enquiry[enq_cus_remarks]"><?php echo isset($datas['vreg_customer_remark']) ? strip_tags($datas['vreg_customer_remark']) : '';?></textarea>
                                                    </div>
                                                </div>
                                                <!--                                                            <div class="form-group">
                                                                 <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Last Comments</label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <?php echo isset($datas['vreg_last_action']) ? strip_tags($datas['vreg_last_action']) : '';?>
                                                                 </div>
                                                            </div>-->
                                                <div class="form-group TypeSale">
                                                    <label for="enq_cus_age_group"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Purpose of
                                                        the Purchase</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_cus_purpose]" id="purpose">
                                                            <option value="">-Select-</option>
                                                            <?php foreach ((array) $puposes as $value) {?>
                                                            <option value="<?php echo $value['purp_id'];?>">
                                                                <?php echo $value['purp_name'];?></option>
                                                            <?php }?>
                                                            <option value="">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group TypeSale" style="display: none"
                                                    id="otherPurpose">
                                                    <label for="enq_cus_remarks"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Enter
                                                        purpose</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input placeholder="Enter purpose" type="text"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            name="enquiry[other_purpose]" />
                                                    </div>
                                                </div>


                                                <div class="form-group TypePurchase" style="display: none">
                                                    <label for="enq_cus_age_group"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Purpose of
                                                        the Sale</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="select2_group form-control form-control-enq"
                                                            name="enquiry[enq_cus_purpose]" id="purposeOfSale">
                                                            <option value="">-Select-</option>
                                                            <?php foreach ((array) $puposes as $value) {?>
                                                            <option value="<?php echo $value['purp_id'];?>">
                                                                <?php echo $value['purp_name'];?></option>
                                                            <?php }?>
                                                            <option value="">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group otherPurchaseOfSale TypePurchase"
                                                    style="display: none" id="other_prp_slae">
                                                    <label for="enq_cus_remarks"
                                                        class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Enter
                                                        purpose </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input placeholder="Enter purpose of sale" type="text"
                                                            class="form-control form-control-enq col-md-7 col-xs-12"
                                                            name="enquiry[other_purpose]" />
                                                    </div>
                                                </div>

                                            </div><!-- @col2 -->
                                        </div>
                                    </div><!-- @rw -->
                                    <!-- rw2 -->
                                    <div>
                                        <table class="table table-striped table-bordered bg-clr tb-man">
                                            <thead>
                                                <tr>
                                                    <th class="lbl">MAN</th>
                                                    <th class="lbl">Name</th>
                                                    <th class="lbl">Phone</th>
                                                    <th class="lbl">Relation</th>
                                                    <th class="lbl">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="lbl">Money</th>
                                                    <td><input class="form-control form-control-enq  col-md-7 col-xs-12"
                                                            type="text" name="money[name]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="money[phone]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="money[relation]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="money[remarks]"></td>
                                                </tr>
                                                <tr>
                                                    <th class="lbl">Need</th>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="need[name]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="need[phone]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="need[relation]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="need[remarks]"></td>
                                                </tr>
                                                <tr>
                                                    <th class="lbl">Authority</th>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="authority[name]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="authority[phone]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="authority[relation]"></td>
                                                    <td><input class="form-control form-control-enq col-md-7 col-xs-12"
                                                            type="text" name="authority[remarks]"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div><!-- @rw2 -->
                                </div>

                            </div>

                        </div>

                        <?php if (!empty($questions)) {?>
                        <div id="step-2" class="step2">
                            <div class="form-horizontal form-label-left">
                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="qstSell">
                                        <?php
                                                         foreach ((array) $questions['sell'] as $k => $value) {
                                                              $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                              ?>
                                        <div class="form-group">
                                            <label for="enq_cus_address" style="font-size: 11px;"
                                                class="control-label col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $value['qus_question'];?>
                                            </label>
                                            <div class="col-md-6 col-sm-3 col-xs-12">
                                                <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                <input type="checkbox" <?php echo $required;?>
                                                    name="saquestions[<?php echo $value['qus_id'];?>]" value="1" />
                                                <?php } else { // Text box ?>
                                                <textarea autocomplete="off" <?php echo $required;?> id="enq_cus_need"
                                                    type="text" class="form-control col-md-7 col-xs-12"
                                                    name="saquestions[<?php echo $value['qus_id'];?>]"><?php echo isset($defRegAnswer[$value['qus_id']]) ? $defRegAnswer[$value['qus_id']] : '';?></textarea>
                                                <?php }?>
                                                <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="qstBuy" style="display: none;">
                                        <?php
                                                         foreach ((array) $questions['buy'] as $k => $value) {
                                                              $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                              ?>
                                        <div class="form-group">
                                            <label for="enq_cus_address" style="font-size: 11px;"
                                                class="control-label col-md-3 col-sm-3 col-xs-12">
                                                <?php echo $value['qus_question'];?>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                <input <?php echo $required;?> type="checkbox" class="chk"
                                                    name="byquestions[<?php echo $value['qus_id'];?>]" value="1" />
                                                <?php } else { // Text box ?>
                                                <textarea <?php echo $required;?> id="enq_cus_need"
                                                    class="form-control col-md-7 col-xs-12" type="text"
                                                    name="byquestions[<?php echo $value['qus_id'];?>]"><?php echo isset($defRegAnswer[$value['qus_id']]) ? $defRegAnswer[$value['qus_id']] : '';?></textarea><?php }?>
                                                <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="qstExch" style="display: none;">
                                        <?php
                                                         foreach ((array) $questions['exch'] as $k => $value) {
                                                              $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                              ?>
                                        <div class="form-group">
                                            <label for="enq_cus_address" style="font-size: 11px;"
                                                class="control-label col-md-3 col-sm-3 col-xs-12">
                                                <?php echo $value['qus_question'];?>
                                            </label>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                <input type="checkbox" <?php echo $required;?> class="chk"
                                                    name="exquestions[<?php echo $value['qus_id'];?>]" value="1" />
                                                <?php } else { // Text box ?>
                                                <textarea <?php echo $required;?> id="enq_cus_need"
                                                    class="form-control col-md-7 col-xs-12" type="text"
                                                    name="exquestions[<?php echo $value['qus_id'];?>]"><?php echo isset($defRegAnswer[$value['qus_id']]) ? $defRegAnswer[$value['qus_id']] : '';?></textarea><?php }?>
                                                <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <div id="step-3">
                            <h2 class="StepTitle lblSale" style="width: 100%;">Customer required vehicle<span
                                    style="float: right;cursor: pointer;"
                                    class="glyphicon glyphicon-plus btnAddVehDetailsRqVeh"></span></h2>
                            <div class="table-responsive divVehDetailsSale">
                                <table id="datatable-responsive"
                                    class="tbl-blk vehDetailsSale table table-stripedj table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="11">

                                                <!--                                                            <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>-->
                                                <!--                                                            <select style="width: 170px;float: left;" class="cmbSearchList select2_group form-control cmbStock" 
                                                                    name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry_1/bindSalesTable');?>">
                                                                 <option value="0">Select Vehicle</option>
                                                            <?php
                                                              foreach ((array) $evaluation as $key => $value) {
                                                                   if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
                                                                        ?>
                                                                                                                                                   <option value="<?php echo $value['val_id'];?>">
                                                                        <?php
                                                                        echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                        $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                        ?>
                                                                                                                                                   </option>
                                                                        <?php
                                                                   }
                                                              }
                                                            ?>
                                                            </select>-->
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Variant</th>
                                            <th>Fuel</th>
                                            <th colspan="2">Manufacturing Year</th>
                                            <th>Prefer Colour</th>
                                            <th>Budget range </th>
                                            <th>Km Range</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select required="true" style="width: 170px;"
                                                    class="select2_group form-control cmbBindModel"
                                                    data-url="<?php echo site_url('enquiry_1/bindModel');?>"
                                                    name="vehicle[sale][veh_brand][]">
                                                    <option value="0">Select Brand</option>
                                                    <?php foreach ($brands as $key => $value) {?>
                                                    <option
                                                        <?php echo $value['brd_id'] == $datas['vreg_brand'] ? 'selected="selected"' : '';?>
                                                        value="<?php echo $value['brd_id']?>">
                                                        <?php echo $value['brd_title']?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <select style="width: 170px;" required=""
                                                    data-url="<?php echo site_url('enquiry_1/bindVarient');?>"
                                                    data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                    class="cmbEvModel select2_group form-control bindToDropdown"
                                                    name="vehicle[sale][veh_model][]" id="vreg_model">
                                                    <?php foreach ((array) $model as $key => $value) {?>
                                                    <option
                                                        <?php echo $value['mod_id'] == $datas['vreg_model'] ? 'selected="selected"' : '';?>
                                                        value="<?php echo $value['mod_id'];?>">
                                                        <?php echo $value['mod_title'];?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <select style="width: 170px;" required=""
                                                    class="select2_group form-control cmbEvVariant"
                                                    name="vehicle[sale][veh_varient][]" id="vreg_varient">
                                                    <?php foreach ((array) $variant as $key => $value) {?>
                                                    <option
                                                        <?php echo $value['var_id'] == $datas['vreg_varient'] ? 'selected="selected"' : '';?>
                                                        value="<?php echo $value['var_id'];?>">
                                                        <?php echo $value['var_variant_name'];?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <select required="true" style="width: 170px;"
                                                    class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                    <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>

                                                <select data-placeholder="Select Year"
                                                    name="vehicle[sale][veh_manf_year_from][]" style="width: 85px;"
                                                    class="select2_group form-control cmbMultiSelectmm">
                                                    <option value="">From</option>
                                                    <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                    <option <?php echo $datas['vreg_year'] == $i ? 'selected' : ''?>
                                                        value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>

                                                </select>
                                            </td>
                                            <td> <select data-placeholder="Select Year"
                                                    name="vehicle[sale][veh_manf_year_to][]" style="width: 85px;"
                                                    class="select2_group form-control cmbMultiSelectmm">
                                                    <option value="">To</option>
                                                    <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                    <option <?php echo $datas['vreg_year'] == $i ? 'selected' : ''?>
                                                        value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>

                                                </select></td>
                                            <td>
                                                <select data-placeholder="Select Color"
                                                    name="vehicle[sale][veh_color][]" style="width: 170px;"
                                                    class="select2_group form-control  cmbMultiSelectjks">
                                                    <option value="">-Select Color-</option>
                                                    <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                    <option value="<?php echo $vehicleColor['vc_id'];?>">
                                                        <?php echo $vehicleColor['vc_color']?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <select data-placeholder="Select KM"
                                                    name="vehicle[sale][veh_price_id][]" style="width: 170px;"
                                                    class="select2_group form-control  cmbMultiSelectjks">
                                                    <option value="">-Select Price-</option>
                                                    <?php foreach ($price_ranges as $price_range) {?>
                                                    <option value="<?php echo $price_range['pr_id'];?>">
                                                        <?php echo $price_range['pr_range']?></option>

                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <select data-placeholder="Select KM" name="vehicle[sale][veh_km_id][]"
                                                    style="width: 170px;"
                                                    class="select2_group form-control  cmbMultiSelectjks">
                                                    <option value="">-Select KM-</option>
                                                    <?php foreach ($kms as $km) {?>
                                                    <option value="<?php echo $km['kmr_id'];?>">
                                                        <?php echo $km['kmr_range_from']?> KM -
                                                        <?php echo $km['kmr_range_to']?> KM</option>

                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!--                                                       <td>Prefer Number</td>-->
                                            <td colspan="2">
                                                <p class="labl">Prefer Number</p>
                                                <!--                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">-->
                                                <input placeholder="Prefer Number" id="enq_cus_loan_emi"
                                                    style="width: 313px;" class="form-control col-md-12 col-xs-12"
                                                    type="text" name="vehicle[sale][veh_prefer_number][]"
                                                    autocomplete="off">
                                            </td>
                                            <td colspan="1">
                                                <p class="labl">Expected Date of Purchase</p>
                                                <input placeholder="Expected Date of Purchase"
                                                    class="dtpDatePickerDMY form-control col-md-7 col-xs-12" type="text"
                                                    name="vehicle[sale][veh_exptd_date_purchase][]">
                                            </td>

                                            <td colspan="5">
                                                <p class="labl">Remarks</p>
                                                <input placeholder="Remarks" id="enq_cus_loan_emi"
                                                    class="form-control col-md-7 col-xs-12" type="text"
                                                    name="vehicle[sale][veh_remarks][]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="divVehDetailsReq">
                            </div>
                            <!-- existing -->
                            <!-- pitched -->
                            <h2 class="StepTitle lblSale" style="width: 100%;">Pitched vehicle <span
                                    style="float: right;cursor: pointer;"
                                    class="glyphicon glyphicon-plus btnAddVehDetailsPitched"></span></h2>
                            <div class="table-responsive divVehDetailsPitched TypeSale">
                                <table id="datatable-responsive"
                                    class="tbl-pitch vehDetailsSale table table-stripedj table-bordered dt-responsive nowrap tbl"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="11">
                                                <span
                                                    style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;"
                                                    class="glyphicon glyphicon-remove btnRemove_pitchedVeh"></span>
                                                <select style="width: 170px;float: left;"
                                                    class="cmbSearchList select2_group form-control cmbStock"
                                                    name="veh_stock_id"
                                                    data-url="<?php echo site_url('enquiry_1/bindPitchedVehTable');?>">
                                                    <option value="0">Select Vehicle</option>
                                                    <?php
                                                                   foreach ((array) $evaluation as $key => $value) {//val_color
                                                                        if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
                                                                             ?>
                                                    <option value="<?php echo $value['val_id'];?>">
                                                        <?php
                                                                                  echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                                  $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                                  ?>
                                                    </option>
                                                    <?php
                                                                        }
                                                                   }
                                                                 ?>
                                                </select>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Variant</th>
                                            <th>Fuel</th>
                                            <th>Year</th>
                                            <!--                                                       <th>Color</th>-->
                                            <th>Our Price</th>
                                            <th>Customer Offer</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                            <!-- @pitched -->
                            <!-- purchase-->
                            <h2 class="StepTitle lblBuy" style="display: none; width: 100%;">Purchase vehicle<small>
                                    (Vehicle from customer)</small><span
                                    style="display: none; float: right;cursor: pointer;"
                                    class="glyphicon glyphicon-plus btnAddVehDetailsBuy btnAddVehDetailsPurchase"></span>
                            </h2>
                            <div class="table-responsive divVehDetailsBuy" style="display: none;">
                                <table id="datatable-responsive"
                                    class="vehDetailsBuy table table-stripedj table-bordered jdt-responsive nowrapk"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="11">
                                                <span style="margin: 5px 10px;cursor: pointer;font-size: 18px;"
                                                    class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
                                                <select style="width: 170px;float: left;"
                                                    class="cmbSearchList select2_group form-control bndPurchTb"
                                                    name="vehicle[sale][veh_stock_id][]"
                                                    data-url="<?php echo site_url('enquiry_1/bindPurchaseTable');?>">
                                                    <option value="0">Select Vehicle</option>
                                                    <?php
                                                                   foreach ((array) $evaluation as $key => $value) {
                                                                        if ($this->evaluation->isVehicleEvaluated($value['val_id'])) { // check vehicle is evaluated
                                                                             ?>
                                                    <option value="<?php echo $value['val_id'];?>">
                                                        <?php
                                                                                  echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                                  $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                                  ?>
                                                    </option>
                                                    <?php
                                                                        }
                                                                   }
                                                                 ?>
                                                </select>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="lbl-blk">Brand</th>
                                            <th class="lbl-blk">Model</th>
                                            <th class="lbl-blk">Variant</th>
                                            <th class="lbl-blk">Fuel</th>
                                            <th class="lbl-blk">Model year</th>
                                            <th class="lbl-blk">Color</th>
                                            <th class="lbl-blk">Price Range</th>
                                            <th class="lbl-blk">KM</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbd">
                                        <tr>
                                            <td>
                                                <select required="true" style="width: 170px;"
                                                    class="select2_group form-control cmbBindModelBuy"
                                                    data-url="<?php echo site_url('enquiry_1/bindModel');?>"
                                                    name="vehicle[buy][veh_brand][]">
                                                    <option value="0">Select Brand</option>
                                                    <?php foreach ($brands as $key => $value) {?>
                                                    <option value="<?php echo $value['brd_id']?>"
                                                        <?php echo $value['brd_id'] == $datas['vreg_brand'] ? 'selected="selected"' : '';?>>
                                                        <?php echo $value['brd_title']?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td> <select style="width: 170px;" required=""
                                                    data-url="<?php echo site_url('enquiry_1/bindVarient');?>"
                                                    data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                    class="cmbEvModel select2_group form-control bindToDropdown"
                                                    name="vehicle[buy][veh_model][]" id="vreg_model">
                                                    <?php foreach ((array) $model as $key => $value) {?>
                                                    <option
                                                        <?php echo $value['mod_id'] == $datas['vreg_model'] ? 'selected="selected"' : '';?>
                                                        value="<?php echo $value['mod_id'];?>">
                                                        <?php echo $value['mod_title'];?></option>
                                                    <?php }?>
                                                </select></td>
                                            <td><select style="width: 170px;" required=""
                                                    class="select2_group form-control cmbEvVariant"
                                                    name="vehicle[buy][veh_varient][]" id="vreg_varient">
                                                    <?php foreach ((array) $variant as $key => $value) {?>
                                                    <option
                                                        <?php echo $value['var_id'] == $datas['vreg_varient'] ? 'selected="selected"' : '';?>
                                                        value="<?php echo $value['var_id'];?>">
                                                        <?php echo $value['var_variant_name'];?></option>
                                                    <?php }?>
                                                </select></td>
                                            <td>
                                                <select style="width: 170px;" class="select2_group form-control"
                                                    name="vehicle[buy][veh_fuel][]">
                                                    <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <select data-placeholder="Select Year" name="vehicle[buy][veh_year][]"
                                                    style="width: 170px;"
                                                    class="select2_group form-control cmbMultiSelectmm">
                                                    <option value="">-Select Year-</option>
                                                    <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                    <option <?php echo $datas['vreg_year'] == $i ? 'selected' : ''?>
                                                        value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>

                                                </select>
                                            </td>
                                            <td>
                                                <select data-placeholder="Select Color" name="vehicle[buy][veh_color][]"
                                                    style="width: 170px;"
                                                    class="select2_group form-control  cmbMultiSelectjks">
                                                    <option value="">-Select Color-</option>
                                                    <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                    <option value="<?php echo $vehicleColor['vc_id'];?>">
                                                        <?php echo $vehicleColor['vc_color']?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <select data-placeholder="Select Price"
                                                    name="vehicle[buy][veh_price_id][]" style="width: 170px;"
                                                    class="select2_group form-control  cmbMultiSelectjks">
                                                    <option value="">-Select Price-</option>
                                                    <?php foreach ($price_ranges as $price_range) {?>
                                                    <option value="<?php echo $price_range['pr_id'];?>">
                                                        <?php echo $price_range['pr_range']?></option>

                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td>
                                                <?php //print_r($datas); ?>
                                                <input style="width: 100px;" id="enq_cus_loan_emi"
                                                    class="form-control col-md-7 col-xs-12 numOnly"
                                                    value="<?php echo $datas['vreg_km']?>" type="number"
                                                    name="vehicle[buy][veh_km_from][]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <select data-placeholder="Select Color"
                                                    name="vehicle[buy][veh_color_in_rc][]" style="width: 170px;"
                                                    class="select2_group form-control  cmbMultiSelectjks">
                                                    <option value="">-Color in RC-</option>
                                                    <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                    <option value="<?php echo $vehicleColor['vc_id'];?>">
                                                        <?php echo $vehicleColor['vc_color']?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="Delivery Location"
                                                    class="form-control col-md-7 col-xs-12 " type="text"
                                                    name="vehicle[buy][veh_delivery_location][]">
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="Delivery State"
                                                    class="form-control col-md-7 col-xs-12 " type="text"
                                                    name="vehicle[buy][veh_delivery_state][]">
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="Dealership"
                                                    class="form-control col-md-7 col-xs-12 numOnly" type="text"
                                                    name="vehicle[buy][veh_dealership][]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <!-- <input required="true" placeholder="KL-00-AA-0000" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">-->
                                                <input required placeholder="KL" id="enq_cus_loan_emi"
                                                    style="width: 50px;text-transform:uppercase;"
                                                    class="form-control col-md-3 col-xs-3" type="text"
                                                    name="vehicle[buy][veh_reg1][]" autocomplete="off">
                                                <input required placeholder="00" id="enq_cus_loan_emi"
                                                    style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly"
                                                    type="text" name="vehicle[buy][veh_reg2][]" autocomplete="off">
                                                <input required placeholder="AA" id="enq_cus_loan_emi"
                                                    style="width: 60px;text-transform:uppercase;"
                                                    class="form-control col-md-3 col-xs-3" type="text"
                                                    name="vehicle[buy][veh_reg3][]" autocomplete="off">
                                                <input required placeholder="0000" id="enq_cus_loan_emi"
                                                    style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly"
                                                    type="text" name="vehicle[buy][veh_reg4][]" autocomplete="off">
                                            <td>
                                                <input placeholder="Re Registration" style="width: 170px;"
                                                    class="form-control col-md-3 col-xs-3" type="text"
                                                    name="vehicle[buy][veh_re_reg][]">
                                            </td>


                                            <td colspan="1">
                                                <input placeholder="No Of ownes" id="enq_cus_loan_emi"
                                                    class="form-control col-md-7 col-xs-12" type="number"
                                                    name="vehicle[buy][veh_owner][]">
                                            </td>
                                            <td colspan="1">
                                                <select data-placeholder="Select Comprossr"
                                                    name="vehicle[buy][veh_comprossr][]" style="width: 170px;"
                                                    class="select2_group form-control cmbMultiSelectmm">
                                                    <option value="">-Comprossr-</option>

                                                    <option value="1">Single</option>
                                                    <option value="2">Double</option>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="Chassis number" id="enq_cus_loan_emi"
                                                    class="form-control col-md-7 col-xs-12" type="text"
                                                    name="vehicle[buy][veh_chassis_number][]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <input placeholder="Remarks" id="enq_cus_loan_emi"
                                                    class="form-control col-md-7 col-xs-12" type="text"
                                                    name="vehicle[buy][veh_remarks][]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input placeholder="First delivery date" id="veh_delivery_date"
                                                    class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12"
                                                    type="text" name="vehicle[buy][veh_delivery_date][]">
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="First reg date" id="veh_first_reg"
                                                    class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly"
                                                    type="text" name="vehicle[buy][veh_first_reg][]">
                                            </td>
                                            <td colspan="2">
                                                <select data-placeholder="First manf year"
                                                    name="vehicle[buy][veh_manf_year][]" style="width: 270px;"
                                                    class="select2_group form-control cmbMultiSelectmm">
                                                    <option value="">-Select First manf year-</option>
                                                    <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>

                                                </select>
                                            </td>
                                            <td colspan="1">
                                                <select class="form-control col-md-4 col-xs-6"
                                                    name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                    <option value="">Select A/C</option>
                                                    <option value="1">W/o</option>
                                                    <option value="2">Single</option>
                                                    <option value="3">Dual</option>
                                                    <option value="4">Multi</option>
                                                </select>
                                            </td>
                                            <td colspan="1">
                                                <input placeholder="Ac zone" id="veh_ac_zone"
                                                    class="form-control col-md-7 col-xs-12 numOnly" type="text"
                                                    name="vehicle[buy][veh_ac_zone][]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input placeholder="CC" id="veh_cc"
                                                    class="form-control col-md-7 col-xs-12 numOnly" type="text"
                                                    name="vehicle[buy][veh_cc][]">
                                            </td>
                                            <td colspan="2">
                                                <select class="select2_group form-control"
                                                    name="vehicle[buy][veh_vehicle_type][]">
                                                    <option value="">-Vehicle type-</option>
                                                    <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="Engine number" id="veh_engine_num"
                                                    class="form-control col-md-7 col-xs-12" type="text"
                                                    name="vehicle[buy][veh_engine_num][]">
                                            </td>
                                            <td colspan="1">
                                                <select required class="select2_group form-control"
                                                    name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                    <option value="">Select Transmission</option>
                                                    <option value="1">M/T</option>
                                                    <option value="2">A/T</option>
                                                    <option value="3">S/T</option>
                                                </select>
                                            </td>
                                            <td colspan="1">
                                                <input placeholder="No of seat" id="veh_seat_no"
                                                    class="form-control col-md-7 col-xs-12 numOnly" type="text"
                                                    name="vehicle[buy][veh_seat_no][]">
                                            </td>
                                        </tr>
                                        <!-- insu -->
                                        <tr>
                                            <td colspan="12">
                                                <h3>
                                                    <center>Insurance Details</center>
                                                </h3>
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="3" class="lbl-blk">Company name</td>
                                            <td colspan="8"><input placeholder="Insurance Company" id="veh_cc"
                                                    class="form-control col-md-7 col-xs-12 " type="text"
                                                    name="vehicle[buy][insurance_company][]"></td>


                                        </tr>
                                        <tr>

                                            <td colspan="2">
                                                Comprehesive
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="Valid Up to " id="veh_first_reg"
                                                    class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly"
                                                    type="text" name="vehicle[buy][valid_up_to][]">
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="IDV" class=" form-control col-md-7 col-xs-12 "
                                                    type="text" name="vehicle[buy][idv][]">
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="NCB%" class=" form-control col-md-7 col-xs-12 "
                                                    type="text" name="vehicle[buy][ncb_percentage][]">
                                            </td>

                                        </tr>
                                        <tr>

                                            <td colspan="2" class="lbl-blk">
                                                Third party
                                            </td>
                                            <td colspan="2">
                                                <input placeholder="Valid Up to "
                                                    class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly"
                                                    type="text" name="vehicle[buy][val_insurance_ll_date][]">
                                            </td>
                                            <td colspan="2">

                                                <select required class="select2_group form-control"
                                                    name="vehicle[buy][insurance_type][]">
                                                    <option value="">Insurance Type</option>
                                                    <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) {?>
                                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <select required class="select2_group form-control"
                                                    name="vehicle[buy][ncb_req][]">
                                                    <option value="0">NCB Required </option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </td>

                                        </tr>
                                        <!-- @insu -->
                                        <!--- hypothi-->
                                        <tr>
                                            <td colspan="12">
                                                <h3>
                                                    <center>Hypothecation Details</center>
                                                </h3>
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="1">
                                                <p class="labl">Finance Company </p><input placeholder="Finance Company"
                                                    class=" form-control col-md-7 col-xs-12 " type="text"
                                                    name="vehicle[buy][finance_company][]">
                                            </td>
                                            <td colspan="3">
                                                <p class="labl">Bank</p> <select
                                                    class="cmbSearchList select2_group form-control cmbValHypoBank"
                                                    name="vehicle[buy][bank][]" id="val_hypo_bank">
                                                    <option value="">Select bank</option>
                                                    <?php foreach ($banks as $key => $value) {?>
                                                    <option value="<?php echo $value['bnk_id'];?>">
                                                        <?php echo $value['bnk_name'];?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <p class="labl">Branch</p><input placeholder="Branch"
                                                    class=" form-control col-md-7 col-xs-12 " type="text"
                                                    name="vehicle[buy][bank_branch][]">
                                            </td>
                                            <td colspan="2">
                                                <p class="labl">Hypothecation will close by customer</p><input
                                                    class="chkHypoByCust" type="checkbox"
                                                    name=vehicle[buy][val_hypo_close_by_cust][]" value="1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <p class="labl">Loan Starting Date </p><input
                                                    placeholder="Loan Starting Date "
                                                    class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly"
                                                    type="text" name="vehicle[buy][loan_starting_date][]">
                                            </td>


                                            <td colspan="2">
                                                <p class="labl">Loan Ending Date </p><input
                                                    placeholder="Loan Ending Date"
                                                    class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly"
                                                    type="text" name="vehicle[buy][loan_ending_date][]">
                                            </td>

                                            <td colspan="1">
                                                <p class="labl">Loan amount </p><input placeholder="Loan amount"
                                                    class=" form-control col-md-7 col-xs-12 numOnly" type="text"
                                                    name="vehicle[buy][loan_amount][]">
                                            </td>
                                            <td colspan="1">
                                                <p class="labl">Forclousure value </p><input
                                                    placeholder="Forclousure value"
                                                    class=" form-control col-md-7 col-xs-12 numOnly" type="text"
                                                    name="vehicle[buy][forclousure_value][]">
                                            </td>


                                            <td colspan="2">
                                                <p class="labl">Forclousure date </p><input
                                                    placeholder="Forclousure date"
                                                    class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly"
                                                    type="text" name="vehicle[buy][forclousure_date][]">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <p class="labl">Daily Interest </p><input placeholder="Daily Interest "
                                                    class=" form-control col-md-7 col-xs-12 numOnly" type="text"
                                                    name="vehicle[buy][daily_interest][]">
                                            </td>
                                            <td colspan="2">
                                                <p class="labl">Any Top up Loan </p><input class="chkHypoByCust"
                                                    type="checkbox" name=vehicle[buy][any_top_up_loan][]" value="1">
                                            </td>
                                        </tr>
                                        <!-- @hypothi -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="divVehDetailsPurch">

                            </div>
                            <!-- existing -->
                            <h2 class="StepTitle lblBuyk" style="width: 100%;">Existing vehicle <span
                                    style="float: right;cursor: pointer;"
                                    class="glyphicon glyphicon-plus btnAddVehDetailsExisting"></span></h2>

                            <div class="divVehDetailsExisting">

                            </div>
                            <!-- @existing -->

                        </div><!-- @purchase -->
                        <div id="step-4">
                            <div class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label for="enq_cus_loan_perc"
                                        class="control-label col-md-3 col-sm-3 col-xs-12">Loan percentage</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="enq_cus_loan_perc" class="form-control col-md-7 col-xs-12 numOnly"
                                            type="number" name="enquiry[enq_cus_loan_perc]">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="enq_cus_loan_amount"
                                        class="control-label col-md-3 col-sm-3 col-xs-12">Loan amount</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="enq_cus_loan_amount" class="form-control col-md-7 col-xs-12 numOnly"
                                            type="number" name="enquiry[enq_cus_loan_amount]">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="enq_cus_loan_emi" class="control-label col-md-3 col-sm-3 col-xs-12">Loan
                                        EMI</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly"
                                            type="number" name="enquiry[enq_cus_loan_emi]">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="enq_cus_loan_period"
                                        class="control-label col-md-3 col-sm-3 col-xs-12">Loan total period</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="enq_cus_loan_period" class="form-control col-md-7 col-xs-12 numOnly"
                                            type="number" name="enquiry[enq_cus_loan_period]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-5">
                            <div class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label for="foll_status"
                                        class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required="true" class="select2_group form-control"
                                            name="followup[foll_status]" id="foll_status">
                                            <option value="">Select one</option>
                                            <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) {?>
                                            <option
                                                <?php echo ($datas['vreg_customer_status'] == $key) ? 'selected="selected"' : '';?>
                                                value="<?php echo $key;?>"><?php echo $value;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="foll_remarks"
                                        class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input
                                            value="<?php echo isset($datas['vreg_customer_remark']) ? strip_tags($datas['vreg_customer_remark']) : '';?>"
                                            id="foll_remarks" class="form-control col-md-7 col-xs-12" type="text"
                                            name="followup[foll_remarks]">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of
                                        contact</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2_group form-control" name="followup[foll_contact]"
                                            id="foll_contact">
                                            <?php foreach (unserialize(MODE_OF_CONTACT_FOLLOW_UP) as $key => $value) {?>
                                            <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next
                                        action plan
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input required="true" id="foll_action_plan"
                                            class="form-control col-md-7 col-xs-12" type="text"
                                            name="followup[foll_action_plan]">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next
                                        follow up date
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input required="true" type="text"
                                            class="foll_next_foll_date form-control col-md-7 col-xs-12 dtpNextFollowDate"
                                            placeholder="Next follow up date" id="foll_next_foll_date"
                                            name="followup[foll_next_foll_date]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($datas['vreg_department'] == 4) {?>
<script>
//   alert();
$('.divVehDetailsSale').show();
$('.btnAddVehDetailsSale').show();
$('.lblSale').show();
$('.divVehDetailsBuy').hide();
$('.btnAddVehDetailsBuy').hide();
$('.lblBuy').hide();
$('.qstSell').show();
$('.qstBuy').hide();
$('.qstExch').hide();
$('.TypeSale').show();
$('.TypePurchase').hide();
</script>
<?php }?>
<?php if ($datas['vreg_department'] == 7) {?>
<script>
$('.divVehDetailsSale').hide();
$('.lblBuy').show();
$('.divVehDetailsBuy').show();
$('.btnAddVehDetailsBuy').show();
$('.divVehDetailsSale').hide();
$('.TypeSale').hide();
$('.TypePurchase').show();
$('.btnAddVehDetailsSale').hide();
$('.lblSale').hide();
$('.qstSell').hide();
$('.qstBuy').show();
$('.qstExch').hide();
</script>

<?php }?>
<script>
$(document).ready(function() {
    var count = 0;
    /*Clone of sell buy table*/
    var vehDetailsSale = $(".vehDetailsSale").prop('outerHTML');
    var vehDetailsBuy = $(".vehDetailsBuy").prop('outerHTML');
    $(document).on('click', '.btnAddVehDetailsSale', function() {
        //  $('.divVehDetailsSale').append(vehDetailsSale);
        $('.cmbSearchList').SumoSelect({
            csvDispCount: 3,
            search: true,
            searchText: 'Enter here.'
        });
    });
    //          $(document).on('click', '.btnAddVehDetailsBuy', function () {
    //               $('.divVehDetailsBuy').append(vehDetailsBuy);
    //               $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
    //          });
    $('#purpose').change(function() {
        var selected = $(this).children("option:selected").val();
        if (selected === '') {
            $("#otherPurpose").show();

        } else {
            $("#otherPurpose").hide();
        }
    });
    $('#purposeOfSale').change(function() {
        var slctd = $(this).children("option:selected").val();
        if (slctd === '') {
            $("#other_prp_slae").show();

        } else {
            $("#other_prp_slae").hide();
        }
    });

    $('#country').change(function() {
        var slctdContry = $(this).children("option:selected").val();
        if (slctdContry == '101') {
            $(".india").show();

        } else {

            $(".india").hide();
        }
    });

    $(document).on('click', '.btnAddVehDetailsExisting', function() {
        count = count + 1;
        $.ajax({
            type: 'get',
            "url": site_url + "enquiry_1/add_existing_veh_details",
            data: {
                count: count
            },
            success: function(resp) {
                $('.divVehDetailsExisting').append(resp);
                $(".exist-" + count).effect("shake");
            }
        });
    });
    $(document).on('click', '.btnAddVehDetailsRqVeh', function(e) {
        count = count + 1;
        $.ajax({
            type: 'get',
            "url": site_url + "enquiry_1/add_req_veh_details",
            data: {
                count: count
            },
            success: function(resp) {
                $(".divVehDetailsReq").append(resp);
                $(".rq-" + count).effect("shake");
            }
        });

    });
    $(document).on('click', '.btnAddVehDetailsPitched', function() {
        count = count + 1;
        $.ajax({
            type: 'get',
            "url": site_url + "enquiry_1/add_pitched_veh_details",
            data: {
                count: count
            },
            success: function(resp) {
                console.log(resp);
                $(".divVehDetailsPitched").append(resp);
                $(".pitc-" + count).effect("shake");
            }
        });
    });
    $(document).on('click', '.btnRemove_pitchedVeh', function() {
        $(".tbl").hide('slow', function() {
            $(this).slideUp(150, function() {
                $(this).remove();
            });
        });
    });
    $(document).on('click', '.btnAddVehDetailsPurchase', function() {

        count = count + 1;
        $.ajax({
            type: 'get',
            "url": site_url + "enquiry_1/add_purchase_veh_details",
            data: {
                count: count
            },
            success: function(resp) {
                $(".divVehDetailsPurch").append(resp);
                $(".purch-" + count).effect("shake");
            }
        });
    });
});
</script>