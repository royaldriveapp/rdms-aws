<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class blog extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Blog';
            $this->load->model('blog_model', 'blog');
       }

       public function index() {
            $data['blogList'] = $this->blog->getBlog();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($nwsId = $this->blog->newBlog($this->input->post())) {

                      $this->load->library('upload');
                      $x1 = $this->input->post('x1');
                      $fileCount = count($x1);
                      $up = array();
                      if (isset($_FILES['image']['name'][0])) {
                           for ($j = 0; $j < $fileCount; $j++) {
                                /**/
                                $data = array();
                                $angle = array();
                                $newFileName = rand(9999999, 0) . $_FILES['image']['name'][$j];
                                $config['upload_path'] = FILE_UPLOAD_PATH . 'blog/';
                                $config['allowed_types'] = 'gif|jpg|png';
                                $config['file_name'] = $newFileName;
                                $this->upload->initialize($config);

                                $angle['x1']['0'] = $_POST['x1'][$j];
                                $angle['x2']['0'] = $_POST['x2'][$j];
                                $angle['y1']['0'] = $_POST['y1'][$j];
                                $angle['y2']['0'] = $_POST['y2'][$j];
                                $angle['w']['0'] = $_POST['w'][$j];
                                $angle['h']['0'] = $_POST['h'][$j];

                                $_FILES['prd_image_tmp']['name'] = $_FILES['image']['name'][$j];
                                $_FILES['prd_image_tmp']['type'] = $_FILES['image']['type'][$j];
                                $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['image']['tmp_name'][$j];
                                $_FILES['prd_image_tmp']['error'] = $_FILES['image']['error'][$j];
                                $_FILES['prd_image_tmp']['size'] = $_FILES['image']['size'][$j];
                                if (!$this->upload->do_upload('prd_image_tmp')) {
                                     $up = array('error' => $this->upload->display_errors());
                                     debug($up);
                                } else {
                                     $data = $this->upload->data();
                                     crop($this->upload->data(), $angle);
                                     $this->blog->addImages(array('bimg_blog' => $nwsId, 'bimg_image' => $data['file_name']));
                                }
                           }
                      }
                      $this->session->set_flashdata('app_success', 'News successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add news!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['categories'] = $this->blog->blogCategories();
                 $data['tags'] = $this->blog->blogTags();
                 $data['order'] = $this->blog->getNextOrder();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function view($id) {
            $id = encryptor($id, 'D');
            $data['categories'] = $this->blog->blogCategories();
            $data['tags'] = $this->blog->blogTags();
            $data['blog'] = $this->blog->getBlog($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function removeImage($id) {
            if ($this->blog->removeNewsImage($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Image successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete product image"));
            }
       }

       public function update() {
            $nwsId = $this->input->post('blog_id');
            if ($this->blog->updateBlog($this->input->post(), $nwsId)) {

                 $this->load->library('upload');
                 $x1 = $this->input->post('x1');
                 $fileCount = count($x1);
                 $up = array();
                 for ($j = 0; $j < $fileCount; $j++) {
                      /**/
                      $data = array();
                      $angle = array();
                      $newFileName = rand(9999999, 0) . $_FILES['image']['name'][$j];
                      $config['upload_path'] = FILE_UPLOAD_PATH . 'blog/';
                      $config['allowed_types'] = 'gif|jpg|png';
                      $config['file_name'] = $newFileName;
                      $this->upload->initialize($config);

                      $angle['x1']['0'] = $_POST['x1'][$j];
                      $angle['x2']['0'] = $_POST['x2'][$j];
                      $angle['y1']['0'] = $_POST['y1'][$j];
                      $angle['y2']['0'] = $_POST['y2'][$j];
                      $angle['w']['0'] = $_POST['w'][$j];
                      $angle['h']['0'] = $_POST['h'][$j];

                      $_FILES['prd_image_tmp']['name'] = $_FILES['image']['name'][$j];
                      $_FILES['prd_image_tmp']['type'] = $_FILES['image']['type'][$j];
                      $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['image']['tmp_name'][$j];
                      $_FILES['prd_image_tmp']['error'] = $_FILES['image']['error'][$j];
                      $_FILES['prd_image_tmp']['size'] = $_FILES['image']['size'][$j];
                      if (!$this->upload->do_upload('prd_image_tmp')) {
                           $up = array('error' => $this->upload->display_errors());
                      } else {
                           $data = $this->upload->data();
                           crop($this->upload->data(), $angle);
                           $this->blog->addImages(array('bimg_blog' => $nwsId, 'bimg_image' => $data['file_name']));
                      }
                 }

                 $this->session->set_flashdata('app_success', 'News successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update news!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->blog->deleteBlog($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Blog successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete blog"));
            }
       }

       public function import() {
            $this->section = 'Import Product';
            $data['category'] = $this->category_model->categoryTree();
            $this->current_section = 'Import Product';
            $this->render_page(strtolower(__CLASS__) . '/import', $data);
       }

       public function productSortOrder($brandid = '') {
            $data['brandTree'] = $this->brand_model->brandTree();
            $data['productDetails'] = (!empty($brandid)) ? $this->blog->getProductByBrandId($brandid) : array();
            $data['brandid'] = (!empty($brandid)) ? $brandid : '';
            $data['order'] = $this->blog->getNextOrder(true, $brandid);
            $this->render_page(strtolower(__CLASS__) . '/set_product_sort_order', $data);
       }

       function setProductSortOrder() {
            if ($this->blog->arrangeProductOrder($this->input->post())) {
                 echo json_encode(array('status' => 'success', 'msg' => 'News successfully sorted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't sorted news"));
            }
       }

       function category() {
            $data['categories'] = $this->blog->blogCategories();
            $this->render_page(strtolower(__CLASS__) . '/category_list', $data);
       }

       function newCategory() {
            if (!empty($_POST)) {
                 if ($this->blog->newCategory($_POST)) {
                      $this->session->set_flashdata('app_success', 'Row successfully updated!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't updated row!");
                 }
                 redirect('blog/category');
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/category_new');
            }
       }

       function updateCategory($id = '') {
            if (!empty($_POST)) {
                 if ($this->blog->updateCategory($_POST)) {
                      $this->session->set_flashdata('app_success', 'Row successfully updated!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't updated row!");
                 }
                 redirect('blog/category');
            } else {
                 $data['data'] = $this->blog->blogCategories($id);
                 $this->render_page(strtolower(__CLASS__) . '/category_view', $data);
            }
       }

       function deleteCategory($id = '') {
            if ($this->blog->deleteCategory($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Category successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete row"));
            }
       }

       /* Tag */

       function tags() {
            $data['tags'] = $this->blog->blogTags();
            $this->render_page(strtolower(__CLASS__) . '/tag_list', $data);
       }

       function newTag() {
            if (!empty($_POST)) {
                 if ($this->blog->newTag($_POST)) {
                      $this->session->set_flashdata('app_success', 'Row successfully updated!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't updated row!");
                 }
                 redirect('blog/tags');
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/tag_new');
            }
       }

       function updateTag($id = '') {
            if (!empty($_POST)) {
                 if ($this->blog->updateTag($_POST)) {
                      $this->session->set_flashdata('app_success', 'Row successfully updated!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't updated row!");
                 }
                 redirect('blog/tags');
            } else {
                 $data['data'] = $this->blog->blogTags($id);
                 $this->render_page(strtolower(__CLASS__) . '/tag_view', $data);
            }
       }

       function deleteTag($id = '') {
            if ($this->blog->deleteTag($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Category successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete row"));
            }
       }

  }
  