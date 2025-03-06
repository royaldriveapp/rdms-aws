<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Model extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'car name';
            $this->load->library('form_validation');
            $this->load->model('model_model');
            $this->load->model('brand/Brand_model', 'brand_model');
       }

       public function index() {
          $this->current_section = 'Model';
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }
     function index_ajax()
     {
    $response = $this->model_model->selectPaginate($this->input->post(), $this->input->get());
     echo json_encode($response);
     }
       public function add() {
            if (!empty($_POST)) {
                 if ($this->model_model->insert($_POST)) {
                      $this->session->set_flashdata('app_success', 'Brand successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Brand!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $brand['brand'] = $this->brand_model->getBrands();
                 $this->render_page(strtolower(__CLASS__) . '/add', $brand);
            }
       }

       public function view($id) {
            $data['brand'] = $this->brand_model->getBrands();
            $data['car'] = $this->model_model->select($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->model_model->update($_POST)) {
                 $this->session->set_flashdata('app_success', 'Brand successfully added!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add Brand!");
            }
            redirect(strtolower(__CLASS__));
       }
       
       public function delete($id) {
            if ($this->model_model->delete($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Brand successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete brand"));
            }
       }
       
       function bindModel() {
            $id = $_POST['id'];
            $vehicle = $this->model_model->getVehicleByBrand($id);
            echo json_encode($vehicle);
       }
  }  