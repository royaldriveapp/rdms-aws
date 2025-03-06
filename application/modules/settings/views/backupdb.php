<div class="row-fluid">
     <div class="span12">
          <div class="widget red">
               <div class="widget-title">
                    <h4><i class="icon-list-ul"></i> <?php echo $this->section; ?></h4>
               </div>

               <div class="row-fluid">
                    <div class="span12">
                         <div class="widget-body">
                              <button 
                                   data-url="<?php echo site_url('settings/doBckupdb'); ?>" type="button" class="btn btn-primary btnBackupDb">Backup database</button>
                         </div>
                    </div>
               </div>

               <div class="widget-body">
                    <table class="table table-bordered table-striped" id="sample">
                         <thead>
                              <tr>
                                   <th>Icon</th>
                                   <th>Name</th>
                                   <th>Description</th>
                                   <th>Edit</th>
                                   <th>Delete</th>    
                              </tr>
                         </thead>
                         <tfoot>
                              <tr>
                                   <th>Icon</th>
                                   <th>Name</th>
                                   <th>Description</th>
                                   <th>Edit</th>
                                   <th>Delete</th>    
                              </tr>
                         </tfoot>
                         <tbody>
                         </tbody>
                    </table>
               </div>
          </div>
     </div>
</div>