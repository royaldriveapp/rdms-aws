<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Register pending reports on <?php echo date('d-m-Y', strtotime("-1 days")); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Pending registers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pendingRegister['yesterday'])) {
                                foreach ($pendingRegister['yesterday'] as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $value['assign_usr_first_name']; ?></td>
                                        <td><?php echo $value['cnt']; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2>Register pending reports on today <?php echo date('d-m-Y'); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Pending registers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pendingRegister['today'])) {
                                foreach ($pendingRegister['today'] as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $value['assign_usr_first_name']; ?></td>
                                        <td><?php echo $value['cnt']; ?></td>
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
