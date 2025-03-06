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
                    <h2>Model</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="model-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th class="">Model</th>
                                        <th class="">Brand</th>
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
    var darTable = $('#model-table').DataTable({
        "order": [],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": site_url + "model/index_ajax",
            "type": "POST"
        },
        "columns": [
            { "data": "mod_title" },
            { "data": "brd_title" },
            <?php if (is_roo_user()): ?>
                {
                    "render": function(data, type, full, meta) {
                        var deleteUrl = '<?php echo site_url("model/delete/"); ?>/' + full.mod_id;
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
    $('#model-table tbody').on('click', 'tr', function(e) {
        // Exclude specific columns from the click event
        if ($(e.target).hasClass('chkOnchange') || $(e.target).hasClass('slider') || $(e.target).hasClass('fa')) {
            return;
        }
        var rowData = darTable.row(this).data();
        var mod_id = rowData['mod_id'];
        var url = "<?php echo site_url('model/view/'); ?>/" + "<?php echo encryptor('" + mod_id + "'); ?>";
        
        if (url) {
            window.location.href = url;
        }
    });

});
</script>
