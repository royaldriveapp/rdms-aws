<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require '../rdmsdev/vendors/aws-vendor/autoload.php';
class designation extends App_Controller {

     public function __construct() {

          parent::__construct();
          $this->page_title = 'Designation';
          $this->load->library('form_validation');
          $this->load->model('designation_model', 'designation');
          $this->s3 = new Aws\S3\S3Client([
               'region' => AWS_REG,
               'version' => AWS_VER,
               'credentials' => [
                    'key' => AWS_KEY,
                    'secret' => AWS_SEC
               ]
          ]);
          $this->allowTypes = array('pdf','doc','docx','xls','xlsx','jpg','png','jpeg','gif'); 
     }

     public function index() {
          $accessories['data'] = $this->designation->getData();
          $this->render_page(strtolower(__CLASS__) . '/list', $accessories);
     }

     public function add() {
          if (!empty($_POST)) {
               if(isset($_FILES["jd"]["name"])) {
                    $file_name = basename($_FILES["jd"]["name"]);
                    $file_type = pathinfo($file_name, PATHINFO_EXTENSION); 
                    if(in_array($file_type, $this->allowTypes)) { 
                         $file_temp_src = $_FILES["jd"]["tmp_name"];
                         try {
                              $result = $this->s3->putObject([ 
                                   'Bucket' => AWS_BUC_JD, 
                                   'Key'    => $file_name, 
                                   'SourceFile' => $file_temp_src,
                                   'Body' => fopen($_FILES['jd']['tmp_name'], 'r'),
                              ]); 
                         } catch (Aws\S3\Exception\S3Exception $e) {
                              echo "There was an error uploading the file.\n";
                              echo $e;
                         }
                         $_POST['desig_jd'] = $file_name;
                    }
               }
               if ($this->designation->addData($_POST)) {
                    $this->session->set_flashdata('app_success', 'Division successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't add division!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $data['designation'] = $this->designation->getData();
               $data['travelModes'] = $this->designation->getTravelModes();
               $this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     public function view($id) {
          $accessories['data'] = $this->designation->getData($id);
          $accessories['travelModes'] = $this->designation->getTravelModes();
          $this->render_page(strtolower(__CLASS__) . '/view', $accessories);
     }

     public function update() {
          if(isset($_FILES["jd"]["name"])) {
               $file_name = basename($_FILES["jd"]["name"]);
               $file_temp_src = $_FILES["jd"]["tmp_name"];
               $file_type = pathinfo($file_name, PATHINFO_EXTENSION); 
               if(in_array($file_type, $this->allowTypes)) { 
                    try {
                         $result = $this->s3->putObject([ 
                              'Bucket' => AWS_BUC_JD, 
                              'Key'    => $file_name, 
                              'SourceFile' => $file_temp_src,
                              'Body' => fopen($_FILES['jd']['tmp_name'], 'r'),
                         ]); 
                    } catch (Aws\S3\Exception\S3Exception $e) {
                         echo "There was an error uploading the file.\n";
                         echo $e;
                    }
                    $_POST['desig_jd'] = $file_name;
               }
          }
          if ($this->designation->updateData($_POST)) {
               $this->session->set_flashdata('app_success', 'Update successfully!');
          } else {
               $this->session->set_flashdata('app_error', "Can't update!");
          }
          redirect(strtolower(__CLASS__));
     }

     public function delete($id) {
          if ($this->designation->deleteData($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Delete successfully'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete"));
          }
     }

}
