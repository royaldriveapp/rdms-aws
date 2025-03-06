<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Photo upload pending</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="get">
                        <table>
                            <tr>
                                <td style="margin: 10px;">
                                    <select class="form-control col-md-7 col-xs-12" name="prd_rd_mini">
                                        <option value="-1">All products</option>
                                        <option
                                            <?php echo (isset($_GET['prd_rd_mini']) && $_GET['prd_rd_mini'] == 0) ? "selected='true'" : ''; ?>
                                            value="0">RD Luxury</option>
                                        <option
                                            <?php echo (isset($_GET['prd_rd_mini']) && $_GET['prd_rd_mini'] == 1) ? "selected='true'" : ''; ?>
                                            value="1">RD Smart</option>
                                    </select>
                                </td>
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <!-- -->
                    <!-- <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <a href="<?php //echo site_url('product/createDummy'); 
                                             ?>" class="btn btn-success">Create dummy product</a>
                              </div>
                         </div> -->
                    <!-- -->
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Reg No</th>
                                <th>Product No</th>
                                <th>Vehicle</th>
                                <th>Web link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                   if (!empty($productList)) {
                                        foreach ($productList as $key => $value) {
                                             $name = $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'];
                                             if ($value['prd_rd_mini'] == 1) {
                                                  $url = 'https://www.royaldrivesmart.in/vehicle/' . $value['prd_id'] . '-' . get_url_string($name);
                                             } else {
                                                  $url = 'https://royaldrive.in/' . $value['brd_slug'] . '/' . get_url_string($name) . '-' . $value['prd_id'];
                                             }
                                   ?>
                            <tr data-url="<?php echo site_url('product/pendingPhotoupload/' . $value['prd_id']); ?>">
                                <td class="trVOE">
                                    <?php echo $value['prd_regno_prt_1'] . '-' . $value['prd_regno_prt_2'] . '-' . $value['prd_regno_prt_3'] . '-' . $value['prd_regno_prt_4']; ?>
                                </td>
                                <td class="trVOE"><?php echo $value['prd_number']; ?></td>
                                <td class="trVOE">
                                    <?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?>
                                </td>
                                <td><a href="<?php echo $url; ?>" target="_blank"><i class="fa fa-globe"></i></a>
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