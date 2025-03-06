<div class="right_col" role="main">
     <div class="">
          <div class="clearfix"></div>
          <div class="row">
               <div class="col-md-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Compose Leave</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <div class="row">
                                   <!-- CONTENT MAIL -->
                                   <div class="col-sm-12 mail_view">
                                        <div class="inbox-body">
                                             <?php echo form_open_multipart("product/add", array('id' => "frmProduct", 'class' => "form-horizontal form-label-left"))?>
                                             <!-- -->
                                             <table class="table table-striped table-bordered">
                                                  <tr>
                                                       <td colspan="6" style="width: 200px;"><img src="images/long-logo.jpg"/></td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="6" class="text-center">LEAVE REQUEST FORM</td>
                                                  </tr>
                                                  <tr>
                                                       <td>Name</td>
                                                       <td colspan="2">Jayakrishnan</td>
                                                       <td>Date of Joining</td>
                                                       <td colspan="2">12-02-2020</td>
                                                  </tr>
                                                  <tr>
                                                       <td>Designation</td>
                                                       <td colspan="2">Sales executive</td>
                                                       <td>Department</td>
                                                       <td colspan="2" style="font-size: 15px;color: red;">??</td>
                                                  </tr>
                                                  <tr>
                                                       <td>Branch</td>
                                                       <td colspan="2">Calicut</td>
                                                       <td>Reporting to</td>
                                                       <td colspan="2" style="font-size: 15px;color: red;">??</td>
                                                  </tr>
                                                  <tr>
                                                       <td class="text-center" colspan="6">LEAVE DETAILS</td>
                                                  </tr>

                                                  <tr>
                                                       <td></td>
                                                       <td class="text-center">Sick Leaves</td>
                                                       <td class="text-center">Casual Leaves</td>
                                                       <td class="text-center">Annual Leaves</td>
                                                       <td class="text-center">Extra Ordinary</td>
                                                       <td class="text-center" style="width: 163px;">Total</td>
                                                  </tr>

                                                  <tr>
                                                       <td>Leave Availed this Month</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                  </tr>

                                                  <tr>
                                                       <td>UnExcused leaves</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                  </tr>

                                                  <tr>
                                                       <td>Leave Balances</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                  </tr>

                                                  <tr>
                                                       <td>Leave Request</td>
                                                       <td colspan="3">
                                                            <span style="margin-right: 230px;font-size: 15px;color: red;">Period From:??</span>
                                                            <span style="font-size: 15px;color: red;">To:??</span>
                                                       </td>
                                                       <td>No of days</td>
                                                       <td style="font-size: 15px;color: red;">??</td>
                                                  </tr>

                                                  <tr>
                                                       <td>Duties Hand Over to</td>
                                                       <td colspan="2">Name:</td>
                                                       <td>Designation</td>
                                                       <td colspan="2"></td>
                                                  </tr>

                                                  <tr>
                                                       <td colspan="6" class="text-center">
                                                            Declaration: I here by declare that , the leave /Absence requested above is for the 
                                                            purposes indicated , I understand that I must comply with leave policy of the
                                                            organization. I will hand over or assign all pending jobs during my leave period 
                                                            and give required briefing. in case of extention of leave , i will take prior approval 
                                                            from concern authority and intimate the HR as per policy
                                                       </td>
                                                  </tr>

                                                  <tr>
                                                       <td>Signature</td>
                                                       <td colspan="2"></td>
                                                       <td class="text-center">Date</td>
                                                       <td colspan="2"><?php echo date('d-m-Y h:i A');?></td>
                                                  </tr>

                                                  <tr>
                                                       <td>Signature by Take Over</td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                  </tr>

                                                  <tr>
                                                       <td>Sanctioned By</td>
                                                       <td></td>
                                                       <td>Approved By</td>
                                                       <td colspan="2">HR:</td>
                                                       <td>COO :</td>
                                                  </tr>

                                                  <tr>
                                                       <td>Remarks:</td>
                                                       <td colspan="5">
                                                            <textarea class="form-control col-md-7 col-xs-12" style="width: 100%;"></textarea>
                                                       </td>
                                                  </tr>
                                             </table>
                                             <!-- -->

                                             <div class="ln_solid"></div>
                                             <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                       <button type="submit" class="btn btn-success">Submit</button>
                                                       <button class="btn btn-primary" type="reset">Reset</button>
                                                  </div>
                                             </div>
                                             <?php echo form_close()?>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>