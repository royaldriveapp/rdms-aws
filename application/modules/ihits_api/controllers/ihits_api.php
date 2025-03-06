<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ihits_api extends App_Controller
{

     public function __construct()
     {

          parent::__construct();
          $this->page_title = 'ihits_api';
          $this->load->model('ihits_api_model', 'ihits_api');
          $this->load->model('purchase/purchase_model', 'purchase');
     }

     public function ihits_source($val_id)
     {
          //ihitsSource
          $purchas_data = $this->purchase->purchaseApi($val_id);
          $data = $this->ihits_api->ihitsSource($purchas_data);
          debug($data);
     }

     function genTocken()
     {
          echo $this->ihits_api->ihitsGetToken();
     }

     function forceSource()
     {
          if (!empty($_POST)) {
               // debug(unserialize($_POST['ser_data']));
               $json = unserialize($_POST['ser_data']);
               $json['pr_enq_id'] = $_POST['pr_enq_id'];
               $json['pr_id'] = $_POST['pr_id'];
               $json['pr_val_id'] = $_POST['pr_val_id'];
               //$json['enh_booking_amt'] = 2500000;
               //$json['enh_adv_amt'] = 0;
               //$json['enq_trans_mode'] = 'M';
               $json['val_sales_officer_name'] = $_POST['val_sales_officer_name'];
               $res['data'] = $this->ihits_api->ihitsSource($json);
               $this->render_page(strtolower(__CLASS__) . '/forceSource', $res);
          } else {
               $this->render_page(strtolower(__CLASS__) . '/forceSource');
          }
     }

     function forceExpence()
     {
          $f = 'a:18:{s:6:"billNo";s:19:"RD-11206-20941499B6";s:8:"billDate";s:10:"2023-12-01";s:9:"partyName";s:7:"Unknown";s:14:"registrationNo";s:9:"KL30D7854";s:12:"expTotAmount";d:5700;s:7:"remarks";s:56:"NEW 1 TYRE INSTALLING,WHEEL ALIGNMENT&WHEEL BALANCING, 0";s:9:"bookingNo";s:0:"";s:7:"expType";s:16:"Rufurbishing Exp";s:9:"expAmount";d:5700;s:7:"sgstPer";d:0;s:10:"sgstAmount";d:0;s:7:"cgstPer";d:0;s:10:"cgstAmount";d:0;s:7:"igstPer";d:0;s:10:"igstAmount";d:0;s:11:"totalAmount";d:5700;s:4:"mode";s:1:"C";s:7:"stockID";s:15:"SKL202311251512";}';
          $f = unserialize($f);
          $this->ihits_api->ihitsSaveExpense($f, 0, 0, 11206, 21442);

          debug($f);
     }

     function log()
     {
          $this->render_page(strtolower(__CLASS__) . '/log');
     }

     function logAjax()
     {
          $response = $this->ihits_api->log($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     function forcepush($id)
     {
          $response = $this->ihits_api->getLog($id);
          $response['aplg_value'] = unserialize($response['aplg_value']);
          // $response['aplg_value']['TCSAmount'] = 100;

          if (!empty($response)) {
               $endPoint = explode('/', $response['aplg_end_point']);
               //if (stripos($response['aplg_end_point'], 'SaveSource')) {
               $this->render_page(strtolower(__CLASS__) . '/' . strtolower(end($endPoint)), $response);
               // }
               // if (stripos($response['aplg_end_point'], 'SaveExpense')) {
               //      $this->render_page(strtolower(__CLASS__) . '/' . strtolower(end($endPoint)), $response);
               // }
               // if (stripos($response['aplg_end_point'], 'SaveExpense')) {
               //      $this->render_page(strtolower(__CLASS__) . '/' . strtolower(end($endPoint)), $response);
               // }
          }
     }

     function saveSource()
     {
          $aplg_id = $_POST['aplg_id'];
          unset($_POST['aplg_id']);
          $data['responce'] = $this->ihits_api->ihitsSource($_POST, $enqId, $bookingId, $val);
          debug($data['responce']);
          redirect(strtolower(__CLASS__) . '/forcepush/' . $aplg_id);
          $this->render_page(strtolower(__CLASS__) . '/forcepush', $data);
     }

     function saveExpense()
     {
          // debug($_POST, 0);
          //Head
          $_POST['head']['0']['gcCode'] = (int) $_POST['head']['0']['gcCode'];
          $_POST['head']['0']['gstAplcble'] = (int) $_POST['head']['0']['gstAplcble'];
          $_POST['head']['0']['toT_EST_AMT'] = (int) $_POST['head']['0']['toT_EST_AMT'];
          $_POST['head']['0']['expTotAmount'] = (int) $_POST['head']['0']['expTotAmount'];
          $_POST['head']['0']['toT_Add_Exp_Amt'] = (int) $_POST['head']['0']['toT_Add_Exp_Amt'];
          //detail
          foreach ($_POST['detail'] as $key => $details) {
               $_POST['detail'][$key]['esT_AMT'] = (float) $details['esT_AMT'];
               $_POST['detail'][$key]['expAmount'] = (float) $details['expAmount'];
               $_POST['detail'][$key]['add_Exp_Amt'] = (float) $details['add_Exp_Amt'];
               $_POST['detail'][$key]['sgstPer'] = (float) $details['sgstPer'];
               $_POST['detail'][$key]['sgstAmount'] = (float) $details['sgstAmount'];
               $_POST['detail'][$key]['cgstPer'] = (float) $details['cgstPer'];
               $_POST['detail'][$key]['cgstAmount'] = (float) $details['cgstAmount'];
               $_POST['detail'][$key]['igstPer'] = (float) $details['igstPer'];
               $_POST['detail'][$key]['igstAmount'] = (float) $details['igstAmount'];
               $_POST['detail'][$key]['totalAmount'] = (float) $details['totalAmount'];
          }
          $sales = $_POST['sales'];
          $aplg_id = $_POST['aplg_id'];
          unset($_POST['sales']);
          unset($_POST['aplg_id']);

          $enqId = $sales['aplg_enq_id'];
          $bookingId = $sales['aplg_booking_id'];
          $val = $sales['aplg_valuation_id'];
          $rf = $sales['aplg_refurb_id'];
          $apiData['head'] = $_POST['head'];
          $apiData['detail'] = $_POST['detail'];
          $data['responce'] = $this->ihits_api->ihitsSaveExpense($apiData, $enqId, $bookingId, $val, $rf);
          //Update log
          if (!empty($aplg_id)) {
               $this->ihits_api->disable($aplg_id);
          }
          debug($data['responce']);
          //redirect(strtolower(__CLASS__) . '/forcepush/' . $aplg_id);
          //$this->render_page(strtolower(__CLASS__) . '/forcepush', $data);
     }

     function savesales()
     {
          // debug($_POST);
          // unset($_POST['TCSAmount']);
          $enqId = $_POST['aplg_enq_id'];
          $bookingId = $_POST['aplg_booking_id'];
          $val = $_POST['aplg_valuation_id'];
          $_POST['val_model_year'] = (int) $_POST['val_model_year'];
          $_POST['vbk_ttl_sale_amt'] = (int) $_POST['vbk_ttl_sale_amt'];
          $_POST['vbk_advance_amt'] = (int) $_POST['vbk_advance_amt'];
          $_POST['vbk_discount'] = (int) $_POST['vbk_discount'];
          $_POST['tcS_Amt'] = (int) $_POST['tcS_Amt'];
          $_POST['gcCode'] = (int) $_POST['gcCode'];
          $_POST['TCS_Amt'] = (int) $_POST['TCS_Amt'];

          unset($_POST['aplg_enq_id']);
          unset($_POST['aplg_booking_id']);
          unset($_POST['aplg_valuation_id']);
          unset($_POST['aplg_refurb_id']);
          unset($_POST['aplg_net_total']);
          unset($_POST['TCSAmount']);

          unset($_POST['aplg_id']);
          $salesApi = $_POST;
          // debug($salesApi);
          $data['responce'] = $this->ihits_api->ihitsSales($salesApi, $enqId, $bookingId, $val);

          $this->render_page(strtolower(__CLASS__) . '/savesales', $data);
     }
     function disable($id)
     {
          $this->ihits_api->disable($id);
          echo json_encode(array('status' => 'success', 'msg' => ''));
     }

     function savepurchasetoken()
     {
          if ($_POST) {
               $enqId = $_POST['aplg_enq_id'];
               $bookingId = $_POST['aplg_booking_id'];
               $val = $_POST['aplg_valuation_id'];
               $data['responce'] = $this->ihits_api->ihitsPurchaseTokenTest($_POST, $enqId, $bookingId, $val);
               $this->render_page(strtolower(__CLASS__) . '/savepurchasetoken', $data);
          }
          $this->render_page(strtolower(__CLASS__) . '/savepurchasetoken');
     }

     function savesalestoken()
     {
          if ($_POST) {
               $enqId = $_POST['aplg_enq_id'];
               $bookingId = $_POST['aplg_booking_id'];
               $val = $_POST['aplg_valuation_id'];
               $data['responce'] = $this->ihits_api->ihitsSalesTokenTest($_POST, $enqId, $bookingId, $val);
               $this->render_page(strtolower(__CLASS__) . '/savesalestoken', $data);
          }
          $this->render_page(strtolower(__CLASS__) . '/savesalestoken');
     }

     function savepurchase()
     {
          if ($_POST) {
               $enqId = $_POST['aplg_enq_id'];
               $bookingId = $_POST['aplg_booking_id'];
               $val = $_POST['aplg_valuation_id'];
               unset($_POST['RefurbishingEstimatedCost']);
               $data['responce'] = $this->ihits_api->ihitsSourceTest($_POST, $enqId, $bookingId, $val);
               $this->render_page(strtolower(__CLASS__) . '/savesource', $data);
          }
          $this->render_page(strtolower(__CLASS__) . '/savesourceforce');
     }
}
