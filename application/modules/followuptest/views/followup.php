     <div class="right_col" role="main">
          <div class="clearfix"></div>
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Follow up details of <?php echo $enqInfo['enq_id']; ?>- <?php echo $enqInfo['enq_cus_name']; ?> </h2>
                    

                              <ul class="nav navbar-right panel_toolbox">
                              
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
                         <div class="x_content">
                              <div class="col-md-8 col-sm-12 col-xs-12">
                                   <div class="panel panel-default">
                                        <div class="panel-heading">All followup jj
                                             <div style="float: right;">
                                                  <i class="fa fa-circle" style="color: red;"> HOT+</i>
                                                  <i class="fa fa-circle" style="color: #9c3501;"> HOT</i>
                                                  <i class="fa fa-circle" style="color: #ffc800;"> WARM</i>
                                                  <i class="fa fa-circle" style="color: #6aa913;"> COLD</i>
                                             </div>
                                        </div>
                                        <div class="panel-body">
                                             <ul class="list-unstyled timeline">
                                                  <div id="ajx">

                                                  </div>
                                             
                                             </ul>
                                        </div>
                                   </div>
                         
                              </div>
                              
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <script>
     $(document).ready(function() {
     $("#ajx").html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
     $.ajax({
          type: 'GET',
          url: site_url + "followuptest/get_followups/" + "<?php echo $enqInfo['enq_id']; ?>", 
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
