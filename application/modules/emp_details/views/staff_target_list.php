
<style>
     .lbl{
          color: black !Important;
     }
     .modal-dialog{
          width: 1111px !important;
          margin: 30px auto !important ;     
     }
     .bg-gray{
          background-color: #cacaca!important;
     }
     .brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 0px !important;
          border-top-right-radius: 0px !important;
          border-bottom-right-radius: 35px !important;
          border-bottom-left-radius: 35px !important;   
     }
     .h-brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 35px !important;
          border-top-right-radius: 35px !important;
          border-bottom-right-radius: 0px !important;
          border-bottom-left-radius: 0px !important; 

     }
     .modal-content {
          border: 7px solid rgba(0,0,0,.2)!important;
          border-radius: 42px!important;
     }


     table td {width:100px;   white-space: nowrap;;}
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Staff and target<?php echo ($trgt_category == 1) ? '(Sales & Purchase)' : '(Valuation)';?></h2>
                         <div class="clearfix"></div>
                         <form action="<?php echo site_url('emp_details/staff_target/');?>" method="get">
                              <table>
                                   <tbody><tr>
                                   <select style="float: left;width: auto;" class="select2_group form-control" 
                                           name="showroom" >
                                                <?php foreach ($allShowrooms as $key => $value) {?>
                                               <option <?php echo ($showroom == $value['shr_id']) ? 'selected="selected"' : '';?>
                                                    value="<?php echo $value['shr_id']?>"><?php echo $value['shr_location']?></option>
                                               <?php }?>
                                   </select>
                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                                   </tr>

                                   </tbody></table>
                         </form> 

                    </div>
                    <div class="x_content">
                         <div style="overflow-x:auto;">
                              <table id="datatable" class="table table-striped table-bordered cw-table-list">
                                   <thead>
                                        <tr>
                                             <th>ID</th>
                                             <th>Username</th>
     <!--                                        <th>Designation</th>-->

                                             <?php
                                               $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                                               foreach ($months as $key => $month) {
                                                    ?>
                                                    <th colspan="4"><?php echo $month;?></th>

                                               <?php }?>

