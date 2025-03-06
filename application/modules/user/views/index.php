<div class="row-fluid">
     <div class="span12">
          <!-- BEGIN EXAMPLE TABLE widget-->
          <div class="widget red">
               <div class="widget-title">
                    <h4><i class="icon-list-ul"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <table class="table table-bordered table-striped" id="sample">
                         <thead>
                              <tr>
                                   <th class="hidden-phone">Username</th>
                                   <th class="hidden-phone">Email</th>
                                   <th class="hidden-phone">First name</th>
                                   <th class="hidden-phone">Last name</th>
                                   <th class="hidden-phone">Group</th>
                                   <th class="hidden-phone">Edit</th>
                                   <th class="hidden-phone">Delete</th> 
                              </tr>
                         </thead>
                         <tfoot>
                              <tr>
                                   <th class="hidden-phone">Username</th>
                                   <th class="hidden-phone">Email</th>
                                   <th class="hidden-phone">First name</th>
                                   <th class="hidden-phone">Last name</th>
                                   <th class="hidden-phone">Group</th>
                                   <th class="hidden-phone">Edit</th>
                                   <th class="hidden-phone">Delete</th> 
                              </tr>
                         </tfoot>
                         <tbody>
                              <?php
                                if (!empty($users)) {
                                     foreach ($users as $key => $value) {
                                          ?>
                                          <tr>
                                               <td class="hidden-phone"><?php echo $value['username']; ?></td>
                                               <td class="hidden-phone"><?php echo $value['email']; ?></td>
                                               <td class="hidden-phone"><?php echo $value['first_name']; ?></td>
                                               <td class="hidden-phone"><?php echo $value['last_name']; ?></td>
                                               <td class="hidden-phone"><?php echo $value['group_name']; ?></td><!-- brd_title for category -->
                                               <td  class="hidden-phone">
                                                    <a class="pencile edit" href="<?php echo site_url('user/view_user/' . $value['id']); ?>">
                                                         <i class="icon-pencil"></i>
                                                    </a>
                                               </td>
                                               <td  class="hidden-phone">
                                                    <a class="pencile deleteRow" id="<?php echo $value['id']; ?>" href="javascript:void(0);" data-url="<?php echo site_url('user/delete/' . $value['id']); ?>">
                                                         <i class="icon-trash"></i>

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