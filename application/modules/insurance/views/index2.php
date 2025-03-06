<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                    <h2>Comapny Vehicle Insurance Renewel</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="stock-table"class="table table-striped table-bordered">
                         <thead>
                                   <tr>
                                        <?php //if($this->uid == 100) { ?>
                                             <th>Val ID</th>
                                        <?php //} ?>
                                        <th>Reg No</th>
                                        <th>Vehicle</th>
                                        <th>Ins Company</th>
                                        <th>Ins Validity</th>
                                        <th>Validity (in days)</th>
                                   </tr>
                              </thead>
                         </table>

                    </div>
               </div>
          </div>
     </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<script>
     $(document).ready(function() {
  $canedit = "<?php echo check_permission('insurance', 'updateins') ? 'trVOE' : '';?>";
  var uid = '<?php echo $this->uid?>';

  $('#stock-table').DataTable({
    "order": [],
    "processing": true,
    "serverSide": true,
    "serverMethod": "post",
    "ajax": site_url + "insurance/stock_ajax",
    "columns": [
      {
        "mData": null,
        "bSortable": true,
        "mRender": function(data, type, full, meta) {
          var url = "<?php echo site_url('insurance/updateins/'); ?>/" + "<?php echo encryptor('" + full.val_id + "'); ?>";
          if (uid == 100) {
            if ($canedit) {
              return "<a href='" + url + "'>" + full.val_id + "</a>";
            } else {
              return full.val_id;
            }
          } else {
            return '';
          }
        }
      },
      {
        "sortable": false,
        "render": function(data, type, full, meta) {
          var url = "<?php echo site_url('insurance/updateins/'); ?>/" + "<?php echo encryptor('" + full.val_id + "'); ?>";
          return "<a href='" + url + "'>" + full.val_veh_no + "</a>";
        }
      },
      {
        "data": "brd_title"
      },
      {
        "data": "val_insurance_company"
      },
      {
        "sortable": false,
        "render": function(data, type, full, meta) {
          var exp_date = new Date(full.val_insurance_comp_date).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-');
          return exp_date;
        }
      },
      {
        "sortable": false,
        "render": function(data, type, full, meta) {
          var exp_date = new Date(full.val_insurance_comp_date);
          var today = new Date();
          var time_difference = exp_date.getTime() - today.getTime();
          var days_difference = Math.floor(time_difference / (1000 * 60 * 60 * 24));
          return days_difference;
        }
      },
    ],
    "buttons": [
      'copy',
      'excel',
      'pdf',
      'print'
    ],
    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
      var days_difference = parseFloat($('td:eq(5)', nRow).text());

      if (days_difference <= 8) {
        $('td', nRow).css('background-color', 'red');
        $('td', nRow).css('color', '#fff');
      } else if (aData['val_status'] == "1") {
        $('td', nRow).css('background-color', 'white');
        $('td', nRow).css('color', '#000');
      }
    }
  });
});

</script>




