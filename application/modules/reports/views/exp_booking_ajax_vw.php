
<?php 
  
 // $res = $this->reports->isRptExpectBooking(42,5);
  foreach ($expectBookings as $key => $value) {
  $res = $this->reports->isRptExpectBooking($value['eb_veh_id'],$value['eb_id'],$value['eb_sale_staff']); 
    $isBooked = $this->reports->isBookedOrDelivered($value['eb_val_id'],28);
    $isDelivered = $this->reports->isBookedOrDelivered($value['eb_val_id'],40);
    
  ?>
<tr class="hdr singleline <?php echo $isBooked ? 'bgGreen':''; echo $isDelivered ? 'bgGreenDark':'' ?>">
     <td><?php
//            print_r($isBooked);
//            echo '<br>Val='.$value['eb_val_id'].'<br>';
//    echo 'id:-'.$value['eb_id'].'veh:-'.$value['eb_veh_id'];
      echo'<br>'. $key+1?> </td>
     <td><?php echo date('d-m-Y', strtotime($value['eb_created_at']));
     
      foreach ($res as $k => $c_date) {
           echo '<br>'. date('d-m-Y', strtotime($c_date['eb_created_at']));
      }
     ?> </td>
     <td><?php 
       $shrm= unserialize(Showrooms)[$value['eb_showroom_id']];
       echo $shrm ;?></td>
      <td><?php echo date('d-m-Y', strtotime($value['eb_enq_date']));?></td>
     <td><?php echo $value['sale_staff'];?></td>
     <td><?php echo $value['asm_name'];?></td>
     <td><?php echo $value['eb_cus_name'];?> </td>
     <td><?php echo $value['eb_cus_phone'];?></td>
     <td><?php echo $value['eb_reg_no'];?></td>
     <td><?php echo $value['brd_title'].','.$value['mod_title'];?> </td>
     <td><?php 
            $modOfEnq=unserialize(MODE_OF_CONTACT)[$value['eb_mode_of_sale']];
       echo $modOfEnq;?> </td>
     <td><?php echo date('d-m-Y', strtotime($value['eb_expected_delivery_date']));?></td>
     <td>
          <?php// echo $value['eb_remarks'];?>
          <?php echo $isBooked ?'Booked':($isDelivered ? 'Delivered':($value['eb_remarks'])) ?>
     </td>

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