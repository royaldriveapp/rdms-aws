<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class brand extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Brand';
            $this->load->library('form_validation');
            $this->load->model('Brand_model', 'brand_model');
       }

       public function index() {
          $this->render_page(strtolower(__CLASS__) . '/list');
     }
     function index_ajax()
     {
    $response = $this->brand_model->getBrandsPaginate($this->input->post(), $this->input->get());
     echo json_encode($response);
     }

       public function add() {
            if (!empty($_POST)) {
                 $data = array();
                 $newFileName = rand(9999999, 0) . $_FILES['brd_logo']['name'];
                 $config['upload_path'] = FILE_UPLOAD_PATH . 'brand/';
                 $config['allowed_types'] = 'gif|jpg|png';
                 $config['file_name'] = $newFileName;
                 $this->load->library('upload', $config);

                 if (!$this->upload->do_upload('brd_logo')) {
                      array('error' => $this->upload->display_errors());
                 } else {
                      $data = array('upload_data' => $this->upload->data());
                      crop($this->upload->data(), $this->input->post());
                 }
                 /**/
                 $_POST['brd_logo'] = isset($data['upload_data']['file_name']) ? $data['upload_data']['file_name'] : '';

                 if ($this->brand_model->addNewBrand($_POST)) {
                      $this->session->set_flashdata('app_success', 'Brand successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Brand!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $brand['orderNumber'] = $this->brand_model->getBrandNextOrder();
                 $this->render_page(strtolower(__CLASS__) . '/add', $brand);
            }
       }

       public function view($id) {
            $id = encryptor($id, 'D');
            $brand['brand'] = $this->brand_model->getBrands($id);
            $brand['maxOrder'] = $this->brand_model->getBrandNextOrder(true);
            $this->render_page(strtolower(__CLASS__) . '/view', $brand);
       }

       public function removeImage($id) {
            if ($this->brand_model->removeBrandImage($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Brand logo successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete brand logo"));
            }
       }

       public function update() {
            /**/
            if (isset($_FILES['brd_logo']['name']) && !empty($_FILES['brd_logo']['name'])) {
                 $data = array();
                 $newFileName = rand(9999999, 0) . $_FILES['brd_logo']['name'];
                 $config['upload_path'] = FILE_UPLOAD_PATH . 'brand/';
                 $config['allowed_types'] = 'gif|jpg|png';
                 $config['file_name'] = $newFileName;
                 $this->load->library('upload', $config);

                 if (!$this->upload->do_upload('brd_logo')) {
                      array('error' => $this->upload->display_errors());
                 } else {
                      $data = array('upload_data' => $this->upload->data());
                      crop($this->upload->data(), $this->input->post());
                 }
            }
            /**/
            if (isset($data['upload_data']['file_name']) && !empty($data['upload_data']['file_name'])) {
                 $_POST['brd_logo'] = $data['upload_data']['file_name'];
            }

            if ($this->brand_model->updateBrand($_POST)) {
                 $this->session->set_flashdata('app_success', 'Brand successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add Brand!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->brand_model->deleteBrand($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Brand successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete brand"));
            }
       }
       
       function makeluxury($brandId) {
            $userId = encryptor($brandId, 'D');
            $ischecked = isset($_POST['ischecked']) ? $_POST['ischecked'] : 0;
            if ($this->common_model->changeStatusRana($userId, $ischecked, 'brand', 'brd_section', 'brd_id')) {
                 $logMessage = ($ischecked == 1) ? 'Brand is luxury' : 'Brand is smart';
                 generate_log(array(
                     'log_title' => 'Is luxury',
                     'log_desc' => $logMessage,
                     'log_controller' => 'user-status-changed',
                     'log_action' => 'U',
                     'log_ref_id' => $userId,
                     'log_added_by' => $this->uid
                 ));

                 die(json_encode(array('status' => 'success', 'msg' => $logMessage)));
            } else {
                 die(json_encode(array('status' => 'fail', 'msg' => "Error occured")));
            }
       }
  }
  