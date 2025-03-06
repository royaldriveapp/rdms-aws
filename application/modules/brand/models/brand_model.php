<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Brand_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->table = TABLE_PREFIX_RANA . 'brand';
       }

       public function getBrands($id = '') {
               $this->db->select("branda.*, brandb.brd_title AS parent")->from($this->table . ' branda')
                    ->join($this->table . ' brandb', 'branda.brd_parent = brandb.brd_id', 'left');

               if ($id > 0) {
                    return $this->db->where('branda.brd_id', $id)->get()->row_array();
               }
               $this->db->order_by('branda.brd_title', 'asc');
               $brands = $this->db->get()->result_array();
               return $brands;
       }

       public function addNewBrand($datas) {
            unset($datas['x1']);
            unset($datas['x2']);
            unset($datas['y1']);
            unset($datas['y2']);
            unset($datas['h']);
            unset($datas['w']);
            $datas['brd_sort_order'] = $this->getBrandNextOrder();

            $datas['brd_added_by'] = $this->uid;
            $datas['brd_added_on'] = date('Y-m-d H:i:s');
            if ($this->db->insert($this->table, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function removeBrandImage($id) {
            if ($id) {
                 $this->db->where('brd_id', $id);
                 $brand = $this->db->get($this->table)->result_array();
                 $brand = isset($brand['0']) ? $brand['0'] : array();
                 if (isset($brand['brd_logo']) && !empty($brand['brd_logo'])) {
                      if (file_exists(FILE_UPLOAD_PATH . 'brand/' . $brand['brd_logo'])) {
                           unlink(FILE_UPLOAD_PATH . 'brand/' . $brand['brd_logo']);
                      }
                      if (file_exists(FILE_UPLOAD_PATH . 'brand/thumb_' . $brand['brd_logo'])) {
                           unlink(FILE_UPLOAD_PATH . 'brand/thumb_' . $brand['brd_logo']);
                      }
                      $this->db->where('brd_id', $id);
                      $this->db->update($this->table, array('brd_logo' => ''));
                      return true;
                 }
            }
            return false;
       }

       public function updateBrand($datas) {
            
            //$dataWithOldPriority = $this->db->get_where($this->table, array('brd_sort_order' => $datas['brd_sort_order']))->row_array();
            //$dataWithNewPriority = $this->db->get_where($this->table, array('brd_id' => $datas['brd_id']))->row_array();
            
            unset($datas['x1']);
            unset($datas['x2']);
            unset($datas['y1']);
            unset($datas['y2']);
            unset($datas['h']);
            unset($datas['w']);

            $this->db->where('brd_id', $datas['brd_id']);
            unset($datas['brd_id']);
            if ($this->db->update($this->table, $datas)) {
                 //if (!empty($dataWithOldPriority) && !empty($dataWithNewPriority)) {
                 //     $this->db->where('brd_id', $dataWithOldPriority['brd_id']);
                 //     $this->db->update($this->table, array('brd_sort_order' => $dataWithNewPriority['brd_sort_order']));
                // }
                 return true;
            } else {
                 return false;
            }
       }

       public function deleteBrand($id) {
            $this->db->where('brd_id', $id);
            $brand = $this->db->get($this->table)->result_array();
            $brand = isset($brand['0']) ? $brand['0'] : array();
            if (isset($brand['brd_logo']) && !empty($brand['brd_logo'])) {
                 if (file_exists(FILE_UPLOAD_PATH . 'brand/' . $brand['brd_logo'])) {
                      unlink(FILE_UPLOAD_PATH . 'brand/' . $brand['brd_logo']);
                 }
            }
            $this->db->where('brd_id', $id);
            if ($this->db->delete($this->table)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function getBrandChaild($parent, $idNotin = '') {

            $this->db->select("brd_id,  brd_title");
            $this->db->where('brd_parent', $parent);
            if (!empty($idNotin)) {
                 $this->db->where('brd_id !=', $idNotin);
            }
            $result = $this->db->get($this->table)->result_array();
            return $result;
       }

       function getBrandNextOrder($max = false) {
            if ($max) {
                 return $this->db->count_all_results($this->table);
            } else {
                 return $this->db->select_max('brd_sort_order')
                                 ->get($this->table)
                                 ->row()->brd_sort_order + 1;
            }
       }

       public function brandTree() {

            $this->db->select("cat.brd_id AS brd_id, cat.brd_title AS brd_title, cat2.brd_title AS parent_brd_title, cat2.brd_id AS parent_brd_id")
                    ->from($this->table . ' cat')
                    ->join($this->table . ' cat2', 'cat.brd_parent = cat2.brd_id', 'LEFT')
                    ->order_by('parent_brd_title');
            $tree = $this->db->get()->result_array();
            return $tree;
       }

       function getFitTo($inputId = 0, $idList = array()) {

            $this->db->where('brd_id', $inputId);
            $result = $this->db->get($this->table)->result_array();

            if ($result) {
                 $currentTitle = $result[0]["brd_title"];
                 $parentId = $result[0]["brd_parent"];

                 $idList[] = $currentTitle;

                 if ($parentId != 0) {
                      return $this->getFitTo($parentId, $idList);
                 }
            }
            return isset($idList[count($idList) - 1]) ? $idList[count($idList) - 1] : '';
       }
       public function getBrandsPaginate($postDatas, $filterDatas) {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
      
          // Clone the database object for getting the total records without limit and offset
          $totalRecordsQuery = clone $this->db;
          if (!empty($searchValue)) {
              $totalRecordsQuery->where("(branda.brd_title LIKE '%" . $searchValue . "%') ");
          }
          $totalRecordsQuery->select("COUNT(*) as total")->from($this->table . ' branda')
              ->join($this->table . ' brandb', 'branda.brd_parent = brandb.brd_id', 'left');
          $totalRecords = $totalRecordsQuery->get()->row()->total;
      
          if ($rowperpage > 0) {
              $this->db->limit($rowperpage, $row);
          }
      
          if (!empty($searchValue)) {
              $this->db->where("(branda.brd_title LIKE '%" . $searchValue . "%') ");
          }
      
          $this->db->select("branda.brd_id,branda.brd_title, brandb.brd_title AS parent,branda.brd_section")
              ->from($this->table . ' branda')
              ->join($this->table . ' brandb', 'branda.brd_parent = brandb.brd_id', 'left');
      
          $this->db->order_by('branda.brd_title', 'asc');
          $data = $this->db->get()->result_array();
      
          $response = array(
              "draw" => intval($postDatas['draw']),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecords,
              "aaData" => $data
          );
      
          return $response;
      }
      
  } 