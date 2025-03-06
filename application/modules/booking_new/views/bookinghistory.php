<div class="timeline-container">
     <ul class="book-timeline">
          <?php
          if (!empty($histry)) {
               foreach ($histry as $key => $value) {
                    ?>
                    <li>
                         <div class="timeline-time">
                              <span class="date"><?php echo date('d-m-Y', strtotime($value['enh_added_on'])); ?></span>
                              <span class="time"><?php echo date('h:i A', strtotime($value['enh_added_on'])); ?></span>
                         </div>
                         <div class="timeline-icon">
                              <a href="javascript:;">&nbsp;</a>
                         </div>
                         <div class="timeline-body">
                              <div class="timeline-header">
                                   <span class="userimage">
                                        <?php
                                        if (file_exists('assets/uploads/avatar/' . $value['addby_usr_avatar'])) {
                                             echo img(array('src' => 'assets/uploads/avatar/' . $value['addby_usr_avatar']));
                                        } else {
                                             ?><img src="https://www.w3schools.com/howto/img_avatar.png" alt="sdasd"><?php
                                        }
                                        ?>
                                   </span>
                                   <span class="username">
                                        <a href="javascript:;">
                                             <?php echo $value['addby_first_name'] . ' ' . $value['addby_last_name']; ?>
                                        </a>
                                   </span>
                              </div>
                              <div class="timeline-content">
                                   <p>
                                        <?php echo $value['enh_remarks']; ?>
                                   </p>
                              </div>
                         </div>
                    </li>
                    <?php
               }
          }
          ?>
     </ul>
</div>