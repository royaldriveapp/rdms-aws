<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Question</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>ID</th>
                                        <th>Priority</th>
                                        <th>Question</th>
                                        <th>Type</th>
                                        <th>Yes/No</th>
                                        <th>Mandatory</th>
                                        <th>Delete</th>     
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     $type = unserialize(ENQ_QUESTION_TYPES);
                                     foreach ((array) $questions as $key => $value) {
                                          ?>
                                          <tr data-url="<?php echo site_url($controller . '/view/' . encryptor($value['qus_id']));?>">
                                               <td class="trVOE"><?php echo $value['qus_id'];?></td>
                                               <td class="trVOE"><?php echo $value['qus_order'];?></td>
                                               <td class="trVOE"><?php echo strip_tags($value['qus_question']);?></td>
                                               <td class="trVOE"><?php echo isset($type[$value['qus_type']]) ? $type[$value['qus_type']] : ''; ?></td>
                                               <td class="trVOE">
                                                    <?php
                                                    echo $value['qus_is_togler'] == 1 ? '<i class="glyphicon glyphicon-ok green"></i>' :
                                                            '<i class="glyphicon glyphicon-remove green"></i>';
                                                    ?></td>
                                               <td class="trVOE">
                                                    <?php
                                                    echo $value['qus_is_mandatory'] == 1 ? '<i class="glyphicon glyphicon-ok green"></i>' :
                                                            '<i class="glyphicon glyphicon-remove green"></i>';
                                                    ?>
                                               </td>
                                               <td>
                                                    <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                       data-url="<?php echo site_url($controller . '/delete/' . $value['qus_id']);?>">
                                                         <i class="fa fa-remove"></i>
                                                    </a>
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