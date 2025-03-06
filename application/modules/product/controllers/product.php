<?php

defined('BASEPATH') or exit('No direct script access allowed');
require '../rdmsdev/vendors/aws-vendor/autoload.php';
class Product extends App_Controller
{
     public $s3 = '';
     public function __construct()
     {
          parent::__construct();
          $this->body_class[] = 'skin-blue';
          $this->page_title = 'Product';
          $this->load->model('brand/brand_model', 'brand_model');
          $this->load->model('category/category_model', 'category_model');
          $this->load->model('product_model', 'product_model');
          $this->load->model('features/features_model', 'features_model');
          $this->load->model('veh_variant/variant_model', 'variant_model');
          $this->load->model('model/model_model', 'model_model');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('evaluation/evaluation_model', 'evaluation');
          $this->s3 = new Aws\S3\S3Client([
               'region' => AWS_REG,
               'version' => AWS_VER,
               'credentials' => [
                    'key' => AWS_KEY,
                    'secret' => AWS_SEC
               ]
          ]);
     }

     public function index()
     {

          $this->section = 'List Product';
          $this->current_section = 'Product';

          $this->load->library("pagination");
          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $products = $this->product_model->getProduct($limit, $page, $_GET);

          $data['productDetails'] = $products['data'];
          $config['page_query_string'] = TRUE;
          $config['query_string_segment'] = 'page';
          $config["base_url"] = $link;
          $config["total_rows"] = $products['count'];
          $config["per_page"] = $limit;
          $config["uri_segment"] = 3;

          /* Table info */
          $data['pageIndex'] = $page + 1;
          $data['limit'] = $page + $limit;
          $data['totalRow'] = number_format($products['count']);
          /* Table info */

          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $data['brand'] = $this->product_model->getBrands();
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }

