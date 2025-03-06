<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class color_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->table = TABLE_PREFIX . 'vehicle_colors'; 
       }  
          public function getData() {
            return $this->db->order_by('vc_sort_order', "asc")->get($this->table)->result_array();
       }
       public function update($datas) {
            $this->db->where('vc_id', $datas['vc_id']);
            unset($datas['vc_id']);

            if ($this->db->update($this->table, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }
       public function delete($id) {
            $this->db->where('vc_id ', $id);
            if ($this->db->delete($this->table)) {
                 return true;
            } else {
                 return false;
            }
       }
       public function insert($datas) {
            $datas['vc_added_on'] = date('Y-m-d H:i:s');
            $datas['vc_added_by'] = $this->uid;
            if ($this->db->insert($this->table, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       function selectData($id = '') {
            if (!empty($id)) {
                 $this->db->where($this->table . '.vc_id ', $id);
                 return $this->db->select($this->table . '.*')->from($this->table, false)->get()->row_array();                                                           
            } 
            return false;
       }

       public function getDataPaginate($postDatas) {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'vc_id'; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
      
          // Clone the DB instance before making changes,
          $countDb = clone $this->db;
      
          if (!empty($searchValue)) {
              $countDb->where("(" . $this->table . ".vc_color LIKE '%" . $searchValue . "%') ");
          }
      
          // Get the total count of records without the limit applied.
          $totalRecords = $countDb->count_all_results($this->table);
      
          if ($rowperpage > 0) {
              $this->db->limit($rowperpage, $row);
          }
      
          if (!empty($searchValue)) {
              $this->db->where("(" . $this->table . ".vc_color LIKE '%" . $searchValue . "%') ");
          }
      
          if (!empty($columnName) && !empty($columnSortOrder)) {
              $this->db->order_by($columnName, $columnSortOrder);
          }
      
          $res = $this->db->select('vc_id,vc_color')->get($this->table)->result_array();
      
          $response = array(
              "draw" => intval($postDatas['draw']),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecords,
              "aaData" => $res
          );
      
          return $response;
      }

  }
  