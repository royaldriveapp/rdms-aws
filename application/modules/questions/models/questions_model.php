<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class questions_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_questions = TABLE_PREFIX . 'questions';
       }

       public function add($datas) {
            if ($this->db->insert($this->tbl_questions, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function getCategoryChaild($parent, $idNotin = '') {

            $this->db->select("qus_id, qus_question");
            $this->db->where('qus_parent', $parent);
            if (!empty($idNotin)) {
                 $this->db->where('qus_id !=', $idNotin);
            }
            $result = $this->db->get($this->tbl_questions)->result_array();
            return $result;
       }

       public function get($id = '') {

            if (!empty($id)) {
                 $this->db->where('qus_id', $id);
                 return $this->db->get($this->tbl_questions)->row_array();
            } else {
                 return $this->db->get($this->tbl_questions)->result_array();
            }
       }

       public function update($datas) {
            $this->db->where('qus_id', $datas['qus_id']);
            $datas['qus_is_togler'] = isset($datas['qus_is_togler']) ? $datas['qus_is_togler'] : 0;
            $datas['qus_is_mandatory'] = isset($datas['qus_is_mandatory']) ? $datas['qus_is_mandatory'] : 0;
            $datas['qus_status'] = isset($datas['qus_status']) ? $datas['qus_status'] : 0;

            unset($datas['qus_id']);
            if ($this->db->update($this->tbl_questions, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function delete($id) {

            $this->db->where('qus_id', $id);
            if ($this->db->delete($this->tbl_questions)) {
                 $this->db->where('qus_parent', $id);
                 $this->db->delete($this->tbl_questions);
                 return true;
            } else {
                 return false;
            }
       }

       function getNextOrder($max = false) {
            if ($max) {
                 return $this->db->count_all_results($this->tbl_questions);
            } else {
                 return $this->db->select_max('qus_order')->get($this->tbl_questions)->row()->qus_order + 1;
            }
       }

  }
  