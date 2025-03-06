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
                    <h2>Vehicle colors list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div style="padding: 20px 0px;">
                         <div class="btn-group">
                              <a href="<?php echo site_url($controller . '/add');?>" class="btn btn-primary">Add New Color</a>
                         </div>
                    </div>
                    <div class="x_content">
                         <table id="dar-table" class="table table-striped table-bordered">
                              <thead>
                              <tr>
                                        <th class="">Color</th>
                                        <th class="">Delete</th>    
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

    var darTable = $('#dar-table').DataTable({
        "order": [],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": site_url + "color/index_ajax",
            "type": "POST"
        },
        "columns": [
            {
                "data": "vc_color",
              
            },
          
            {
                    "render": function(data, type, full, meta) {
                        var deleteUrl = '<?php echo site_url("color/delete/"); ?>/' + full.vc_id;
                        var content = '<a class="btnRemoveTableRow" href="javascript:void(0);" data-url="' + deleteUrl + '"><i title="Delete" class="fa fa-trash"></i></a>';
                        return content;
                    }
                },
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
         
            $(nRow).addClass('clickable-row');
            return nRow;
        }
    });

    // Add click event handler to the row
    $('#dar-table tbody').on('click', 'tr', function(e) {
     if ($(e.target).hasClass('btnRemoveTableRow') || $(e.target).hasClass('fa')) {
            return;
        }
        
        var rowData = darTable.row(this).data();
        var vc_id = rowData['vc_id'];
        var url = "<?php echo site_url('color/update/'); ?>/" + "<?php echo encryptor('" + vc_id + "'); ?>";
        
        if (url) {
            window.location.href = url;
        }
    });


});
</script>
