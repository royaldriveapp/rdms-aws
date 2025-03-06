<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Careers_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_careers = TABLE_PREFIX . 'careers';
            $this->tbl_career_document = TABLE_PREFIX . 'career_document';
            $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
            $this->tbl_careers_applications = TABLE_PREFIX . 'careers_applications';
       }

       function getApplication() {
            return $this->db->select($this->tbl_careers_applications . '.*,' . $this->tbl_careers . '.*,' . $this->tbl_district_statewise . '.std_district_name')
                            ->join($this->tbl_careers, $this->tbl_careers . '.car_id = ' . $this->tbl_careers_applications . '.cap_post', 'LEFt')
                            ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_careers_applications . '.cap_district', 'LEFt')
                            ->order_by($this->tbl_careers_applications . '.cap_date', 'DESC')->get($this->tbl_careers_applications)->result_array();
       }

       public function getCareers($id = '') {

            if (!empty($id)) {
                 $this->db->where('car_id', $id);
                 return $this->db->get($this->tbl_careers)->row_array();
            }
            $this->db->order_by('car_order', 'asc');
            return $this->db->get($this->tbl_careers)->result_array();
       }

       public function addNewCareer($datas) {
            unset($datas['x1']);
            unset($datas['x2']);
            unset($datas['y1']);
            unset($datas['y2']);
            unset($datas['h']);
            unset($datas['w']);
            if ($this->db->insert($this->tbl_careers, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function removeCareerImage($id) {
            if ($id) {
                 $this->db->where('car_id', $id);
                 $brand = $this->db->get($this->tbl_careers)->result_array();
                 $brand = isset($brand['0']) ? $brand['0'] : array();
                 if (isset($brand['brd_logo']) && !empty($brand['brd_logo'])) {
                      if (file_exists(UPLOAD_PATH . 'brand/' . $brand['brd_logo'])) {
                           unlink(UPLOAD_PATH . 'brand/' . $brand['brd_logo']);
                      }
                      $this->db->where('car_id', $id);
                      $this->db->update($this->tbl_careers, array('brd_logo' => ''));
                      return true;
                 }
            }
            return false;
       }

       public function updateCareer($datas) {

            $dataWithOldPriority = $this->db->get_where($this->tbl_careers, array('car_order' => $datas['car_order']))->row_array();
            $dataWithNewPriority = $this->db->get_where($this->tbl_careers, array('car_id' => $datas['car_id']))->row_array();

            unset($datas['x1']);
            unset($datas['x2']);
            unset($datas['y1']);
            unset($datas['y2']);
            unset($datas['h']);
            unset($datas['w']);

            $this->db->where('car_id', $datas['car_id']);
            unset($datas['car_id']);
            if ($this->db->update($this->tbl_careers, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function deleteCareer($id) {
            $this->db->where('car_id', $id);
            $brand = $this->db->get($this->tbl_careers)->result_array();
            $brand = isset($brand['0']) ? $brand['0'] : array();
            if (isset($brand['brd_logo']) && !empty($brand['brd_logo'])) {
                 if (file_exists(UPLOAD_PATH . 'brand/' . $brand['brd_logo'])) {
                      unlink(UPLOAD_PATH . 'brand/' . $brand['brd_logo']);
                 }
            }
            $this->db->where('car_id', $id);
            if ($this->db->delete($this->tbl_careers)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function getCareerChaild($parent, $idNotin = '') {

            $this->db->select("car_id,  brd_title");
            $this->db->where('brd_parent', $parent);
            if (!empty($idNotin)) {
                 $this->db->where('car_id !=', $idNotin);
            }
            $result = $this->db->get($this->tbl_careers)->result_array();
            return $result;
       }

       function getCareerNextOrder($max = false) {
            if ($max) {
                 return $this->db->count_all_results($this->tbl_careers);
            } else {
                 return $this->db->select_max('car_order')
                                 ->get($this->tbl_careers)
                                 ->row()->car_order + 1;
            }
       }

       public function brandTree() {

            $this->db->select("cat.car_id AS car_id, cat.brd_title AS brd_title, cat2.brd_title AS parent_brd_title, cat2.car_id AS parent_car_id")
                    ->from($this->tbl_careers . ' cat')
                    ->join($this->tbl_careers . ' cat2', 'cat.brd_parent = cat2.car_id', 'LEFT')
                    ->order_by('parent_brd_title');
            $tree = $this->db->get()->result_array();
            return $tree;
       }

       function getFitTo($inputId = 0, $idList = array()) {

            $this->db->where('car_id', $inputId);
            $result = $this->db->get($this->tbl_careers)->result_array();

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

       public function addCareerDocument($datas) {
            if ($this->db->insert($this->tbl_career_document, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       function getDocuments() {
            return $this->db->get($this->tbl_career_document)->row_array();
       }

       function delete_document($id) {
            $this->db->where('crd_id', $id);
            $brand = $this->db->get($this->tbl_career_document)->row_array();
            if (isset($brand['crd_dodument']) && !empty($brand['crd_dodument'])) {
                 if (file_exists(UPLOAD_PATH . 'career_document/' . $brand['crd_dodument'])) {
                      unlink(UPLOAD_PATH . 'career_document/' . $brand['crd_dodument']);
                 }
            }
            $this->db->where('crd_id', $id);
            if ($this->db->delete($this->tbl_career_document)) {
                 return true;
            } else {
                 return false;
            }
       }

  }
  