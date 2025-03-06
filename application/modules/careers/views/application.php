<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Application</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table  class="tblCarrers table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>District</th>
                                        <th>Email</th>    
                                        <th>Mobile</th>
                                        <th>Experience</th>
                                        <th>Applied for</th>
                                        <th>Posted on</th>
                                        <th>Resume</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $application as $key => $value) {
                                          ?>
                                          <tr>
                                               <td><?php echo $value['cap_fname'];?></td>
                                               <td><?php echo $value['cap_lname'];?></td>
                                               <td><?php echo $value['std_district_name'];?></td>
                                               <td><?php echo $value['cap_email'];?></td>
                                               <td><?php echo $value['cap_mobile'];?></td>
                                               <td><?php echo $value['cap_experience'];?></td>
                                               <td><?php echo $value['car_title'];?></td>
                                               <td><?php echo date('j M Y', strtotime($value['cap_date']));?></td>
                                               <td>
                                                    <a target="_blank" href="<?php echo './uploads/cv/' .  $value['cap_resume'];?>"><i class="fa fa-file-text-o"></i></a>
                                               </td>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>