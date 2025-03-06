<?php

defined('BASEPATH') or exit('No direct script access allowed');

class fixedassets extends App_Controller
{

     public function __construct()
     {

          parent::__construct();
          $this->body_class[] = 'skin-blue';
          $this->page_title = 'Fixed Assets';
          $this->load->library('form_validation');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('fixedassets_model', 'fixedassets');
     }

     public function index()
     {
          $data['assets'] = $this->fixedassets->getProduct();
          $this->render_page(strtolower(__CLASS__) . '/assets', $data);
     }

     public function categories()
     {
          $this->page_title = $this->page_title . " | Categories";
          $categories['categories'] = $this->fixedassets->getCategories();
          $this->render_page(strtolower(__CLASS__) . '/listcategory', $categories);
     }

     public function newcategory()
     {
          $this->page_title = $this->page_title . " | New category";
          $this->render_page(strtolower(__CLASS__) . '/newcategory');
     }

     public function insert()
     {
          if ($this->fixedassets->addNewCategory($_POST['category'])) {
               $this->session->set_flashdata('app_success', 'Category successfully added!');
          } else {
               $this->session->set_flashdata('app_error', "Can't add category!");
          }
          redirect(strtolower(__CLASS__) . '/categories');
     }

     public function update($id = 0)
     {

          if (!empty($id)) {
               $this->section = "Edit category";
               $categories['categories'] = $this->fixedassets->getCategories($id);
               $this->current_section = 'Category edit';
               $this->render_page(strtolower(__CLASS__) . '/viewcategory', $categories);
          } else {
               if ($this->fixedassets->updateCategory($_POST['category'])) {
                    $this->session->set_flashdata('app_success', 'Category successfully updated!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't update category!");
               }
               redirect(strtolower(__CLASS__));
          }
     }

     public function deletefixedassets($id)
     {
          if ($this->fixedassets->deleteCategory($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Category successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete category"));
          }
     }

     public function removeImage($id)
     {
          if ($this->fixedassets->removeCategoryImage($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Brand logo successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete brand logo"));
          }
     }

     function purchase()
     {
          $this->load->library('upload');
          if (!empty($_POST)) {
               $docNos = isset($_POST['product']['prd_number']) ? count($_POST['product']['prd_number']) : 0;
               $i = 0;
               if ($docNos > 0) {
                    //Invoice
                    $_POST['product']['prd_invoice'][$i] = '';
                    for ($i = 0; $i < $docNos; $i++) {
                         $newFileName = rand() . time();
                         $config['upload_path'] = '../assets/uploads/fixedassets/';
                         $config['allowed_types'] = '*';
                         $config['file_name'] = $newFileName;
                         $this->upload->initialize($config);
                         $_FILES['prd_image_tmp']['name'] = $_FILES['prd_invoice']['name'][$i];
                         $_FILES['prd_image_tmp']['type'] = $_FILES['prd_invoice']['type'][$i];
                         $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['prd_invoice']['tmp_name'][$i];
                         $_FILES['prd_image_tmp']['error'] = $_FILES['prd_invoice']['error'][$i];
                         $_FILES['prd_image_tmp']['size'] = $_FILES['prd_invoice']['size'][$i];

                         if ($this->upload->do_upload('prd_image_tmp')) {
                              $uploadData = $this->upload->data();
                              $_POST['product']['prd_invoice'][$i] = $uploadData['file_name'];
                         } else {
                              $uploadData = $this->upload->display_errors();
                         }
                    }

                    //Warranty card
                    $_POST['product']['prd_warty_card'][$i] = '';
                    for ($i = 0; $i < $docNos; $i++) {
                         $newFileName = rand() . time();
                         $config['upload_path'] = '../assets/uploads/fixedassets/';
                         $config['allowed_types'] = '*';
                         $config['file_name'] = $newFileName;
                         $this->upload->initialize($config);
                         $_FILES['prd_image_tmp']['name'] = $_FILES['prd_warty_card']['name'][$i];
                         $_FILES['prd_image_tmp']['type'] = $_FILES['prd_warty_card']['type'][$i];
                         $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['prd_warty_card']['tmp_name'][$i];
                         $_FILES['prd_image_tmp']['error'] = $_FILES['prd_warty_card']['error'][$i];
                         $_FILES['prd_image_tmp']['size'] = $_FILES['prd_warty_card']['size'][$i];

                         if ($this->upload->do_upload('prd_image_tmp')) {
                              $uploadData = $this->upload->data();
                              $_POST['product']['prd_warty_card'][$i] = $uploadData['file_name'];
                         } else {
                              $uploadData = $this->upload->display_errors();
                         }
                    }
               }
               $salesId = $this->fixedassets->addNewProduct($_POST);
               if ($_POST['submit'] == 'submit') {
                    $this->session->set_flashdata('app_success', 'Sale successfully completed!');
                    redirect(strtolower(__CLASS__) . '/');
               }
          } else {
               $this->page_title = 'Purchase';
               $data['categories'] = $this->fixedassets->getCategories();
               $data['products'] = $this->fixedassets->getProduct('', $_GET);
               $data['salesOrderNum'] = time() + rand(9, 9999999);
               $data['division'] = $this->divisions->getActiveData();
               $this->render_page(strtolower(__CLASS__) . '/add_product', $data);
          }
     }

     public function getpurchasefields()
     {
          $data['company'] = $this->fixedassets->getFxedAssetsCompany();
          $html = $this->load->view(strtolower(__CLASS__) . '/ajx_purchasefields', $data, true);
          die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
     }

     function issueAssets()
     {
          if (!empty($_POST)) {
               $this->fixedassets->issueAssets($_POST);
               redirect(strtolower(__CLASS__));
          } else {
               $data['users'] = $this->fixedassets->getAllUserGroups();
               $data['assets'] = $this->fixedassets->getAssetsNotIssues();
               $this->render_page(strtolower(__CLASS__) . '/issue_assets', $data);
          }
     }

     function returnAssets()
     {
          if (!empty($_POST)) {
               $this->fixedassets->returnAssets($_POST);
               redirect(strtolower(__CLASS__));
          } else {
               $data['users'] = $this->fixedassets->getAllUserGroups();
               $this->render_page(strtolower(__CLASS__) . '/return_assets', $data);
          }
     }

     function bindIssuedAssets()
     {
          $data['assets'] = $this->fixedassets->bindIssuedAssets($_POST['id']);
          $html = $this->load->view(strtolower(__CLASS__) . '/tmp_issuedAssets', $data, true);
          die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
     }
     public function list()
     {
          $this->render_page(strtolower(__CLASS__) . '/list');
     }
     function fixedasset_ajax()
     {
          $response = $this->fixedassets->getProductPaginate($this->input->post());
          echo json_encode($response);
     }
}
