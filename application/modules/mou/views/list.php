<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>MOU</h2>
                    <div style="float: right;">
                        <i class="fa fa-circle" style="color: red;"> Approval pending </i>
                        <i class="fa fa-circle" style="color: green;"> Approved </i>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <a href="<?php echo site_url('mou/add'); ?>" class="btn btn-round btn-primary">
                            <i class="fa fa-pencil-square-o"></i> Create MOU
                        </a>
                    </div>
                    <table id="tblMOU" class="table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Division</th>
                                <th>Showroom</th>
                                <th>MOU Number</th>
                                <th>MOU Date</th>
                                <th>Reg No</th>
                                <th>Vehicle</th>
                                <th>Engine No</th>
                                <th>Chassis No</th>
                                <th>Purchase Place</th>
                                <th>Customer</th>
                                <th>Customer Number</th>
                                <th>Customer Father</th>
                                <th>Age</th>
                                <th>Address</th>
                                <th>Pin</th>
                                <th>District</th>
                                <th>Purchase Staff</th>
                                <th>Net Price</th>
                                <th>EC</th>
                                <th>Advance</th>
                                <th>Approved On</th>
                                <th>MOU</th>
                                <th>Share</th>
                                <th>Copy MOU</th>
                                <?php if (check_permission('mou', 'forceapproval')) { ?>
                                    <th>Approve</th>
                                <?php }
                                if (check_permission('mou', 'delete')) { ?>
                                    <th>Delete</th>
                                <?php  } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($moulist)) {
                                foreach ($moulist as $key => $value) {
                                    $trStyle = !empty($value['moum_approved_on']) ? 'style="background-color: green;color:#fff"' : 'style="background-color: red;color:#fff"';
                            ?>
                                    <tr <?php echo $trStyle; ?> class="trMOU<?php echo $value['moum_id']; ?>">
                                        <td><?php echo $value['div_name']; ?></td>
                                        <td><?php echo $value['shr_location']; ?></td>
                                        <td><?php echo $value['moum_number']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($value['moum_date'])); ?></td>
                                        <td><?php echo $value['moum_reg_num']; ?></td>
                                        <td><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?>
                                        </td>
                                        <td><?php echo $value['moum_engine_number']; ?></td>
                                        <td><?php echo $value['moum_chassis_number']; ?></td>
                                        <td><?php echo $value['moum_purchase_place']; ?></td>
                                        <td><?php echo $value['moum_customer_name']; ?></td>
                                        <td><?php echo $value['moum_cust_phone']; ?></td>
                                        <td><?php echo $value['moum_father_name']; ?></td>
                                        <td><?php echo $value['moum_age']; ?></td>
                                        <td><?php echo $value['moum_address']; ?></td>
                                        <td><?php echo $value['moum_pin']; ?></td>
                                        <td><?php echo $value['std_district_name']; ?></td>
                                        <td><?php echo $value['usr_username'] . ' (' . $value['desig_title'] . ')'; ?></td>
                                        <td><?php echo $value['moum_net_price']; ?></td>
                                        <td><?php echo $value['moum_bl_amt']; ?></td>
                                        <td><?php echo $value['moum_adv_token']; ?></td>
                                        <td><?php echo !empty($value['moum_approved_on']) ? date('d-m-Y H:i:s', strtotime($value['moum_approved_on'])) : ''; ?>
                                        </td>
                                        <td><a href="<?php echo site_url('mou/view/' . $value['moum_token']); ?>"><i class="fa fa-print"></i></a></td>
                                        <td>
                                            <?php if (!empty($value['moum_cust_phone'])) { ?>
                                                <a target="_blank" href="https://wa.me/<?php echo $value['moum_cust_phone']; ?>/?text= <?php echo 'https%3A%2F%2Fcust.royaldrive.in%2Findex.php%2Fmou%2Fview%2F' . $value['moum_token']; ?>"><i class="fa fa-whatsapp"></i></a>
                                            <?php } ?>

                                        </td>
                                        <td><i style="cursor:pointer;" data-txt="<?php echo 'https://cust.royaldrive.in/index.php/mou/view/' . $value['moum_token']; ?>" onclick="copyToClip(this)" class="fa fa-copy"></i></td>
                                        <?php if (check_permission('mou', 'forceapproval')) {
                                            if (empty($value['moum_approved_on'])) { ?>
                                                <td>
                                                    <a href="<?php echo site_url('mou/approve/' . $value['moum_id']); ?>">Approve</a>
                                                </td>
                                            <?php } else { ?>
                                                <td>Approved</td>
                                            <?php }
                                        }
                                        if (check_permission('mou', 'delete')) { ?>
                                            <td>
                                                <a class="btnRemoveTableRow" href="javascript:void(0);" data-url="<?php echo site_url('mou/delete/' . $value['moum_id']); ?>"><i title="Delete" class="fa fa-trash"></i></a>
                                            </td>
                                        <?php }  ?>
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

<script>
    function copyToClip(th) {
        console.time('time1');
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($(th).data('txt')).select();
        document.execCommand("copy");
        temp.remove();
        console.timeEnd('time1');
    }
    $(document).ready(function() {

        $('#tblMOU').DataTable({
            "order": [
                [1, "asc"]
            ],
            "scrollX": true,
            "pageLength": 20
        });
        // $(document).on('click', '.btnSubmit', function(e) {
        //     var url = $(this).data('url');
        //     var mouId = $(this).data('id');
        //     var name = $(this).data('descname');
        //     var txtDesc = $('.' + name).val().trim();
        //     if (txtDesc == '' || (txtDesc.length < 5)) {
        //         alert('Please enter description at least 30 characters');
        //     } else {
        //         $.ajax({
        //             type: 'post',
        //             url: url,
        //             dataType: 'json',
        //             data: {
        //                 'desc': txtDesc
        //             },
        //             success: function(resp) {
        //                 $('#exampleModal' + mouId).modal('toggle');
        //                 $('.divApproval' + mouId).html('Approved');
        //                 $('.trMOU' + mouId).css({
        //                     "background-color": "green",
        //                     "color": "#fff"
        //                 });
        //             }
        //         });
        //     }
        // });
    });
</script>

<style>
    a {
        color: unset;
    }
</style>