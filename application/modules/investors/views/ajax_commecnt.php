<li>
     <div class="timeline-time">
          <span class="date"><i class="fa fa-calendar" style="margin-right: 5px;"></i>
               <?php echo date('d-m-Y', strtotime($datas['invf_added_on'])); ?>
          </span>
     </div>
     <div class="timeline-icon">
          <a href="javascript:;">&nbsp;</a>
     </div>
     <div class="timeline-body">
          <div class="timeline-header">
               <span class="userimage">
                    <?php
                    if (file_exists('assets/uploads/avatar/' . $datas['usr_avatar'])) {
                         echo img(array('src' => 'assets/uploads/avatar/' . $datas['usr_avatar']));
                    } else {
                         ?>
                         <img src="https://www.w3schools.com/howto/img_avatar.png" alt="">
                    <?php } ?>
               </span>
               <span class="username">
                    <a href="javascript:;">
                         <?php echo $datas['usr_first_name'] . ' ' . $datas['usr_last_name']; ?>
                    </a>
               </span>
          </div>
          <div class="timeline-content">
               <p>
                    <?php echo $datas['invf_comment']; ?>
               </p>
          </div>
     </div>
</li>