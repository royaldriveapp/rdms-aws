<?php

$CI = get_instance();
$childrens = array();
/**
 * Function for crop image with jcrop
 * @param array $upload_data
 * @param array $postDatas
 * @return boolean
 */
function crop($upload_data, $postDatas, $watermark = false)
{
     $CI = &get_instance();

     $x1 = $postDatas['x1'];
     $x1 = isset($x1['0']) ? $x1['0'] : '';

     $x2 = $postDatas['x2'];
     $x2 = isset($x2['0']) ? $x2['0'] : '';

     $y1 = $postDatas['y1'];
     $y1 = isset($y1['0']) ? $y1['0'] : '';

     $y2 = $postDatas['y2'];
     $y2 = isset($y2['0']) ? $y2['0'] : '';

     $w = $postDatas['w'];
     $w = isset($w['0']) ? $w['0'] : '';

     $h = $postDatas['h'];
     $h = isset($h['0']) ? $h['0'] : '';

     $CI->load->library('image_lib');

     $image_config['image_library'] = 'gd2';
     $image_config['source_image'] = $upload_data["file_path"] . $upload_data["file_name"];
     $image_config['new_image'] = $upload_data["file_path"] . $upload_data["file_name"];
     $image_config['quality'] = "100%";
     $image_config['maintain_ratio'] = FALSE;
     $image_config['x_axis'] = $x1;
     $image_config['y_axis'] = $y1;
     $image_config['width'] = $w;
     $image_config['height'] = $h;

     $CI->image_lib->initialize($image_config);
     $CI->image_lib->crop();
     if ($watermark) {
          watermark($upload_data["file_path"] . $upload_data["file_name"]);
     }
     $CI->image_lib->clear();

     /* Second size */
     $configSize2['image_library'] = 'gd2';
     $configSize2['source_image'] = $upload_data["file_path"] . $upload_data["file_name"];
     $configSize2['create_thumb'] = TRUE;
     $configSize2['maintain_ratio'] = TRUE;
     $width = get_settings_by_key('thumbnail_width');
     $height = get_settings_by_key('thumbnail_height');
     $configSize2['width'] = !empty($width) ? $width : DEFAULT_THUMB_W;
     $configSize2['height'] = !empty($height) ? $height : DEFAULT_THUMB_H;
     $configSize2['new_image'] = 'thumb_' . $upload_data["file_name"];

     $CI->image_lib->initialize($configSize2);
     $CI->image_lib->resize();
     $CI->image_lib->clear();
     return true;
}

function get_ihits_fin_year_code()
{
     global $CI;
     return $CI->common_model->getIhitsFinYearCode();
}

/**
 * Function for custome crop image with jcrop 
 * @param array $upload_data
 * @param array $postDatas
 * @return boolean
 */
function custome_crop($upload_data, $w, $h)
{
     $CI = &get_instance();
     $configSize2['image_library'] = 'gd2';
     $configSize2['source_image'] = $upload_data["file_path"] . $upload_data["file_name"];
     $configSize2['create_thumb'] = TRUE;
     $configSize2['maintain_ratio'] = FALSE;
     $configSize2['width'] = $w;
     $configSize2['height'] = $h;
     $configSize2['quality'] = "100%";
     $configSize2['thumb_marker'] = "";
     $configSize2['new_image'] = $w . 'X' . $h . '_' . $upload_data["file_name"];

     $CI->load->library('image_lib');
     $CI->image_lib->initialize($configSize2);
     $CI->image_lib->resize();
     $CI->image_lib->clear();
     return $configSize2['new_image'];
}

function watermark($source, $image = true)
{
     global $CI;
     if ($image) {
          $config['source_image'] = $source;
          $config['new_image'] = $source;
          $config['wm_type'] = 'overlay';
          $config['wm_opacity'] = 50;
          $config['wm_vrt_alignment'] = 'bottom';
          $config['wm_hor_alignment'] = 'right';
          $config['wm_overlay_path'] = 'assets/images/watermark-sample.png';
     } else {
          $config['source_image'] = '/path/to/image/mypic.jpg';
          $config['wm_text'] = 'Copyright 2006 - John Doe';
          $config['wm_type'] = 'text';
          $config['wm_font_path'] = './system/fonts/texb.ttf';
          $config['wm_font_size'] = '16';
          $config['wm_font_color'] = 'ffffff';
          $config['wm_vrt_alignment'] = 'bottom';
          $config['wm_hor_alignment'] = 'center';
          $config['wm_padding'] = '20';
     }
     $CI->image_lib->initialize($config);
     $CI->image_lib->watermark();
     echo $CI->image_lib->display_errors();
}

