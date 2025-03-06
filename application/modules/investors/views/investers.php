<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Investors</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-12 col-sm-12 col-xs-12">
                              <a href="<?php echo site_url($controller . '/newInvestor'); ?>" class="btn btn-round btn-primary">
                                   <i class="fa fa-pencil-square-o"></i> New Investor
                              </a>
                         </div>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Occupation</th>
                                        <th>Company</th>
                                        <th>Email</th>
                                        <th>Location</th>
                                        <?php if ($this->uid == ADMIN_ID) { ?>
                                             <th><i class="fa fa-trash"></i></th>
                                        <?php } ?>
                                        <th>Invest</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   if (!empty($data)) {
                                        foreach ($data as $key => $value) {
                                             ?>
                                             <tr data-url="<?php echo site_url($controller . '/view/' . $value['inv_id']); ?>">
                                                  <td class="trVOE"><?php echo $value['inv_name']; ?></td>
                                                  <td class="trVOE"><?php echo $value['cntct_numbrs']; ?></td>
                                                  <td class="trVOE"><?php echo $value['inv_address']; ?></td>
                                                  <td class="trVOE"><?php echo $value['inv_occupation']; ?></td>
                                                  <td class="trVOE"><?php echo $value['inv_company']; ?></td>
                                                  <td class="trVOE"><?php echo $value['inv_email']; ?></td>
                                                  <td class="trVOE"><?php echo $value['inv_location']; ?></td>
                                                  <?php if ($this->uid == ADMIN_ID) { ?>
                                                       <td>
                                                            <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                               data-url="<?php echo site_url($controller . '/delete/' . $value['inv_id']); ?>">
                                                                 <i class="fa fa-remove"></i>
                                                            </a>
                                                       </td>
                                                  <?php } ?>
                                                  <td>
                                                       <a class="pencile" href="<?php echo site_url($controller . '/makeInvest/' . $value['inv_id']); ?>">
                                                            <i class="fa fa-arrow-right"></i>
                                                       </a>
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