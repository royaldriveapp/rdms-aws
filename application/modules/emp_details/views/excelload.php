<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Import staff details</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <a href="./uploads/staffmaster.xlsx">
                                        <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                   </a>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url($controller . '/excelload'); ?>" method="post" class="frmImportExcel" enctype="multipart/form-data">
                              <table>
                                   <tr>
                                        <td>
                                             <input name="uploadDocument" type="file" required/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary"><i class="fa fa-upload"> Import</i></button>
                                        </td>
                                   <tr>
                              </table>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>