function get_options($array, $parent = 0, $indent = "")
{
     $return = array();
     foreach ($array as $key => $val) {
          if ($val["parent_category_id"] == $parent) {
               $return["x" . $val["category_id"]] = $indent . $val["category_name"];
               $return = array_merge($return, get_options($array, $val["category_id"], $indent . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"));
          }
     }
     return $return;
}

function getCategories()
{
     global $CI;
     $CI->load->model('home_model');
     return $CI->home_model->getCategories();
}

function getParentCategories()
{
     global $CI;
     $CI->load->model('home_model');
     return $CI->home_model->getParentCategories();
}

function debug($array = array(), $exit = 1)
{
     echo '<pre>';
     print_r($array);
     if ($exit == 1)
          exit;
}

function getCaptcha()
{
     $number1 = rand(1, 9999);
     $number2 = rand(1, 9999);
     return $number1 + $number2;
}

function getPaginationDesign()
{
     $config['full_tag_open'] = '<ul class="pagination">';
     $config['full_tag_close'] = '</ul>';
     $config['prev_link'] = '&lt;';
     $config['prev_tag_open'] = '<li>';
     $config['prev_tag_close'] = '</li>';
     $config['next_link'] = '&gt;';
     $config['next_tag_open'] = '<li>';
     $config['next_tag_close'] = '</li>';
     $config['cur_tag_open'] = '<li class="active"><a>';
     $config['cur_tag_close'] = '</a></li>';
     $config['num_tag_open'] = '<li>';
     $config['num_tag_close'] = '</li>';
     $config['first_tag_open'] = '<li>';
     $config['first_tag_close'] = '</li>';
     $config['last_tag_open'] = '<li>';
     $config['last_tag_close'] = '</li>';
     $config['first_link'] = '&laquo;';
     $config['last_link'] = '&raquo;';
     return $config;
}

function get_state_province($id = '')
{
     global $CI;
     $CI->db->order_by('stat_long_name');
     return $CI->db->select('*')->get('gtech_state_province')->result_array();
}

function get_country_list($id = '')
{
     global $CI;
     $CI->db->order_by('ctr_country');
     return $CI->db->select('*')->get('gtech_country')->result_array();
}

function get_hashed_password($pass)
{
     if ($pass) {
          return base64_encode(base64_encode(base64_encode($pass)));
     }
}

function get_original_password($hash)
{
     if ($hash) {
          return base64_decode(base64_decode(base64_decode($hash)));
     }
}

function check_login()
{

     global $CI;
     $userdata = $CI->session->userdata;

     if (
          isset($userdata) &&
          !empty($userdata)
     ) {
          return true;
     } else {
          return false;
     }
}

/**
 * Return the value of logged user by specified field
 * @global object $CI
 * @param string $key
 * @return array
 */
function get_logged_user($key = '')
{
     if (check_login()) {
          global $CI;
          $id = $CI->session->userdata['usr_user_id'];
          if (empty($key)) {
               return $CI->common_model->getUser($id);
          } else {
               $userdata = $CI->common_model->getUser($id);
               return isset($userdata[$key]) ? $userdata[$key] : '';
          }
     } else {
          return null;
     }
}

/* Settings */

function get_settings_by_key($key)
{
     if ($key) {
          global $CI;
          $CI->load->model('settings/settings_model');
          $settings = $CI->settings_model->getSettings($key);
          return isset($settings['set_value']) ? $settings['set_value'] : '';
     } else {
          return false;
     }
}

/* Settings */

/**
 * Check is serialized data
 * @param serialized $data
 * @return boolean
 */
function is_serialized($data)
{
     return (is_string($data) && preg_match("#^((N;)|((a|O|s):[0-9]+:.*[;}])|((b|i|d):[0-9.E-]+;))$#um", $data));
}

function slugify($text)
{

     // replace & to and
     $text = str_replace('&', 'and', $text);

     // replace non letter or digits by -
     $text = preg_replace('~[^\pL\d]+~u', '-', $text);

     // transliterate
     $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

     // remove unwanted characters
     $text = preg_replace('~[^-\w]+~', '', $text);

     // trim
     $text = trim($text, '-');

     // remove duplicate -
     $text = preg_replace('~-+~', '-', $text);

     // lowercase
     $text = strtolower($text);

     if (empty($text)) {
          return '';
     }

     return $text;
}

function facebook_time_ago($timestamp)
{
     date_default_timezone_set('Asia/Kolkata');
     $time_ago = strtotime($timestamp);
     $current_time = time();
     $time_difference = $current_time - $time_ago;
     $seconds = $time_difference;
     $minutes = round($seconds / 60);           // value 60 is seconds  
     $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
     $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
     $weeks = round($seconds / 604800);          // 7*24*60*60;  
     $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
     $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
     if ($seconds <= 60) {
          return "Just Now";
     } else if ($minutes <= 60) {
          if ($minutes == 1) {
               return "one minute ago";
          } else {
               return "$minutes minutes ago";
          }
     } else if ($hours <= 24) {
          if ($hours == 1) {
               return "an hour ago";
          } else {
               return "$hours hrs ago";
          }
     } else if ($days <= 7) {
          if ($days == 1) {
               return "yesterday";
          } else {
               return "$days days ago";
          }
     } else if ($weeks <= 4.3) { //4.3 == 52/12  
          if ($weeks == 1) {
               return "a week ago";
          } else {
               return "$weeks weeks ago";
          }
     } else if ($months <= 12) {
          if ($months == 1) {
               return "a month ago";
          } else {
               return "$months months ago";
          }
     } else {
          if ($years == 1) {
               return "one year ago";
          } else {
               return "$years years ago";
          }
     }
}

function generate_log($logData, $table = "general_log")
{
     global $CI;
     $CI->common_model->generateLog($logData, $table);
}

function check_permission($controller, $method)
{
     global $CI;
     return $CI->check_permission($controller, $method);
}

/**
 * 
 * @param string $action
 * @param string $string
 * @return If passing E get a encripted string, If passing D get a decripted string, 
 */
function encryptor($string, $action = 'E')
{
     return $string;
     //do the encyption given text/string/number
     if ($action == 'E') {
          $output = encode($string);
     } else if ($action == 'D') {
          $output = decode($string);
     }
     return $output;
}

define('skey', "SuPerEncKey20018");

function safe_b64encode($string)
{

     $data = base64_encode($string);
     $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
     return $data;
}

function safe_b64decode($string)
{
     $data = str_replace(array('-', '_'), array('+', '/'), $string);
     $mod4 = strlen($data) % 4;
     if ($mod4) {
          $data .= substr('====', $mod4);
     }
     return base64_decode($data);
}

function encode($value)
{

     if (!$value) {
          return false;
     }
     $text = $value;
     $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
     $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
     $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, skey, $text, MCRYPT_MODE_ECB, $iv);
     return trim(safe_b64encode($crypttext));
}

function decode($value)
{

     if (!$value) {
          return false;
     }
     $crypttext = safe_b64decode($value);
     $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
     $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
     $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, skey, $crypttext, MCRYPT_MODE_ECB, $iv);
     return trim($decrypttext);
}

