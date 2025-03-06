<style>
     .alert {
          padding: 10px;
          color: white;
          position: fixed;
          width: 30%;
          z-index: 9999999;
          bottom: 0;
          right: 0;
          margin: 2%;
     }

     .close {
          top: auto !important;
          right: auto !important;
     }
</style>

<?php if ($success = $this->session->flashdata('app_success')):?>
       <div class="alert alert-success alert-dismissible fade in msgBox" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong><?php echo $success?></strong>
       </div>
  <?php endif?>

<!--<div class="alert alert-success alert-dismissible fade in msgBox" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong class="sus_msg"><?php echo $success?></strong>
</div>-->

<div style="position: fixed;top: 0px;left: 0px;bottom: 0px;right: 0px; z-index: 99999;background-color:rgba(0, 0, 0, 0.1);width: 100%;height: 100%;display: none;" class="divLoading">
     <img src="images/loading.gif" style="position: absolute;z-index: 99999;top: 50%;left: 50%;width: 150px;"/>
</div>
<?php if ($app_success_pop = $this->session->flashdata('app_success_pop')):?>
       <div class="modal fade popupMessage" role="dialog">
            <div class="modal-dialog">
                 <!-- Modal content-->
                 <div class="modal-content">
                      <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <h4 class="modal-title">Alert!</h4>
                      </div>
                      <div class="modal-body">
                           <p><?php echo $app_success_pop;?></p>
                      </div>
                      <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                 </div>

            </div>
       </div>
  <?php endif
?>
<div class="modal fade" role="dialog" id="msgBox" style="display: none;z-index: 99999;">
     <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert!</h4>
               </div>
               <div class="modal-body ">
                    <p class="sus_msg"></p>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
          </div>
     </div>
</div>
