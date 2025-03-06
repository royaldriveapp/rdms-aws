<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class fine_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_fine_master = TABLE_PREFIX . 'fine_master';
            $this->tbl_fine_details = TABLE_PREFIX . 'fine_details';
            $this->tbl_valuation = TABLE_PREFIX . 'valuation';
       }
       
       function getStockes() {
            return $this->db->select('val_id, val_stock_num, val_veh_no')->where('val_stock_num IS NOT NULL')
                    ->get($this->tbl_valuation)->result_array();
       }
       
       public function read($master_id = '') {
            if (!empty($master_id)) {
                // return $this->db->get_where($this->tbl_fine_master, array('finm_id' => $id))->row_array();
                $res['masterData']= $this->db->where('finm_id',$master_id)->select($this->tbl_fine_master . '.finm_id,'. $this->tbl_fine_master . '.finm_stock_id,' . $this->tbl_fine_master . '.finm_added_on,' . $this->tbl_valuation . '.val_veh_no')->order_by('finm_id', 'DESC')->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_fine_master . '.finm_stock_id', 'left')->get($this->tbl_fine_master)->row_array();
                $res['detailsData']=$this->db->where('find_master',$master_id)->select($this->tbl_fine_details . '.*,')->order_by('find_id', 'ASC')->get($this->tbl_fine_details)->result_array();
                return $res;
            }
            return $this->db->select($this->tbl_fine_master . '.finm_id,'. $this->tbl_fine_master . '.finm_stock_id,' . $this->tbl_fine_master . '.finm_added_on,' . $this->tbl_valuation . '.val_veh_no')->order_by('finm_id', 'DESC')->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_fine_master . '.finm_stock_id', 'left')->get($this->tbl_fine_master)->result_array();
       }

       public function create($data) {



         // debug($datas);
         $res['master']['finm_stock_id'] = $data['fin_val_id'];
         $res['master']['finm_added_by'] = $this->uid;
         $res['master']['finm_added_on'] = date('Y-m-d H:i:s');
         if ($this->db->insert($this->tbl_fine_master, array_filter($res['master']))) {
              $lastId = $this->db->insert_id();

      
               $id = $this->db->insert_id();
               generate_log(array(
                   'log_title' => 'Fine',
                   'log_desc' => 'New Fine created',
                   'log_controller' => strtolower(__CLASS__),
                   'log_action' => 'C',
                   'log_ref_id' => $id,
                   'log_added_by' => get_logged_user('usr_id')
               ));
              //debug($data['fine']);

         foreach ($data['fine']['find_billno'] as $index => $find_billno) {
       
             // Check if the  fields are empty or not provided
    $find_amount = !empty($data['fine']['find_amount'][$index]) ? $data['fine']['find_amount'][$index] : 0;
    $find_sgst = !empty($data['fine']['find_sgst'][$index]) ? $data['fine']['find_sgst'][$index] : 0;
    $find_sgst_amt = !empty($data['fine']['find_sgst_amt'][$index]) ? $data['fine']['find_sgst_amt'][$index] : 0;
    $find_cgst = !empty($data['fine']['find_cgst'][$index]) ? $data['fine']['find_cgst'][$index] : 0;
    $find_cgst_amt = !empty($data['fine']['find_cgst_amt'][$index]) ? $data['fine']['find_cgst_amt'][$index] : 0;
    $find_igst = !empty($data['fine']['find_igst'][$index]) ? $data['fine']['find_igst'][$index] : 0;
    $find_igst_amt = !empty($data['fine']['find_igst_amt'][$index]) ? $data['fine']['find_igst_amt'][$index] : 0;

    $fine_detail_data = array(
        'find_master' => $lastId, // Link to the master record
        'find_billno' => $find_billno,
        'find_billl_date' => date('Y-m-d', strtotime($data['fine']['find_billl_date'][$index])),
        'find_fine_category' => $data['fine']['find_fine_category'][$index],
        'find_amount' => $find_amount,
        'find_sgst' => $find_sgst,
        'find_sgst_amt' => $find_sgst_amt,
        'find_cgst' => $find_cgst,
        'find_cgst_amt' => $find_cgst_amt,
        'find_igst' => $find_igst,
        'find_igst_amt' => $find_igst_amt,
        'find_narration' => $data['fine']['find_narration'][$index]
    );

          // Insert each fine detail record
          $this->db->insert($this->tbl_fine_details, $fine_detail_data);
          $fine_detail_data['stockNum']=$data['fin_val_id'];
          $fine_detail_data['materId']=$lastId;
          $fine_detail_data['total'] += $fine_detail_data['find_amount'] + $fine_detail_data['find_sgst_amt'] + $fine_detail_data['find_cgst_amt'] + $fine_detail_data['find_igst_amt'];
         // $this->SaveExpenseApi($fine_detail_data);//call Api
      }
     }
          
         
       }
