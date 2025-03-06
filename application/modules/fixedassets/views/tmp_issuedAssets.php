<?php
if (!empty($assets)) {
     foreach ($assets as $key => $value) {
?>
          <tr>
               <td><input type="checkbox" name="asset[issueId][<?php echo $value['fai_id']; ?>]" value="1"></td>
               <td><?php echo $value['fap_number']; ?></td>
               <td><?php echo $value['fap_name']; ?></td>
               <td><?php echo $value['fac_title']; ?></td>
               <td><?php echo $value['facm_title']; ?></td>
               <td><?php echo $value['fap_slno']; ?></td>
               <td><?php echo $value['fap_warty_till']; ?></td>
               <td><?php echo date('d-m-Y', strtotime($value['fai_issue_date'])); ?></td>
               <td><input type="text" class="select2_group form-control" name="asset[cmnts][<?php echo $value['fai_id']; ?>]" /></td>
          </tr>
<?php
     }
}
?>