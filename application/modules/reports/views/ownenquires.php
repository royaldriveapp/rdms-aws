<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Own enquires between 2023-10-01 and 2023-10-31 <span class="small">&nbsp;(Report generated based
                            on DAR submission)</span></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Sales/Purchase officer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($datas)) {
                                foreach ($datas as $key => $value) { ?>
                                    <tr>
                                        <th><?php echo $value['dare_enq_customer']; ?></th>
                                        <th><?php echo $value['dare_enq_mobile']; ?></th>
                                        <th><?php echo $value['ab_usr_username']; ?></th>
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