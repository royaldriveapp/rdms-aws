<div class="right_col" role="main">
     <style>
          .card {
               margin-bottom: 30px;
               border: 0;
               box-shadow: 0 0 2rem 0 rgb(136 152 170 / 15%);
          }
          .card {
               position: relative;
               display: flex;
               flex-direction: column;
               min-width: 0;
               word-wrap: break-word;
               border: 1px solid rgba(0,0,0,.05);
               border-radius: .375rem;
               background-color: #fff;
               background-clip: border-box;
          }
          *, ::after, ::before {
               box-sizing: border-box;
          }
          .card-stats .card-body {
               padding: 1rem 1.5rem;
          }
          .card-body {
               min-height: 1px;
               padding: 1.5rem;
               flex: 1 1 auto;
          }
          *, ::after, ::before {
               box-sizing: border-box;
          }
          .text-muted {
               color: #8898aa!important;
          }
          .text-uppercase {
               text-transform: uppercase!important;
          }
          .mb-0, .my-0 {
               margin-bottom: 0!important;
          }
          .card-title {
               font-size: 12px;
               margin-bottom: 1.25rem;
               width:135px;
          }
          .font-weight-bold {
               font-weight: 600!important;
          }
          .mb-0, .my-0 {
               margin-bottom: 0!important;
          }
          .text-white {
               color: #fff!important;
          }
          [class*=shadow] {
               transition: all .15s ease;
          }
          .bg-gradient-red {
               background: linear-gradient(
                    87deg
                    ,#f5365c 0,#f56036 100%)!important;
          }
          .icon-shape {
               display: inline-flex;
               padding: 12px;
               text-align: center;
               border-radius: 50%;
               align-items: center;
               justify-content: center;
          }
          .icon {
               width: 3rem;
               height: 3rem;
          }
          .text-white {
               color: #fff!important;
          }
          .text-white {
               color: #fff!important;
          }
          .shadow {
               box-shadow: 0 0 2rem 0 rgba(136,152,170,.15)!important;
          }
          .avatar.rounded-circle img, .rounded-circle {
               border-radius: 50%!important;
          }
          .bg-gradient-green {
               background: linear-gradient(
                    87deg
                    ,#2dce89 0,#2dcecc 100%)!important;
          }
          .bg-gradient-info {
               background: linear-gradient(
                    87deg
                    ,#11cdef 0,#1171ef 100%)!important;
          }
          .bg-gradient-orange {
               background: linear-gradient(
                    87deg
                    ,#fb6340 0,#fbb140 100%)!important;
          }
          .col {
               position: relative;
               width: 56%;
               padding-right: 15px;
               padding-left: 15px;
               max-width: 100%;
               flex-basis: 0;
               flex-grow: 1;
               float: left;
          }
          .col-auto {
               width: auto;
               max-width: 30%;
               flex: 0 0 auto;
               position: relative;
               padding-right: 15px;
               padding-left: 15px;
               float: right;
          }
          .text-sm {
               font-size: .875rem!important;
          }
          .mt-3, .my-3 {
               margin-top: 1rem!important;
          }
          .mb-0, .my-0 {
               margin-bottom: 0!important;
          }
     </style>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Voxbay calls</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <!-- <a class="btnEportVoxbayDailyCallReport" href="javascript:void(0)" data-url="<?php //echo site_url($controller . '/eportVoxbayDailyCallReport');                           ?>">
                                        <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                   </a>-->
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="divVBDailyCalls"></div>
                         <table>
                              <tr>
                                   <?php if (isset($staffs) && !empty($staffs)) { ?>
                                        <td style="padding-left: 5px;">
                                             <select multiple="multiple" style="float: left;width: auto;" class="muliSelectCombo select2_group form-control cmbSalesExecutives" name="executive[]">
                                                  <?php
                                                  foreach ((array) $staffs as $key => $value) {
                                                       ?><option value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_username']; ?></option> 
                                                       <?php
                                                  }
                                                  ?>
                                             </select>
                                        </td>
                                   <?php } ?>

                                   <td style="padding-left: 5px;">
                                        <input autocomplete="off" name="data_from" type="text" class="dtpDateFrom dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" value=""/>
                                   </td>
                                   <td style="padding-left: 5px;">
                                        <input autocomplete="off" name="data_to" type="text" class="dtpDateTo dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date to" value=""/>
                                   </td>
                                   <td style="padding-left: 5px;">
                                        <button type="submit" class="btnVoxBay btn btn-round btn-primary">Filter</button>
                                   </td>
                              </tr>
                         </table>
                         <!-- -->
                         <table id="voxbayDailyCallReport" class="table table-striped table-bordered dt-responsive nowrap">
                              <thead>
                                   <tr>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>CUG</th>
                                        <th>Assigned by</th>
                                        <th>Assigned to</th>
                                        <th>Customer Feedback</th>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function () {
          setInterval(function () {
               $.ajax({
                    type: 'post',
                    url: "<?php echo site_url('reports/voxbayDailyCallsAjax'); ?>",
                    dataType: 'json',
                    success: function (resp) {
                         $('.divVBDailyCalls').html(resp.html);
                    }
               });
          }, 10000);
     });
</script>