public function SaveExpenseApi($refArray){
    $this->load->model('ihits_api/ihits_api_model', 'ihits_api_model');
     $this->ihits_api_model->ihitsSaveExpense(array(
          'billNo' => $refArray['find_billno'],
          'billDate' => $refArray['find_billl_date'],
          'partyName' => 'Unknown',
          'registrationNo' => 'KL-55',
          'expTotAmount' => (float) $refArray['total'],
          'remarks' => $refArray['find_narration'] . ', ' . $refArray['find_narration'],
          'bookingNo' => '',
          'expType' => 'Fine',
          'expAmount' => (float) $refArray['find_amount'],
          'sgstPer' => (float) $refArray['find_sgst'],
          'sgstAmount' => (float) $refArray['find_sgst_amt'],
          'cgstPer' => (float) $refArray['find_cgst'],
          'cgstAmount' => (float) $refArray['find_cgst_amt'],
          'igstPer' => (float) $refArray['find_igst'],
          'igstAmount' => (float) $refArray['find_igst_amt'],
          'totalAmount' =>(float) $refArray['total'],
          //'totalAmount' => $refArray['upgrd_refurb_actual_cost'] + (float) $refArray['upgrd_sgst'] + (float) $refArray['upgrd_cgst'] + (float) $refArray['upgrd_igst'],
          'mode' => 'C',
          'stockID' => $refArray['stockNum']
     ), 0, 0, $refArray['stockNum'], $refArray['materId']);
    // return true;
}

       public function update($data) {// debug($data);
          // Update the master record
          $master_id = $data['master_id'];
          $master_data = array(
              'finm_stock_id' => $data['fin_val_id'],
              'finm_added_by' => $this->uid,
              'finm_added_on' => date('Y-m-d H:i:s')
          );
      
          $this->db->where('finm_id', $master_id);
          
          // Update the master record
          if ($this->db->update($this->tbl_fine_master, $master_data)) {
            //  $existing_detail_ids = array(); // To keep track of detail records that should be updated
              foreach ($data['fine']['find_billno'] as $index => $find_billno) {
               $find_id = $data['fine']['find_id'][$index];

               $find_amount = !empty($data['fine']['find_amount'][$index]) ? $data['fine']['find_amount'][$index] : 0;
               $find_sgst = !empty($data['fine']['find_sgst'][$index]) ? $data['fine']['find_sgst'][$index] : 0;
               $find_sgst_amt = !empty($data['fine']['find_sgst_amt'][$index]) ? $data['fine']['find_sgst_amt'][$index] : 0;
               $find_cgst = !empty($data['fine']['find_cgst'][$index]) ? $data['fine']['find_cgst'][$index] : 0;
               $find_cgst_amt = !empty($data['fine']['find_cgst_amt'][$index]) ? $data['fine']['find_cgst_amt'][$index] : 0;
               $find_igst = !empty($data['fine']['find_igst'][$index]) ? $data['fine']['find_igst'][$index] : 0;
               $find_igst_amt = !empty($data['fine']['find_igst_amt'][$index]) ? $data['fine']['find_igst_amt'][$index] : 0;
           
               $fine_detail_data = array(
                   'find_master' => $master_id, // Link to the master record
                   'find_billno' => $find_billno,
                   'find_billl_date' => date('Y-m-d', strtotime($data['fine']['find_billl_date'][$index])),
                   'find_fine_category' => $data['fine']['find_fine_category'][$index],
                   'find_amount' => $find_amount,
                   'find_sgst' => $find_sgst,
                   'find_sgst_amt' => $find_sgst_amt,
                   'find_cgst' => $find_cgst,
                   'find_cgst_amt' => $find_cgst_amt,
                   'find_igst' => $find_igst,
                   'find_igst_amt' => $find_igst_amt,
                   'find_narration' => $data['fine']['find_narration'][$index]
               );
                 
                  if ($find_id !== 'new') {
                      $this->db->where('find_id', $find_id);
                      $this->db->update($this->tbl_fine_details, $fine_detail_data);
                    //  $existing_detail_ids[] = $find_id; // Track this detail record as updated
                  } else {
                  
                      $this->db->insert($this->tbl_fine_details, $fine_detail_data);
                      echo 'iserted';
                  }
              }
      
           //   After updating existing records, delete any remaining detail records not in the existing_detail_ids
          //     $this->db->where('find_master', $master_id);
          //     $this->db->where_not_in('find_id', $existing_detail_ids);
          //     $this->db->delete($this->tbl_fine_details);
      
              return true;
          }
      }


       public function delete($id) {
            $this->db->where('finm_id', $id);
            if ($this->db->delete($this->tbl_fine_master)) {
               $this->db->where('find_master', $id);
                $this->db->delete($this->tbl_fine_details);
                 generate_log(array(
                     'log_title' => 'Fine delete',
                     'log_desc' => 'Fine deleted master and details',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'D',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       public function delete_fine_detail($fineId) {
          $this->db->where('find_id', $fineId);
     
          if ($this->db->delete($this->tbl_fine_details)) {
          generate_log(array(
               'log_title' => 'Delete Fine Detail ',
               'log_desc' => 'Fine details deleted',
               'log_controller' => strtolower(__CLASS__),
               'log_action' => 'D',
               'log_ref_id' => $fineId,
               'log_added_by' => get_logged_user('usr_id')
           ));
           return true;
          }
          else {
               return false;
          }
      }

  }
  