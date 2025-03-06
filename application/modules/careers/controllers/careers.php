<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Careers extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'careers';
            $this->load->library('form_validation');
            $this->load->model('careers_model');
            $this->load->model('showroom/showroom_model', 'showroom');
       }

       public function index() {
            $this->section = "Careers";
            $career['career'] = $this->careers_model->getCareers();
            $this->current_section = 'Careers';
            $this->render_page(strtolower(__CLASS__) . '/list', $career);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->careers_model->addNewCareer($_POST)) {
                      $this->session->set_flashdata('app_success', 'Careers successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Careers!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['showroom'] = $this->showroom->get();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function view($id) {
            $this->section = 'Edit Careers';
            $career['showroom'] = $this->showroom->get();
            $career['career'] = $this->careers_model->getCareers($id);
            $career['maxOrder'] = $this->careers_model->getCareerNextOrder(true);
            $this->current_section = 'Careers edit';
            $this->render_page(strtolower(__CLASS__) . '/view', $career);
       }

       public function removeImage($id) {
            if ($this->careers_model->removeCareersImage($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Careers logo successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete career logo"));
            }
       }

       public function update() {

            if ($this->careers_model->updateCareer($_POST)) {
                 $this->session->set_flashdata('app_success', 'Careers successfully added!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add Careers!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->careers_model->deleteCareer($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Careers successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete career"));
            }
       }

       function application() {
            $data['application'] = $this->careers_model->getApplication();
            $this->render_page(strtolower(__CLASS__) . '/application', $data);
       }
       
       function changeuserstatus($carId) {
            $carId = encryptor($carId, 'D');
            $ischecked = isset($_POST['ischecked']) ? $_POST['ischecked'] : 0;
            if ($this->common_model->changeStatus($carId, $ischecked, 'careers', 'car_status', 'car_id')) {
                 $logMessage = ($ischecked == 1) ? 'Job status activated' : 'Job status de-activated';
                 generate_log(array(
                     'log_title' => 'Status changed',
                     'log_desc' => $logMessage,
                     'log_controller' => 'job-status-changed',
                     'log_action' => 'U',
                     'log_ref_id' => $carId,
                     'log_added_by' => $this->uid
                 ));

                 $msg = ($ischecked == 1) ? "Activated this record successfully" : "De-activated this record successfully";
                 die(json_encode(array('status' => 'success', 'msg' => $msg)));
            } else {
                 die(json_encode(array('status' => 'fail', 'msg' => "Error occured")));
            }
       
       }
  }
  