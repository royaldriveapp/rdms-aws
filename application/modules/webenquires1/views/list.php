<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Web enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                              <table id="datatable" class="table table-striped table-bordered">
                                   <thead>
                                        <tr>
                                             <th>Date</th>
                                             <th>First name</th>
                                             <th>Last name</th>
                                             <th>Email</th>
                                             <th>Phone</th>
                                             <th>Comments</th>
                                             <th>Vehicle</th>
                                             <th>Web link</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          if (!empty($data)) {
                                               foreach ($data as $key => $value) {
                                                    $uri = array(
                                                        't' => encryptor('rana_connect_with_seller'),
                                                        'pk' => 'cws_id',
                                                        'i' => encryptor($value['cws_id']),
                                                        'f' => 'cws_first_name AS name,cws_phone AS phone'
                                                    );
                                                    $url = '?' . http_build_query($uri, '', '&amp;');
                                                    ?>
                                                    <tr data-url="<?php echo site_url($controller . '/punch' . $url);?>">
                                                         <td class="trVOE"><?php echo date('d-m-Y', strtotime($value['cws_added_date']));?></td>
                                                         <td class="trVOE"><?php echo $value['cws_first_name'];?></td>
                                                         <td class="trVOE"><?php echo $value['cws_last_name'];?></td>
                                                         <td class="trVOE"><?php echo $value['cws_email'];?></td>
                                                         <td><a target="blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['cws_phone'];?>"><?php echo $value['cws_phone'];?></a></td>
                                                         <td class="trVOE"><?php echo $value['cws_comments'];?></td>
                                                         <td class="trVOE"><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?></td>
                                                         <td><a target="blank" href="<?php echo $value['cws_url'];?>"><i class="fa fa-link"></i></a></td>
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
</div>

<style>
     .table>thead>tr>th {
          white-space: nowrap;
          width: 1%;
     }
     .table>tbody>tr>td {
          white-space: nowrap;
          width: 1%;
     }
</style>