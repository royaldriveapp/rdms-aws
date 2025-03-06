<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class rdpolicy extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->page_title = 'Privacy policy | Royaldrive';
            $this->load->model('rdpolicy_model', 'rdpolicy');
       }

       public function index() {
            $data['travelPolicy'] = $this->rdpolicy->travelPolicy();
            $data['holidays'] = $this->rdpolicy->getHolidays();
            $data['policiesOther'] = $this->rdpolicy->getPolicies(0);
            $this->render_page(strtolower(__CLASS__) . '/index', $data);
       }

       function create() {
          if (!empty($_POST)) {
               $this->load->library('upload');
               $newFileName = rand(9999999, 0) . $_FILES['pol_doc']['name'];
               $config['upload_path'] = '../assets/uploads/rdpolicies/';
               $config['allowed_types'] = 'pdf';
               $config['file_name'] = $newFileName;
               $this->upload->initialize($config);
               if ($this->upload->do_upload('pol_doc')) {
                    $data = $this->upload->data();
                    $_POST['pol_doc'] = $data['file_name'];
               }
               $this->rdpolicy->createPolicy($_POST);
          }
          $data['data'] = $this->rdpolicy->getPolicies();
          $this->render_page(strtolower(__CLASS__) . '/create', $data);
     }

     function view($id) {
          $data['data'] = $this->rdpolicy->getPoliciesById($id);
          $this->render_page(strtolower(__CLASS__) . '/view', $data);
     }

     function update() {
          if (!empty($_POST)) {
               if (isset($_FILES['pol_doc']['name']) && !empty($_FILES['pol_doc']['name'])) {
                    $this->load->library('upload');
                    $newFileName = rand(9999999, 0) . $_FILES['pol_doc']['name'];
                    $config['upload_path'] = '../assets/uploads/rdpolicies/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_name'] = $newFileName;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('pol_doc')) {
                         $data = $this->upload->data();
                         $_POST['pol_doc'] = $data['file_name'];
                    }
               }
               $this->rdpolicy->updatePolicy($_POST);
          }
          redirect(__CLASS__ . '/create');
     }

     function delete($id) {
          if ($this->rdpolicy->deleteData($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Delete successfully'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete"));
          }
     }
  }