<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class User_permission_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_user_access = TABLE_PREFIX . 'user_access';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_role = TABLE_PREFIX . 'role';
     }

     function getAllUserGroups()
     {
          return $this->db->get($this->tbl_designation)->result_array();
     }

     function getUsers($grps)
     {
          return $this->db->select($this->tbl_users . '.*, ' .
               $this->tbl_users_groups . '.group_id as group_id, ' .
               $this->tbl_groups . '.name as group_name, ' .
               $this->tbl_groups . '.description as group_desc, ' . $this->tbl_showroom . '.*,' . $this->tbl_designation . '.*')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->order_by($this->tbl_users . '.usr_first_name')->where(array(
                    $this->tbl_users . '.usr_designation_new' => $grps,
                    $this->tbl_users . '.usr_active' => 1
               ))->get($this->tbl_users)->result_array();
     }

     function addUserPermission($data)
     {
          if (!empty($data)) {
               $userDetails = $this->db->select($this->tbl_users . '.usr_id, ' .
                    $this->tbl_users_groups . '.group_id as group_id, ' .
                    $this->tbl_groups . '.grp_slug, ' . $this->tbl_groups . '.name as group_name, ' .
                    $this->tbl_groups . '.description as group_desc, ' . $this->tbl_showroom . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                    ->where($this->tbl_users . '.usr_id', $data['cua_user_id'])->get($this->tbl_users)->row_array();

               $data['cua_group_id'] = isset($userDetails['group_id']) ? $userDetails['group_id'] : 0;
               $data['cua_desig'] = isset($userDetails['grp_slug']) ? $userDetails['grp_slug'] : '';
               $data['cua_access'] = !empty($data['cua_access']) ? serialize($data['cua_access']) : serialize(array());

               $ifAlreadyExists = $this->db->get_where($this->tbl_user_access, array('cua_user_id' => $data['cua_user_id']))->num_rows();

               if ($ifAlreadyExists > 0) {
                    $this->db->where('cua_user_id', $data['cua_user_id'])->update($this->tbl_user_access, $data);
               } else {
                    $this->db->insert($this->tbl_user_access, $data);
               }
          } else {
               return false;
          }
     }

     function getUserPermission($id)
     {
          if (!empty($id)) {
               return $this->db->select('*')->where('cua_user_id', $id)->get($this->tbl_user_access)->row_array();
          } else {
               return false;
          }
     }
     /* role and permission*/
     function addRole($data)
     { //jsk

          if (!empty($data)) {
               $ifAlreadyExists = 0;
               $data['rol_access'] = !empty($data['rol_access']) ? serialize($data['rol_access']) : serialize(array());
               if (isset($data['rol_id'])) {
                    $ifAlreadyExists = $this->db->get_where($this->tbl_role, array('rol_id' => $data['rol_id']))->num_rows();
               }
               if ($ifAlreadyExists > 0) {
                    
                    if (!$data['rol_name']) {
                         unset($data['rol_name']);
                    }

                    $this->db->where('rol_id', $data['rol_id'])->update($this->tbl_role, $data);
               } else {
                    $this->db->insert($this->tbl_role, $data);
               }
          } else {
               return false;
          }
     }
     function getRole($id = '')
     { //jsk
          if (!empty($id)) {
               return $this->db->select('*')->where('cua_user_id', $id)->get($this->tbl_role)->row_array();
          } else {
               return $this->db->select('*')->get($this->tbl_role)->result_array();
          }
     }
     function getRolePermission($id)
     { //jsk
          if (!empty($id)) {
               return $this->db->select('*')->where('rol_id', $id)->get($this->tbl_role)->row_array();
          } else {
               return false;
          }
     }
     /*@role and permission*/
}
