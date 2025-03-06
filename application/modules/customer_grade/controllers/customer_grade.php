<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class customer_grade extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Customer grade';
            $this->load->model('customer_grade_model', 'customer_grade');
            $this->lock_in();
       }

       public function index() {
            $data['countries'] = $this->customer_grade->get();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add() {
            if (!empty($_POST)) {
                 if (isset($_FILES['icon']['name']) && !empty($_FILES['icon']['name'])) {
                      /* Category image */
                      $newFileName = rand(9999999, 0) . $_FILES['icon']['name'];
                      $config['upload_path'] = FILE_UPLOAD_PATH . 'icon/';
                      $config['allowed_types'] = 'gif|jpg|png';
                      $config['file_name'] = $newFileName;
                      $this->load->library('upload', $config);

                      if (!$this->upload->do_upload('icon')) {
                           array('error' => $this->upload->display_errors());
                      } else {
                           $data = array('upload_data' => $this->upload->data());
                           crop($this->upload->data(), $this->input->post());
                      }
                      $_POST['grade']['sgrd_icon'] = isset($data['upload_data']['file_name']) ? $data['upload_data']['file_name'] : '';
                 }

                 if ($this->customer_grade->newGrade($_POST['grade'])) {
                      $this->session->set_flashdata('app_success', 'Row successfully updated!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't updated row!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['priority'] = $this->customer_grade->getNextOrder();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function view($id) {
            $data['supplierGrade'] = $this->customer_grade->get($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if (isset($_FILES['icon']['name']) && !empty($_FILES['icon']['name'])) {
                 /* Category image */
                 $newFileName = rand(9999999, 0) . $_FILES['icon']['name'];
                 $config['upload_path'] = FILE_UPLOAD_PATH . 'icon/';
                 $config['allowed_types'] = 'gif|jpg|png';
                 $config['file_name'] = $newFileName;
                 $this->load->library('upload', $config);

                 if (!$this->upload->do_upload('icon')) {
                      array('error' => $this->upload->display_errors());
                 } else {
                      $data = array('upload_data' => $this->upload->data());
                      crop($this->upload->data(), $this->input->post());
                 }
                 $_POST['grade']['sgrd_icon'] = isset($data['upload_data']['file_name']) ? $data['upload_data']['file_name'] : '';
            }
            if ($this->customer_grade->updateGrade($this->input->post('grade'))) {
                 $this->session->set_flashdata('app_success', 'Successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update data!");
            }
            redirect(strtolower(__CLASS__));
       }

       function deleteGrade($id = '') {
            if ($this->customer_grade->deleteGrade($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
                 die();
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete row"));
                 die();
            }
       }

       function removeImage($id, $image) {
            if ($this->customer_grade->removeImage($id, $image)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Image successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete image"));
            }
       }

       function verificationView($enqId = 0) {
            $enqId = encryptor($enqId, 'D');
            if (!empty($_POST)) {
                $data['enquiryDetails'] = $this->customer_grade->verifyCustomerGrade($enqId);
                die(json_encode(array('status' => 'success', 'msg' => 'Customer grade verified', 'specialaction' => 'removerow')));
            } else {
                 $data['enquiryDetails'] = $this->customer_grade->getEnquiryDetails($enqId);
                 $this->render_page(strtolower(__CLASS__) . '/verificationView', $data);
            }
       }

  }
  