<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Veh_variant extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Vehicle model';
            $this->load->library('form_validation');
            $this->load->model('variant_model');
            $this->load->model('model/model_model', 'model_model');
            $this->load->model('brand/brand_model', 'brand_model');
       }

       public function index() {
          $this->section = "Vehicle";
          $this->current_section = 'Vehicle';   
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }

     function index_ajax()
     {
    $response = $this->variant_model->selectPaginate($this->input->post(), $this->input->get());
     echo json_encode($response);
     }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->variant_model->insert($_POST)) {
                      $this->session->set_flashdata('app_success', 'Vehicle successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Vehicle!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $this->section = 'Add Vehicle';
                 $brand['brands'] = $this->brand_model->getBrands();
                 $brand['vehicle'] = $this->model_model->select();
                 $this->render_page(strtolower(__CLASS__) . '/add', $brand);
            }
       }

       public function view($id) {
            $this->section = 'Edit Vehicle';
            $data['car'] = $this->variant_model->select($id);
            $brdId = $data['car']['var_brand_id'];
            $data['model'] = $this->model_model->getVehicleByBrand($brdId);
            $data['brands'] = $this->brand_model->getBrands();
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->variant_model->update($_POST)) {
                 $this->session->set_flashdata('app_success', 'Vehicle successfully added!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add Vehicle!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->variant_model->delete($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Vehicle successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete Vehicle"));
            }
       }

       function bindVariant() {
            $id = $_POST['id'];
            $vehicle = $this->variant_model->getVariantByModel($id);
            echo json_encode($vehicle);
       }
  } 