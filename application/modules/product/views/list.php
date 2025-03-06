<style>
.highlight {
    background-color: #FFFF99;
    /* Light yellow color */
}
</style>
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Vehicles displayed on website</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?php echo site_url('product'); ?>" method="get">
                        <table>
                            <tr>
                                <td>
                                    <select data-url="<?php echo site_url('enquiry/bindModel'); ?>"
                                        data-bind="cmbEvModel" data-dflt-select="Select Model"
                                        class="cmbBrand select2_group form-control bindToDropdown" name="prd_brand"
                                        id="prd_brand">
                                        <option value="">Select Brand</option>
                                        <?php foreach ($brand as $key => $value) { ?>
                                        <option value="<?php echo $value['brd_id']; ?>">
                                            <?php echo $value['brd_title']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>"
                                        data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                        class="cmbEvModel select2_group form-control bindToDropdown" name="prd_model"
                                        id="prd_model">
                                    </select>
                                </td>
                                <td>
                                    <select class="select2_group form-control cmbEvVariant" name="prd_variant"
                                        id="prd_variant"></select>
                                </td>
                            </tr>
                            <tr>
                                <!--                                   <td style="margin: 10px;">
                                             <select class="form-control col-md-7 col-xs-12">
                                                  <option value="-1">All products</option>
                                                  <option <?php echo (isset($_GET['who']) && $_GET['who'] == 0) ? "selected='true'" : ''; ?>value="0">Admin uploaded</option>
                                                  <option <?php echo (isset($_GET['who']) && $_GET['who'] == 1) ? "selected='true'" : ''; ?> value="1">User uploaded</option>
                                             </select>
                                        </td>-->
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
                                <td style="margin: 10px;">
                                    <select class="form-control col-md-7 col-xs-12" name="prd_status">
                                        <option value="-1">All status</option>
                                        <option
                                            <?php echo (isset($_GET['prd_status']) && $_GET['prd_status'] == 1) ? "selected='true'" : ''; ?>
                                            value="1">Active</option>
                                        <option
                                            <?php echo (isset($_GET['prd_status']) && $_GET['prd_status'] == 0) ? "selected='true'" : ''; ?>
                                            value="0">Inn-active</option>
                                    </select>
                                </td>
                                <td style="margin: 10px;">
                                    <select class="form-control col-md-7 col-xs-12" name="prd_booking_status">
                                        <option value="-1">All vehicle</option>
                                        <option
                                            <?php echo (isset($_GET['prd_booking_status']) && $_GET['prd_booking_status'] == 28) ? "selected='true'" : ''; ?>
                                            value="28">Show only booked products</option>
                                        <option
                                            <?php echo (isset($_GET['prd_booking_status']) && $_GET['prd_booking_status'] == 40) ? "selected='true'" : ''; ?>
                                            value="40">Show only sold products</option>
                                        <option
                                            <?php echo (isset($_GET['prd_booking_status']) && $_GET['prd_booking_status'] == 11111) ? "selected='true'" : ''; ?>
                                            value="11111">Active only</option>
                                    </select>
                                </td>
                                <td>
                                    <input <?php echo (isset($_GET['prd_photo_upld_by'])) ? "checked" : ''; ?>
                                        style="margin-left: 10px;" type="checkbox" name="prd_photo_upld_by" value="1" />
                                    Photo update pending
                                </td>
                                <td>
                                    <input <?php echo (isset($_GET['prd_verified_by'])) ? "checked" : ''; ?>
                                        style="margin-left: 10px;" type="checkbox" name="prd_verified_by" value="0" />
                                    is verify product
                                </td>
                                <td>
                                    <input placeholder="search string" style="margin-left: 10px;" type="text"
                                        name="search_string"
                                        value="<?php echo (isset($_GET['search_string'])) ? $_GET['search_string'] : ''; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="x_content">
                    <table id="datatable1" class="table table-stripedj table-bordered">
                        <thead>
                            <tr>
                                <th>Reg No</th>
                                <th>Product No</th>
                                <th>Make, Model, Variant</th>
                                <?php if (check_permission('product', 'update')) { ?>
                                <th>Status</th>
                                <th>RD Mini</th>
                                <th>Popular</th>
                                <th>Booked</th>
                                <th>Sold</th>
                                <th>Latest</th>
                                <?php } ?>
                                <th>Action</th>
                                <th>Added on</th>
                                <th>Color new</th>
                                <th>Price</th>
                                <th>Customer name</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            //debug($productDetails);
                            if (!empty($productDetails)) {
                                foreach ($productDetails as $key => $value) {
                            ?>
                            <tr data-url="<?php echo site_url('product/view/' . $value['prd_id']); ?>"
                                class="<?php echo !empty($value['prd_cus_name']) ? 'highlight' : ''; ?>">
                                <td title="<?php echo $value['prd_id']; ?>" class="trVOE">
                                    <?php echo $value['prd_regno_prt_1'] . '-' . $value['prd_regno_prt_2'] . '-' . $value['prd_regno_prt_3'] . '-' . $value['prd_regno_prt_4']; ?>
                                </td>
                                <td class="trVOE"
                                    alt="<?php echo $value['prd_id'] . '-' . $value['prd_valuation_id']; ?>">
                                    <?php echo $value['prd_number']; ?></td>
                                <td class="trVOE">
                                    <?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?>
                                </td>
                                <?php if (check_permission('product', 'update')) { ?>
                                <td>
                                    <input for="status"
                                        data-url="<?php echo site_url('product/changesCheckBoxFields/prd_status/' . $value['prd_id']) ?>"
                                        class="chkStatus" type="checkbox" name="chkStatus"
                                        value="<?php echo $value['prd_status']; ?>"
                                        <?php echo ($value['prd_status'] == 1) ? "checked" : ''; ?> />
                                </td>
                                <td>
                                    <input for="RD Mini"
                                        data-url="<?php echo site_url('product/changesCheckBoxFields/prd_rd_mini/' . $value['prd_id']) ?>"
                                        class="chkStatus" type="checkbox" name="chkStatus"
                                        value="<?php echo $value['prd_rd_mini']; ?>"
                                        <?php echo ($value['prd_rd_mini'] == 1) ? "checked" : ''; ?> />
                                </td>
                                <td>
                                    <input for="Popular"
                                        data-url="<?php echo site_url('product/changesCheckBoxFields/prd_popular/' . $value['prd_id']) ?>"
                                        class="chkStatus" type="checkbox" name="chkStatus"
                                        value="<?php echo $value['prd_popular']; ?>"
                                        <?php echo ($value['prd_popular'] == 1) ? "checked" : ''; ?> />
                                </td>
                                <td>
                                    <input for="Booked"
                                        data-url="<?php echo site_url('product/changesCheckBoxFields/prd_booked/' . $value['prd_id']) ?>"
                                        class="chkStatus" type="checkbox" name="chkStatus"
                                        value="<?php echo $value['prd_booked']; ?>"
                                        <?php echo ($value['prd_booked'] == 1) ? "checked" : ''; ?> />
                                </td>
                                <td>
                                    <input for="Soled"
                                        data-url="<?php echo site_url('product/changesCheckBoxFields/prd_soled/' . $value['prd_id']) ?>"
                                        class="chkStatus" type="checkbox" name="chkStatus"
                                        value="<?php echo $value['prd_soled']; ?>"
                                        <?php echo ($value['prd_soled'] == 1) ? "checked" : ''; ?> />
                                </td>
                                <td>
                                    <input for="Latest"
                                        data-url="<?php echo site_url('product/changesCheckBoxFields/prd_latest/' . $value['prd_id']) ?>"
                                        class="chkStatus" type="checkbox" name="chkStatus"
                                        value="<?php echo $value['prd_latest']; ?>"
                                        <?php echo ($value['prd_latest'] == 1) ? "checked" : ''; ?> />
                                </td>
                                <?php } ?>
                                <td>
                                    <?php if (check_permission('product', 'delete')) { ?>
                                    <a class="pencile deleteListItem" href="javascript:void(0);"
                                        data-url="<?php echo site_url('product/delete/' . $value['prd_id']); ?>">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                    <?php } ?>
                                    <a target="_blank" class="pencile"
                                        href="<?php echo site_url('product/product_share/' . $value['prd_id']); ?>">
                                        <i class="fa fa-share"></i>
                                    </a>
                                    <?php if (check_permission('evaluation', 'printevaluation')) { ?>
                                    <a class="pencile"
                                        href="<?php echo site_url('evaluation/printevaluation/' . $value['prd_valuation_id']); ?>">
                                        <i class="fa fa-car"></i>
                                    </a>
                                    <?php } ?>
                                </td>
                                <td><?php echo !empty($value['prd_date']) ? date('j M Y', strtotime($value['prd_date'])) : ''; ?>
                                </td>
                                <td><?php echo $value['vc_color']; ?></td>
                                <td><?php echo $value['prd_price']; ?></td>
                                <td><?php echo $value['prd_cus_name']; ?></td>
                                <td><?php echo $value['prd_cus_phone']; ?></td>
                                <td><?php echo $value['prd_cus_email']; ?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">
                        <?php echo 'Total ' . $totalRow; ?> products</div>
                    <div style="float: right;">
                        <?php echo $links; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>