     public function add($vehicleno = '')
     {
          if (!empty($_POST)) {
               generate_log(array(
                    'log_title' => 'upload product',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'upload-product',
                    'log_action' => 'C',
                    'log_ref_id' => 9090,
                    'log_added_by' => $this->uid
               ));
               if ($prdId = $this->product_model->addNewProduct($this->input->post())) {

                    $this->load->library('upload');
                    $x1 = $this->input->post('x1');
                    $fileCount = count($x1);
                    $up = array();
                    if ($fileCount > 0 && (isset($_POST['x1'][0]) && !empty($_POST['x1'][0]))) {
                         for ($j = 0; $j < $fileCount; $j++) {
                              /**/
                              //$this->product_model->updatePhotoloaded($prdId);
                              $data = array();
                              $angle = array();
                              // $newFileName = rand(9999999, 0) . $_FILES['prd_image']['name'][$j];
                              $config['upload_path'] = '../rdms/assets/uploads/tmp/';
                              $config['allowed_types'] = 'gif|jpg|png|jpeg';
                              // $config['file_name'] = $newFileName;
                              $config['encrypt_name'] = TRUE;
                              $this->upload->initialize($config);

                              $angle['x1']['0'] = $_POST['x1'][$j];
                              $angle['x2']['0'] = $_POST['x2'][$j];
                              $angle['y1']['0'] = $_POST['y1'][$j];
                              $angle['y2']['0'] = $_POST['y2'][$j];
                              $angle['w']['0'] = $_POST['w'][$j];
                              $angle['h']['0'] = $_POST['h'][$j];

                              $_FILES['prd_image_tmp']['name'] = $_FILES['prd_image']['name'][$j];
                              $_FILES['prd_image_tmp']['type'] = $_FILES['prd_image']['type'][$j];
                              $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['prd_image']['tmp_name'][$j];
                              $_FILES['prd_image_tmp']['error'] = $_FILES['prd_image']['error'][$j];
                              $_FILES['prd_image_tmp']['size'] = $_FILES['prd_image']['size'][$j];
                              if (!$this->upload->do_upload('prd_image_tmp')) {
                                   $up = array('error' => $this->upload->display_errors());
                                   //debug($up);
                              } else {
                                   $data = array('upload_data' => $this->upload->data());
                                   //                                crop($this->upload->data(), $angle, false);
                                   //$croppedFile = custome_crop($this->upload->data(), WB_DE_THUMB_W, WB_DE_THUMB_H);
                                   $setDefault = ($j == 0) ? 1 : 0;
                                   $this->product_model->addImages(
                                        array(
                                             'pdi_prod_id' => $prdId,
                                             'pdi_image' => $data['upload_data']['file_name'],
                                             'pdi_is_default' => $setDefault
                                        )
                                   );

                                   /*Push to S3 bucket*/
                                   try {
                                        $this->s3->putObject([
                                             'Bucket' => AWS_BUC,
                                             'Key' => $data['upload_data']['file_name'],
                                             'Body' => fopen($_FILES['prd_image_tmp']['tmp_name'], 'r'),
                                        ]);
                                        // $s3->putObject([
                                        //      'Bucket' => 'royaldrive',
                                        //      'Key' => 'products/' . $croppedFile,
                                        //      'Body' => file_get_contents('https://royaldrive.in/assets/uploads/tmp/' . $croppedFile), 
                                        //      'ACL' => 'public-read',
                                        // ]);
                                        //unlink('./../assets/uploads/tmp/' . $newFileName);
                                        //unlink('./../assets/uploads/tmp/' . $croppedFile);
                                   } catch (Aws\S3\Exception\S3Exception $e) {
                                        echo "There was an error uploading the file.\n";
                                        echo $e;
                                   }
                                   /*Push to S3 bucket*/
                              }
                         }
                    }
                    $this->session->set_flashdata('app_success', 'Product successfully added!');
                    redirect(strtolower(__CLASS__) . '/product_share/' . $prdId);
               } else {
                    $this->session->set_flashdata('app_error', "Can't add product!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $data['location'] = $this->showroom->get();
               $data['vehNo'] = explode('-', $vehicleno);
               $data['features'] = $this->features_model->getFeatures();
               $data['order'] = $this->product_model->getNextOrder();
               $data['brands'] = $this->brand_model->getBrands();
               $data['category'] = $this->category_model->categoryTree();
               $data['brandTree'] = $this->brand_model->brandTree();
               $data['color'] = $this->product_model->getColor();
               $this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     public function view($id)
     {
          $data['color'] = $this->product_model->getColor();
          $data['location'] = $this->showroom->get();
          $data['features'] = $this->features_model->getFeatures();
          $data['order'] = $this->product_model->getNextOrder(true);
          $data['brands'] = $this->brand_model->getBrands();
          $data['productsDetails'] = $this->product_model->getSingleProduct($id);
          $data['category'] = $this->category_model->categoryTree();
          $data['brandTree'] = $this->brand_model->brandTree();
          $data['variant'] = $this->variant_model->getVariantByModel($data['productsDetails']['product_details']['prd_model']);
          $data['model'] = $this->model_model->getVehicleByBrand($data['productsDetails']['product_details']['brd_id']);
          $data['valDetails'] = $this->product_model->getValDetails();
          $this->render_page(strtolower(__CLASS__) . '/view', $data);
     }

     public function removeImage($id)
     {
          if ($this->product_model->removePrductImage($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Product image successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete product image"));
          }
     }

     public function update()
     {
          error_reporting(E_ALL);
          error_reporting(1);

          $prdId = $this->input->post('prd_id');
          generate_log(array(
               'log_title' => 'update product',
               'log_desc' => serialize($_POST),
               'log_controller' => 'upload-product-update',
               'log_action' => 'U',
               'log_ref_id' => $prdId,
               'log_added_by' => $this->uid
          ));
          if ($this->product_model->updateProduct($this->input->post())) {

               $this->load->library('upload');
               $x1 = $this->input->post('x1');
               $fileCount = count($x1);
               $up = array();
               for ($j = 0; $j < $fileCount; $j++) {
                    /**/
                    $data = array();
                    $angle = array();
                    //$newFileName = rand(9999999, 0) . clean_image_name($_FILES['prd_image']['name'][$j]);
                    $config['upload_path'] = '../rdms/assets/uploads/tmp/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    //   $config['file_name'] = $newFileName;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);

                    $angle['x1']['0'] = $_POST['x1'][$j];
                    $angle['x2']['0'] = $_POST['x2'][$j];
                    $angle['y1']['0'] = $_POST['y1'][$j];
                    $angle['y2']['0'] = $_POST['y2'][$j];
                    $angle['w']['0'] = $_POST['w'][$j];
                    $angle['h']['0'] = $_POST['h'][$j];

                    $_FILES['prd_image_tmp']['name'] = $_FILES['prd_image']['name'][$j];
                    $_FILES['prd_image_tmp']['type'] = $_FILES['prd_image']['type'][$j];
                    $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['prd_image']['tmp_name'][$j];
                    $_FILES['prd_image_tmp']['error'] = $_FILES['prd_image']['error'][$j];
                    $_FILES['prd_image_tmp']['size'] = $_FILES['prd_image']['size'][$j];
                    if (!$this->upload->do_upload('prd_image_tmp')) {
                         $up = array('error' => $this->upload->display_errors());
                         //debug($up);
                    } else {
                         $data = array('upload_data' => $this->upload->data());
                         //crop($this->upload->data(), $angle);
                         //$croppedFile = custome_crop($this->upload->data(), WB_DE_THUMB_W, WB_DE_THUMB_H);
                         $this->product_model->addImages(array('pdi_prod_id' => $prdId, 'pdi_image' => $data['upload_data']['file_name']));

                         /*Push to S3 bucket  veh-valuation*/
                         try {
                              $result = $this->s3->putObject([
                                   'Bucket' => "royaldrive-prod",
                                   'Key' => $data['upload_data']['file_name'],
                                   'Body' => fopen($_FILES['prd_image_tmp']['tmp_name'], 'r')
                              ]);
                              //debug($result, 0);
                              //  $s3->putObject([
                              //       'Bucket' => 'royaldrive',
                              //        'Key' => 'products/' . $croppedFile,
                              //        'Body' => file_get_contents('https://royaldrive.in/assets/uploads/tmp/' . $croppedFile), 
                              //        'ACL' => 'public-read',
                              //  ]);
                              //unlink('./../assets/uploads/tmp/' . $newFileName);
                              //unlink('./../assets/uploads/tmp/' . $croppedFile);
                         } catch (Aws\S3\Exception\S3Exception $e) {
                              echo "There was an error uploading the file.\n";
                              echo $e;
                         }
                         /*Push to S3 bucket*/
                    }
               }
               $this->session->set_flashdata('app_success', 'Product successfully updated!');
               redirect(strtolower(__CLASS__) . '/product_share/' . $prdId);
          } else {
               $this->session->set_flashdata('app_error', "Can't add product!");
          }
          redirect(strtolower(__CLASS__));
     }

     public function delete($id)
     {
          if ($this->product_model->deleteProduct($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Product successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete product"));
          }
     }

     public function import()
     {
          $data['category'] = $this->category_model->categoryTree();
          $this->render_page(strtolower(__CLASS__) . '/import', $data);
     }

     public function productSortOrder($brandid = '')
     {
          $data['brandTree'] = $this->brand_model->brandTree();
          $data['productDetails'] = (!empty($brandid)) ? $this->product_model->getProductByBrandId($brandid) : array();
          $data['brandid'] = (!empty($brandid)) ? $brandid : '';
          $data['order'] = $this->product_model->getNextOrder(true, $brandid);
          $this->render_page(strtolower(__CLASS__) . '/set_product_sort_order', $data);
     }

     function setProductSortOrder()
     {
          if ($this->product_model->arrangeProductOrder($this->input->post())) {
               echo json_encode(array('status' => 'success', 'msg' => 'Product successfully sorted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't sorted product"));
          }
     }

     public function doImport()
     {

          require_once APPPATH . "/third_party/PHPExcel.php";
          $this->load->library('upload');
          $this->load->library('unzip');
          $dataUpload = array();

          /* Upload product zip file */
          $newFile = date('d_m_Y') . '_' . rand(9999999, 0);
          if (isset($_FILES['image_zip']['name']) && !empty($_FILES['image_zip']['name'])) {
               $newFileName = $newFile . '_' . $_FILES['image_zip']['name'];
               $config['upload_path'] = FILE_UPLOAD_PATH . 'product_zip/';
               $config['allowed_types'] = 'application/zip|zip';
               $config['file_name'] = $newFileName;
               $this->upload->initialize($config);
               if ($this->upload->do_upload('image_zip')) {
                    $dataUpload = $this->upload->data();
                    $this->unzip->extract('../assets/uploads/product_zip/' . $dataUpload['file_name'], '../assets/uploads/product/');
               }
          }
          /* Upload product xls */
          $newFileName = $newFile . '_' . $_FILES['product_file']['name'];
          $config['upload_path'] = '../assets/uploads/product_xls/';
          $config['allowed_types'] = 'xls|xlsx|csv';
          $config['file_name'] = $newFileName;
          $this->upload->initialize($config);
          if ($this->upload->do_upload('product_file')) {
               $dataUpload = $this->upload->data();
               $prodCount = $this->input->post('product_count');
               if ($prodCount > 0) {
                    //here i used microsoft excel 2007
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    //set to read only
                    $objReader->setReadDataOnly(true);
                    //load excel file
                    $objPHPExcel = $objReader->load("../assets/uploads/product_xls/" . $dataUpload['file_name']);
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data until last data

                    $prodCount = $this->input->post('product_count');
                    $product = array();
                    $product['specification']['spe_specification'] = array();
                    $product['specification']['spe_specification_detail'] = array();

                    $product['brandSpecification']['brs_specification'] = array();
                    $product['brandSpecification']['brs_part_no'] = array();

                    for ($i = 1; $i <= $prodCount; $i++) {
                         $j = $i + 1;
                         $product['product']['prd_eg_no'] = $objWorksheet->getCellByColumnAndRow(0, $j)->getValue();
                         $product['product']['prd_model'] = $objWorksheet->getCellByColumnAndRow(1, $j)->getValue();
                         $product['product']['prd_from_import'] = 1;
                         $product['product']['prd_order'] = $this->product_model->getNextOrder();
                         $product['product']['prd_category'] = $this->input->post('prd_category');

                         /* Product image */
                         $product_image = $objWorksheet->getCellByColumnAndRow(6, $j)->getValue();

                         /* Specification */
                         $prd_specifications_key = $objWorksheet->getCellByColumnAndRow(2, $j)->getValue();
                         $prd_specifications_key = !empty($prd_specifications_key) ?
                              explode('|', $prd_specifications_key) : array();

                         $prd_specifications_value = $objWorksheet->getCellByColumnAndRow(3, $j)->getValue();
                         $prd_specifications_value = !empty($prd_specifications_value) ?
                              explode('|', $prd_specifications_value) : array();

                         if (!empty($prd_specifications_key) && !empty($prd_specifications_value)) {
                              $count = count($prd_specifications_key);
                              for ($k = 0; $k < $count; $k++) {
                                   if (!empty($prd_specifications_value[$k])) {
                                        array_push($product['specification']['spe_specification'], $prd_specifications_key[$k]);
                                        array_push($product['specification']['spe_specification_detail'], $prd_specifications_value[$k]);
                                   }
                              }
                         }

                         /* Other Brands with same */
                         $other_brands_with_same_key = $objWorksheet->getCellByColumnAndRow(4, $j)->getValue();
                         $other_brands_with_same_key = !empty($other_brands_with_same_key) ?
                              explode('|', $other_brands_with_same_key) : array();

                         $other_brands_with_same_value = $objWorksheet->getCellByColumnAndRow(5, $j)->getValue();
                         $other_brands_with_same_value = !empty($other_brands_with_same_value) ?
                              explode('|', $other_brands_with_same_value) : array();

                         if (!empty($other_brands_with_same_key) && !empty($other_brands_with_same_value)) {
                              $count = count($other_brands_with_same_key);
                              for ($k = 0; $k < $count; $k++) {
                                   if (!empty($other_brands_with_same_value[$k])) {
                                        array_push($product['brandSpecification']['brs_specification'], $other_brands_with_same_key[$k]);
                                        array_push($product['brandSpecification']['brs_part_no'], $other_brands_with_same_value[$k]);
                                   }
                              }
                         }

                         $prdId = $this->product_model->addNewProduct($product);
                         if (!empty($product_image)) {
                              $this->product_model->addImages(array('pdi_prod_id' => $prdId, 'pdi_image' => $product_image));
                         }
                    }
               }
          }

          $this->session->set_flashdata('app_success', 'Product successfully imported!');
          redirect(strtolower(__CLASS__));
     }

     function changesCheckBoxFields($field = 'prd_status', $prdId)
     {
          $status = ($_POST['status'] == 1) ? 0 : 1;
          if ($f = $this->product_model->changesStatus($field, $prdId, $status)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Product status successfully changed' . $f));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't change product status" . $f));
          }
     }

     function bindVehicle()
     {
          $id = $_POST['id'];
          $vehicle = $this->car_name_model->getVehicleByBrand($id);
          echo json_encode($vehicle);
     }

     function bindVariant()
     {
          $id = $_POST['id'];
          $variant = $this->vehicle_model_model->getVariantByVehicle($id);
          echo json_encode($variant);
     }

     function setDefaultImage($imgId, $prodId)
     {
          if (!empty($imgId)) {
               if ($this->product_model->setDefaultImage($imgId, $prodId)) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Updated default image'));
               } else {
                    echo json_encode(array('status' => 'fail', 'msg' => "Can't updated default image"));
               }
          } else {
               return false;
          }
     }

     function product_share($prdId)
     {
          $productDetails = $this->product_model->getSingleProduct($prdId);
          $productDetails['valuation'] = $this->product_model->getProductValuation($productDetails['product_details']['prd_valuation_id']);
          $this->render_page(strtolower(__CLASS__) . '/product_share', $productDetails);
     }

     function downloadspec($prdId)
     {
          $this->load->library('M_pdf');
          $productDetails = $this->product_model->getSingleProduct($prdId);
          $productDetails['valuation'] = $this->product_model->getProductValuation($productDetails['product_details']['prd_valuation_id']);
          if ($productDetails['product_details']['prd_rd_mini'] == 1) {
               $productDetails['spec'] = $html = $this->load->view(strtolower(__CLASS__) . '/product_spec_smart', $productDetails, true);
          } else {
               $productDetails['spec'] = $html = $this->load->view(strtolower(__CLASS__) . '/product_spec', $productDetails, true);
          }

          $pdfFilePath = "product_spec.pdf";
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($pdfFilePath, 'D');
     }

     function prv($prdId)
     {
          $productDetails = $this->product_model->getSingleProduct($prdId);
          $productDetails['valuation'] = $this->product_model->getProductValuation($productDetails['product_details']['prd_valuation_id']);
          $this->load->view(strtolower(__CLASS__) . '/product_spec_smart', $productDetails);
     }

     function downloadimagezipold($prdId)
     {
          $this->load->library('zip');
          $prdId = encryptor($prdId, 'D');
          $productDetails = $this->product_model->getSingleProduct($prdId);
          $fileName = slugify($productDetails['product_details']['brd_title'] . ' ' . $productDetails['product_details']['mod_title'] . ' ' . $productDetails['product_details']['var_variant_name']);
          $images = array_column($productDetails['product_images'], 'pdi_image');
          foreach ($images as $key => $value) {
               $this->zip->read_file(FILE_UPLOAD_PATH . 'product/' . $value);
               //$this->zip->read_file(FILE_UPLOAD_PATH . 'product/380X238_' . $value);
          }
          $this->zip->download($fileName . '.zip');
     }

     function downloadimagezip($prdId)
     {
          $this->load->library('zip');
          $prdId = encryptor($prdId, 'D');
          $productDetails = $this->product_model->getSingleProduct($prdId);
          $fileName = slugify($productDetails['product_details']['brd_title'] . ' ' . $productDetails['product_details']['mod_title'] . ' ' . $productDetails['product_details']['var_variant_name']);
          $images = array_column($productDetails['product_images'], 'pdi_image');

          try {
               //$s3 = new Aws\S3\S3Client(['region' => 'ap-south-1', 'version' => 'latest', 'credentials' => ['key' => "AKIAS4CD2OOUQZJNMDXG", 'secret' => "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"]]);

               foreach ($images as $f) {

                    $result = $this->s3->getObject(array(
                         'Bucket' => AWS_BUC,
                         'Key'    => urldecode($f),
                         'SaveAs' => FILE_UPLOAD_PATH . 'tmp/' . $f
                    ));

                    $this->zip->read_file(FILE_UPLOAD_PATH . 'tmp/' . $f);
                    unlink(FILE_UPLOAD_PATH . 'tmp/' . $f);
               }
               $this->zip->download($fileName . '.zip');
          } catch (Exception $e) {
               die("Error: " . $e->getMessage());
          }
     }

     function pendingPhotoupload($id = 0)
     {

          if (!empty($id)) {
               $data['productsDetails'] = $this->product_model->getSingleProduct($id);
               $this->render_page(strtolower(__CLASS__) . '/uploadimage', $data);
          } else if (!empty($_POST)) {
          } else {
               $data['productList'] = $this->product_model->pendingPhotoupload();
               $this->render_page(strtolower(__CLASS__) . '/pending_photoupload', $data);
          }
     }

     function updateImage()
     {
          $prdId = $this->input->post('prd_id');
          //$s3 = new Aws\S3\S3Client(['region' => 'ap-south-1', 'version' => 'latest', 'credentials' => ['key' => "AKIAXOJGLIEEHAKBQSU2", 'secret' => "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"]]);
          $this->load->library('upload');
          $x1 = $this->input->post('x1');
          $fileCount = count($x1);
          $up = array();

          if ($fileCount > 0) {
               for ($j = 0; $j < $fileCount; $j++) {
                    $this->product_model->updatePhotoloaded($prdId);
                    $this->product_model->updateWalkaround($prdId, $this->input->post('prd_video'));
                    $data = array();
                    $angle = array();
                    $newFileName = rand(9999999, 0) . $_FILES['prd_image']['name'][$j];
                    $config['upload_path'] = '../rdms/assets/uploads/tmp/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    // $config['file_name'] = $newFileName;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);

                    $angle['x1']['0'] = $_POST['x1'][$j];
                    $angle['x2']['0'] = $_POST['x2'][$j];
                    $angle['y1']['0'] = $_POST['y1'][$j];
                    $angle['y2']['0'] = $_POST['y2'][$j];
                    $angle['w']['0'] = $_POST['w'][$j];
                    $angle['h']['0'] = $_POST['h'][$j];

                    $_FILES['prd_image_tmp']['name'] = $_FILES['prd_image']['name'][$j];
                    $_FILES['prd_image_tmp']['type'] = $_FILES['prd_image']['type'][$j];
                    $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['prd_image']['tmp_name'][$j];
                    $_FILES['prd_image_tmp']['error'] = $_FILES['prd_image']['error'][$j];
                    $_FILES['prd_image_tmp']['size'] = $_FILES['prd_image']['size'][$j];
                    if (!$this->upload->do_upload('prd_image_tmp')) {
                         $up = array('error' => $this->upload->display_errors());
                    } else {
                         $data = array('upload_data' => $this->upload->data());
                         //crop($this->upload->data(), $angle);
                         //custome_crop($this->upload->data(), WB_DE_THUMB_W, WB_DE_THUMB_H);
                         $this->product_model->addImages(array('pdi_prod_id' => $prdId, 'pdi_image' => $data['upload_data']['file_name']));
                         try {
                              $this->s3->putObject([
                                   'Bucket' => AWS_BUC,
                                   'Key' => $data['upload_data']['file_name'],
                                   'Body' => fopen($_FILES['prd_image_tmp']['tmp_name'], 'r'),
                              ]);
                         } catch (Aws\S3\Exception\S3Exception $e) {
                              echo "There was an error uploading the file.\n";
                              echo $e;
                         }
                    }
               }
          }
          redirect(strtolower(__CLASS__) . '/pendingPhotoupload/' . $prdId);
     }

     function getValuationProduct()
     {
          $data = $this->product_model->getValuationProduct($_POST);
          $data['model'] = 0;
          $data['variant'] = 0;
          if (isset($data['val_brand'])) {
               $data['model'] = $this->enquiry->getModelByBrand($data['val_brand']);
          }
          if (isset($data['val_model'])) {
               $data['variant'] = $this->enquiry->getVariantByModel($data['val_model']);
          }
          die(json_encode($data));
     }

     function upldphotostockvehicle()
     {
          $data['productList'] = $this->product_model->upldphotostockvehicle($_GET);
          $this->render_page(strtolower(__CLASS__) . '/pending_photoupload', $data);
     }

     function createDummy()
     {
          if (!empty($_POST)) {
               if (!empty($_POST)) {
                    if ($prdId = $this->product_model->addNewProduct($this->input->post())) {
                         $this->load->library('upload');
                         $x1 = $this->input->post('x1');
                         $fileCount = count($x1);
                         $up = array();
                         if ($fileCount > 0) {
                              for ($j = 0; $j < $fileCount; $j++) {
                                   $this->product_model->updatePhotoloaded($prdId);
                                   $data = array();
                                   $angle = array();
                                   $newFileName = rand(9999999, 0) . $_FILES['prd_image']['name'][$j];
                                   $config['upload_path'] = FILE_UPLOAD_PATH . 'product/';
                                   $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                   $config['file_name'] = $newFileName;
                                   $this->upload->initialize($config);

                                   $angle['x1']['0'] = $_POST['x1'][$j];
                                   $angle['x2']['0'] = $_POST['x2'][$j];
                                   $angle['y1']['0'] = $_POST['y1'][$j];
                                   $angle['y2']['0'] = $_POST['y2'][$j];
                                   $angle['w']['0'] = $_POST['w'][$j];
                                   $angle['h']['0'] = $_POST['h'][$j];

                                   $_FILES['prd_image_tmp']['name'] = $_FILES['prd_image']['name'][$j];
                                   $_FILES['prd_image_tmp']['type'] = $_FILES['prd_image']['type'][$j];
                                   $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['prd_image']['tmp_name'][$j];
                                   $_FILES['prd_image_tmp']['error'] = $_FILES['prd_image']['error'][$j];
                                   $_FILES['prd_image_tmp']['size'] = $_FILES['prd_image']['size'][$j];
                                   if (!$this->upload->do_upload('prd_image_tmp')) {
                                        $up = array('error' => $this->upload->display_errors());
                                        debug($up);
                                   } else {
                                        $data = array('upload_data' => $this->upload->data());
                                        custome_crop($this->upload->data(), WB_DE_THUMB_W, WB_DE_THUMB_H);
                                        $setDefault = ($j == 0) ? 1 : 0;
                                        $this->product_model->addImages(
                                             array(
                                                  'pdi_prod_id' => $prdId,
                                                  'pdi_image' => $data['upload_data']['file_name'],
                                                  'pdi_is_default' => $setDefault
                                             )
                                        );
                                   }
                              }
                         }
                         $this->session->set_flashdata('app_success', 'Product successfully added!');
                    } else {
                         $this->session->set_flashdata('app_error', "Can't add product!");
                    }
                    redirect(strtolower(__CLASS__) . '/upldphotostockvehicle');
               }
          } else {
               $this->render_page(strtolower(__CLASS__) . '/create_dummy');
          }
     }

     function createNew()
     {
          if (!empty($_POST)) {
               $vehNo = implode('-', $_POST);
               redirect(strtolower(__CLASS__) . '/add/' . $vehNo);
          }
          $this->render_page(strtolower(__CLASS__) . '/create_new');
     }

     function viewDymmy($id)
     {
          $id = encryptor($id, 'D');
          $data['features'] = $this->features_model->getFeatures();
          $data['prdValuationDtl'] = $valData = $this->product_model->getValuationProduct($_POST);
          $data['productsDetails'] = $prdData = $this->product_model->getSingleProduct($id);

          $vBrand = (isset($valData['val_brand']) && !empty($valData['val_brand'])) ? $valData['val_brand'] : 0;
          $pBrand = (isset($prdData['product_details']['prd_brand']) && !empty($prdData['product_details']['prd_brand'])) ? $prdData['product_details']['prd_brand'] : 0;
          $brand = !empty($pBrand) ? $pBrand : $vBrand;

          $vModel = (isset($valData['val_model']) && !empty($valData['val_model'])) ? $valData['val_model'] : 0;
          $pModel = (isset($prdData['product_details']['prd_model']) && !empty($prdData['product_details']['prd_model'])) ? $prdData['product_details']['prd_model'] : 0;
          $model = !empty($pModel) ? $pModel : $vModel;

          $vVarnt = (isset($valData['val_variant']) && !empty($valData['val_variant'])) ? $valData['val_variant'] : 0;
          $pVarnt = (isset($prdData['product_details']['prd_variant']) && !empty($prdData['product_details']['prd_variant'])) ? $prdData['product_details']['prd_variant'] : 0;
          $varnt = !empty($pVarnt) ? $pVarnt : $vVarnt;

          $data['selectBrand'] = $brand;
          $data['selectModel'] = $model;
          $data['selectVarint'] = $varnt;

          $data['order'] = $this->product_model->getNextOrder(true);
          $data['brands'] = $this->brand_model->getBrands();
          $data['category'] = $this->category_model->categoryTree();
          $data['variant'] = $this->variant_model->getVariantByModel($model);
          $data['model'] = $this->model_model->getVehicleByBrand($brand);
          $data['location'] = $this->showroom->get();
          $data['color'] = $this->product_model->getColor();
          $this->render_page(strtolower(__CLASS__) . '/view_dummy', $data);
     }

     function getPhotoUploadedImages()
     {
          $alreadyImageUploaded = $this->product_model->getProdImagesByVehRegNumber($_POST);
          if (!empty($alreadyImageUploaded)) {
               $msg = "Product images already uploaded, you don't have upload images again, click 'Submit' to update other details";
               die(json_encode(array(
                    'status' => 'success',
                    'msg' => 'Already exists',
                    'action' => site_url('product/viewDymmy/' . encryptor($alreadyImageUploaded['prd_id'])),
                    'prd_id' => $alreadyImageUploaded['prd_id'],
                    'msg' => $msg
               )));
          } else {
               die(json_encode(array(
                    'status' => 'fail',
                    'msg' => 'Product not found',
                    'action' => site_url('product/createnew'),
                    'prd_id' => 0
               )));
          }
     }

     // function healthcard_luxury($prdId)
     // {


     //      // Query to check if record exists
     //      $this->db->where('hc_prd_id', $prdId);
     //      $query = $this->db->get('cpnl_health_card');

     //      // Check if there is a row with the specified hc_prd_id
     //      if ($query->num_rows() > 0) {
     //          echo "Record exists!";
     //      } else {
     //          echo "Record does not exist.";
     //      }


     //      $productDetails = $this->product_model->getSingleProduct($prdId);
     //      $productDetails['valuation'] = $this->product_model->getProductValuation($productDetails['product_details']['prd_valuation_id']);
     //      if ($productDetails['product_details']['prd_rd_mini'] == 1) {
     //           $productDetails['spec'] = $html = $this->load->view(strtolower(__CLASS__) . '/healthcart_luxury', $productDetails, true);
     //      } else {
     //           $productDetails['spec'] = $html = $this->load->view(strtolower(__CLASS__) . '/healthcart_luxury', $productDetails, true);
     //      }
     //      echo $html;
     // }


     function healthcard_luxury_bk($prdId)
     {
          // $query = "ALTER TABLE `cpnl_health_card` ADD COLUMN `hc_km` INT(11) DEFAULT 0";

          //$this->db->query($query);
          // Query to check if record exists

          $this->db->where('hc_prd_id', $prdId);
          $query = $this->db->get('cpnl_health_card');

          // Check if there is a row with the specified hc_prd_id
          if ($query->num_rows() > 0) {
               // $data = $this->product_model->getSingleProduct($prdId);
               //debug(771);
               $data = $this->product_model->getHealthCard($prdId);
               $data['uid'] = $this->uid;
               //  debug($data);
               // echo "Record exists!";
               $html = $this->load->view(strtolower(__CLASS__) . '/healthcard', $data, true);
               echo $html;
          } else {
               //echo "Record does not exist.";
               redirect(strtolower(__CLASS__) . '/create_health_card/' . $prdId);
          }
     }



     function healthcard_luxury($prdId)
     {
          // $query = "ALTER TABLE `cpnl_health_card` ADD COLUMN `hc_km` INT(11) DEFAULT 0";
          // $this->db->where('hc_prd_id', $prdId);
          //$query = $this->db->get('cpnl_health_card');
          $data = $this->product_model->getHealthCard($prdId);
          // debug($data);
          // Check if there is a row with the specified hc_prd_id
          // if ($query->num_rows() > 0) {
          if ($data['main']) {
               // $data = $this->product_model->getSingleProduct($prdId);
               //debug(771);
               //   $data = $this->product_model->getHealthCard($prdId);
               $data['uid'] = $this->uid;
               //  debug($data);
               // echo "Record exists!";
               $html = $this->load->view(strtolower(__CLASS__) . '/healthcard', $data, true);
               echo $html;
          } else {
               //echo "Record does not exist.";
               redirect(strtolower(__CLASS__) . '/create_health_card/' . $prdId);
          }
     }

     function healthcard_from_val($val_id)
     {
          $prdId = $this->product_model->getPrdIdByValId($val_id);
          if (!$prdId) {
               //debug('No record found');
               $data = $this->product_model->getHealthCardByValId($val_id);
               //debug($data);
               if ($data['main']) {   // echo "Record exists!";

                    $data['uid'] = $this->uid;
                    //debug($data);
                    $html = $this->load->view(strtolower(__CLASS__) . '/healthcard', $data, true);
                    echo $html;
               } else {
                    //echo "Record does not exist.";
                    redirect(strtolower(__CLASS__) . '/create_health_card_by_val/' . $val_id);
               }
          }

          $this->healthcard_luxury($prdId);
     }

     function create_health_card($prdId)
     {
          $data = $this->product_model->getSingleProduct($prdId);
          //debug($data);
          //*  $data['valuation'] = $this->product_model->getProductValuation($data['product_details']['prd_valuation_id']);
          $data['valuation'] = $this->product_model->getHealthCardValData($data['product_details']['prd_valuation_id']);
          // debug($data['valuation'] );
          $data['color'] = $this->evaluation->getColors();
          $data['tyre'] = $this->evaluation->getTyre();
          //debug($data);
          $this->render_page(strtolower(__CLASS__) . '/create_health_card', $data);
     }

     function create_health_card_by_val($val_id)
     {
          //  $data = $this->product_model->getSingleProduct($prdId);
          //debug($data);
          $data['valuation'] = $this->product_model->getHealthCardValData($val_id);
          //  debug($data['valuation'] );
          $data['color'] = $this->evaluation->getColors();
          $data['tyre'] = $this->evaluation->getTyre();
          $data['refurbDetails'] = $this->product_model->getRfDtlsForHealthCard($val_id);
          //debug($data);
          $this->render_page(strtolower(__CLASS__) . '/create_health_card_by_val', $data);
     }


     public function saveHealthCard()
     {
          // debug($_POST);
          // exit;
          // Check if it's an AJAX request
          if ($this->input->is_ajax_request()) {
               $this->load->library('form_validation');
               $this->load->helper('form');

               // Set validation rules

               // Set validation rules
               $this->form_validation->set_rules('hc_km', 'KM Driven', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_minif_month', 'Manufacture Month', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_minif_year', 'Manufacture Year', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_no_of_owner', 'Ownership', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_torque', 'Torque', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_arai_tstd_fuel_efncy', 'ARAI Tested Fuel efficiency', 'required|numeric|greater_than[0]');
               //$this->form_validation->set_rules('hc_wrnty_type', ' Warranty Type', 'required|greater_than[0]'); 


               $form = $this->input->post('f');
               unset($_POST['f']);

               if ($this->form_validation->run() == false) {
                    // Validation failed, show error messages and repopulate form data
                    $response = array('success' => false, 'message' => validation_errors());
               } else {
                    // Validation passed, process the form data (your logic here)
                    $res = $this->product_model->addNewHealthCard($this->input->post());
                    if ($res) {
                         $prdId = $this->input->post('hc_prd_id');
                         if ($prdId == 0) {
                              $valId = $this->input->post('hc_val_id');
                              $url = site_url(strtolower(__CLASS__) . '/healthcard_from_val/' . $valId);
                         } else {
                              $url = site_url(strtolower(__CLASS__) . '/healthcard_luxury/' . $prdId);
                         }

                         $response = array('success' => true, 'message' => 'Successfully Created .', 'url' => $url);
                    } else {
                         $response = array('success' => false, 'message' => 'An error occurred while saving data.');
                    }
               }

               // Send JSON response back to the AJAX request
               $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
          } else {
               // Non-AJAX request, handle as usual
               error_log('Non-AJAX request received'); // Add debugging statement

               // Your existing code for non-AJAX form submission
          }
     }


     function deleteHealthCard($hc_id)
     {
          $res = $this->product_model->deleteHealthCard($hc_id);
          echo $res;
     }

     function editHealthCard($hc_id)
     {
          $data = $this->product_model->getHealthCardByHcId($hc_id);
          //  debug($data);
          //   print_r($data['rfDetails']);
          //debug($data['main']);
          $data['color'] = $this->evaluation->getColors();
          $data['tyre'] = $this->evaluation->getTyre();
          $data['allrefurbDetails'] = $this->product_model->getRfDtlsForHealthCard($data['main']['hc_val_id']);
          // debug($data['allrefurbDetails']);
          $this->render_page(strtolower(__CLASS__) . '/edit_health_card', $data);
     }

     public function updateHealthCard()
     {
          // debug($_POST);
          // exit;
          // Check if it's an AJAX request
          if ($this->input->is_ajax_request()) {
               $this->load->library('form_validation');
               $this->load->helper('form');

               // Set validation rules

               // Set validation rules
               $this->form_validation->set_rules('hc_id', 'KM Driven', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_km', 'KM Driven', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_minif_month', 'Manufacture Month', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_minif_year', 'Manufacture Year', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_no_of_owner', 'Ownership', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_torque', 'Torque', 'required|numeric|greater_than[0]');
               $this->form_validation->set_rules('hc_arai_tstd_fuel_efncy', 'ARAI Tested Fuel efficiency', 'required|numeric|greater_than[0]');
               //$this->form_validation->set_rules('hc_wrnty_type', ' Warranty Type', 'required|greater_than[0]'); 


               $form = $this->input->post('f');
               unset($_POST['f']);

               if ($this->form_validation->run() == false) {
                    // Validation failed, show error messages and repopulate form data
                    $response = array('success' => false, 'message' => validation_errors());
               } else {
                    // Validation passed, process the form data (your logic here)
                    $res = $this->product_model->updateHealthCard($this->input->post());
                    if ($res) {
                         $prdId = $this->input->post('hc_prd_id');
                         if ($prdId == 0) {
                              $valId = $this->input->post('hc_val_id');
                              $url = site_url(strtolower(__CLASS__) . '/healthcard_from_val/' . $valId);
                         } else {
                              $url = site_url(strtolower(__CLASS__) . '/healthcard_luxury/' . $prdId);
                         }

                         $response = array('success' => true, 'message' => 'Successfully Updated .', 'url' => $url);
                    } else {
                         $response = array('success' => false, 'message' => 'An error occurred while updating data.');
                    }
               }

               // Send JSON response back to the AJAX request
               $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
          } else {
               // Non-AJAX request, handle as usual
               error_log('Non-AJAX request received'); // Add debugging statement

               // Your existing code for non-AJAX form submission
          }
     }
}