function todaysFollowups()
{
     global $CI;
     return $CI->common_model->todaysFollowups();
}

function get_snippet($str, $wordCount = 10)
{

     $count = str_word_count($str);
     $word = implode(
          '',
          array_slice(
               preg_split(
                    '/([\s,\.;\?\!]+)/',
                    $str,
                    $wordCount * 2 + 1,
                    PREG_SPLIT_DELIM_CAPTURE
               ),
               0,
               $wordCount * 2 - 1
          )
     );
     return ($count > $wordCount) ? $word . '...' : $word;
}

function clean_image_name($name)
{
     return preg_replace("/[^a-zA-Z.0-9]/", "", $name);
}

function is_roo_user()
{
     global $CI;
     if ($CI->usr_grp == 'MD' || $CI->usr_grp == 'VP' || $CI->usr_grp == 'AD' || $CI->usr_grp == 'CEO') {
          return true;
     } else {
          return false;
     }
}

function generate_vehicle_virtual_id($input)
{
     if (!empty($input)) {
          $input = md5($input);
          $input = preg_replace("/[^0-9,.]/", "", $input);
          return substr($input, 0, 6) + rand(1, 99999);
     } else {
          return false;
     }
}

/**
 * Generate random number
 * @return int
 */
function gen_random()
{
     return time() + rand(0, 999999);
}

function get_current_url()
{
     $currentURL = current_url(); //http://myhost/main
     $params = $_SERVER['QUERY_STRING']; //my_id=1,3
     $fullURL = $currentURL . '?' . $params;
     return $fullURL;   //http://myhost/main?my_id=1,3
}

function get_file_extension($file_name)
{
     return substr(strrchr($file_name, '.'), 1);
}

function is_image($name)
{
     $SupExt = array('jpg', 'jpeg', 'png', 'gif');
     $ext = substr(strrchr($name, '.'), 1);
     if (in_array($ext, $SupExt)) {
          return true;
     }
     return false;
}

function can_access_module($module)
{
     global $CI;
     if ($CI->usr_grp == 'SA' || $CI->uid == ADMIN_ID) {
          return true;
     } else if (!empty($module)) {
          if (is_serialized($CI->userAccess)) {
               $access = unserialize($CI->userAccess);
               if (key_exists($module, $access)) {
                    return true;
               } else {
                    return false;
               }
          } else {
               return false;
          }
     } else {
          return false;
     }
}

function clean_whatsapp_num($num)
{
     $num = trim($num);
     if (strlen($num) <= 10) { // Indian number
          return '91' . $num;
     }
     return $num;
}

function send_sms($msg, $mob, $logtitle, $tmpId = '', $route = 2)
{
     $senderid = get_settings_by_key('sms_sender_id');
     $username = get_settings_by_key('sms_username');
     $password = get_settings_by_key('sms_password');

     $msg = urlencode($msg);
     $ch = curl_init();

     curl_setopt($ch, CURLOPT_URL, "https://sms.xpresssms.in/api/api.php?");
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, "ver=1&mode=1&action=push_sms&type=1&route=" . $route . "&login_name=" . $username . "&api_password=" . $password . "&message=" .
          $msg . "&number=" . $mob . "&sender=" . $senderid . "&template_id=" . $tmpId);
     $buffer = curl_exec($ch);

     $output['resp'] = $buffer;
     $output['msg'] = $msg;
     $output['tmpId'] = $tmpId;
     curl_close($ch);
     generate_log(array(
          'log_title' => $logtitle,
          'log_desc' => serialize($output),
          'log_controller' => 'SMS',
          'log_action' => 'C',
          'log_ref_id' => 0,
          'log_added_by' => get_logged_user('usr_id')
     ));
     return $output['resp'];
}

function send_trans_sms($msg, $mob, $logtitle, $tmpId)
{
     $entityId = get_settings_by_key('sms_entity_id');
     $apiKey = get_settings_by_key('sms_trans_api_key');
     $clientId = get_settings_by_key('sms_trans_clnt_id');

     $url = "http://api.xpresssms.in/api/v2/SendSMS?";
     $msg = rawurlencode($msg);
     $param = "SenderId=TEAMRD&Message=" . $msg . "&MobileNumbers=" . $mob . "&PrincipleEntityId=" . $entityId . "&TemplateId=" . $tmpId . "&ApiKey=" . $apiKey . "&ClientId=" . $clientId;
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url . $param);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $buffer = curl_exec($ch);
     curl_close($ch);

     $output['resp'] = $buffer;
     $output['msg'] = $msg;
     $output['tmpId'] = $tmpId;
     curl_close($ch);
     generate_log(array(
          'log_title' => $logtitle,
          'log_desc' => serialize($output),
          'log_controller' => 'send-trans-sms',
          'log_action' => 'C',
          'log_ref_id' => 0,
          'log_added_by' => get_logged_user('usr_id')
     ));
     return $output['resp'];
}

