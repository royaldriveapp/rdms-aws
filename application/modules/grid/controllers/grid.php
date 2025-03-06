<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class grid extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Vehcle grid';
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            $this->load->model('grid_model', 'grid');
            $this->load->model('showroom/showroom_model', 'showroom');//rmv
            $this->load->model('emp_details/emp_details_model', 'emp_details');//rmv
       }
       public function indexk() {
            $data['gridVehicles'] = $this->grid->getgrid();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

function qry(){

//      UPDATE grid_new
// SET brand_id = (
//     SELECT brd_id
//     FROM rana_brand
//     WHERE rana_brand.brd_title = grid_new.brand
// )
// WHERE EXISTS (
//     SELECT 1
//     FROM rana_brand
//     WHERE rana_brand.brd_title = grid_new.brand
// );


/*UPDATE grid_new
JOIN rana_model ON grid_new.model = rana_model.mod_title AND grid_new.brand_id = rana_model.mod_brand
SET grid_new.model_id = rana_model.mod_id;*/

// UPDATE grid_new
// JOIN grid_models ON grid_new.model = grid_models.gmod_model AND grid_new.brand_id = grid_models.gmod_brand_id
// SET grid_new.model_id = grid_models.gmod_id;


// UPDATE grid_new
// JOIN cpnl_grid_master ON grid_new.brand = cpnl_grid_master.grd_brand
//                       AND grid_new.model = cpnl_grid_master.grd_model
//                       AND grid_new.variant = cpnl_grid_master.grd_variant
// SET grid_new.grdtl_master_id = cpnl_grid_master.grd_id;

// UPDATE grid_variant_xl
// JOIN grid_models_xl ON grid_variant_xl.gvar_model = grid_models_xl.gmod_model AND grid_variant_xl.gvar_brand_id = grid_models_xl.gmod_brand_id
// SET grid_variant_xl.gvar_model_id = grid_models_xl.gmod_id;

// UPDATE grid_details_xl
// JOIN grid_models_xl ON grid_details_xl.grdtl_brand = grid_models_xl.gmod_brand
//                       AND grid_details_xl.grdtl_model = grid_models_xl.gmod_model
// SET grid_details_xl.grdtl_model_id = grid_models_xl.gmod_id;


}
    
     //   function index() {
     //      $data['brand'] = $this->enquiry->getBrands();
     //        $this->render_page(strtolower(__CLASS__) . '/grid_list', $data);
     //   }
       function grid_ajax() {
            $response = $this->grid->getData($this->input->post(),$this->input->get());
  echo json_encode($response);
            exit;
       }
       public function list($category=1) {//new
          $data['allShowrooms'] = $this->showroom->get();//rmv
          $shrm=!empty($_GET['showroom'])?$_GET['showroom']:1;//rmv
          $data['showroom']=$shrm;//rmv
          $data['users'] = $this->emp_details->getSaleStaffs($shrm);//rmv
          $data['trgt_category']=$category;//rmv
         $this->render_page(strtolower(__CLASS__) . '/staff_target_list', $data);
    }
    public function list_new($category=1) {//new
     $data['brands'] = $this->enquiry->getBrands();
     $data['allShowrooms'] = $this->showroom->get();//rmv
     $shrm=!empty($_GET['showroom'])?$_GET['showroom']:1;//rmv
     $data['showroom']=$shrm;//rmv
     $data['users'] = $this->emp_details->getSaleStaffs($shrm);//rmv
     $data['trgt_category']=$category;//rmv
    $this->render_page(strtolower(__CLASS__) . '/list_new', $data);
}
public function index() {//new
     $data['brands'] = $this->grid->getBrands();
   //  debug(  $data['brands'] ); exit;
     if($_GET['brand']){
     $data['models'] = $this->grid->getModelByBrand($_GET['brand']);
     }
     if($_GET['model']){
     $data['variants'] = $this->grid->getVariantByModel($_GET['model']);
     }
   // debug($data);
    $this->render_page(strtolower(__CLASS__) . '/grid_filter', $data);
}
public function card() {//new
     $data['brands'] = $this->grid->getBrands();
   //  debug(  $data['brands'] ); exit;
     if($_GET['brand']){
     $data['models'] = $this->grid->getModelByBrand($_GET['brand']);
     }
     if($_GET['model']){
     $data['variants'] = $this->grid->getVariantByModel($_GET['model']);
     }
     if($_GET['brand']&&$_GET['model']&&$_GET['variant']){
          $data['grid_data'] = $this->grid->getFilteredData($_GET);
     }
   // debug($data);
    $this->render_page(strtolower(__CLASS__) . '/card', $data);
}
public function edit() {//new
     if($_GET['id']){
          $data['data'] = $this->grid->edit($_GET['id']);
          debug($data['data']);
          }
   
    $this->render_page(strtolower(__CLASS__) . '/edit', $data);
}
public function calcGrid() {
     if($_POST['brand']&&$_POST['model']&&$_POST['variant']){
          $data['grid_data'] = $this->grid->getFilteredData($_POST);
     }
     echo json_encode($data);
}

public function bindModel($brdId = '', $dataType = 'json') {

     $id = isset($_POST['id']) ? $_POST['id'] : $brdId;
     $vehicle = $this->grid->getModelByBrand($id);
     if ($dataType == 'json') {
          echo json_encode($vehicle);
     } else {
          return $vehicle;
     }
}


function bindVarient($modelId = '', $dataType = 'json') {
     $id = isset($_POST['id']) ? $_POST['id'] : $modelId;
     $vehicle = $this->grid->getVariantByModel($id);
     if ($dataType == 'json') {
          echo json_encode($vehicle);
     } else {
          return $vehicle;
     }
}
public function create() {//new
     $data['brands'] = $this->enquiry->getBrands();
   
    
    $this->render_page(strtolower(__CLASS__) . '/create', $data);
}

function store() {
     if (!empty($_POST)) {
          //debug($_POST);
          $this->grid->store($_POST);
          debug($_POST);
          echo json_encode(array('status' => 'success', 'msg' => 'Row updated Successfully'));
     } 
}


function isExist($modelId = '', $dataType = 'json') {
     $id =$_GET['id'];
     //echo $id; 
     $data = $this->grid->isExist($id);
     if ($dataType == 'json') {
          echo json_encode($data);
     } else {
          return $data;
     }
}

public function excel() {//new
     $data= $this->grid->getExcel();
     debug($data);
     
    $this->render_page(strtolower(__CLASS__) . '/excel', $data);
}
function exportExl() {
     
     $data= $this->grid->getExcel();
  $this->load->library("excel");
     $objPHPExcel = new PHPExcel();
     $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
     $heading = array('brand', 'model', 'variant', 'owner', 'year', 'km', 'depreciation','price','year_range');
   //Loop Heading
     $rowNumberH = 1;
     $colH = 'A';
     foreach ($heading as $h) {
          $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
          $colH++;
     }

     //Loop Result
     $row = 2;
     $no = 1;

     if (!empty($data)) {
          foreach ($data as $key => $value) {
          
               $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['brd_title']);
               $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['mod_title']);
               $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['var_variant_name']);
               $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['grdtl_owner']);
               $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['grdtl_year']);
               $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['grdtl_km']);
               $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['grdtl_depreciation']);
               $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['grdtl_price']);
               $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['grdate_year_range']);
             
               $row++;
               $no++;
          }
     }
     //Save as an Excel BIFF (xls) file
     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
     //header('Content-Type: application/vnd.ms-excel');
     //header('Content-Disposition: attachment;filename="rdportal-myregister-report.xls"');
     //header('Cache-Control: max-age=0');
     //$objWriter->save('php://output');
     $objWriter->save('../rdportal/assets/uploads/demo-grid.xls');
     die(json_encode('../assets/uploads/demo-grid.xls'));
}



  }
  