
<?php 
  
 // $res = $this->reports->isRptExpectBooking(42,5);
  foreach ($expectDeliveries as $key => $value) {
  $res = $this->reports->isRptExpectDelivery($value['ed_veh_id'],$value['ed_id'],$value['ed_sale_staff']); 
    $isBooked = $this->reports->isBookedOrDelivered($value['ed_val_id'],28);
    $isDelivered = $this->reports->isBookedOrDelivered($value['ed_val_id'],40);
    
  ?>
<tr class="hdr singleline <?php echo $isBooked ? 'bgGreen':''; echo $isDelivered ? 'bgGreenDark':'' ?>">
     <td><?php
            //print_r($expectDeliveries);
           // echo '<br>Val='.$value['ed_val_id'].'<br>';
   // echo 'id:-'.$value['ed_id'].'veh:-'.$value['ed_veh_id'];
      echo'<br>'. $key+1?> </td>
     <td><?php echo date('d-m-Y', strtotime($value['ed_created_at']));
           foreach ($res as $k => $c_date) {
           echo '<br>'. date('d-m-Y', strtotime($c_date['ed_created_at']));
      }
     ?> </td>
     <td><?php 
       $shrm= unserialize(Showrooms)[$value['ed_showroom_id']];
       echo $shrm ;?></td>
      <td><?php echo date('d-m-Y', strtotime($value['ed_enq_date']));?></td>
     <td><?php echo $value['sale_staff'];?></td>
     <td><?php echo $value['asm_name'];?></td>
     <td><?php echo $value['ed_cus_name'];?> </td>
     <td><?php echo $value['ed_cus_phone'];?></td>
     <td><?php echo $value['ed_reg_no'];?></td>
     <td><?php echo $value['brd_title'].','.$value['mod_title'];?> </td>
     <td><?php 
            $modOfEnq=unserialize(MODE_OF_CONTACT)[$value['ed_mode_of_sale']];
       echo $modOfEnq;?> </td>
     <td><?php echo date('d-m-Y', strtotime($value['ed_expected_full_payment']));?></td>
    

</tr>

<?php } ?>
<style>
     .bgGreen{
          background-color:#479347a8 !important;
          color :black;
     }
      .bgGreenDark{
          background-color:#3c8f3cc7 !important;
          color :black;
     }
     </style>