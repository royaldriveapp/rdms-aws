<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class test extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Welcome kit';
            $this->load->model('test_model');
       }

       public function index() {
            if(!empty($_POST)) {
              debug($_POST);
            }
            $this->render_page(strtolower(__CLASS__) . '/test');
       }

       function ajax() {
            echo json_encode('success');
       }

       public function courtesyCallList() {
            $data['data'] = $this->test_model->courtesyCallList();
            $this->render_page(strtolower(__CLASS__) . '/index', $data);
       }
       
       function send_whatsapp_msg($to_number='') {//Whatsapp Cloud Api test
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
            CURLOPT_POSTFIELDS =>'{
            "messaging_product": "whatsapp",
            "recipient_type": "individual",
            "to": "'.$to_number.'",
            "type": "text",
            "text": { 
              "preview_url": false,
              "body": "Hi this is frm  WhatsApp cloud "
            }
          }',
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json',
              'Authorization: Bearer EAAO9dLJM5FgBAHXSH3pFI8lNwK36eQ4kyp18op8MJIbsO35C7ZC5K5AWxcGoLhvUz8Oy3OMcJB31AZCSQJmR7pc27JTh9IiolkPCK28i2h9HvOgEYlE0tWx5xDhmHTeSyXt0xn2D6DDap6Pocjoh9pEkDvNrkpYOpS9ArmQuZCBqGgCfVJ9WktDYrPnQVLfSZAoxAgwoTEoTuHgTs5I3OoJztaIlstgZD'
                                     
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          echo $response;
     }

     public function customers_phone_no($param='') {
      //$data = $this->test_model->getPhoneNo($param);
      if($param){
        $res=$data = $this->test_model->getPhoneNo($param);
      }else{
      $data['enq'] = $this->test_model->getPhoneNo('enq');
      $data['reg'] = $this->test_model->getPhoneNo('reg');
      $res=array_merge($data['reg'],$data['enq']);
      }
      //debug($res);
      //Excell//
      $fileName = "10-indian" . date('Y-m-d') . ".csv";
     // $fields = array('id', 'name', 'phone');
     $fields = array('phone');
      $excelData = implode("\t", array_values($fields)) . "\n"; 
      $number=$val['phone'];
      $numlength = mb_strlen($number); 
      $prx = substr($number, 0, 2);
      foreach($res as $k=>$val){ 
//$value=9656557105;
        if($this->validating($val['phone'])){
         // $lineData = array($k, $val['name'], $val['phone']);
         $lineData = array($val['phone']);  
          array_walk($lineData, 'filterData'); 
          $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }
 } 
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Pragma: no-cache");
header("Expires: 0");
echo $excelData; 
}

    
 public function filterData(&$str){ 
  $str = preg_replace("/\t/", "\\t", $str); 
  $str = preg_replace("/\r?\n/", "\\n", $str); 
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

function validating($phone){
  if(preg_match('/^[0-9]{10}+$/', $phone)) {
    return true;
//return "Valid Phone Number";
  } else {
    return false;
//return "Invalid Phone Number";
  }
  }
  function app_test($id='') {//281
  // $res= $this->db->select('*')->where(array("val_enquiry_id" =>45554))->get('cpnl_valuation')->row_array();//45554
$res= $this->db->select('apt_res')->where(array("apt_id" => $id))->get('cpnl_apptest')->row_array();
//$res= $this->db->select('*')->get('cpnl_apptest')->result_array();
$j=unserialize($res['apt_res']);
//debug($res);
debug($j);
///new
foreach($j['enquiry'] as  $x => $val){
  echo "enquiry[$x]:$val<br>";
}
foreach($j['money'] as  $x => $val){
  echo "money[$x]:$val<br>";
}
foreach($j['need'] as  $x => $val){
  echo "need[$x]:$val<br>";
}
foreach($j['authority'] as  $x => $val){
  echo "authority[$x]:$val<br>";
}
foreach($j['followup'] as  $x => $val){
  echo "followup[$x]:$val<br>";
}
foreach($j['saquestions'] as  $x => $val){
  echo "saquestions[$x]:$val<br>";
}
foreach($j['vehicle']['sale'] as  $x => $val){
  //echo $x;
 ///// echo $val[0].'<br>';
  //print_r($val);
 // echo $val[$x].'<br>';
  echo "vehicle[sale][$x][]:$val[0]<br>";
}
foreach($j['vehicle']['pitched'] as  $x => $val){
  echo "vehicle[pitched][$x][]:$val[0]<br>";
}
foreach($j['vehicle']['existing'] as  $x => $val){
  echo "vehicle[existing][$x][]:$val[0]<br>";
}

exit;
foreach($j as $x => $val) {
  echo "$x:$val<br>";
}
  }
  function app_test_all() {//281
  $res= $this->db->select('*')->get('cpnl_apptest')->result_array();
  debug($res);
}

function customers_ph($page=0) {//281
 
  //$res= $this->db->select('vbk_id,vbk_per_ph_no as phone')->get('cpnl_vehicle_booking_master')->result_array();
 //$this->db->limit(50,0);
 $offset=$page*50;
 $this->db->limit(50,$offset);
 //shrm 2,4
  $res=$this->db->select('vbk_id,vbk_showroom,vbk_per_ph_no as phone')->where_in('vbk_showroom',[2,4])->get('cpnl_vehicle_booking_master')->result_array();
 //debug(  $res); 
 foreach($res as $k=>$val){ 
    $phn='91'.$val['phone'];
    //debug( $phn);
    //$value=9656557105;
        if($this->validating($val['phone'])){
         // $lineData = array($k, $val['name'], $val['phone']);
         
         $lineData = array('91'.$val['phone']);  
          array_walk($lineData, 'filterData'); 
          $excelData .= implode("\t", array_values($lineData)) . ","; 
        }
    } 
  debug($excelData);
}




    }

  