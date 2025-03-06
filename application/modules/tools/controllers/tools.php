<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class tools extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Tools';
            $this->load->model('tools_model', 'tools');
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            $this->load->model('reports/reports_model', 'reports');
       }

       public function sendWhatsAppMessage() {
            $filterStatus = isset($_GET['status']) ? $_GET['status'] : 0;

            $this->load->library("pagination");
            $limit = get_settings_by_key('pagination_limit');
            $page = !isset($_GET['page']) ? 0 : $_GET['page'];
            $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
            $link = $linkParts[0];
            $config = getPaginationDesign();

            $data = $_GET;
            $enquires = $this->tools->enquires('', array(), $limit, $page, $_GET);
            $data['enquires'] = $enquires['data'];

            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config["base_url"] = $link;
            $config["total_rows"] = $enquires['count'];
            $config["per_page"] = $limit;
            $config["uri_segment"] = 3;

            /* Table info */
            $data['pageIndex'] = $page + 1;
            $data['limit'] = $page + $limit;
            $data['totalRow'] = number_format($enquires['count']);
            /* Table info */

            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();

            $this->render_page(strtolower(__CLASS__) . '/sendWhatsAppMessage', $data);
       }

       function sendMessage() {
            $apikey = get_logged_user('usr_api_key');
            $this->load->library('upload');
            $image = '';

            if (!empty($_POST['enq_id'])) {
                 $message = urlencode(trim($_POST['message']));
                 if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                      $data = array();
                      $newFileName = rand(9999999, 0) . $_FILES['image']['name'];
                      $config['upload_path'] = FILE_UPLOAD_PATH . 'tmp/';
                      $config['allowed_types'] = 'gif|jpg|png';
                      $config['file_name'] = $newFileName;
                      $this->upload->initialize($config);

                      if (!$this->upload->do_upload('image')) {
                           $data = array('error' => $this->upload->display_errors());
                      } else {
                           $data = $this->upload->data();
                           $image = $data['file_name'];
                      }
                 }
                 if (!empty($message)) {
                      foreach ($_POST['enq_id'] as $key => $value) {

                           $number = $this->tools->customerWhatsappNumber($value);
                           $number = clean_whatsapp_num($number);
                           //Send image
                           if (!empty($image)) {
                                $url = "https://panel.apiwha.com/send_message.php?apikey=" . urlencode($apikey) . "&number=" . urlencode($number)
                                        . "&text=" . $image;
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => "",
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 30,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "GET",
                                    CURLOPT_SSL_VERIFYHOST => false,
                                    CURLOPT_SSL_VERIFYPEER => false
                                ));

                                $response = curl_exec($curl);
                                $err = curl_error($curl);

                                curl_close($curl);

                                if ($err) {
                                     $_POST['resp'] = $err;
                                     generate_log(array(
                                         'log_title' => 'Bulk whats app message error',
                                         'log_desc' => serialize($_POST),
                                         'log_controller' => 'bulk-wapp-msg-error',
                                         'log_action' => 'C',
                                         'log_ref_id' => 0,
                                         'log_added_by' => get_logged_user('usr_id')
                                     ));
                                } else {
                                     $_POST['resp'] = $response;
                                     generate_log(array(
                                         'log_title' => 'Bulk whats app message',
                                         'log_desc' => serialize($_POST),
                                         'log_controller' => 'bulk-wapp-msg',
                                         'log_action' => 'C',
                                         'log_ref_id' => 0,
                                         'log_added_by' => get_logged_user('usr_id')
                                     ));
                                }
                           }
                           //Send text
                           $number = $this->tools->customerWhatsappNumber($value);
                           $url = "https://panel.apiwha.com/send_message.php?apikey=" . urlencode($apikey) . "&number=" . urlencode($number)
                                   . "&text=" . $message;
                           $curl = curl_init();
                           curl_setopt_array($curl, array(
                               CURLOPT_URL => $url,
                               CURLOPT_RETURNTRANSFER => true,
                               CURLOPT_ENCODING => "",
                               CURLOPT_MAXREDIRS => 10,
                               CURLOPT_TIMEOUT => 30,
                               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                               CURLOPT_CUSTOMREQUEST => "GET",
                               CURLOPT_SSL_VERIFYHOST => false,
                               CURLOPT_SSL_VERIFYPEER => false
                           ));

                           $response = curl_exec($curl);
                           $err = curl_error($curl);

                           curl_close($curl);

                           if ($err) {
                                $_POST['resp'] = $err;
                                generate_log(array(
                                    'log_title' => 'Bulk whats app message error',
                                    'log_desc' => serialize($_POST),
                                    'log_controller' => 'bulk-wapp-msg-error',
                                    'log_action' => 'C',
                                    'log_ref_id' => 0,
                                    'log_added_by' => get_logged_user('usr_id')
                                ));
                                $this->session->set_flashdata('app_success', 'Error occure when sent bulk whatsapp message!');
                           } else {
                                $_POST['resp'] = $response;
                                generate_log(array(
                                    'log_title' => 'Bulk whats app message',
                                    'log_desc' => serialize($_POST),
                                    'log_controller' => 'bulk-wapp-msg',
                                    'log_action' => 'C',
                                    'log_ref_id' => 0,
                                    'log_added_by' => get_logged_user('usr_id')
                                ));
                                $this->session->set_flashdata('app_success', 'Bulk whatsapp message successfully completed!');
                           }
                      }
                 } else {
                      generate_log(array(
                          'log_title' => 'Bulk whats app message',
                          'log_desc' => 'Something wrong',
                          'log_controller' => 'bulk-wapp-msg',
                          'log_action' => 'C',
                          'log_ref_id' => 0,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                      $this->session->set_flashdata('app_success', 'Bulk whatsapp message, something wrong!');
                 }
            }
            redirect(__CLASS__ . '/sendWhatsAppMessage');
       }

       function sendBulkSms() {
            error_reporting(E_ALL);
            $this->page_title = 'Tools | Send bulk sms';
            $this->load->model('settings/settings_model', 'settings');

            $customers = array();
            if (!empty($_POST)) {
                 if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
                      if (isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'blk_sms_ind_customers') {
                           $this->settings->newSettings($this->input->post('settings'));
                           $customers = $this->tools->getAllCustomerContactsBySE();
                           $template = isset($_POST['settings']['blk_sms_template']) ? $_POST['settings']['blk_sms_template'] : '';
                           if (!empty($customers)) {
                                foreach ($customers as $key => $value) {
                                     if (is_indian_number($value['enq_cus_mobile'])) {
                                          $message = str_replace('{cust_name}', $value['enq_cus_name'], $template);
                                          $message = str_replace('{se_name}', $value['usr_username'], $message);
                                          $message = str_replace('{se_number}', $value['usr_phone'], $message);
                                          send_sms($message, $value['enq_cus_mobile'], 'sms-bulk');
                                          $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('enq_sms_sent' => 1));
                                     }
                                }
                                $this->session->set_flashdata('app_success', 'Bulk SMS sent ' . count($customers) . ' customers');
                           }
                      } else if (isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'blk_sms_direct') {
                           $this->settings->newSettings($this->input->post('settings'));
                           if (!empty($_POST['settings']['blk_sms_numbers'])) {
                                $numbers = explode(',', $_POST['settings']['blk_sms_numbers']);
                                $message = isset($_POST['settings']['blk_sms_template_direct']) ? $_POST['settings']['blk_sms_template_direct'] : '';
                                foreach ($numbers as $key => $phoneNumber) {
                                     if (is_indian_number($phoneNumber)) {
                                          send_sms($message, $phoneNumber, 'sms-bulk-direct-number');
                                     }
                                }
                                $this->session->set_flashdata('app_success', 'Bulk SMS sent ' . count($numbers) . ' customers');
                           }
                      }
                 } else {
                      $this->session->set_flashdata('app_success', 'Please confirm to send SMS');
                 }
                 $this->render_page(strtolower(__CLASS__) . '/sendBulkSms');
            } else if (!empty($_GET)) {
                 if (!empty($_GET)) {
                      $data['veh_brand'] = isset($_GET['vehicle']['sale']['veh_brand'][0]) ? $_GET['vehicle']['sale']['veh_brand'][0] : 0;
                      $data['veh_model'] = isset($_GET['vehicle']['sale']['veh_model'][0]) ? $_GET['vehicle']['sale']['veh_model'][0] : 0;
                      $data['veh_varient'] = isset($_GET['vehicle']['sale']['veh_varient'][0]) ? $_GET['vehicle']['sale']['veh_varient'][0] : 0;

                      if (isset($_GET['vehicle']['sale']['veh_brand'])) {
                           $brand = isset($_GET['vehicle']['sale']['veh_brand'][0]) ? $_GET['vehicle']['sale']['veh_brand'][0] : 0;
                           $data['model'] = $this->enquiry->getModelByBrand($brand, 'array');
                      }
                      if (isset($_GET['vehicle']['sale']['veh_model'])) {
                           $model = isset($_GET['vehicle']['sale']['veh_model'][0]) ? $_GET['vehicle']['sale']['veh_model'][0] : 0;
                           $data['variant'] = $this->enquiry->getVariantByModel($model, 'array');
                      }
                 }
                 $data = $this->reports->quickVehicleSearch($_GET);
                 $data['numbers'] = (isset($data['data']) && !empty($data['data'])) ? array_filter(array_column($data['data'], 'enq_cus_mobile')) : array();
                 $this->render_page(strtolower(__CLASS__) . '/sendBulkSms', $data);
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/sendBulkSms');
            }
       }

  }
  