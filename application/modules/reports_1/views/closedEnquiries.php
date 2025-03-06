<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Enquires</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Vehicle</th>
                                <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Sales Executive</th>' : ''; ?>
                                <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Showroom</th>' : ''; ?>
                                <th>Added By</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Whatsapp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //debug($enquires);
                            if (!empty($enquires)) {
                                foreach ($enquires as $key => $value) {
                                    ?>
                                    <tr data-url="<?php echo site_url('reports/viewVehicleStatusHistory/' . encryptor($value['veh_id']) . '/' . 7); ?>">
                                        <td class="trVOE"><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ',' . $value['var_variant_name']; ?></td>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : ''; ?>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . $value['shr_location'] . '</td>' : ''; ?>
                                        <td class="trVOE"><?php echo ($value['usr_id'] == $value['enq_added_by']) ? 'Self' : strtoupper($value['enq_added_by_name']) ?></td>
                                        <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']); ?></td>
                                        <td class="trVOE"><?php echo $value['enq_cus_mobile']; ?></td>
                                        <td class="trVOE"><?php echo $value['enq_cus_email']; ?></td>
                                        <td class="trVOE"><?php echo $value['enq_cus_whatsapp']; ?></td>
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
