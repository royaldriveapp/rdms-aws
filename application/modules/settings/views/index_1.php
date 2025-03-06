<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add New Employee</h2>
                    <span>
                        <a href="https://cust.royaldrive.in/cronelive/sceduler">Push</a>
                    </span>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div class="tabbable portlet-tabs">
                        <ul class="nav nav-tabs pull-left">
                            <li class="active"><a href="#carAnniversary" data-toggle="tab">Car Anniversary</a></li>
                            <li><a href="#stafBirthday" data-toggle="tab">Staf Birthday</a></li>
                            <li><a href="#stafWorkAnni" data-toggle="tab">Staf Work Anniversary</a></li>
                            <li><a href="#stafMarAnni" data-toggle="tab">Staf Marriage Anniversary</a></li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="carAnniversary">
                                <div class="widget-body">
                                    <table class="datatable-resp table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Vehicle</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                       foreach ((array) $data['carAnniversary'] as $key => $value) {
                                                       ?>
                                            <tr>
                                                <td><?php echo $value['vbk_cust_name']; ?></td>
                                                <td><?php echo $value['vbk_per_ph_no']; ?></td>
                                                <td>
                                                    <?php echo $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['var_variant_name']; ?>
                                                </td>
                                                <td><?php echo $value['vbk_delivery_date']; ?></td>
                                            </tr>
                                            <?php
                                                       }
                                                       ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane " id="stafBirthday">
                                <div class="widget-body">
                                    <table class="datatable-resp table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                       foreach ((array) $data['stafBirthday'] as $key => $value) {
                                                       ?>
                                            <tr>
                                                <td><?php echo $value['usr_username']; ?></td>
                                                <td><?php echo $value['usr_dob']; ?></td>
                                            </tr>
                                            <?php
                                                       }
                                                       ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="stafWorkAnni">
                                <div class="widget-body">
                                    <table class="datatable-resp table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                       foreach ((array) $data['stafWorkAnni'] as $key => $value) {
                                                       ?>
                                            <tr>
                                                <td><?php echo $value['usr_username']; ?></td>
                                                <td><?php echo $value['usr_doj']; ?></td>
                                            </tr>
                                            <?php
                                                       }
                                                       ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="stafMarAnni">
                                <div class="widget-body">
                                    <table class="datatable-resp table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                       foreach ((array) $data['stafMarAnni'] as $key => $value) {
                                                       ?>
                                            <tr>
                                                <td><?php echo $value['usr_username']; ?></td>
                                                <td><?php echo $value['usr_marriage_date']; ?></td>
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
            </div>
        </div>
    </div>
</div>