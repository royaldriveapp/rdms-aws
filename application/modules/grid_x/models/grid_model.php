<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class grid_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");

          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
         // $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_grid_master = TABLE_PREFIX . 'grid_master';
          $this->tbl_grid_details = TABLE_PREFIX . 'grid_details';
          $this->tbl_grid_date_ranges = TABLE_PREFIX . 'grid_date_ranges';
          $this->tbl_variant = TABLE_PREFIX . 'grid_variants';
     }

     

   
     ////////

     function getVehData($filterDatas = array())
     {
         
          if (isset($filterDatas['brand']) && !empty($filterDatas['brand'])) {
             //  debug($filterDatas['brand']);
               $this->db->where_in($this->tbl_grid_master . '.grdm_brand', $filterDatas['brand']);
          }
          if (isset($filterDatas['model']) && !empty($filterDatas['model'])) {
               // debug(121);
               $this->db->where_in($this->tbl_grid_master . '.grdm_model', $filterDatas['model']);
          }
          if (isset($filterDatas['variant']) && !empty($filterDatas['variant'])) {
               $this->db->where_in($this->tbl_grid_master . '.grdm_variant', $filterDatas['variant']);
          }
          if (isset($filterDatas['year']) && !empty($filterDatas['year'])) {
               $this->db->where_in($this->tbl_grid_details . '.grdtl_year', $filterDatas['year']);
          }
          if (isset($filterDatas['km']) && !empty($filterDatas['km'])) {
               $this->db->where_in($this->tbl_grid_details . '.grdtl_km', $filterDatas['km']);
          }
          if (isset($filterDatas['owner']) && !empty($filterDatas['owner'])) {
               $this->db->where_in($this->tbl_grid_details . '.grdtl_owner', $filterDatas['owner']);
          }
          $data =$this->db->select($this->tbl_grid_master . '.grdm_id,' . $this->tbl_grid_master . '.grdm_variant,'. $this->tbl_grid_details . '.grdtl_owner,'. $this->tbl_grid_details . '.grdtl_depreciation,'
          . $this->tbl_grid_details . '.grdtl_year,' . $this->tbl_grid_details . '.grdtl_km,' . $this->tbl_grid_details . '.grdtl_price,'
          . $this->tbl_model . '.mod_id,' . $this->tbl_model . '.mod_title,' .
          $this->tbl_brand . '.brd_id,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.grv_id  AS var_id,' . $this->tbl_variant . '.grv_variant AS var_variant_name,'. $this->tbl_grid_date_ranges . '.grdate_year_range')
          ->join($this->tbl_grid_details, $this->tbl_grid_details . '.grdtl_master_id = ' . $this->tbl_grid_master . '.grdm_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_grid_master . '.grdm_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_grid_master . '.grdm_brand', 'left')
              // ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_grid_master . '.grdm_variant', 'left')
              ->join($this->tbl_variant, $this->tbl_variant . '.grv_id  = ' . $this->tbl_grid_master . '.grdm_variant', 'left')
               ->join($this->tbl_grid_date_ranges, $this->tbl_grid_date_ranges . '.grdate_master_id = ' . $this->tbl_grid_master . '.grdm_id', 'left')
               ->order_by($this->tbl_grid_master . '.grdm_brand', 'asc')->order_by($this->tbl_grid_master . '.grdm_model', 'asc')->order_by($this->tbl_grid_master . '.grdm_variant', 'asc')
               ->order_by($this->tbl_grid_details . '.grdtl_owner', 'asc')
               ->group_by($this->tbl_grid_master . '.grdm_brand')
               ->group_by($this->tbl_grid_master . '.grdm_model')
               ->group_by($this->tbl_grid_master . '.grdm_variant')
               ->group_by($this->tbl_grid_details . '.grdtl_owner')
               ->get($this->tbl_grid_master)->result_array();
     
          return $data;
     }
     function getDetails($masterId,$depreciation,$year,$km)
     {
         // return $depreciation;
     $data = $this->db->select($this->tbl_grid_details . '.*')->where('grdtl_master_id',$masterId)->where('grdtl_depreciation',$depreciation)->where('grdtl_year',$year)->where('grdtl_km',$km)->get($this->tbl_grid_details)->row_array();
     if(!empty($data)){
     //return 786;
     return $data;
     }
     return 0;
     }
     function getVariantByModel($id)
     {
          return $this->db->select($this->tbl_variant . '.*, grv_id  AS col_id, grv_variant AS col_title')
               ->where_in('grv_model', $id)->get($this->tbl_variant)->result_array();
     }
     function store($datas)
     {
          $exist = $this->db->select($this->tbl_grid_master . '.grdm_id')->where('grdm_variant',$datas['variant'])->get($this->tbl_grid_master)->row_array();
          if(!empty($exist)){
               debug('Data exists',1);
               exit;
               }
              
              
          if (isset($datas['cost']) && !empty($datas['cost'])) {
                    $this->db->insert($this->tbl_grid_master, array(
                                 'grdm_brand' => $datas['brand'],
                                 'grdm_model' => $datas['model'],
                                 'grdm_variant' => $datas['variant'],'grdm_created_at' => date('Y-m-d H:i:s')
                    ));
                    $masterId = $this->db->insert_id();

                    $this->db->insert($this->tbl_grid_date_ranges, array(
                         'grdate_master_id' => $masterId,
                         'grdate_year_range' => $datas['date_ranges'],
                       'grdate_created_at' => date('Y-m-d H:i:s')
            ));


               $year = isset($datas['cost']['year']) ? count($datas['cost']['year']) : 0;
               for ($i = 0; $i < $year; $i++) {

                    //foreach ($datas['cost'] as $key => $value) {
                    if((isset($datas['cost']['year'][$i]) && !empty(($datas['cost']['year'][$i])))) {
                         $this->db->insert($this->tbl_grid_details, array(
                                 'grdtl_master_id' => $masterId,
                                 'grdtl_owner' => 1,
                                 'grdtl_year' => $datas['cost']['year'][$i],
                                 'grdtl_km' => 25000,
                                 'grdtl_depreciation' =>$datas['depre_owner1'] ,
                                 'grdtl_price' => $datas['cost']['25000'][$i],
                                 'grdtl_created_at' => date('Y-m-d H:i:s')
                              )
                              
                         );//1

                         $this->db->insert($this->tbl_grid_details, array(
                              'grdtl_master_id' => $masterId,
                              'grdtl_owner' => 1,
                              'grdtl_year' => $datas['cost']['year'][$i],
                              'grdtl_km' => 50000,
                              'grdtl_depreciation' =>$datas['depre_owner1'] ,
                              'grdtl_price' => $datas['cost']['50000'][$i],
                              'grdtl_created_at' => date('Y-m-d H:i:s')
                           )
                           
                      );//2

                      $this->db->insert($this->tbl_grid_details, array(
                         'grdtl_master_id' => $masterId,
                         'grdtl_owner' => 1,
                         'grdtl_year' => $datas['cost']['year'][$i],
                         'grdtl_km' => 75000,
                         'grdtl_depreciation' =>$datas['depre_owner1'] ,
                         'grdtl_price' => $datas['cost']['75000'][$i],
                         'grdtl_created_at' => date('Y-m-d H:i:s')
                      )
                      
                 );//3

                 //-------------------------//
                // $owner2_25000km_cost=($datas['depre_owner2']/100)* $datas['cost']['25000'][$i];
              //-------------------------//
                 $this->db->insert($this->tbl_grid_details, array(
                    'grdtl_master_id' => $masterId,
                    'grdtl_owner' => 2,
                    'grdtl_year' => $datas['cost']['year'][$i],
                    'grdtl_km' => 25000,
                    'grdtl_depreciation' =>$datas['depre_owner2'] ,
                    'grdtl_price' => 0,
                    'grdtl_created_at' => date('Y-m-d H:i:s')
                 )
                 
            );//b1
            $this->db->insert($this->tbl_grid_details, array(
               'grdtl_master_id' => $masterId,
               'grdtl_owner' => 2,
               'grdtl_year' => $datas['cost']['year'][$i],
               'grdtl_km' => 50000,
               'grdtl_depreciation' =>$datas['depre_owner2'] ,
               'grdtl_price' => 0,
               'grdtl_created_at' => date('Y-m-d H:i:s')
            )
            
       );//b2
       $this->db->insert($this->tbl_grid_details, array(
          'grdtl_master_id' => $masterId,
          'grdtl_owner' => 2,
          'grdtl_year' => $datas['cost']['year'][$i],
          'grdtl_km' => 75000,
          'grdtl_depreciation' =>$datas['depre_owner2'] ,
          'grdtl_price' =>0,
          'grdtl_created_at' => date('Y-m-d H:i:s')
       )
       
  );//b3

  $this->db->insert($this->tbl_grid_details, array(
     'grdtl_master_id' => $masterId,
     'grdtl_owner' => 3,
     'grdtl_year' => $datas['cost']['year'][$i],
     'grdtl_km' => 25000,
     'grdtl_depreciation' =>$datas['depre_owner3'] ,
     'grdtl_price' => 0,
     'grdtl_created_at' => date('Y-m-d H:i:s')
  )
  
);//c1
$this->db->insert($this->tbl_grid_details, array(
'grdtl_master_id' => $masterId,
'grdtl_owner' => 3,
'grdtl_year' => $datas['cost']['year'][$i],
'grdtl_km' => 50000,
'grdtl_depreciation' =>$datas['depre_owner3'] ,
'grdtl_price' => 0,
'grdtl_created_at' => date('Y-m-d H:i:s')
)

);//c2
$this->db->insert($this->tbl_grid_details, array(
'grdtl_master_id' => $masterId,
'grdtl_owner' => 3,
'grdtl_year' => $datas['cost']['year'][$i],
'grdtl_km' => 75000,
'grdtl_depreciation' =>$datas['depre_owner3'] ,
'grdtl_price' =>0,
'grdtl_created_at' => date('Y-m-d H:i:s')
)

);//c3

                    }
               }
          }
     }

     function isExist($id)
     {
         // return $depreciation;
     $data = $this->db->select($this->tbl_grid_master . '.grdm_id')->where('grdm_variant',$id)->get($this->tbl_grid_master)->row_array();
     if(!empty($data)){
     return true;
     }
     return false;
     }
}
