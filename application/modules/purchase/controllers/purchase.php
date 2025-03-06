<?php
defined('BASEPATH') or exit('No direct script access allowed');
class purchase extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'Purchase';
          $this->load->model('purchase_model', 'purchase');
          $this->load->model('followup/followup_model', 'followup');
          $this->load->model('ihits_api/ihits_api_model', 'ihits_api_model');
          $this->load->model('evaluation/evaluation_model', 'evaluation');
     }

     public function index()
     {

          // if($this->uid=100 ){

          //     $response = $this->purchase->getPurcasePaginateTest($this->input->post());
          //  debug( $response);
          // }
          $this->render_page(strtolower(__CLASS__) . '/list');
     }
     public function list_ajax()
     {
          $response = $this->purchase->getPurcasePaginate($this->input->post());

          // if($this->uid=100 ){
          //      debug( $response);
          // }
          echo json_encode($response);
     }
     public function create($enq_id = '', $val_id = '')
     {
          if ($enq_id) {
               if ($val_id == '') {
                    $res = $this->purchase->getValIdByEnq($enq_id);
                    $val_id = $res['val_id'];
               }
               $data['purchase_data'] = $this->purchase->getData($val_id);
               $data['valuations'] = $this->purchase->getValData();
               $data['enq_id'] = $enq_id;
               $data['val_id'] = $val_id;
               $data['states'] = $this->purchase->getStates();
               $data['company'] = $this->purchase->getCompany();
               $data['salesExe'] = $this->evaluation->getEnquiryHandingMembers();
               $data['salesDetails'] = $this->purchase->getEnquiryDetails($enq_id);
               $this->render_page(strtolower(__CLASS__) . '/view', $data);
          }
     }

     public function add()
     {
          if (!empty($_POST)) { //enh_booked_vehicle
               generate_log(array(
                    'log_title' => 'purchase pre insert',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'purchase-pre-insert',
                    'log_action' => 'C',
                    'log_ref_id' => 0,
                    'log_added_by' => $this->uid
               ));
               $_POST['pr_ref_no'] = generate_inv_number($_POST['pr_val_id']);
               if ($this->purchase->insert($_POST)) {
                    $data['enh_enq_id'] = $_POST['pr_enq_id'];
                    $data['quickfollowup'] = '';
                    $data['cb'] = '';
                    $data['enh_status'] = 6;
                    $data['enh_booked_vehicle'] = $_POST['pr_val_id']; //val_id
                    $data['enh_booking_amt'] = $_POST['pr_total'];
                    $data['enh_remarks'] = '';
                    $this->changeStatus($data);
                    $this->session->set_flashdata('app_success', 'Successfully added!');
               }
          }
          redirect(strtolower(__CLASS__));
     }

     function changeStatus($data)
     {
          $cb = isset($data['cb']) ? $data['cb'] : '';
          unset($data['cb']);
          if (isset($data['quickfollowup'])) {
               $msg = isset($data['enh_remarks']) ? $data['enh_remarks'] : '';
               $this->followup->removeRow($data['quickfollowup'], $msg);
               unset($data['quickfollowup']);
          }
          if ($this->followup->changeStatus($data)) {
               $msg = isset($data['enh_remarks']) ? $data['enh_remarks'] : '';
               $enqId = isset($data['enh_enq_id']) ? $data['enh_enq_id'] : '';
               $status = $this->common_model->getStatusById($data['enh_status']);
               $stsmsg = isset($status['sts_des']) ? $status['sts_des'] : '';
               if ($enqId > 0) {
                    $this->followup->updateComments(array(
                         'foll_is_cmnt' => 1, 'foll_remarks' => $msg . ' ' . $stsmsg,
                         'foll_cus_id' => $enqId, 'foll_parent' => 0
                    ));
               }
          }
     }

     public function update_approval()
     {
          $message = 'successfully Updated!';
          if (!empty($_POST) && $this->purchase->updateApproval($_POST)) {
               $stockId = 0;
               $purchsedata = $this->purchase->gePurchaseData($_POST['pr_id']);
               $stockId = $purchsedata['pr_stocknum'];
               if ($_POST['pr_approve']) {
                    $purchas_data = $this->purchase->purchaseApi($_POST['pr_val_id'], $_POST['pr_id'], $_POST['pr_enq_id']);
                    $purchas_data['stockID'] = $stockId = empty($stockId) ? $purchas_data['stockID'] : $stockId;
                    //Brokerage
                    if (isset($purchsedata['pr_brokerage']) && (int)$purchsedata['pr_brokerage'] > 0 && !empty($stockId)) {
                         $billno = generate_inv_number($_POST['pr_val_id']);
                         $this->ihits_api_model->ihitsSaveExpense(array(
                              'billNo' => (string) $billno,
                              'billDate' => date('Y-m-d'),
                              'partyName' => (string) $purchsedata['pr_broker'],
                              'registrationNo' => $purchas_data['val_veh_no'],
                              'expTotAmount' => (float) $purchsedata['pr_brokerage'],
                              'remarks' => (string) 'Brokerage collected from ' . $purchsedata['pr_broker'] . ' for vehicle number ' . $purchas_data['val_veh_no'],
                              'bookingNo' => '',
                              'expType' => (string) 'Brockerage / Commission',
                              'expAmount' => (int) $purchsedata['pr_brokerage'],
                              'sgstPer' => 0,
                              'sgstAmount' => 0,
                              'cgstPer' => 0,
                              'cgstAmount' => 0,
                              'igstPer' => 0,
                              'igstAmount' => 0,
                              'totalAmount' => (int) $purchsedata['pr_brokerage'],
                              'mode' => 'C',
                              'stockID' => (string) $stockId,
                              'GstAplcble' => 0,
                              'gcCode' => (int)$purchas_data['gcCode']
                         ), 0, 0, $_POST['pr_val_id'], 0);
                    }
                    //Fine
                    if (isset($purchsedata['pr_fine']) && (int)$purchsedata['pr_fine'] > 0) {
                         $billno = generate_inv_number($_POST['pr_val_id']);
                         $this->ihits_api_model->ihitsSaveExpense(array(
                              'billNo' => (string) $billno,
                              'billDate' => date('Y-m-d'),
                              'partyName' => (string) $purchas_data['val_veh_no'],
                              'registrationNo' => $purchas_data['val_veh_no'],
                              'expTotAmount' => (float) $purchsedata['pr_fine'],
                              'remarks' => (string) 'Fine collected for ' . $purchas_data['val_veh_no'],
                              'bookingNo' => '',
                              'expType' => (string) 'RTO Charges',
                              'expAmount' => (int) $purchsedata['pr_fine'],
                              'sgstPer' => 0,
                              'sgstAmount' => 0,
                              'cgstPer' => 0,
                              'cgstAmount' => 0,
                              'igstPer' => 0,
                              'igstAmount' => 0,
                              'totalAmount' => (int) $purchsedata['pr_fine'],
                              'mode' => 'C',
                              'stockID' => (string) $purchas_data['stockID'],
                              'GstAplcble' => 0,
                              'gcCode' => (int)$purchas_data['gcCode']
                         ), 0, 0, $_POST['pr_val_id'], 0);
                    }
                    $this->ihits_api_model->ihitsSource($purchas_data);
                    $message = 'successfully Approved!';
                    /*Message*/
                    $cdo = $this->purchase->getCustomerDelightStaff();
                    if(!empty($cdo)) {
                        $apiData = array(
                            "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                            "campaignName" => "vb_purchase_confirm_live",
                            'destination' => $purchas_data['val_cust_phone'],
                            'userName' => 'royaldrive9090@gmail.com',
    			            'templateParams' => array('+' . $cdo['usr_did_number'], $cdo['usr_username'], $cdo['desig_title'])
                        );
                        $data_string = json_encode($apiData);
                        $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                        curl_setopt_array($ch, array(
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $data_string,
                            CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                            CURLOPT_RETURNTRANSFER => true
                        ));
                        $result = curl_exec($ch);
                    }
                    /*Message*/
               }
               echo json_encode($message);
          } else {
               $message = 'Error';
               echo json_encode($message);
          }
     }

     public function approved_list()
     {
          $this->render_page(strtolower(__CLASS__) . '/list_approved');
     }
     public function approved_list_ajax()
     {
          $response = $this->purchase->getApprovedPaginate($this->input->post());
          echo json_encode($response);
     }

     public function edit($id = '')
     {
          $data['mou_data'] = $this->purchase->getMou();
          $data['purchase'] = $this->purchase->gePurchaseData($id);
          $this->render_page(strtolower(__CLASS__) . '/edit', $data);
     }
     public function update()
     {
          if (!empty($_POST)) {
               if ($this->purchase->update($_POST)) {
                    $this->session->set_flashdata('app_success', 'Successfully added!');
               }
          }
          redirect(strtolower(__CLASS__));
     }
     /*
     */
     public function get_column_names()
     {
          $table_name = 'cpnl_purchase';
          //$table_name='cpnl_valuation';
          $sql = "DESCRIBE $table_name";
          $query = $this->db->query($sql);
          // Check if the query was successful
          if ($query) {
               $result = $query->result();
               // Extract and display the column names and data types
               foreach ($result as $row) {
                    echo $row->Field . " (" . $row->Type . ")<br>";
               }
          } else {
               echo "Error fetching column names: " . $this->db->error();
          }
     }

     public function purchase_api()
     {
          $data = $this->purchase->purchaseApi();
          debug($data);
     }
     function bindDistrictBystate()
     {
          if (isset($_GET['state_id']) && !empty($_GET['state_id'])) {
               $district = $this->purchase->bindDistrictBystate($_GET['state_id']);
               echo json_encode($district);
          }
     }

     public function insertDistricts()
     {
          //$this->purchase->insertDistricts();    
          //$this->purchase->updateStatus();
     }

     function delete($prId)
     {
          if ($prId != 0) {
               $this->purchase->delete($prId);
               $this->session->set_flashdata('app_success', 'Row deleted!');
               redirect('purchase');
          }
     }

     public function allPurchase()
     {
          $this->render_page(strtolower(__CLASS__) . '/allPurchase');
     }
     public function allPurchaseAjax()
     {
          $response = $this->purchase->allPurchaseAjax($this->input->post());
          echo json_encode($response);
     }

     function approve($id)
     {
          $data['data'] = $this->purchase->gePurchaseData($id);
          //debug($data['data']);
          $this->render_page(strtolower(__CLASS__) . '/approve', $data);
     }
}
