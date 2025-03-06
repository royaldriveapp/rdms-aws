<div class="materialContainer">
     <div class="box">
          <?php echo form_open('user/login', array('class' => 'frmLogin'))?>
          <div class="title">LOGIN</div>
          <div class="input">
               <label for="identity">Username</label>
               <?php echo form_input($identity) ?>
               <span class="spin"></span>
          </div>
          <div class="input">
               <label for="password">Password</label>
               <?php echo form_input($password) ?>
               <span class="spin"></span>
          </div>
          <div class="button login">
               <button type="submit" class="submitMe"><span>GO</span><i class="fa fa-check"></i></button>
          </div>
          <?php echo form_close()?>
          <a href="javascript:;" class="login-error"><?php echo $this->session->flashdata('app_error'); ?></a>
     </div>
     <!--     <div class="overbox">
               <div class="material-button alt-2"><span class="shape"></span></div>
               <div class="title">REGISTER</div>
               <div class="input">
                    <label for="regname">Username</label>
                    <input type="text" name="regname" id="regname">
                    <span class="spin"></span>
               </div>
               <div class="input">
                    <label for="regpass">Password</label>
                    <input type="password" name="regpass" id="regpass">
                    <span class="spin"></span>
               </div>
               <div class="input">
                    <label for="reregpass">Repeat Password</label>
                    <input type="password" name="reregpass" id="reregpass">
                    <span class="spin"></span>
               </div>
               <div class="button">
                    <button><span>NEXT</span></button>
               </div>
          </div>-->
</div>