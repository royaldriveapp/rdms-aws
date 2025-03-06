<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class crone extends CI_Controller {

       public function __construct() {
            parent::__construct();
            $this->tbl_model = TABLE_PREFIX . 'model';
            $this->tbl_brand = TABLE_PREFIX . 'brand';
            $this->tbl_variant = TABLE_PREFIX . 'variant';
            $this->tbl_valuation = TABLE_PREFIX_PORTAL . 'valuation';
            $this->load->model('Common_model', 'common');

            $this->tbl_city = TABLE_PREFIX_PORTAL . 'city';
            $this->tbl_state = TABLE_PREFIX_PORTAL . 'state';
            $this->tbl_place = TABLE_PREFIX_PORTAL . 'place';
            $this->tbl_users = TABLE_PREFIX_PORTAL . 'users';
            $this->tbl_groups = TABLE_PREFIX_PORTAL . 'groups';
            $this->tbl_states = TABLE_PREFIX_PORTAL . 'states';
            $this->tbl_rto_office = TABLE_PREFIX_PORTAL . 'rto_office';
            $this->tbl_user_access = TABLE_PREFIX_PORTAL . 'user_access';
            $this->tbl_valuation = TABLE_PREFIX_PORTAL . 'valuation';
            $this->tbl_showroom = TABLE_PREFIX_PORTAL . 'showroom';
            $this->tbl_country = TABLE_PREFIX_PORTAL . 'country';
            $this->tbl_vehicle = TABLE_PREFIX_PORTAL . 'vehicle';
            $this->tbl_enquiry = TABLE_PREFIX_PORTAL . 'enquiry';
            $this->tbl_statuses = TABLE_PREFIX_PORTAL . 'statuses';
            $this->tbl_followup = TABLE_PREFIX_PORTAL . 'followup';
            $this->tbl_district = TABLE_PREFIX_PORTAL . 'district';
            $this->tbl_showroom = TABLE_PREFIX_PORTAL . 'showroom';
            $this->tbl_questions = TABLE_PREFIX_PORTAL . 'questions';
            $this->tbl_occupation = TABLE_PREFIX_PORTAL . 'occupation';
            $this->tbl_users_groups = TABLE_PREFIX_PORTAL . 'users_groups';
            $this->tbl_vehicle_colors = TABLE_PREFIX_PORTAL . 'vehicle_colors';
            $this->tbl_enq_prefrences = TABLE_PREFIX_PORTAL . 'enq_prefrences';
            $this->tbl_vehicle_status = TABLE_PREFIX_PORTAL . 'vehicle_status';
            $this->tbl_quick_tc_report = TABLE_PREFIX_PORTAL . 'quick_tc_report';
            $this->tbl_register_master = TABLE_PREFIX_PORTAL . 'register_master';
            $this->tbl_enquiry_history = TABLE_PREFIX_PORTAL . 'enquiry_history';
            $this->tbl_valuation_status = TABLE_PREFIX_PORTAL . 'valuation_status';
            $this->tbl_enquiry_questions = TABLE_PREFIX_PORTAL . 'enquiry_questions';
            $this->tbl_followup_view_log = TABLE_PREFIX_PORTAL . 'followup_view_log';
            $this->view_vehicle_vehicle_status = TABLE_PREFIX_PORTAL . 'view_vehicle_vehicle_status';
            $this->view_enquiry_vehicle_master = TABLE_PREFIX_PORTAL . 'view_enquiry_vehicle_master';
            $this->tbl_procurement_rqsts = TABLE_PREFIX_PORTAL . 'procurement_rqsts';
            $this->tbl_procurement_rqst_details = TABLE_PREFIX_PORTAL . 'procurement_rqst_details';
            $this->tbl_procurement_rqst_status = TABLE_PREFIX_PORTAL . 'procurement_rqst_status';
            $this->tbl_travel_modes = TABLE_PREFIX_PORTAL . 'travel_modes';
            $this->tbl_home_visits = TABLE_PREFIX_PORTAL . 'home_visits';
            $this->tbl_test_drives = TABLE_PREFIX_PORTAL . 'test_drives';
            $this->tbl_home_visits_approvals = TABLE_PREFIX_PORTAL . 'home_visit_approvals';
            $this->tbl_test_drive_approvals = TABLE_PREFIX_PORTAL . 'test_drive_approvals';
            $this->tbl_district_statewise = TABLE_PREFIX_PORTAL . 'district_statewise';
            $this->tbl_vehicle_booking_master = TABLE_PREFIX_PORTAL . 'vehicle_booking_master';
            $this->tbl_divisions = TABLE_PREFIX_PORTAL . 'divisions';
            $this->tbl_showroom = TABLE_PREFIX_PORTAL . 'showroom';
       }

       /**
        * Compress images without loosing quality
        */
       function compimg($quality = 10) {
            $path = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'evaluation' . DIRECTORY_SEPARATOR;
            //. 'vehicle' . DIRECTORY_SEPARATOR
            //debug(glob($path . "*.jp*"), 0);
            //$path = glob($path . "*.jp*");
            //echo $path[1];
            //$res = ImageJPEG(ImageCreateFromString(file_get_contents($path[1])), $path[1], 50);
            //exit;
            $index = 1;
            $ttlsise = 0;
            foreach (glob($path . "*.jp*") as $key => $file) {
                 $file_size = filesize($file);
                 $file_size = $file_size / 1024; // Convert to KB
                 // if ($file_size > 200) {
                 $res = ImageJPEG(ImageCreateFromString(file_get_contents($file)), $file, $quality);
                 echo $index . ' - ' . $file . ' - ' . $file_size . '<br>';
                 $index++;
                 $ttlsise = $ttlsise + $file_size;
                 // }
            }
            echo '<br><h2>' . $ttlsise . ' MB</h2>';
            echo '<br><h2>' . $ttlsise / 1024 . ' GB</h2>';
       }

       /**
        * Delete unused images from server, products
        */
       function unusedValImages() {
            error_reporting(E_ALL);
            $mydir = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'evaluation' . DIRECTORY_SEPARATOR . 'vehicle' . DIRECTORY_SEPARATOR;
            $myfiles = scandir($mydir, 1);

            $i = 0;
            foreach ($myfiles as $key => $value) {
                 if (strpos($value, '380X238') !== FALSE) {
                      
                 } else {
                      $prdImages = $this->db->select('vvi_image')->like('vvi_image', trim($value), 'none')->get('cpnl_valuation_veh_images')->result_array();
                      //echo $value . '<br>';
                      //echo '-----------------<br>'; 
                      if (!empty($prdImages)) {
                           //debug($prdImages, 0);
                      } else if (!empty($value)) {
                           //echo '<img width="100" src="https://www.royaldrive.in/assets/uploads/evaluation/vehicle/' . $value . '"/><br>';
                           echo $value . '<br>';
                           //unlink($mydir . '/' . $value);
                           //unlink($mydir . '/380X238_' . $value);
                      }
                 }
            }
            //echo $i; 
            exit;
            //
            //debug($prdImages);
            //debug($myfiles); 
       }

       /**
        * Delete unused images from server, products
        */
       function unusedProdImages() {
            error_reporting(E_ALL);
            $mydir = FCPATH . 'assets/uploads/product/';
            $myfiles = scandir($mydir, 1);

            $i = 0;
            foreach ($myfiles as $key => $value) {
                 if (strpos($value, '380X238') !== FALSE) {
                      
                 } else {
                      $prdImages = $this->db->select('pdi_image')->like('pdi_image', trim($value), 'both')->get('rana_prod_images')->result_array();

                      //echo $value . '<br>';
                      //echo '-----------------<br>'; 
                      if (!empty($prdImages)) {
                           //debug($prdImages, 0);
                      } else if (!empty($value)) {
                           echo $this->db->last_query() . '<br>';
                           //echo '<img width="100" src="https://www.royaldrive.in/assets/uploads/evaluation/vehicle/' . $value . '"/><br>';
                           echo $value . '<br>';
                           unlink($mydir . $value);
                           //unlink($mydir . '/380X238_' . $value);
                      }
                 }
            }
            exit;
       }

       function preparesitemap() {
            //"https://royaldrive.in/comeonkerala",
            //"https://royaldrive.in/comeonkerala/lucky-draw"
            $static_values = [
                "https://royaldrive.in",
                "https://royaldrive.in/used-audi-cars",
                "https://royaldrive.in/used-bmw-cars",
                "https://royaldrive.in/used-mercedes-benz-cars",
                "https://royaldrive.in/used-lamborghini-cars",
                "https://royaldrive.in/used-porsche-cars",
                "https://royaldrive.in/used-volvo-cars",
                "https://royaldrive.in/used-jaguar-cars",
                "https://royaldrive.in/used-land-rover-cars",
                "https://royaldrive.in/used-lexus-cars",
                "https://royaldrive.in/used-mini-cooper-cars",
                "https://royaldrive.in/used-bentley-cars",
                "https://royaldrive.in/pre-owned-luxury-cars",
                "https://royaldrive.in/pre-owned-luxury-bikes",
                "https://royaldrive.in/used-harley-davidson-bikes",
                "https://royaldrive.in/used-toyota-cars",
                "https://royaldrive.in/used-triumph-bikes",
                "https://royaldrive.in/used-kawasaki-bikes",
                "https://royaldrive.in/used-bmw-motorrad",
                "https://royaldrive.in/used-ford-cars",
                "https://royaldrive.in/used-tvs-bikes",
                "https://royaldrive.in/used-royal-enfield-bikes",
                "https://royaldrive.in/used-ktm-bikes",
                "https://royaldrive.in/used-jeep-cars",
                "https://royaldrive.in/aboutus",
                "https://royaldrive.in/contactus",
                "https://royaldrive.in/career",
                "https://royaldrive.in/sell-your-vehicle",
                "https://royaldrive.in/testimonials",
                "https://royaldrive.in/blog",
                "https://royaldrive.in/assets/150-check-points.pdf"
            ];
            $sitemap_text = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

            foreach ($static_values as $value) {
                 $mod_date = date('c');
                 $priority = '0.80';
                 if ($value == 'https://royaldrive.in/')
                      $priority = '1.00';
                 $sitemap_text .= "<url>
        <loc>$value</loc>
        <lastmod>$mod_date</lastmod>
        <priority>$priority</priority>
    </url>";
            }
            $Vehicles = $this->common->VehiclesSiteMap();
            foreach ((array) $Vehicles as $key => $value) {
                 $mod_date = date('c');
                 $priority = '0.80';
                 $name = $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'];
                 $url = site_url($value['brd_slug'] . '/' . get_url_string($name) . '-' . $value['prd_id']);

                 $sitemap_text .= "<url>
        <loc>$url</loc>
        <lastmod>$mod_date</lastmod>
        <priority>$priority</priority>
    </url>";
            }
            $sitemap_text .= '</urlset>';
            $sitemap = fopen('sitemap.xml', 'w');
            fwrite($sitemap, $sitemap_text);

            generate_log(array(
                'log_title' => 'Generate site max XML',
                'log_desc' => 'Generate site max XML',
                'log_controller' => 'cron-prepare-sitemap-luxury',
                'log_action' => 'C',
                'log_ref_id' => 9090,
                'log_added_by' => 9090
            ));
       }

       function sendsms() {
            $senderid = get_settings_by_key('sms_sender_id');
            $username = get_settings_by_key('sms_username');
            $password = get_settings_by_key('sms_password');

            $tmpId = '1607100000000042909';
            $route = 2;
            $enqs = $this->db->select('enq_id, enq_cus_name, enq_cus_mobile')->limit(300)->get_where(
                            'cpnl_enquiry',
                            array('enq_current_status' => 1, 'is_exe' => 0)
                    )->result_array();

            // $rootuser = array(
            // 9745661946
            // );
            // foreach ($rootuser as $key => $value) {
            // $msg = "Dear Customer, Wishing you a joyous Christmas and a prosperous New Year, 918129909090 - Royal Drive South
            // India's Largest Pre-Owned Luxury Car Showroom";
            // $mob = str_replace(' ','', trim($value));
            // $msg = urlencode($msg);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, "https://sms.xpresssms.in/api/api.php?");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, "ver=1&mode=1&action=push_sms&type=1&route=" . $route . "&login_name=" .
            //$username . "&api_password=" . $password . "&message=" .
            // $msg . "&number=" . $mob . "&sender=" . $senderid . "&template_id=" . $tmpId);
            // $buffer = curl_exec($ch);
            // curl_close($ch);
            // }

            if (!empty($enqs)) {
                 foreach ($enqs as $key => $value) {
                      $msg = "Dear Customer, Wishing you a joyous Christmas and a prosperous New Year, 918129909090 - Royal Drive South
India's Largest Pre-Owned Luxury Car Showroom";
                      $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('is_exe' => 1));
                      $mob = str_replace(' ', '', trim($value['enq_cus_mobile']));
                      $msg = urlencode($msg);
                      $ch = curl_init();

                      curl_setopt($ch, CURLOPT_URL, "https://sms.xpresssms.in/api/api.php?");
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_POST, 1);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, "ver=1&mode=1&action=push_sms&type=1&route=" . $route . "&login_name=" . $username
                              . "&api_password=" . $password . "&message=" .
                              $msg . "&number=" . $mob . "&sender=" . $senderid . "&template_id=" . $tmpId);
                      $buffer = curl_exec($ch);
                      curl_close($ch);
                      echo $value['enq_cus_name'] . ' - ' . $value['enq_cus_mobile'] . ' - ' . $ch . '<br>';
                 }
            } else {
                 echo 'Empty';
            }
            //debug($enqs);
       }

       function rdownvehicleinsurancerenewal() {

            $senderid = get_settings_by_key('sms_sender_id');
            $username = get_settings_by_key('sms_username');
            $password = get_settings_by_key('sms_password');
            $tmpId = '1607100000000042909';
            $enty = '1601100000000014534';
            $route = 2;

            $selArray = array(
                $this->tbl_valuation . '.val_id',
                'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
                $this->tbl_valuation . '.val_status',
                $this->tbl_valuation . '.val_type',
                $this->tbl_valuation . '.val_prt_1',
                $this->tbl_valuation . '.val_prt_2',
                $this->tbl_valuation . '.val_prt_3',
                $this->tbl_valuation . '.val_prt_4',
                $this->tbl_valuation . '.val_valuation_date',
                $this->tbl_valuation . '.val_insurance_idv',
                $this->tbl_valuation . '.val_insurance_company',
                $this->tbl_valuation . '.val_insurance_validity',
                $this->tbl_valuation . '.val_insurance_comp_date',
                $this->tbl_model . '.mod_title',
                $this->tbl_brand . '.brd_title',
                $this->tbl_variant . '.var_variant_name',
            );
            $return = $this->db->select($selArray, false)
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->order_by('val_insurance_comp_date')->where('val_comp_stock', 1)->where('((DATEDIFF(val_insurance_comp_date,
CURRENT_DATE) -1) <= 2)')->get($this->tbl_valuation)->result_array();
            //debug($return);
            $to = array(
                //                '919633334477', // Bava Sir
                '919645269090', // Soumya
                //'7593099090', // Robin Sir
                // '918593029090', // Afsal
                '919745661946', // JK
                    // '919645849090' // Arun antory (Group admin)
            );

            if (!empty($return) && !empty($to)) {
                 foreach ($return as $key => $value) {
                      $template = $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' . $value['mod_title'] . ' insurance due for
    renewal on ' . date('d-m-Y', strtotime($value['val_insurance_comp_date']));
                      $msg = "Dear Sir, " . $template . " - Royal Drive South India's Largest Pre-Owned Luxury Car Showroom";
                      $to = implode(',', $to);

                      //New message
                      $url = "http://api.xpresssms.in/api/v2/SendSMS?";
                      $msg = rawurlencode($msg);
                      $param = "SenderId=TEAMRD&Message=" . $msg . "&MobileNumbers=" . $to . "&PrincipleEntityId=1601100000000014534&TemplateId=1607100000000042909&ApiKey=AzsdSFt21JOEHYuUcpD0LRqd88dYPY1wlkT0EgXiYJc=&ClientId=47d5c8bf-817d-4c5b-9c57-542ebbd41434";
                      $ch = curl_init();
                      curl_setopt($ch, CURLOPT_URL, $url . $param);
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      $buffer = curl_exec($ch);
                      curl_close($ch);
                      //debug(json_decode($buffer));
                      //new message

                      $log['res'] = $result;
                      $log['payload'] = $payload;
                      $log['values'] = $value;
                      generate_log(array(
                          'log_title' => 'insurance renewal for company vehicle',
                          'log_desc' => serialize($log),
                          'log_controller' => 'cron-own-vehicle-ins-reneval',
                          'log_action' => 'C',
                          'log_ref_id' => 9091,
                          'log_added_by' => 9091
                      ));
                 }
            }
       }

       function insurance() {
            $this->tbl_model = 'rana_model';
            $this->tbl_brand = 'rana_brand';
            $this->tbl_variant = 'rana_variant';
            $this->tbl_valuation = 'cpnl_valuation';

            // $selArray = array(
            // $this->tbl_valuation . '.val_id',
            // 'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
            // $this->tbl_valuation . '.val_status',
            // $this->tbl_valuation . '.val_type',
            // $this->tbl_valuation . '.val_prt_1',
            // $this->tbl_valuation . '.val_prt_2',
            // $this->tbl_valuation . '.val_prt_3',
            // $this->tbl_valuation . '.val_prt_4',
            // $this->tbl_valuation . '.val_valuation_date',
            // $this->tbl_valuation . '.val_insurance_idv',
            // $this->tbl_valuation . '.val_insurance_company',
            // $this->tbl_valuation . '.val_insurance_validity',
            // "DATEDIFF(DATE(" . $this->tbl_valuation . ".val_insurance_validity), '" . date('Y-m-d') . "') AS validity",
            // $this->tbl_model . '.mod_title',
            // $this->tbl_brand . '.brd_title',
            // $this->tbl_variant . '.var_variant_name',
            // );
            // $return = $this->db->select($selArray, false)
            // ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
            // ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
            // ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
            // ->where("(DATEDIFF(DATE(" . $this->tbl_valuation . ".val_insurance_comp_date), '" . date('Y-m-d') . "') <= 4) OR
            // (DATEDIFF(DATE(" . $this->tbl_valuation . ".val_insurance_ll_date), '" . date('Y-m-d') . "') <= 4)") // ->
            // where_in($this->tbl_valuation . '.val_status', array(39,
            // 40))->order_by('val_insurance_validity')->where('val_comp_stock', 1)
            // ->get($this->tbl_valuation)->result_array();
            // debug($return);

            /*             * */
            $selectArray = array(
                $this->tbl_valuation . '.val_id',
                'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
                $this->tbl_valuation . '.val_status',
                $this->tbl_valuation . '.val_type',
                $this->tbl_valuation . '.val_prt_1',
                $this->tbl_valuation . '.val_prt_2',
                $this->tbl_valuation . '.val_prt_3',
                $this->tbl_valuation . '.val_prt_4',
                $this->tbl_valuation . '.val_valuation_date',
                $this->tbl_valuation . '.val_insurance_idv',
                $this->tbl_valuation . '.val_insurance_company',
                $this->tbl_valuation . '.val_insurance_validity',
                $this->tbl_valuation . '.val_cust_name',
                $this->tbl_valuation . '.val_cust_phone',
                $this->tbl_valuation . '.val_cust_email',
                $this->tbl_valuation . '.val_cust_place',
                $this->tbl_valuation . '.val_rc_owner',
                $this->tbl_valuation . '.val_no_of_owner',
                $this->tbl_valuation . '.val_no_of_seats',
                $this->tbl_valuation . '.val_eng_cc',
                $this->tbl_valuation . '.val_cust_adrs',
                $this->tbl_valuation . '.val_cust_age',
                $this->tbl_valuation . '.val_cust_pin',
                $this->tbl_valuation . '.val_hp',
                $this->tbl_valuation . '.val_insurance_comp_date',
                $this->tbl_valuation . '.val_insurance_comp_idv',
                $this->tbl_valuation . '.val_insurance_ll_date',
                $this->tbl_valuation . '.val_insurance_ll_idv',
                $this->tbl_valuation . '.val_insurance',
                $this->tbl_valuation . '.val_insurance_need_ncb',
                $this->tbl_model . '.mod_title',
                $this->tbl_brand . '.brd_title',
                $this->tbl_variant . '.var_variant_name'
            );

            return $this->db->select($selectArray, false)
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join(
                                    $this->tbl_variant,
                                    $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant',
                                    'left'
                            )
                            ->where_in($this->tbl_valuation . '.val_status', array(39, 40))->count_all_results($this->tbl_valuation);
            echo $this->db->last_query();
            debug($return);
       }

       function sendtestsms() {

            $senderid = get_settings_by_key('sms_sender_id');
            $username = get_settings_by_key('sms_username');
            $password = get_settings_by_key('sms_password');
            $tmpId = '1607100000000042909';
            $route = 4;

            //$this->db->where_in('enq_current_status', array(1, 14, 15));
            $numbers = $this->db->select('number, id')->where(array('done' => 0))->get('test')->result_array();
            array_push($numbers, array('number' => '9745661946'));
            array_push($numbers, array('number' => '8592029090'));

            //debug($numbers);
            foreach ($numbers as $key => $value) {

                 $msg = "Dear Customer Royal Drive Showrooms, will closed on SEP 3, 4 2022 due to Annual Meet and Tour -
            Royal
            Drive South India's Largest Pre-Owned Luxury Car Showroom";

                 $mob = $value['number']; // implode(', ', $to);
                 $msg = urlencode($msg);
                 $ch = curl_init();

                 curl_setopt($ch, CURLOPT_URL, "https://sms.xpresssms.in/api/api.php?");
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch, CURLOPT_POST, 1);
                 curl_setopt($ch, CURLOPT_POSTFIELDS, "ver=1&mode=1&action=push_sms&type=1&route=" . $route . "&login_name="
                         . $username . "&api_password=" .
                         $password . "&message=" . $msg . "&number=" . $mob . "&sender=" . $senderid . "&template_id=" . $tmpId);
                 $buffer = curl_exec($ch);
                 curl_close($ch);
                 echo $buffer . '<br>';

                 $this->db->where('id', $value['id'])->update('test', array('done' => 1));
            }
            echo 'Success';
       }

       function send_whatsapp_msg($to_number = '') { //Whatsapp Cloud Api test
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v13.0/102727912520321/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
            "messaging_product": "whatsapp",
            "recipient_type": "individual",
            "to": "' . $to_number . '",
            "type": "text",
            "text": {
            "preview_url": false,
            "body": "Hi this is WhatsApp cloud test msg!"
            }
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer
            EAAO9dLJM5FgBAKMfAjmFf60M15STEj4RCuhKIRdzsza17F0BzuD1GVK1f3DgIaC15M6bTw76uTabtpGDJM5ycosXVcsBaEbJK9fPfJtcw0OVh4Gf93ZBmSjHiZAaH2ElvqhP08fBAZB2u4s09ZBhydysXIUXfj6H0ZAk583nL7CV80HHbGeyKBDqXQF350lTr6f1CB7P3ay6oJxBPa2ZByBy1W0puewOQZD'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
       }

       function nullnextfolloup() {
            $f = $this->db->query("SELECT enq_id FROM `cpnl_enquiry` WHERE enq_added_on >
            DATE('2022-08-01')")->result_array();
            //debug($f);
            foreach ($f as $key => $value) {
                 $fol = $this->db->query("SELECT foll_cus_id FROM `cpnl_followup` WHERE foll_cus_id = " .
                                 $value['enq_id'])->result_array();
                 if (empty($fol)) {
                      debug($value, 0);
                 }
            }
       }

       function forceLost() {
            $f = $this->db->query("SELECT cpnl_dar_followup.*, cpnl_followup.foll_id, cpnl_enquiry.enq_cus_name,
            cpnl_enquiry.enq_cus_mobile, cpnl_enquiry.enq_id,
            cpnl_enquiry.enq_current_status, cpnl_enquiry.enq_se_id, cpnl_enquiry.enq_mode_enq
            FROM `cpnl_dar_followup`
            LEFT JOIN cpnl_followup ON cpnl_followup.foll_id = cpnl_dar_followup.darf_followup
            LEFT JOIN cpnl_enquiry ON cpnl_enquiry.enq_id = cpnl_followup.foll_cus_id
            WHERE cpnl_dar_followup.darf_master = 18055 AND cpnl_enquiry.enq_current_status = 1")->result_array();
            debug($f);
            /**/
            if (!empty($f)) {
                 foreach ($f as $key => $value) {
                      $data['enh_added_by'] = 100;
                      $data['enh_enq_id'] = $value['enq_id'];
                      $data['enh_current_sales_executive'] = $value['enq_se_id'];
                      $data['enh_booked_vehicle'] = 0;
                      $data['enh_booking_amt'] = 0;
                      $data['enh_status'] = 5;
                      $data['enh_source'] = $value['enq_mode_enq'];
                      $data['enh_remarks'] = 'Enquiry forcely status changed to lost';
                      $data['enh_added_by'] = 100;
                      $data['enh_added_on'] = date('Y-m-d H:i:s');
                      $data['enh_alias'] = 'Enquiry forcely status changed to lost, due to bug';
                      $data['enh_added_on_system_date'] = date('Y-m-d H:i:s');

                      if ($this->db->insert($this->tbl_enquiry_history, $data)) {

                           $enqHistoryId = $this->db->insert_id();
                           $curStatus = $this->db->get_where($this->tbl_statuses, array('sts_value' =>
                                       $data['enh_status']))->row_array();
                           $selectArray = array(
                               $this->tbl_enquiry . '.enq_se_id',
                               $this->tbl_enquiry . '.enq_cus_name',
                               $this->tbl_enquiry . '.enq_cus_mobile',
                               $this->tbl_users . '.usr_first_name'
                           );

                           $enqdetails = $this->db->select($selectArray)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' .
                                                   $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                                           ->get_where($this->tbl_enquiry, array('enq_id' => $data['enh_enq_id']))->row_array();

                           $salesStaffName = isset($enqdetails['usr_first_name']) ? $enqdetails['usr_first_name'] : '';
                           $custName = isset($enqdetails['enq_cus_name']) ? $enqdetails['enq_cus_name'] : '';
                           $curStatusName = isset($curStatus['sts_des']) ? $curStatus['sts_des'] : '';

                           $comment = $salesStaffName . "'s " . ' customer ' . $custName . ' enquiry status has been changed to ' .
                                   $curStatusName .
                                   ', satus changed by ' . $this->session->userdata('usr_username');

                           $follCmd['foll_remarks'] = $comment;
                           $follCmd['foll_cus_id'] = $data['enh_enq_id'];
                           $follCmd['foll_parent'] = 0;
                           $follCmd['foll_cus_vehicle_id'] = 0;
                           $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                           $follCmd['foll_customer_feedback'] = '';
                           $follCmd['foll_can_show_all'] = 1;
                           $follCmd['foll_contact'] = 0;
                           $follCmd['foll_action_plan'] = '';
                           $follCmd['foll_added_by'] = $this->uid;
                           $follCmd['foll_updated_by'] = $this->uid;
                           $follCmd['foll_is_dar_submited'] = 0;
                           $follCmd['foll_is_cmnt'] = 1;
                           $this->db->insert($this->tbl_followup, $follCmd);

                           $enUpdate = array(
                               'enq_current_status' => $data['enh_status'],
                               'enq_current_status_history' => $enqHistoryId
                           );

                           $this->db->where('enq_id', $data['enh_enq_id']);
                           $this->db->update($this->tbl_enquiry, $enUpdate);
                           generate_log(array(
                               'log_title' => 'Change enquiry status forcely',
                               'log_desc' => 'Status has been changed forcely',
                               'log_controller' => 'sts-lost-forc',
                               'log_action' => 'C',
                               'log_ref_id' => $enqHistoryId,
                               'log_added_by' => 100
                           ));
                      }
                 }
            }
            /**/
       }

       function removedisable() {
            error_reporting(E_ALL);
            $mydir = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'product' .
                    DIRECTORY_SEPARATOR;
            $files = scandir($mydir);
            unset($files[0]);
            unset($files[1]);
            $prefixed_array = preg_filter('/^/', 'https://www.royaldrive.in/assets/uploads/product/', $files);
            //debug($prefixed_array);
            echo count($files) . '<br>';
            echo "
            <pre>" . implode("\n", $prefixed_array) . "</pre>";

            $f = $this->db->select('prd_id')->where('prd_status', 0)->get('rana_products')->result_array();
            foreach ($f as $key => $value) {
                 $images = $this->db->select('pdi_image')->where(
                                 'pdi_prod_id',
                                 $value['prd_id']
                         )->get('rana_prod_images')->result_array();
                 if (!empty($images)) {
                      // debug($images, 0);
                      foreach ($images as $key1 => $val) {
                           echo $val['pdi_image'];
                           echo '<img src="assets/uploads/product/' . $val['pdi_image'] . '" /><br>';
                           //unlink($mydir . $val['pdi_image']);
                           //unlink($mydir . '380X238_'. $val['pdi_image']);
                      }
                 }
            }
            //debug($f);
       }

       function revertAssignedEnq() {
            //$f = $this->db->query("SELECT log_ref_id FROM `cpnl_general_log` WHERE `log_controller` LIKE
            // '%quk-assign-inquiry-%' AND log_added_on_in LIKE '%2022-10-15%'")->result_array();
            $f = $this->db->query("SELECT foll_id FROM `cpnl_followup` WHERE `foll_remarks` LIKE '%JAMSHEER\'s enquires
            reassigned%' AND foll_entry_date LIKE '%2022-10-15%'")->result_array();
            exit;
            foreach ($f as $key => $value) {
                 // $follCmd['foll_remarks'] = 'Misplaced enquiry assign to telecaller, riveted';
                 // $follCmd['foll_cus_id'] = $value['log_ref_id'];
                 // $follCmd['foll_parent'] = 0;
                 // $follCmd['foll_cus_vehicle_id'] = 0;
                 // $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                 // $follCmd['foll_customer_feedback'] = '';
                 // $follCmd['foll_can_show_all'] = 1;
                 // $follCmd['foll_contact'] = 0;
                 // $follCmd['foll_action_plan'] = '';
                 // $follCmd['foll_added_by'] = 100;
                 // $follCmd['foll_updated_by'] = 100;
                 // $follCmd['foll_is_dar_submited'] = 0;
                 // $follCmd['foll_is_cmnt'] = 1;
                 // $this->db->insert($this->tbl_followup, $follCmd);

                 $this->db->where('foll_id', $value['foll_id'])->update('cpnl_followup', array('foll_added_by' => 48));
            }
       }

       function pool() {
            $f = $this->db->query("SELECT * FROM `cpnl_general_log` WHERE `log_controller` LIKE '%quk-assign-inquiry%'
            AND log_added_on_in LIKE '%2022-10-31%'")->result_array();
            foreach ($f as $key => $value) {
                 $this->db->where('enq_id', $value['log_ref_id'])->update($this->tbl_enquiry, array(
                     'enq_is_pool' => 1, 'enq_pool_lst_cmd' => $value['log_title'],
                     'enq_pool_entry_date' => $value['log_added_on_in'],
                 ));
            }
       }

       function smart() {
            $mydir = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'product' .
                    DIRECTORY_SEPARATOR;
            error_reporting(E_ALL);
            $prdImages = $this->db->select('prd_id')->where('prd_rd_mini', 0)->get('rana_products')->result_array();
            foreach ($prdImages as $key => $value) {
                 $images = $this->db->select('pdi_image')->where(
                                 'pdi_prod_id',
                                 $value['prd_id']
                         )->get('rana_prod_images')->result_array();
                 foreach ($images as $key => $value) {
                      unlink($mydir . $value['pdi_image']);
                      unlink($mydir . '380X238_' . $value['pdi_image']);
                 }
            }
       }

       function getLastFollowupDate() {
            generate_log(array(
                'log_title' => 'get-last-followup-date',
                'log_desc' => date('Y-m-d H:i:s'),
                'log_controller' => 'get-last-followup-date',
                'log_action' => 'C',
                'log_ref_id' => 9090,
                'log_added_by' => 9090
            ));

            $enqs = $this->db->select('enq_id')->limit(150)->order_by('enq_id', 'DESC')->where('(enq_last_foll_cust_rmk
            IS NULL AND enq_last_foll_date IS NULL)')
                            ->get_where('cpnl_enquiry', array('is_exe' => 0))->result_array();

            if (!empty($enqs)) {
                 foreach ($enqs as $key => $value) {
                      //get last followup date
                      $lstFoll = $this->db->select('foll_entry_date, foll_added_by, foll_budget_from,
            foll_budget_to')->where(array('foll_cus_id' => $value['enq_id'], 'foll_is_cmnt' => 0))
                                      ->order_by('foll_id', 'DESC')->limit(1)->get($this->tbl_followup)->row_array();

                      $lstCustRem = $this->db->select('foll_customer_feedback')->where(array(
                                          'foll_cus_id' => $value['enq_id'],
                                          'foll_is_cmnt' => 0, 'foll_customer_feedback !=' => 'NULL'
                                      ))
                                      ->order_by('foll_id', 'DESC')->limit(1)->get($this->tbl_followup)->row_array();

                      $data['enq_last_foll_date'] = isset($lstFoll['foll_entry_date']) ? $lstFoll['foll_entry_date'] : NULL;
                      $data['enq_last_followup_by'] = isset($lstFoll['foll_added_by']) ? $lstFoll['foll_added_by'] : 0;
                      $data['enq_last_foll_cust_rmk'] = isset($lstCustRem['foll_customer_feedback']) ?
                              $lstCustRem['foll_customer_feedback'] : NULL;
                      $data['is_exe'] = 1;
                      $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', $data);
                 }
            }
       }

       function careinv() {
            exit;
            $senderid = get_settings_by_key('sms_sender_id');
            $username = get_settings_by_key('sms_username');
            $password = get_settings_by_key('sms_password');

            $tmpId = '1607100000000252548';
            $route = 2;

            $enqs = $this->db->select('enq_id, enq_cus_name, enq_cus_mobile,enq_showroom_id')->limit(100)
                            ->order_by('enq_showroom_id', 'DESC')->get_where('cpnl_enquiry', array('enq_current_status' => 1, 'is_exe'
                        => 0))->result_array();

            // $enqs[0]['enq_id'] = 1;
            // $enqs[0]['enq_cus_name'] = 'JK';
            // $enqs[0]['enq_cus_mobile'] = 9745661946;

            if (!empty($enqs)) {
                 foreach ($enqs as $key => $value) {
                      $msg = "Greetings from Royal Drive.
            With great pleasure, we announce the opening ceremony of Royal Drive Care – Premium Luxury Car Service, an
            initiative by Royal Drive on 3rd March 2023 at 3 pm. Meet our expert technicians and see our
            state-of-the-art facility. We welcome you to be a part of history in making. bit.ly/rd-care";

                      $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('is_exe' => 1));
                      $mob = str_replace(' ', '', trim($value['enq_cus_mobile']));
                      $msg = urlencode($msg);
                      $ch = curl_init();

                      curl_setopt($ch, CURLOPT_URL, "https://sms.xpresssms.in/api/api.php?");
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_POST, 1);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, "ver=1&mode=1&action=push_sms&type=1&route=" . $route . "&login_name="
                              . $username . "&api_password=" . $password . "&message=" .
                              $msg . "&number=" . $mob . "&sender=" . $senderid . "&template_id=" . $tmpId);
                      $buffer = curl_exec($ch);

                      curl_close($ch);
                      echo '<br>' . $value['enq_cus_name'] . ' - ' . $value['enq_cus_mobile'] . ' - ' . $ch . '<br>';
                 }
            } else {
                 echo 'Empty';
            }

            // $rootuser = array(
            // 9745661946
            // );
            // foreach ($rootuser as $key => $value) {
            // $msg = "Dear Customer, Wishing you a joyous Christmas and a prosperous New Year, 918129909090 - Royal
            //Drive South India's Largest Pre-Owned Luxury Car Showroom";
            // $mob = str_replace(' ','', trim($value));
            // $msg = urlencode($msg);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, "https://sms.xpresssms.in/api/api.php?");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, "ver=1&mode=1&action=push_sms&type=1&route=" . $route .
            //"&login_name=" . $username . "&api_password=" . $password . "&message=" .
            // $msg . "&number=" . $mob . "&sender=" . $senderid . "&template_id=" . $tmpId);
            // $buffer = curl_exec($ch);
            // curl_close($ch);
            // }
            //debug($enqs);
       }

       function bookingid() {
            exit;
            //$this->tbl_divisions = TABLE_PREFIX_PORTAL . 'divisions';
            $f = $this->db->get($this->tbl_vehicle_booking_master)->result_array();
            foreach ($f as $key => $value) {
                 $dcod = $this->db->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom .
                                         '.shr_division')
                                 ->get_where($this->tbl_showroom, array('shr_id' => $value['vbk_showroom']))->row()->div_code .
                         $value['vbk_ref_no'];
                 $this->db->where('vbk_id', $value['vbk_id'])->update($this->tbl_vehicle_booking_master, array('vbk_ref_no'
                     => $dcod));
            }
       }

       function enquirymeta() {

            $this->db->cache_off();

            error_reporting(E_ALL);
            error_reporting(1);
            $selectArray = array(
                $this->tbl_vehicle . '.veh_price_from',
                $this->tbl_vehicle . '.veh_price_to',
                $this->tbl_vehicle . '.veh_km_from',
                $this->tbl_vehicle . '.veh_km_to',
                $this->tbl_vehicle . '.veh_color',
                $this->tbl_vehicle . '.veh_year',
                $this->tbl_brand . '.brd_title',
                $this->tbl_model . '.mod_title',
                $this->tbl_variant . '.var_variant_name'
            );
            $f = $this->db->select('enq_id')->where('enq_added_to_meta =
            0')->limit(20)->get($this->tbl_enquiry)->result_array();
            debug($f, 0);
            if (!empty($f)) {
                 foreach ($f as $key => $value) {
                      if (!empty($value)) {
                           $update = array();
                           $update['enqm_enq_id'] = (int) $value['enq_id'];
                           $this->db->where('enqm_enq_id', $update['enqm_enq_id'])->delete('cpnl_enquiry_meta');
                           $sales = $this->db->select($selectArray)
                                           ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                           ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                           ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                           ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')->limit(1)->get_where($this->tbl_vehicle, array(
                                       $this->tbl_vehicle . '.veh_enq_id' => $value['enq_id'],
                                       $this->tbl_vehicle . '.veh_status' => 1
                                   ))->row_array();

                           if (!empty($sales)) {
                                $update['enqm_sls_veh'] = $sales['brd_title'] . ', ' . $sales['mod_title'] . ', ' .
                                        $sales['var_variant_name'];
                           }
                           $purchase = $this->db->select($selectArray)
                                           ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                           ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                           ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                           ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')->limit(1)->get_where($this->tbl_vehicle, array(
                                       $this->tbl_vehicle . '.veh_enq_id' => $value['enq_id'],
                                       $this->tbl_vehicle . '.veh_status' => 2
                                   ))->row_array();
                           if (!empty($purchase)) {
                                $update['enqm_pur_veh'] = $purchase['brd_title'] . ', ' . $purchase['mod_title'] . ', ' .
                                        $purchase['var_variant_name'];
                           }

                           $this->db->insert('cpnl_enquiry_meta', $update);
                           echo $this->db->last_query() . '<br>';
                           $this->db->where('enq_id', $update['enqm_enq_id'])->update('cpnl_enquiry', array('enq_added_to_meta' => 1));
                           echo $this->db->last_query() . '<br>';
                      }
                 }
                 $f = $this->db->select('enq_id')->where(array('enq_budget_id' => 0, 'enq_id' =>
                             $value['enq_id']))->get($this->tbl_enquiry)->result_array();

                 foreach ($f as $key => $value) {
                      if (!empty($f)) {
                           $lstFoll = $this->db->select('foll_budget')->where(array('foll_cus_id' => $value['enq_id']))
                                           ->order_by('foll_id', 'DESC')->limit(1)->get($this->tbl_followup)->row_array();
                           if (isset($lstFoll['foll_budget']) && !empty($lstFoll['foll_budget'])) {
                                $this->db->where('enq_id', $value['enq_id'])->update($this->tbl_enquiry, array('enq_budget_id' =>
                                    $lstFoll['foll_budget']));
                           }
                           $this->db->where('enq_id', $value['enq_id'])->update($this->tbl_enquiry, array('tmp' => 1));
                      }
                 }
            } else {
                 echo 'Completed';
            }
       }

       function enquiryBudget() {
            exit;
            $f = $this->db->select('enq_id')->where(array('enq_budget_id' => 0, 'tmp' => 0))->limit(50)
                            ->order_by('enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();

            foreach ($f as $key => $value) {
                 if (!empty($f)) {
                      echo $value['enq_id'] . '<br>';
                      $lstFoll = $this->db->select('foll_budget')->where(array('foll_cus_id' => $value['enq_id']))
                                      ->order_by('foll_id', 'DESC')->limit(1)->get($this->tbl_followup)->row_array();
                      if (isset($lstFoll['foll_budget']) && !empty($lstFoll['foll_budget'])) {
                           debug($lstFoll, 0);
                           $this->db->where('enq_id', $value['enq_id'])->update($this->tbl_enquiry, array('enq_budget_id' =>
                               $lstFoll['foll_budget']));
                      }
                      $this->db->where('enq_id', $value['enq_id'])->update($this->tbl_enquiry, array('tmp' => 1));
                 }
            }
       }

       function refurbactualcose() {
            //LIMIT 100 OFFSET 800
            exit;
            $f = $this->db->query("SELECT upgrd_master_id, COALESCE(SUM(`upgrd_value`), 0) AS upgrd_value FROM
            `cpnl_valuation_upgrade_details`
            GROUP BY `upgrd_master_id` HAVING upgrd_value > 0 ORDER BY upgrd_master_id ASC")->result_array();

            if (!empty($f)) {
                 foreach ($f as $key => $value) {
                      $this->db->where('val_id', $value['upgrd_master_id'])->update($this->tbl_valuation, array('val_refurb_cost'
                          => $value['upgrd_value']));
                 }
                 echo 'Compleated!';
            } else {
                 echo 'No da available!';
            }
       }

       function stockdate() {
            $f = $this->db->select('val_id, val_purchased_date')->where('val_purchased_date IS
            NULL')->order_by('val_id', 'DESC')->limit(200)->get('cpnl_valuation')->result_array();
            foreach ($f as $key => $value) {
                 //
                 $d = $this->db->select('pcl_created_at')->where('pcl_val_id', $value['val_id'])
                                 ->order_by('pcl_check_list_id', 'DESC')->limit(1)->get('cpnl_purchase_check_list')->result_array();
                 echo $value['val_id'] . '<br>';
                 debug($d, 0);
            }
       }

       function reassignEnquires() {
            $fr = 635;
            $to = 838;
            $status = 4; //Req for drop
            $dltext = ($status == 2) ? ' request for drop' : ' request for lost';
            $limit = "LIMIT 215";
            $toName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' =>
                        $to))->row()->usr_username;
            $frName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' =>
                        $fr))->row()->usr_username;

            $data = $this->db->query("SELECT `cpnl_enquiry`.`enq_id` FROM (`cpnl_enquiry`) WHERE
            `cpnl_enquiry`.`enq_se_id` = '" . $fr .
                            "' AND `enq_current_status` = '" . $status . "' " . $limit)->result_array();

            $comment = $frName . "'s " . $dltext . ' enquires assignted to ' . $toName . ', for calling, suggested by
            Shiny (equally divide request for drop/lost)';
            echo $comment;
            debug($data);
            foreach ($data as $key => $enq) {

                 $follCmd['foll_remarks'] = $comment;
                 $follCmd['foll_cus_id'] = $enq['enq_id'];
                 $follCmd['foll_sales_staff'] = $to;
                 $follCmd['foll_parent'] = 0;
                 $follCmd['foll_cus_vehicle_id'] = 0;
                 $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                 $follCmd['foll_customer_feedback'] = '';
                 $follCmd['foll_can_show_all'] = 1;
                 $follCmd['foll_contact'] = 0;
                 $follCmd['foll_action_plan'] = '';
                 $follCmd['foll_added_by'] = 100;
                 $follCmd['foll_updated_by'] = 100;
                 $follCmd['foll_is_dar_submited'] = 0;
                 $follCmd['foll_is_cmnt'] = 1;
                 $this->db->insert('cpnl_followup', $follCmd);

                 //Enquiry history
                 $enqHtry = array(
                     'enh_enq_id' => $enq['enq_id'],
                     'enh_current_sales_executive' => $to,
                     'enh_status' => 1,
                     'enh_remarks' => $comment
                 );

                 $this->db->insert('cpnl_enquiry_history', $enqHtry);
                 $hisId = $this->db->insert_id();

                 //Update enquiry
                 $this->db->where('enq_id', $enq['enq_id'])->update('cpnl_enquiry', array(
                     'enq_last_viewd' => $to, 'enq_se_id' => $to, 'is_exe' => 1, 'enq_current_status_history' => $hisId
                 ));

                 generate_log(array(
                     'log_title' => 'Quick assign enquiry ' . $frName . ' to ' . $toName,
                     'log_desc' => '',
                     'log_controller' => 'drop-lost-enq-assigned',
                     'log_action' => 'C',
                     'log_ref_id' => $enq['enq_id'],
                     'log_added_by' => 100
                 ));
            }
       }

       function undopool() {
            $enquires = $this->db->select('enp_enq_id, enp_se_to_id')
                            ->where_in('enq_pool_batch', array('6594482029', '5987937565', '6529955591'))
                            ->get('cpnl_enquiry_pool')->result_array();

            foreach ($enquires as $key => $enq) {
                 //Enquiry history
                 $enqHtry = array(
                     'enh_enq_id' => $enq['enp_enq_id'],
                     'enh_current_sales_executive' => $enq['enp_se_to_id'],
                     'enh_status' => 1,
                     'enh_remarks' => 'Enquires removed from pool requested by Shiny, ' . date('Y-m-d H:i:s')
                 );

                 $this->db->insert('cpnl_enquiry_history', $enqHtry);
                 $hisId = $this->db->insert_id();

                 $this->db->where('enq_id', $enq['enp_enq_id'])->update('cpnl_enquiry', array(
                     'enq_last_viewd' => 0, 'enq_current_status_history' => $hisId, 'enq_is_pool' => 0,
                     'enq_pool_flag' => 0, 'enq_pool_entry_date' => NULL, 'enq_pool_updt_date' => NULL, 'enq_pool_lst_cmd' => '', 'enq_pool_id' => 0
                 ));
            }
       }

       function customersurvey() {
            $enqDate = date('Y-m-d', strtotime('-2 day'));
            $enquires = $this->db->select('enq_id,enq_cus_mobile,enq_entry_date')->where('date(enq_entry_date)', $enqDate)->get('cpnl_enquiry')->result_array();

            foreach ($enquires as $key => $enq) {
                 if (strlen($enq['enq_cus_mobile']) == 10) {
                      $to[] = '91' . $enq['enq_cus_mobile'];
                      $enquires[$key]['enq_cus_mobile_in'] = '91' . $enq['enq_cus_mobile'];
                 } else if (substr($enq['enq_cus_mobile'], 0, 1) == 0) {
                      $to[] = '91' . substr($enq['enq_cus_mobile'], 1, strlen($enq['enq_cus_mobile']));
                      $enquires[$key]['enq_cus_mobile_in'] = '91' . substr($enq['enq_cus_mobile'], 1, strlen($enq['enq_cus_mobile']));
                 }
            }
            $to = implode(',', array_column($enquires, 'enq_cus_mobile_in')) . ',919745661946';
            debug($to);

            $apiKey = "IZuPcjFyPlOLOxTyu6nOb2rE2Rpw+cwVSPN7WBwYchc=";
            $clntId = "872ca4dc-4580-4105-a09e-51fd70989394";

            $url = "http://api.xpresssms.in/api/v2/SendSMS?";
            $msg = urlencode("Dear customer! 
We greatly appreciate your connection with Royal Drive. We would be honored if you could take a moment to share your invaluable feedback by clicking on the link. Thank you for your continued support.
https://bit.ly/3Rze4St");
            $params = $url . "ApiKey=" . $apiKey . "&ClientId=" . $clntId . "&SenderId=TEAMRD&Message=" . $msg . "&MobileNumbers=" . $to . "&principleEntityId=1601100000000014534&templateId=1607100000000277537";
            echo $params;
            debug($enquires);
       }

       function todayRetails() {
            $selectArray = array(
                $this->tbl_vehicle_booking_master . '.vbk_id',
                'bkdby.usr_username AS bkdby_user_name',
                $this->tbl_valuation . '.val_veh_no',
                $this->tbl_model . '.mod_title',
                $this->tbl_brand . '.brd_title',
                $this->tbl_variant . '.var_variant_name',
                $this->tbl_showroom . '.shr_location'
            );

            $today = date('Y-m-d'); //Get current date
            $bookedVehicle = $this->db->select($selectArray, false)
                            ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
                            ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
                            ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
                            ->where('date(' . $this->tbl_vehicle_booking_master . '.vbk_added_on)', $today)
                            ->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del, book_delvry))
                            ->get($this->tbl_vehicle_booking_master)->result_array();
            if (!empty($bookedVehicle)) {
                 $cnt = '';
                 foreach ($bookedVehicle as $key => $value) {
                      if(!empty($value['val_veh_no'])) {
                         $cnt = $cnt . ($key + 1) . '. ' . str_replace('-', '', $value['val_veh_no']) . ',' . $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['shr_location'] . ',' . $value['bkdby_user_name'] . '\n\n';
                      }
                 }
                 //JK
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '919745661946', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));
                 
                 //Afsal
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '918593029090', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));
                 
                 //Utham
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '917592889090', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));

                 //VP
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '919633334477', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));

                 //MD
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '919745069090', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));

                 //Sajin
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '917034239090', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));

                 //Devesh
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '918592866060', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));
                 
                 //Nijish
                 $apiData = array("apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                     "campaignName" => "rdms_deal_of_today", 'destination' => '917034929090', 'userName' => 'royaldrive9090@gmail.com', 'templateParams' => array($cnt));
                 $data_string = json_encode($apiData);
                 $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                 curl_setopt_array($ch, array(
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $data_string,
                     CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                     CURLOPT_RETURNTRANSFER => true
                 ));
                 $result = curl_exec($ch);
                 generate_log(array(
                     'log_title' => 'Today retail',
                     'log_desc' => serialize($result),
                     'log_controller' => 'cron-today-retails',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vbk_id'],
                     'log_added_by' => 1987
                 ));
            }
       }
  }