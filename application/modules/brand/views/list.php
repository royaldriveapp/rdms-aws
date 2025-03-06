<style>
.clickable-row {
    cursor: pointer;
}
</style>

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Brand</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="brand-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Luxury</th>
                                <?php if (is_roo_user()): ?>
                                    <th>Delete</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var darTable = $('#brand-table').DataTable({
        "order": [],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": site_url + "brand/index_ajax",
            "type": "POST"
        },
        "columns": [
            { "data": "brd_title" },
            {
                "render": function(data, type, full, meta) {
                    var url = "<?php echo site_url($controller . '/makeluxury'); ?>/" + "<?php echo encryptor('" + full.brd_id + "'); ?>";
                    var checked = full.brd_section == 1 ? 'checked' : '';
                    var chkbx = '<label class="switch"><input type="checkbox" value="1" class="chkOnchange" ' + checked + ' data-url="' + url + '"><span class="slider round"></span></label>';
                    return chkbx;
                }
            },
            <?php if (is_roo_user()): ?>
                {
                    "render": function(data, type, full, meta) {
                        var deleteUrl = '<?php echo site_url("brand/delete/"); ?>/' + full.brd_id;
                        var content = '<a class="pencile deleteListItemDataTbl" href="javascript:void(0);" data-url="' + deleteUrl + '"><i class="fa fa-remove"></i></a>';
                        return content;
                    }
                },
            <?php endif; ?>
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $(nRow).addClass('clickable-row');
            return nRow;
        }
    });

    // Add click event handler to the row
    $('#brand-table tbody').on('click', 'tr', function(e) {
        // Exclude specific columns from the click event
        if ($(e.target).hasClass('chkOnchange') || $(e.target).hasClass('slider') || $(e.target).hasClass('fa')) {
            return;
        }
        var rowData = darTable.row(this).data();
        var brd_id = rowData['brd_id'];
        var url = "<?php echo site_url('brand/view/'); ?>/" + "<?php echo encryptor('" + brd_id + "'); ?>";
        
        if (url) {
            window.location.href = url;
        }
    });

});
</script>
