<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Events</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('lms/lmsReport/');?>" method="get">
                              <table>
                              <tr>
                                   <td>
                                        <input autocomplete="off" name="date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" />
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <input autocomplete="off" name="date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date to" />
                                   </td>
                                   <td>
                                   <select data-placeholder="funnel" name="funnel" class="select2_group filter-form-control form-control col-md-7 col-xs-12" >
                                                <?php
                                                if (!empty($funnels)) {
                                                    foreach ($funnels as $value) {
                                                ?>
                                                        <option value="<?php echo $value['sfnl_id']; ?>"><?php echo $value['sfnl_funnel']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                   </td>
                                   <td>
                                   <select data-placeholder="Source" name="source" class="select2_group filter-form-control form-control col-md-7 col-xs-12" >
                                                <?php
                                                if (!empty($sources)) {
                                                    foreach ($sources as $key => $value) {
                                                ?>
                                                        <option value="<?php echo $value['cmd_mod_id']; ?>"><?php echo $value['cmd_title']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                   </td>

                                   <td>
                                   <select data-placeholder="campaign" name="campaign" class="select2_group filter-form-control form-control col-md-7 col-xs-12" >
                                                <?php
                                                if (!empty($campaigns)) {
                                                    foreach ($campaigns as $key => $value) {
                                                ?>
                                                        <option value="<?php echo $value['evnt_id']; ?>"><?php echo $value['evnt_title']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                   </td>
                                   
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>

                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                   <th>Funnel</th>
            <th>Source</th>
            <th>Campaign</th>
            <th>Hot+</th>
            <th>Hot</th>
            <th>Warm</th>
            <th>Cold</th>
            <th>Total</th>
                                   </tr>
                              </thead>
                              <tbody>
                              <?php if (!empty($reports)) : ?>

                                   <?php foreach ($reports as $row) : ?>
            <tr>
                <td><?php echo $row['Funnel']; ?></td>
                <td><?php echo $row['Source']; ?></td>
                <td><?php echo $row['Campaign']; ?></td>
                <td><?php echo $row['HotPlus']; ?></td>
                <td><?php echo $row['Hot']; ?></td>
                <td><?php echo $row['Warm']; ?></td>
                <td><?php echo $row['Cold']; ?></td>
                <td><?php echo $row['Total']; ?></td>
            </tr>
        <?php endforeach; ?>

                                   <?php else : ?>
    <p>No data available.</p>
<?php endif; ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>