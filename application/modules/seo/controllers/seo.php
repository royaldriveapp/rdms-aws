<?php

defined('BASEPATH') or exit('No direct script access allowed');

class seo extends App_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->model('seo_model', 'seo');
          $this->page_title = 'SEO | Royaldrive';
     }

     public function index()
     {
          $data['data'] = $this->seo->getPageTitles();
          $this->render_page(strtolower(__CLASS__) . '/listpagetitles', $data);
     }

     public function editpagetitle($id = 0)
     {
          if (!empty($_POST)) {
               if ($this->seo->updateData($_POST)) {
                    $this->session->set_flashdata('app_success', 'Update successfully!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't update!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $data['data'] = $this->seo->getPageTitles($id);
               $this->render_page(strtolower(__CLASS__) . '/editpagetitle', $data);
          }
     }

     function listPagecms()
     {
          $data['data'] = $this->seo->getPagecms();
          $this->render_page(strtolower(__CLASS__) . '/page_cms_list', $data);
     }

     function setPagecms($id = 0)
     {
          if (!empty($this->input->post())) {
               if (isset($_FILES['banner']['name']) && !empty($_FILES['banner']['name'])) {
                    $newFileName = rand() . time();
                    $config['upload_path'] = '../assets/uploads/banner/page_banners/';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $newFileName;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('banner')) {
                         $uploadData = $this->upload->data();
                         $_POST['seocms_image'] = $uploadData['file_name'];
                    } else {
                         $uploadData = $this->upload->display_errors();
                         debug($uploadData);
                    }
               }

               $this->seo->setPagecms($this->input->post());
               redirect(strtolower(__CLASS__) . '/listPagecms');
          }
          $data['data'] = $this->seo->getPagecms($id);
          $this->render_page(strtolower(__CLASS__) . '/page_cms', $data);
     }

     function uploader()
     {
          $files = array();
          if (isset($_FILES['file']['name'][0]) && !empty($_FILES['file']['name'][0])) {
               foreach ($_FILES['file']['name'] as $key => $value) {
                    $newFileName = rand() . time();
                    $config['upload_path'] = '../assets/uploads/banner/page_banners/';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $newFileName;

                    $_FILES['prd_image_tmp']['name'] = $_FILES['file']['name'][$key];
                    $_FILES['prd_image_tmp']['type'] = $_FILES['file']['type'][$key];
                    $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['file']['tmp_name'][$key];
                    $_FILES['prd_image_tmp']['error'] = $_FILES['file']['error'][$key];
                    $_FILES['prd_image_tmp']['size'] = $_FILES['file']['size'][$key];

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('prd_image_tmp')) {
                         $uploadData = $this->upload->data();
                         $files['file-' . $key] = array(
                              'url' => 'https://www.royaldrive.in/assets/uploads/banner/page_banners/' . $uploadData['file_name'], 'id' => $key
                         );
                    } else {
                         $uploadData = $this->upload->display_errors();
                         debug($uploadData);
                    }
               }
               echo stripslashes(json_encode($files));
          }
     }

     function productTitle($id = 0)
     {

          if (!empty($_POST)) {
               $this->seo->setProductTitle($_POST);
               redirect(strtolower(__CLASS__) . '/productTitle');
          } else if ($id) {
               $data['product'] = $this->seo->products($id);
               $this->render_page(strtolower(__CLASS__) . '/product_cms', $data);
          } else {
               $data['products'] = $this->seo->products();
               $this->render_page(strtolower(__CLASS__) . '/product_cms_list', $data);
          }
     }
}
