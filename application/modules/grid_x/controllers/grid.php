<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class grid extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Vehcle grid';
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            $this->load->model('grid_model', 'grid');
       }
   
    
//        function index() {
//           $data['brand'] = $this->enquiry->getBrands();
//             $this->render_page(strtolower(__CLASS__) . '/grid_list', $data);
//        }
//        function grid_ajax() {
//             $response = $this->grid->getData($this->input->post(),$this->input->get());
//   echo json_encode($response);
//             exit;
//        }
       public function index() {//new
          $data['brands'] = $this->enquiry->getBrands();
          if($_GET['brand']){
          $data['models'] = $this->enquiry->getModelByBrand($_GET['brand']);
          }
          if($_GET['models']){
          $data['variants'] = $this->enquiry->getVariantByModel($_GET['variant']);
          }
         $this->render_page(strtolower(__CLASS__) . '/grid_filter', $data);
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
  }
  