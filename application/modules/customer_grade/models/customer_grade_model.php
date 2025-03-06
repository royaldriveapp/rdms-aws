<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class customer_grade_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();

            $this->tbl_users = TABLE_PREFIX . 'users';
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $this->tbl_occupation = TABLE_PREFIX . 'occupation';
            $this->tbl_supplier_grade = TABLE_PREFIX . 'customer_grade';
       }

       function get($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_supplier_grade, array('sgrd_id' => $id))->row_array();
            }
            return $this->db->order_by('sgrd_priority')->get($this->tbl_supplier_grade)->result_array();
       }

       function newGrade($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_supplier_grade, $data);
                 return true;
            } else {
                 return false;
            }
       }

       function updateGrade($data) {
            if ($data) {
                 $id = isset($data['sgrd_id']) ? $data['sgrd_id'] : '';
                 unset($data['sgrd_id']);
                 $data['sgrd_need_verification'] = isset($data['sgrd_need_verification']) ? $data['sgrd_need_verification'] : 0;
                 $this->db->where('sgrd_id', $id);
                 $this->db->update($this->tbl_supplier_grade, $data);
                 return true;
            } else {
                 return FALSE;
            }
       }

       function deleteGrade($id) {
            if (!empty($id)) {
                 $this->db->where('sgrd_id', $id);
                 $this->db->delete($this->tbl_supplier_grade);
                 return true;
            } else {
                 return false;
            }
       }

       function removeImage($id, $image) {
            $this->db->where('sgrd_id', $id);
            $this->db->update($this->tbl_supplier_grade, array('sgrd_icon' => ''));

            if (file_exists(FILE_UPLOAD_PATH . 'icon/' . $image)) {
                 unlink(FILE_UPLOAD_PATH . 'icon/' . $image);
            }
       }

       function getNextOrder() {
            return $this->db->select_max('sgrd_priority')->get($this->tbl_supplier_grade)->row()->sgrd_priority + 1;
       }

       function getEnquiryDetails($enqId) {
            $select = array(
                $this->tbl_enquiry . '.enq_id',
                $this->tbl_enquiry . '.enq_cus_name',
                $this->tbl_enquiry . '.enq_cus_mobile',
                $this->tbl_supplier_grade . '.sgrd_id',
                $this->tbl_supplier_grade . '.sgrd_grade',
                $this->tbl_users . '.usr_id',
                $this->tbl_users . '.usr_username',
                $this->tbl_occupation . '.occ_name'
            );
            return $this->db->select($select, false)
                            ->join($this->tbl_supplier_grade, $this->tbl_enquiry . '.enq_customer_grade = ' . $this->tbl_supplier_grade . '.sgrd_id', 'LEFT')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                            ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
                            ->where(array($this->tbl_enquiry . '.enq_id' => $enqId, 'enq_customer_grade_verify_by' => 0))
                            ->get($this->tbl_enquiry)->row_array();
       }

       function verifyCustomerGrade($enqId) {
            if ($this->db->where('enq_id', $enqId)->update($this->tbl_enquiry, array('enq_customer_grade_verify_by' => $this->uid))) {
                 return true;
            }
            return false;
       }

  }
  