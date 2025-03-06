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
          <h2>Tracking</h2>
          <ul class="nav navbar-right panel_toolbox">
            <?php if (check_permission('tracking', 'exportTracking')) : ?>
              <li style="float: right;">
                <a href="<?php echo site_url('tracking/exportGatePass?' . $_SERVER['QUERY_STRING']); ?>">
                  <img width="20" title="Export to excel" src="images/excel-export.png" />
                </a>
              </li>
              <!-- <li style="float: right;">
                <a href="<?php echo site_url('tracking/exportTracking?' . $_SERVER['QUERY_STRING']); ?>">
                  <img width="20" title="Export to excel" src="images/excel-export.png" />
                </a>
              </li> -->
            <?php endif; ?>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="dar-table" class="table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
            <thead>
              <tr>
                <th>Track No</th>
                <th>Reg No</th>
                <th>Vehicle</th>
                <th>Booking No</th>
                <th>Out pass on</th>
                <th>Issued by</th>
                <th>Driver</th>
                <th>Check in by</th>
                <th>Place</th>
                <!--<th>Est return on</th>-->
                <th>Return on</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$showSubmittedBy = (is_roo_user() || $this->usr_grp == 'MG') ? 1 : 0;
$showRevenueAndChallenges = ($this->usr_grp != 'DE') ? 1 : 0;
$showShowroomAndTL = (is_roo_user() || $this->usr_grp == 'MG') ? 1 : 0;
$showManager = (is_roo_user()) ? 1 : 0;
$permission = (check_permission('tracking', 'update') == 1) ? 1 : 0;
?>

<script>
  $(document).ready(function() {
    var permission = <?php echo $permission; ?>;
    var darTable = $('#dar-table').DataTable({
      "order": [],
      "scrollX": true,
      "processing": true,
      "serverSide": true,
      "serverMethod": "post",
      "ajax": site_url + "tracking/list_ajax",

      "columns": [{
          "data": "trk_number"
        },
        {
          "data": "val_veh_no"
        },
        {
          "mData": null,
          "bSortable": true,
          "mRender": function(data, type, row) {
            return row.brd_title + ', ' + row.mod_title + ', ' + row.var_variant_name;
          }
        },
        {
          "data": "vbk_ref_no"
        },
        {
          "render": function(data, type, full, meta) {
            var dateTime = full.trk_out_pass_time.split(' ');
            var dateComponents = dateTime[0].split('-');
            var timeComponents = dateTime[1].split(':');
            var hours = parseInt(timeComponents[0]);
            var minutes = parseInt(timeComponents[1]);

            // Adjust hours for AM/PM format
            if (dateTime[2] === 'PM' && hours !== 12) {
              hours += 12;
            } else if (dateTime[2] === 'AM' && hours === 12) {
              hours = 0;
            }

            var date = new Date(dateComponents[2], dateComponents[1] - 1, dateComponents[0], hours, minutes);

            if (isNaN(date.getTime())) {
              return 'Invalid';
            }

            return date.toLocaleString('en-US', {
              day: 'numeric',
              month: 'short',
              year: 'numeric',
              hour: 'numeric',
              minute: 'numeric'
            });
          }
        },


        {
          "data": "added_first_name"
        },
        {
          "render": function(data, type, full, meta) {
            const driver = (full.usr_username && full.usr_username !== '') ?
              full.usr_username :
              full.trk_out_pass_other_driver;
            return driver;
          }

        },
        {
          "data": "checkin_by_first_name"
        },
        {
          "data": "trk_out_pass_to_place"
        },
        {

          "render": function(data, type, full, meta) {
            if (full.trk_check_in_date) {
              var dateTime = full.trk_check_in_date.split(' ');
              var dateComponents = dateTime[0].split('-');
              var timeComponents = dateTime[1].split(':');
              var hours = parseInt(timeComponents[0]);
              var minutes = parseInt(timeComponents[1]);

              // Adjust hours for AM/PM format
              if (dateTime[2] === 'PM' && hours !== 12) {
                hours += 12;
              } else if (dateTime[2] === 'AM' && hours === 12) {
                hours = 0;
              }

              var date = new Date(dateComponents[2], dateComponents[1] - 1, dateComponents[0], hours, minutes);

              if (isNaN(date.getTime())) {
                return 'Invalid';
              }

              return date.toLocaleString('en-US', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                hour: 'numeric',
                minute: 'numeric'
              });
            } else {
              return '';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            var trk_id = full.trk_id;
            var url = "<?php echo site_url('tracking/update/'); ?>/" + "<?php echo encryptor('" + trk_id + "'); ?>";
            return permission ? '<a href="' + url + '" class="btn btn-primary">Edit</a>' : '';
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
        if (!aData['trk_check_in_date']) {
          $(nRow).find('td').css({
            'background-color': 'red',
            'color': '#fff'
          });
        }

        $(nRow).addClass('clickable-row');
        return nRow;
      }
    });
    $('#dar-table tbody').on('click', 'tr', function() {
      var rowData = darTable.row(this).data();
      var darm_id = rowData['trk_id'];
      var url = "<?php echo site_url('tracking/check_in'); ?>/" + "<?php echo encryptor('" + darm_id + "'); ?>";

      if (url) {
        window.location.href = url;
      }
    });

  });
</script>