function is_indian_number($mobile_number)
{
     $mobile_number = trim($mobile_number);
     $zno = substr($mobile_number, 0, 3);
     $zzno = substr($mobile_number, 0, 4);
     if ($zno == '091') {
          $mobile_number = substr_replace($mobile_number, '91', 0, 3);
     } else if ($zzno == '0091') {
          $mobile_number = substr_replace($mobile_number, '91', 0, 4);
     }

     if (preg_match("#^(\+){0,1}(91){0,1}(-|\s){0,1}[0-9]{10}$#", $mobile_number)) {
          return $mobile_number;
     } else {
          return false;
     }
}

/**
 * Clean the text and also remove -
 * @return string
 */
function clean_text($name, $ucfirst = 1)
{
     $name = strip_tags($name); // Strip tags.
     $name = trim(preg_replace("/\s+/", ' ', $name)); // Remove multiple space in between words.
     $name = str_replace('-', ' ', $name); // Replaces all hyphens with spaces.
     if ($ucfirst) {
          return ucfirst(preg_replace('/[^A-Za-z0-9\-]/', ' ', $name));
     }
     return preg_replace('/[^A-Za-z0-9\-]/', ' ', $name);
}

function get_in_currency_format($amt)
{
     return preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amt);
}

function get_km_ranges()
{
     global $CI;
     return $CI->common_model->getKMRanges();
}

function excel_column_range($lower, $upper)
{
     $return = '';
     ++$upper;
     for ($i = $lower; $i !== $upper; ++$i) {
          $return[] = $i;
     }
     return $return;
}

if (!function_exists('get_url_string')) {
     function get_url_string($text)
     {
          $text = trim(strtolower($text));
          $text = str_replace(' ', '-', $text);
          $text = str_replace('/', '-', $text);
          $text = str_replace('---', '-', $text);
          $text = str_replace('--', '-', $text);
          return $text;
     }
}

if (!function_exists('get_ownership_text')) {
     function get_ownership_text($num)
     {
          switch ($num) {
               case 1:
                    return 'Single';
               case 2:
                    return 'Second';
               case 3:
                    return 'Third';
               case 4:
                    return 'Fourth';
               case 5:
                    return 'Fifth';
               case 6:
                    return 'Sixth';
               case 7:
                    return 'Seventh';
               case 8:
                    return 'Eighth';
               case 9:
                    return 'Ninth';
               case 10:
                    return 'Tenth';
          }
     }
}

function inr_currency_format($inr, $symbol = true)
{
     if ($symbol) {
          return '₹ ' . preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $inr);
     }
     return preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $inr);
}

function url_shortner($longUrl)
{
     $apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
     $genericAccessToken = '33a7fe2d98acfe9ed51417d009226c4f329cb0e8';

     $data = array(
          'long_url' => $longUrl
     );
     $payload = json_encode($data);

     $header = array(
          'Authorization: Bearer ' . $genericAccessToken,
          'Content-Type: application/json',
          'Content-Length: ' . strlen($payload)
     );

     $ch = curl_init($apiv4);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
     curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     $result = curl_exec($ch);
     return json_decode($result)->link;
}
function get_price_ranges($id = '')
{ //jsk
     global $CI;
     return $CI->common_model->getPriceRanges($id);
}
function getVehicleColors($id = '')
{ //jsk
     global $CI;
     return $CI->common_model->getVehicleColors($id);
}
function findPercentage($param1, $param2, $target)
{ //jsk
     $result = (($param1 + $param2) / $target) * 100;
     $result = round($result, 2);
     return $result;
}

function my_staff($id)
{
     global $CI;
     return $CI->common_model->myChildStaffs($id);
}

function format_date($dt)
{
     $dateFormat = array_shift(explode(' ', DATE_FORMAT));

     $h = date('H', strtotime($dt));
     if ($h > 0) { //date and time exists
          return strtoupper(date(DATE_FORMAT, strtotime($dt)));
     } else { //only time exists
          return strtoupper(date($dateFormat, strtotime($dt)));
     }
}

function amount_in_words($number)
{
     $decimal = round($number - ($no = floor($number)), 2) * 100;
     $hundred = null;
     $digits_length = strlen($no);
     $i = 0;
     $str = array();
     $words = array(
          0 => '', 1 => 'One', 2 => 'Two',
          3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
          7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
          10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
          13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
          16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
          19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
          40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
          70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
     );
     $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
     while ($i < $digits_length) {
          $divider = ($i == 2) ? 10 : 100;
          $number = floor($no % $divider);
          $no = floor($no / $divider);
          $i += $divider == 10 ? 1 : 2;
          if ($number) {
               $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
               $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
               $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
          } else
               $str[] = null;
     }
     $Rupees = implode('', array_reverse($str));
     $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
     return ($Rupees ? $Rupees : '') . $paise;
}
if (!function_exists('get_url_string')) {
     function get_url_string($text)
     {
          $text = trim(strtolower($text));
          $text = str_replace(' ', '-', $text);
          $text = str_replace('/', '-', $text);
          $text = str_replace('---', '-', $text);
          $text = str_replace('--', '-', $text);
          return $text;
     }
}

