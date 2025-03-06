
<style>
     .filter{
          margin-bottom: 10px;
     }
     .btn-round{
          margin-left: 10px;  
     }
     .noDataMessage{
          text-align: center;
     }
     .lbl-blk{
          color: black !important; 
     }
     .tbl{ overflow-x: auto;
           overflow-y: hidden;
     }
     /*      .tbl-blk{
                      background-color:#98cdd9; 
                    border: 3px dotted #fffffff2;
          }*/
     table, th, td {
          border: 1px solid black !important;
     }

     .tbl-pitch{
          background-color:#474a56; 
          border: 4px dotted #fffffff2;
     }
     .bg-clr {
          background-color: #2b27271c !important;
          border: 1px solid #dfe1e6 !important;
          padding: 20px !important;
          box-shadow: 14px 1px 14px 3px #6f81a8f5 !important;
     }
     .singleline { white-space: nowrap; overflow: hidden; text-overflow:ellipsis; }
     .hdr{   
          background-color: #ededed!important;
          color: black!important;
     }
     .total{
          background-color: #F4B084!important;
          color: black!important;  
     }
     .qlt{
          background-color:#ACB9CA!important;
          color: black!important; 
     }

     .td-total{
          background-color: #F8CBAD!important;
          color: black!important;  
     }
     .qlt{
          background-color:#BDD7EE!important;
          color: black!important; 
     }
     .txtBlk{
          color: black !important;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2 class="txtBlk">Price list</h2>
   <ul class="nav navbar-right panel_toolbox">
                                             <li style="float: right;">
                                                  
                                                       <a href="<?php echo site_url('reports/price_list_export_excel?' . $_SERVER['QUERY_STRING']); ?>">
                                                            <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                                       </a>
                                                
                                             </li>

                                           
                                        </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row filter">
                              <form action="<?php echo site_url('reports/price_list_test_new');?>" method="get" id="filterForm">
                                   
                                     <table>
                                   <tr>
                                        <td>
                                             <input Type="text" class="form-control" name="part_1">
                                        </td>
                                        <td>
                                        <input Type="text" class="form-control" name="part_2">
                                        </td>
                                        <td>
                                        <input Type="text" class="form-control" name="part_3">
                                        </td>
                                        <td>
                                        <input Type="text" class="form-control" name="part_4">
                                        </td>
                              
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                             
                              
                              </table>

<!--                                   <td style="margin: 10px;">
                                        <?php
                                             $default_shrm = $this->shrm == 0 ? 1 : $this->shrm;
                                          if(isset($showroom)){
                                               $default_shrm=$showroom;
                                          }elseif ($this->shrm==0) {
                                            $default_shrm=1;   
                                          }
                                        $showrooms = unserialize(Showrooms);
                                        ?>
                                        <select  name="showroom" class="select2_group " >
                                             <?php foreach ($showrooms as $key => $showroom) {?>
                                                    <option <?php echo $key == $default_shrm ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $showroom;?></option>
                                               <?php }?>
                                        </select>
                                   </td>
                                
                                   <input type="hidden" value="" id="page">

                                   <td style="margin: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
-->
                              </form>
                         </div>
 