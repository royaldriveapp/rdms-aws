<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class manage_banner extends App_Controller {

       public $page;

       public function __construct() {

            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Banner';
            $this->load->library('form_validation');
            $this->load->model('manage_banner_model');

            $this->load->helper('directory');
            $this->page = directory_map('../application/modules/');
            unset($this->page['home']);
            $this->lock_in();
       }

       public function index($cat = '') {
            $data['banners'] = $this->manage_banner_model->getBanner();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add($cat = '') {

            if (!empty($_POST)) {
                 $data = array();
                 if (isset($_FILES['banner']['name']) && !empty($_FILES['banner']['name'])) {
                      /* Category image */
                      $newFileName = rand(9999999, 0) . $_FILES['banner']['name'];
                      $config['upload_path'] = FILE_UPLOAD_PATH . 'banner/';
                      $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                      $config['file_name'] = $newFileName;
                      $this->load->library('upload', $config);

                      if (!$this->upload->do_upload('banner')) {
                           array('error' => $this->upload->display_errors());
                      } else {
                           $data = array('upload_data' => $this->upload->data());
                           crop($this->upload->data(), $this->input->post());
                      }
                      $_POST['banner']['bnr_image'] = isset($data['upload_data']['file_name']) ? $data['upload_data']['file_name'] : '';
                 }
                 if ($this->manage_banner_model->addNewBenner($_POST['banner'])) {
                      $this->session->set_flashdata('app_success', 'Category successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add category!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['category'] = $cat;
                 $data['order'] = $this->manage_banner_model->getNextOrder();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       function view($id, $cat = '') {
            $data['category'] = $cat;
            $data['order'] = $this->manage_banner_model->getNextOrder(true);
            $data['pages'] = $this->page;
            $data['banner'] = $this->manage_banner_model->getBanner($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       function update() {
            $data = array();
            if (isset($_FILES['banner']['name']) && !empty($_FILES['banner']['name'])) {
                 /* Category image */
                 $newFileName = rand(9999999, 0) . $_FILES['banner']['name'];
                 $config['upload_path'] = FILE_UPLOAD_PATH . 'banner/';
                 $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                 $config['file_name'] = $newFileName;
                 $this->load->library('upload', $config);

                 if (!$this->upload->do_upload('banner')) {
                      debug(array('error' => $this->upload->display_errors()));
                      exit;
                 } else {
                      $data = array('upload_data' => $this->upload->data());
                      crop($this->upload->data(), $this->input->post());
                 }
                 $_POST['banner']['bnr_image'] = isset($data['upload_data']['file_name']) ? $data['upload_data']['file_name'] : '';
            }

            if ($this->manage_banner_model->updateBenner($_POST)) {
                 $this->session->set_flashdata('app_success', 'Category successfully added!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add category!");
            }
            redirect(strtolower(__CLASS__));
       }

       function removeImage($id, $image) {
            if ($this->manage_banner_model->removeImage($id, $image)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Image successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete image"));
            }
       }

       function delete($id, $image='') {
            if ($this->manage_banner_model->deleteBanner($id, $image)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Banner successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete banner"));
            }
       }

  }
  