/**
 * Generate random unique invoice number for iHits 
 * @param type $id
 * @param type $length
 */
function generate_inv_number($id, $length = 10)
{
     $uniq = strtoupper(uniqid(rand()));
     return 'RD-' . $id . '-' . substr(str_shuffle($uniq), 0, $length);
}



// new

function getInquiryDataSQL($date = null)
{
     $CI = &get_instance();
     $CI->load->database();

     $currentYearMonth = date('Y-m');
     $showrooms = $CI->db
          ->select('shr_id, shr_location')
          ->get('cpnl_showroom')
          ->result(); //ixd

     $total_enquiry_count = 0;
     $total_enquiry_status_hot_plus = 0;
     $total_enquiry_status_hot = 0;
     $total_enquiry_status_warm = 0;
     $total_enquiry_status_cold = 0;
     $total_enquiry_status_drop = 0;
     $total_enquiry_status_lost = 0;
     $total_enquiry_self_count = 0;
     $total_enquiry_company_count = 0;
     $total_pending_reg=0;
     $total_missed_followup_count =0;

     $total_home_visit_hot_plus_count = 0;
     $total_home_visit_hot_count = 0;
     $total_home_visit_warm_count = 0;
     $total_home_visit_cold_count = 0;

     $total_home_visit_hot_plus_achieved_count = 0;
     $total_home_visit_hot_achieved_count = 0;
     $total_home_visit_warm_achieved_count = 0;
     $total_home_visit_cold_achieved_count = 0;
     $total_booking_enq=0;

     foreach ($showrooms as $showroom) {
          $enquiry_count = 0;
          $enquiry_status_hot_plus = 0;
          $enquiry_status_hot = 0;
          $enquiry_status_warm = 0;
          $enquiry_status_cold = 0;
          $enquiry_status_drop = 0;
          $enquiry_status_lost = 0;
          $enquiry_self_count = 0;
          $enquiry_company_count = 0;
          //
          $home_visit_hot_plus_achieved_count = 0;
          $home_visit_hot_achieved_count = 0;
          $home_visit_warm_achieved_count = 0;
          $home_visit_cold_achieved_count = 0;

          $home_visit_hot_plus_count = 0;
          $home_visit_hot_count = 0;
          $home_visit_warm_count = 0;
          $home_visit_cold_count = 0;
          $pending_reg=0;
          $missed_followup_count=0;
          $booking_enq=0;
          

          $salesManagers = $CI->db
               ->select('usr_id,usr_username')
               ->where_in('usr_designation_new', [5, 25])
               ->where('usr_showroom', $showroom->shr_id)
               ->where('usr_active', 1) //jsk
               ->get('cpnl_users')
               ->result(); //ixd

          foreach ($salesManagers as $salesManager) {
               $salesManager->total_sales_consultants = 0;
               $asms = $CI->db
                    ->select('usr_id,usr_username')
                    ->where('usr_designation_new', 6)
                    ->where('usr_tl', $salesManager->usr_id)
                    ->where('usr_active', 1) //
                    ->get('cpnl_users')
                    ->result(); //idx

               foreach ($asms as $asm) {
                    $countSalesConsultants = 0;
                    $salesConsultants = $CI->db
                         ->select('usr_id,usr_username')
                         ->where_in('usr_designation_new', [79, 18, 12, 11])
                         ->where('usr_tl', $asm->usr_id)
                         ->where('usr_active', 1) //
                         ->get('cpnl_users')
                         ->result(); //idx

                    if (empty($salesConsultants)) {
                         $asm->sales_consultants[] = [];
                         $countSalesConsultants = $countSalesConsultants + 1;
                    }

                    foreach ($salesConsultants as $salesConsultant) {

                         //new single
             
                    $enquiryData = $CI->db
                    ->select('
              COUNT(*) AS enquiry_count,
              SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_status = 1 THEN 1 ELSE 0 END) AS enquiry_status_hot_plus,
              SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_status = 2 THEN 1 ELSE 0 END) AS enquiry_status_hot,
              SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_status = 3 THEN 1 ELSE 0 END) AS enquiry_status_warm,
              SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_status = 4 THEN 1 ELSE 0 END) AS enquiry_status_cold,
              SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_current_status = 3 THEN 1 ELSE 0 END) AS enquiry_status_drop,
              SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_current_status = 5 OR cpnl_dar_enquiry.dare_enq_current_status = 4 THEN 1 ELSE 0 END) AS enquiry_status_lost,
              SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_mode_enquiry = 6 OR 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry = 17 OR 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry = 18 OR 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry = 19 OR 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry = 20 OR 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry = 30 OR 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry = 31 OR 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry = 34 THEN 1 ELSE 0 END) AS enquiry_self_count,
        SUM(CASE WHEN cpnl_dar_enquiry.dare_enq_mode_enquiry != 6 AND 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry != 17 AND 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry != 18 AND 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry != 19 AND 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry != 20 AND 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry != 30 AND 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry != 31 AND 
                      cpnl_dar_enquiry.dare_enq_mode_enquiry != 34 THEN 1 ELSE 0 END) AS enquiry_company_count
    
          ')
                   
                              ->from('cpnl_dar_master')
                              ->join('cpnl_dar_enquiry', 'cpnl_dar_enquiry.dare_master = cpnl_dar_master.darm_id', 'left')
                              ->where('cpnl_dar_master.darm_added_by', $salesConsultant->usr_id)
                              ->where('cpnl_dar_master.darm_added_on >=', $currentYearMonth . '-01')
                              ->where('cpnl_dar_master.darm_added_on <', date('Y-m-d', strtotime('+1 month', strtotime($currentYearMonth . '-01'))))
                              ->where('cpnl_dar_enquiry.dare_master IS NOT NULL')
                              ->get()
                              ->row();
  // debug( $enquiryData);
                         //  Assigning the values to sales consultant object
                         $salesConsultant->enquiry_count = $enquiryData->enquiry_count;
                         $salesConsultant->enquiry_status_hot_plus = $enquiryData->enquiry_status_hot_plus;
                         $salesConsultant->enquiry_status_hot = $enquiryData->enquiry_status_hot;
                         $salesConsultant->enquiry_status_warm = $enquiryData->enquiry_status_warm;
                         $salesConsultant->enquiry_status_cold = $enquiryData->enquiry_status_cold;
                         $salesConsultant->enquiry_status_drop = $enquiryData->enquiry_status_drop;
                         $salesConsultant->enquiry_status_lost = $enquiryData->enquiry_status_lost;
                         $salesConsultant->enquiry_self_count = $enquiryData->enquiry_self_count;
                         $salesConsultant->enquiry_company_count = $enquiryData->enquiry_company_count;

                         $enquiry_count = $enquiry_count + $salesConsultant->enquiry_count;
                         $enquiry_status_hot_plus = $enquiry_status_hot_plus + $salesConsultant->enquiry_status_hot_plus;
                         $enquiry_status_hot = $enquiry_status_hot + $salesConsultant->enquiry_status_hot;
                         $enquiry_status_warm = $enquiry_status_warm + $salesConsultant->enquiry_status_warm;
                         $enquiry_status_cold = $enquiry_status_cold + $salesConsultant->enquiry_status_cold;
                         $enquiry_status_drop = $enquiry_status_drop + $salesConsultant->enquiry_status_drop;
                         $enquiry_status_lost = $enquiry_status_lost + $salesConsultant->enquiry_status_lost;
                         $enquiry_self_count = $enquiry_self_count + $salesConsultant->enquiry_self_count;
                         $enquiry_company_count = $enquiry_company_count + $salesConsultant->enquiry_company_count;
                         //End new single

                         /*Home visit*/
                         // hmv Total count
                         $salesConsultant->home_visit_hot_plus_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 1)
                              ->where("DATE_FORMAT(hmv_created_at, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();

                         $home_visit_hot_plus_count = $home_visit_hot_plus_count + $salesConsultant->home_visit_hot_plus_count;

                         $salesConsultant->home_visit_hot_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 2)
                              ->where("DATE_FORMAT(hmv_created_at, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();
                         $home_visit_hot_count = $home_visit_hot_count + $salesConsultant->home_visit_hot_count;
                         //  $salesConsultant->home_visit_warm_count =10;//jsk
                         $salesConsultant->home_visit_warm_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 3)
                              ->where("DATE_FORMAT(hmv_created_at, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();
                         $home_visit_warm_count = $home_visit_warm_count + $salesConsultant->home_visit_warm_count;

                         // $salesConsultant->home_visit_cold_count =11;
                         $salesConsultant->home_visit_cold_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 4)
                              ->where("DATE_FORMAT(hmv_created_at, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();

                         $home_visit_cold_count = $home_visit_cold_count + $salesConsultant->home_visit_cold_count;
                         //End hmv Total count

                         // hmv achieved Total count
                         $salesConsultant->home_visit_hot_plus_achieved_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 1)
                              ->where("DATE_FORMAT(hmv_in_date, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();

                         $home_visit_hot_plus_achieved_count = $home_visit_hot_plus_achieved_count + $salesConsultant->home_visit_hot_plus_achieved_count;

                         $salesConsultant->home_visit_hot_achieved_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 2)
                              ->where("DATE_FORMAT(hmv_in_date, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();
                         $home_visit_hot_achieved_count = $home_visit_hot_achieved_count + $salesConsultant->home_visit_hot_achieved_count;
                         //  $salesConsultant->home_visit_warm_count =10;//jsk
                         $salesConsultant->home_visit_warm_achieved_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 3)
                              ->where("DATE_FORMAT(hmv_in_date, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();
                         $home_visit_warm_achieved_count = $home_visit_warm_achieved_count + $salesConsultant->home_visit_warm_achieved_count;

                         // $salesConsultant->home_visit_cold_count =11;
                         $salesConsultant->home_visit_cold_achieved_count = $CI->db
                              ->from('cpnl_home_visits')
                              ->where('hmv_added_by', $salesConsultant->usr_id)
                              ->where('hmv_cust_status', 4)
                              ->where("DATE_FORMAT(hmv_in_date, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();

                         $home_visit_cold_achieved_count = $home_visit_cold_achieved_count + $salesConsultant->home_visit_cold_achieved_count;

                         // End hmv achieved Total count
                         /*End Home Visit*/

                         /*Pending Register*/
                         $salesConsultant->pending_reg = $CI->db
                              ->from('cpnl_register_master')
                              ->where('vreg_assigned_to', $salesConsultant->usr_id)
                              ->where('vreg_inquiry', 0)
                              ->where("DATE_FORMAT(vreg_entry_date, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();
                              $pending_reg = $pending_reg + $salesConsultant->pending_reg;
                         /*End Pending Register */

                         /*Missed followp */
                         $salesConsultant->missed_followup_count = $CI->db
                              ->from('cpnl_enquiry')
                              ->where('enq_se_id', $salesConsultant->usr_id)
                              ->where('enq_cus_when_buy', 3)
                              ->where('enq_cus_home_visit', 1)
                              ->where("DATE_FORMAT(enq_entry_date, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->where('(DATEDIFF(DATE(cpnl_enquiry.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)')
                              ->count_all_results();
                              $missed_followup_count = $missed_followup_count + $salesConsultant->missed_followup_count;
                         /*End Missed followp */

                         /*Booking enq & Delivered*/
                         $salesConsultant->booking_enq = $CI->db
                              ->from('cpnl_vehicle_booking_master')
                              ->where('vbk_sales_staff', $salesConsultant->usr_id)
                              ->where('(cpnl_vehicle_booking_master.vbk_status = ' . confm_book . ' OR ' .
                                   'cpnl_vehicle_booking_master.vbk_status = ' . book_delvry . ')')
                              ->where("DATE_FORMAT(vbk_booking_date, '%Y-%m') =", $currentYearMonth) // Filter by current year and month
                              ->count_all_results();
                              $booking_enq = $booking_enq + $salesConsultant->booking_enq;
                         /*End Booking & delivered enq*/
                         if (!isset($salesConsultant->enquiry_count)) {
                              $salesConsultant->enquiry_count = 0;
                         }

                         $asm->sales_consultants[] = $salesConsultant;

                         $countSalesConsultants = $countSalesConsultants + 1;
                    }

                    $salesManager->asm[] = $asm;
                    $salesManager->total_sales_consultants = $salesManager->total_sales_consultants + $countSalesConsultants;
               }

               $showroom->sales_managers[] = $salesManager;
          }

          $infos[] = [
               'shr_id' => $showroom->shr_id,
               'name' => $showroom->shr_location,
               'sales_managers' => !empty($showroom->sales_managers) ? $showroom->sales_managers : [],
               'enquiry_count' => $enquiry_count,
               'enquiry_status_hot_plus' => $enquiry_status_hot_plus,
               'enquiry_status_hot' => $enquiry_status_hot,
               'enquiry_status_warm' => $enquiry_status_warm,
               'enquiry_status_cold' => $enquiry_status_cold,
               'enquiry_status_drop' => $enquiry_status_drop,
               'enquiry_status_lost' => $enquiry_status_lost,
               'enquiry_self_count' => $enquiry_self_count,
               'enquiry_company_count' => $enquiry_company_count,

               'pending_reg' => $pending_reg,
               'missed_followup_count' => $missed_followup_count,
               'booking_enq'=>$booking_enq,

               'home_visit_hot_plus_count' => $home_visit_hot_plus_count,
               'home_visit_hot_count' => $home_visit_hot_count,
               'home_visit_warm_count' => $home_visit_warm_count,
               'home_visit_cold_count' => $home_visit_cold_count,

               'home_visit_hot_plus_achieved_count' => $home_visit_hot_plus_achieved_count,
               'home_visit_hot_achieved_count' => $home_visit_hot_achieved_count,
               'home_visit_warm_achieved_count' => $home_visit_warm_achieved_count,
               'home_visit_cold_achieved_count' => $home_visit_cold_achieved_count,
               'home_visit_done' => $home_visit_hot_plus_achieved_count+$home_visit_hot_achieved_count+ $home_visit_warm_achieved_count+$home_visit_cold_achieved_count,
          ];

          $total_enquiry_count += $enquiry_count;
          $total_enquiry_status_hot_plus += $enquiry_status_hot_plus;
          $total_enquiry_status_hot += $enquiry_status_hot;
          $total_enquiry_status_warm += $enquiry_status_warm;
          $total_enquiry_status_cold += $enquiry_status_cold;
          $total_enquiry_status_drop += $enquiry_status_drop;
          $total_enquiry_status_lost += $enquiry_status_lost;
          $total_enquiry_self_count += $enquiry_self_count;
          $total_enquiry_company_count += $enquiry_company_count;

          $total_pending_reg += $pending_reg;
          $total_missed_followup_count += $missed_followup_count;
          $total_booking_enq += $booking_enq;

          $total_home_visit_hot_plus_count += $home_visit_hot_plus_count;
          $total_home_visit_hot_count += $home_visit_hot_count;
          $total_home_visit_warm_count += $home_visit_warm_count;
          $total_home_visit_cold_count += $home_visit_cold_count;

          $total_home_visit_hot_plus_achieved_count += $home_visit_hot_plus_achieved_count;
          $total_home_visit_hot_achieved_count += $home_visit_hot_achieved_count;
          $total_home_visit_warm_achieved_count += $home_visit_warm_achieved_count;
          $total_home_visit_cold_achieved_count += $home_visit_cold_achieved_count;
     }

     $total_count_info = [
          'enquiry_count' => $total_enquiry_count,
          'enquiry_status_hot_plus' => $total_enquiry_status_hot_plus,
          'enquiry_status_hot' => $total_enquiry_status_hot,
          'enquiry_status_warm' => $total_enquiry_status_warm,
          'enquiry_status_cold' => $total_enquiry_status_cold,
          'enquiry_status_drop' => $total_enquiry_status_drop,
          'enquiry_status_lost' => $total_enquiry_status_lost,
          'enquiry_self_count' => $total_enquiry_self_count,
          'enquiry_company_count' => $total_enquiry_self_count,

          'pending_reg' => $total_pending_reg,
          'missed_followup_count' => $total_missed_followup_count,
          'booking_enq' => $total_booking_enq,

          'home_visit_hot_plus_count' => $total_home_visit_hot_plus_count,
          'home_visit_hot_count' => $total_home_visit_hot_count,
          'home_visit_warm_count' => $total_home_visit_warm_count,
          'home_visit_cold_count' => $total_home_visit_cold_count,

          'home_visit_hot_plus_achieved_count' => $total_home_visit_hot_plus_achieved_count,
          'home_visit_hot_achieved_count' => $total_home_visit_hot_achieved_count,
          'home_visit_warm_achieved_count' => $total_home_visit_warm_achieved_count,
          'home_visit_cold_achieved_count' => $total_home_visit_cold_achieved_count,
          'home_visit_done' => $total_home_visit_cold_achieved_count+$total_home_visit_hot_plus_achieved_count+$total_home_visit_warm_achieved_count+$total_home_visit_cold_achieved_count,
     ];
     return [
          'infos' => $infos,
          'total_count_info' => $total_count_info,
     ];
}

