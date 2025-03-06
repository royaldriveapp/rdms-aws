<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Category extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Filter type - Category';
            $this->load->library('form_validation');
            $this->load->model('Category_model', 'category_model');
       }

       public function index() {
            $this->section = "Category";
            $categories['categories'] = $this->category_model->getCategories();
            $this->current_section = 'Category';
            $this->render_page(strtolower(__CLASS__) . '/list', $categories);
       }

       public function add() {
            $this->section = "Add category";
            $categories['order'] = $this->category_model->getNextOrder();
            $this->current_section = 'Category add';
            $this->render_page(strtolower(__CLASS__) . '/add', $categories);
       }

       public function insert() {
            /**/
            $data = array();
            if (isset($_FILES['cat_image']['name']) && !empty($_FILES['cat_image']['name'])) {
                 $newFileName = rand(9999999, 0) . $_FILES['cat_image']['name'];
                 $config['upload_path'] = FILE_UPLOAD_PATH . 'category/';
                 $config['allowed_types'] = 'gif|jpg|png';
                 $config['file_name'] = $newFileName;
                 $this->load->library('upload', $config);

                 if (!$this->upload->do_upload('cat_image')) {
                      array('error' => $this->upload->display_errors());
                 } else {
                      $data = array('upload_data' => $this->upload->data());
                      crop($this->upload->data(), $this->input->post());
                 }
                 /**/
                 $_POST['category']['cat_image'] = isset($data['upload_data']['file_name']) ? $data['upload_data']['file_name'] : '';
            }

            if ($this->category_model->addNewCategory($_POST['category'])) {
                 $this->session->set_flashdata('app_success', 'Category successfully added!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add category!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function update() {
            /**/
            $data = array();
            if (isset($_FILES['cat_image']['name']) && !empty($_FILES['cat_image']['name'])) {
                 $newFileName = rand(9999999, 0) . $_FILES['cat_image']['name'];
                 $config['upload_path'] = FILE_UPLOAD_PATH . 'category/';
                 $config['allowed_types'] = 'gif|jpg|png';
                 $config['file_name'] = $newFileName;
                 $this->load->library('upload', $config);

                 if (!$this->upload->do_upload('cat_image')) {
                      $data = array('error' => $this->upload->display_errors());
                 } else {
                      $data = array('upload_data' => $this->upload->data());
                      crop($this->upload->data(), $this->input->post());
                 }
                 /**/
                 $_POST['category']['cat_image'] = isset($data['upload_data']['file_name']) ? $data['upload_data']['file_name'] : '';
            }
            
            if ($this->category_model->updateCategory($_POST['category'])) {
                 $this->session->set_flashdata('app_success', 'Category successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update category!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->category_model->deleteCategory($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Category successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete category"));
            }
       }

       public function view($id) {
            $this->section = "Edit category";
            $categories['order'] = $this->category_model->getNextOrder(true);
            $categories['categories'] = $this->category_model->getCategories($id);
            $this->current_section = 'Category edit';
            $this->render_page(strtolower(__CLASS__) . '/view', $categories);
       }

       public function removeImage($id) {
            if ($this->category_model->removeCategoryImage($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Brand logo successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete brand logo"));
            }
       }
  }