<!-- <th>Action</th>-->
                                        </tr>

                                   </thead>
                                   <tbody>
                                        <tr>

                                             <td class=""></td>
                                             <td class=""></td>


                                             <?php
                                               foreach ($months as $k => $month) {
                                                    ?>
                                                    <td class="td_bg" data-td="td1-<?php echo $k?>" data-clicks="1">
                                                         1st wk 
                                                    </td>
                                                    <td class="td_bg" data-td="td2-<?php echo $k?>" data-clicks="1">2nd wk </td>
                                                    <td class="td_bg" data-td="td3-<?php echo $k?>" data-clicks="1"> 3rd wk</td>
                                                    <td class="td_bg" data-td="td4-<?php echo $k?>" data-clicks="1"> 4th wk</td>

                                               <?php }?>


                                        </tr>
                                        <?php
                                          if (!empty($users)) {
                                               foreach ($users as $key => $value) {
                                                    ?>
                                                    <tr>

                                                         <td data-clicks="1" class="tr_bg "><?php echo $value['col_id'];?></td>
                                                         <td class="td_bg "><?php echo $value['col_title'];?></td>
            <!--                                                    <td class=""><?php echo $value['desig_title'];?></td>-->

                                                         <?php
                                                         foreach ($months as $month_id => $month) {
                                                              ?>
                                                              <td class="td1-<?php echo $month_id?>" contenteditable="true"  onClick="showEdit(this);"  onkeyup="saveToDatabase(this, 1,<?php echo $month_id?>, '<?php echo $value['col_id'];?>')">
                                                                   <?php
                                                                   $target = $this->emp_details->getTargetByUserId($value['col_id'], $month_id, $trgt_category); //1 for sales and purchs target 2 for valuation target
                                                                   //print_r($target);
                                                                   echo ($trgt_category == 1) ? @$target['st_1st_week_target'] : @$target['st_1st_week_valuation_target'];
                                                                   ?></td>
                                                              <td class="td2-<?php echo $month_id?>" contenteditable="true" onClick="showEdit(this);"  onkeyup="saveToDatabase(this, 2,<?php echo $month_id?>, '<?php echo $value['col_id'];?>')"><?php echo ($trgt_category == 1) ? @$target['st_2nd_week_target'] : @$target['st_2nd_week_valuation_target'];?> </td>
                                                              <td class="td3-<?php echo $month_id?>" contenteditable="true" onClick="showEdit(this);" onkeyup="saveToDatabase(this, 3,<?php echo $month_id?>, '<?php echo $value['col_id'];?>')"> <?php echo ($trgt_category == 1) ? @$target['st_3rd_week_target'] : @$target['st_3rd_week_valuation_target'];?></td>
                                                              <td class="td4-<?php echo $month_id?>" contenteditable="true" onClick="showEdit(this);" onkeyup="saveToDatabase(this, 4,<?php echo $month_id?>, '<?php echo $value['col_id'];?>')"> <?php echo ($trgt_category == 1) ? @$target['st_4th_week_target'] : @$target['st_4th_week_valuation_target'];?></td>

                                                         <?php }?>


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
     <!-- $model -->

     <div class="modal fade" id="targetModel" role="dialog" >

          <div class="modal-dialog ">
               <?php echo form_open_multipart("emp_details/storeTargets", array('id' => "home_Visit", 'class' => "submitHomeVisit  modal-content form-horizontal form-label-left"))?>

               <div class="modal-header bg-gray h-brd-radi">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title lbl"> Update target  <span class="msg"></span></h4>

               </div>
               <div class="modal-body bg-gray brd-radi">
                    <div class="mdl_div">
                         <p class="lbl staff-name">Abdurahiman</p>
                         <input type="hidden" value="" name="user_id" id="user_id" class="user_id">
                         <div class="row">

                              <table id="datatable" class="table table-striped table-bordered lbl">
                                   <thead>
                                        <tr>

                                             <?php
                                               $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                                               foreach ($months as $key => $month) {
                                                    ?>
                                                    <th><?php echo $month;?></th>

                                               <?php }?>


                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <?php foreach ($months as $key => $month) {
                                                    ?>
                                                    <th>
                                                         <input  placeholder="Target" style="width: 70px;" class="reg form-control numOnly" type="text" name="target[<?php echo $key?>]" autocomplete="off">
                                                    </th>

                                               <?php }?>

                                        </tr>
                                   </tbody>
                              </table>

                         </div>

                    </div>
                    <div class="modal-footer">
                         <button type="submit" class="btn btn-success">Submit</button>
                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    <?php echo form_close()?>
               </div>
          </div></div><!-- @model -->
</div>
<script>
     var img_url = '<?php echo base_url('assets/images/loading.gif');?>';
     var trgt_category = '<?php echo $trgt_category?>';
     function showEdit(editableObj) {
          $(editableObj).css("background", "#dbfc03");
     }
     function saveToDatabase(editableObj, wk, month_id, stff_id) {
          $(editableObj).css("background", "#FFF url(https://www.rdms.royaldrive.in/assets/images/loaderIcon.gif) no-repeat center right 5px");
          $.ajax({
               url: site_url + "emp_details/storeTargets",
               type: "POST",
               data: 'wk=' + wk + '&target=' + parseInt(editableObj.innerHTML)
                       + '&month_id=' + month_id + '&stff_id=' + stff_id + '&tagetCategory=' + trgt_category,
               success: function (data) {
                    $(editableObj).css("background", "#42f57e");
               },
               error: function (error) {
                    $(editableObj).css("background", "#f54242");
               }
          });
     }
     $('.tr_bg').bind('click', function (e) {
          var click = $(this).data('clicks');
          if (click % 2 == 1) {
               $(e.target).closest('tr').children('td,th').css('background-color', '#f2ca16');
          } else {
               $(e.target).closest('tr').children('td,th').css('background-color', '#fff');
          }
          ;
          $(this).data('clicks', click + 1);

     });

     $('.td_bg').bind('click', function (e) {
          var td_class = $(this).data('td');
          var click = $(this).data('clicks');
          if (click % 2 == 1) {
               $(e.target).closest('td').css('background-color', '#f2ca16');
               $('.' + td_class).closest('td').css('background-color', '#f2ca16');
          } else {
               $(e.target).closest('td').css('background-color', '#fff');
               $('.' + td_class).closest('td').css('background-color', '#fff');
          }
          ;
          $(this).data('clicks', click + 1);

     });

</script>