function getReAssignData($date = null)
{
     $CI = &get_instance();
     $CI->load->database();

     $today_date = date('Y-m-d');
// Get the first day of the current month
$first_day_of_month = date('Y-m-01');
     $currentYearMonth = date('Y-m');
     $first_day_of_month = date('Y-m-01');

     $showrooms = $CI->db
          ->select('*')
          ->get('cpnl_showroom')
          ->result(); //ixd

//debug($showrooms);


     $total_today_count=0;
     $total_this_count =0;

     foreach ($showrooms as $showroom) {
        $today_count=0;
        $this_month_count=0;
          $enquiry_count = 0;
       
          

          $salesManagers = $CI->db
               ->select('usr_id,usr_username')
               ->where_in('usr_designation_new', [5, 25])
               ->where('usr_showroom', $showroom->shr_id)
               ->where('usr_active', 1) //jsk
               ->get('cpnl_users')
               ->result(); //ixd

          foreach ($salesManagers as $salesManager) {
               $salesManager->total_sales_consultants = 0;
               $asms = $CI->db
                    ->select('usr_id,usr_username')
                    ->where('usr_designation_new', 6)
                    ->where('usr_tl', $salesManager->usr_id)
                    ->where('usr_active', 1) //
                    ->get('cpnl_users')
                    ->result(); //idx

               foreach ($asms as $asm) {
                    $countSalesConsultants = 0;
                    $salesConsultants = $CI->db
                         ->select('usr_id,usr_username')
                         ->where_in('usr_designation_new', [79, 18, 12, 11])
                         ->where('usr_tl', $asm->usr_id)
                         ->where('usr_active', 1) //
                         ->get('cpnl_users')
                         ->result(); //idx

                    if (empty($salesConsultants)) {
                         $asm->sales_consultants[] = [];
                         $countSalesConsultants = $countSalesConsultants + 1;
                    }

                    foreach ($salesConsultants as $salesConsultant) {

                         //new single

                    $CI->db->select('cpnl_re_assign_reports.re_added_by,
                        SUM(DATE(cpnl_re_assign_reports.re_added_on) = "' . $today_date . '") as TodayCount,
                        SUM(DATE(cpnl_re_assign_reports.re_added_on) >= "' . $first_day_of_month . '") as ThisMonthCount
                    ');
                    $CI->db->from('cpnl_re_assign_reports');
                    $CI->db->where('cpnl_re_assign_reports.re_staff', $salesConsultant->usr_id);
                  //  $CI->db->where('cpnl_re_assign_reports.re_added_by', $CI->uid);

                    $query =  $CI->db->get();
$row = $query->row();

$salesConsultant->today_count = $row->TodayCount;
$today_count = $today_count + $salesConsultant->today_count;//
$salesConsultant->this_month_count = $row->ThisMonthCount;
$this_month_count = $this_month_count + $salesConsultant->this_month_count;//
$salesConsultant->addedBy = $row->re_added_by;

// echo "Today's inserted records count: " . $row->TodayCount . "<br>";
// echo "This month's inserted records count: " . $row->ThisMonthCount. "<br>";
// debug($row);
                         /*End Booking & delivered enq*/
                         if (!isset($salesConsultant->enquiry_count)) {
                              $salesConsultant->enquiry_count = 0;
                         }

                         $asm->sales_consultants[] = $salesConsultant;

                         $countSalesConsultants = $countSalesConsultants + 1;
                    }

                    $salesManager->asm[] = $asm;
                    $salesManager->total_sales_consultants = $salesManager->total_sales_consultants + $countSalesConsultants;
               }

               $showroom->sales_managers[] = $salesManager;
          }

          $infos[] = [
               'shr_id' => $showroom->shr_id,
               'name' => $showroom->shr_location,
               'sales_managers' => $showroom->sales_managers ? $showroom->sales_managers : [],
               'enquiry_count' => $enquiry_count,
               'today_count' => $today_count,
               'this_month_count' => $this_month_count,
 ];


          $total_today_count += $today_count;
          $total_this_count +=  $this_month_count;
          
     }

     $total_count_info = [
          'today_count' => $total_today_count,
          'this_month_count' => $total_this_count,
 ];
     return [
          'infos' => $infos,
          'total_count_info' => $total_count_info,
     ];
}



