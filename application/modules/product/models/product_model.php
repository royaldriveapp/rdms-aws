<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class Product_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");

          $this->table = TABLE_PREFIX_RANA . 'products';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbt_prod_features = TABLE_PREFIX_RANA . 'prod_features';
          $this->tbt_prod_images = TABLE_PREFIX_RANA . 'prod_images';
          $this->tbl_users = TABLE_PREFIX_RANA . 'users';
          $this->tbl_users_admin = TABLE_PREFIX . 'users';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_tyres_comp = TABLE_PREFIX . 'tyres_comp';
          $this->tbl_valuation_upgrade_details = TABLE_PREFIX . 'valuation_upgrade_details';
          $this->tbl_health_card = TABLE_PREFIX . 'health_card';
          $this->tbl_health_card_tyre_and_break_pad = TABLE_PREFIX . 'health_card_tyre_and_break_pad';
          $this->tbl_health_card_battery = TABLE_PREFIX . 'health_card_battery';
          $this->tbl_health_card_refurb_details = TABLE_PREFIX . 'health_card_refurb_details';
     }

     function getColor()
     {
          return $this->db->order_by('vc_color', 'ASC')->get_where($this->tbl_vehicle_colors, array('vc_status' => 1))->result_array();
     }

     public function getBrands($id = '')
     {
          $this->db->select("branda.*, brandb.brd_title AS parent")
               ->from($this->tbl_brand . ' branda')
               ->join($this->tbl_brand . ' brandb', 'branda.brd_parent = brandb.brd_id', 'left');

          if (!empty($id)) {
               $this->db->where('branda.brd_id', $id);
          }
          $this->db->order_by('branda.brd_title', 'asc');
          $brands = $this->db->get()->result_array();
          return $brands;
     }
     public function getProduct($limit = 0, $page = 0, $filter = array())
     {
          $data = array();

          //Count
          if (isset($filter['search_string']) && !empty($filter['search_string'])) {
               $this->db->where("(prd_regno_prt_1 LIKE '%" . $filter['search_string'] . "%' OR prd_regno_prt_2 LIKE '%"
                    . $filter['search_string'] . "%' OR " . "prd_regno_prt_3 LIKE '%" . $filter['search_string'] . "%' OR prd_regno_prt_4 LIKE '%" .
                    $filter['search_string'] . "%' OR prd_number LIKE '%" . $filter['search_string'] . "%' OR prd_id = " . $filter['search_string'] . ") ");
          }
          if (isset($filter['who'])) {
               $this->db->where($this->table . '.prd_added_by_user', $filter['who']);
          }
          if (isset($filter['lux'])) {
               $this->db->where($this->table . '.prd_rd_mini', $filter['lux']);
          }
          if (isset($filter['sts'])) {
               $this->db->where($this->table . '.prd_status', $filter['sts']);
          }
          if (isset($filter['sld'])) {
               $this->db->where($this->table . '.prd_soled', $filter['sld']);
          }

          if (isset($filter['prd_rd_mini']) && ($filter['prd_rd_mini'] >= 0)) {
               $this->db->where($this->table . '.prd_rd_mini', $filter['prd_rd_mini']);
          }

          if (isset($filter['prd_status']) && ($filter['prd_status'] >= 0)) {
               $this->db->where($this->table . '.prd_status', $filter['prd_status']);
          } else {
               //$this->db->where($this->table . '.prd_status', 1);
          }

          if (isset($filter['prd_booking_status']) && ($filter['prd_booking_status'] >= 0)) {
               $this->db->where($this->table . '.prd_booking_status', $filter['prd_booking_status']);
          } 

          if (isset($filter['prd_photo_upld_by'])) {
               $this->db->where($this->table . '.prd_photo_upld_by', 0);
          }

          if (isset($filter['prd_verified_by']) && ($filter['prd_verified_by'] > 0)) {
               $this->db->where($this->table . '.prd_verified_by > 0');
          }

          if (isset($filter['prd_brand']) && $filter['prd_brand'] > 0) {
               $this->db->where($this->table . '.prd_brand', $filter['prd_brand']);
          }

          if (isset($filter['prd_model']) && $filter['prd_model'] > 0) {
               $this->db->where($this->table . '.prd_model', $filter['prd_model']);
          }

          if (isset($filter['prd_variant']) && ($filter['prd_variant'] > 0)) {
               $this->db->where($this->table . '.prd_variant', $filter['prd_variant']);
          }
          $data['count'] = $this->db->count_all_results($this->table);

          $selectArray = array(
               $this->table . '.prd_id',
               $this->table . '.prd_regno_prt_1',
               $this->table . '.prd_regno_prt_2',
               $this->table . '.prd_regno_prt_3',
               $this->table . '.prd_regno_prt_4',
               $this->table . '.prd_number',
               $this->table . '.prd_name',
               $this->table . '.prd_status',
               $this->table . '.prd_rd_mini',
               $this->table . '.prd_popular',
               $this->table . '.prd_booked',
               $this->table . '.prd_soled',
               $this->table . '.prd_latest',
               $this->table . '.prd_date',
               $this->table . '.prd_color',
               $this->table . '.prd_price',
               $this->table . '.prd_valuation_id',
               $this->table . '.prd_cus_name',
               $this->table . '.prd_cus_phone',
               $this->table . '.prd_cus_email',
               $this->table . '.prd_user_id',
               $this->tbl_vehicle_colors . '.vc_color',
               $this->tbl_brand . '.*',
               $this->tbl_model . '.*',
               $this->tbl_variant . '.*'
          );

          $this->db->select($selectArray);
          $this->db->join($this->tbl_vehicle_colors, 'vc_id = prd_color_id', 'left');
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->table . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->table . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->table . '.prd_variant', 'left');

          if (isset($filter['who'])) {
               $this->db->where($this->table . '.prd_added_by_user', $filter['who']);
          }
          if (isset($filter['lux'])) {
               $this->db->where($this->table . '.prd_rd_mini', $filter['lux']);
          }
          if (isset($filter['sts'])) {
               $this->db->where($this->table . '.prd_status', $filter['sts']);
          }
          if (isset($filter['sld'])) {
               $this->db->where($this->table . '.prd_soled', $filter['sld']);
          }

          if (isset($filter['prd_rd_mini']) && ($filter['prd_rd_mini'] >= 0)) {
               $this->db->where($this->table . '.prd_rd_mini', $filter['prd_rd_mini']);
          }

          if (isset($filter['prd_status']) && ($filter['prd_status'] >= 0)) {
               $this->db->where($this->table . '.prd_status', $filter['prd_status']);
          } else {
               //$this->db->where($this->table . '.prd_status', 1);
          }

          if (isset($filter['prd_booking_status']) && ($filter['prd_booking_status'] >= 0)) {
               $this->db->where($this->table . '.prd_booking_status', $filter['prd_booking_status']);
          } 

          if (isset($filter['prd_photo_upld_by'])) {
               $this->db->where($this->table . '.prd_photo_upld_by', 0);
          }

          if (isset($filter['prd_verified_by']) && ($filter['prd_verified_by'] > 0)) {
               $this->db->where($this->table . '.prd_verified_by > 0');
          }
          if (isset($filter['search_string']) && !empty($filter['search_string'])) {
               $this->db->where("(prd_regno_prt_1 LIKE '%" . $filter['search_string'] . "%' OR prd_regno_prt_2 LIKE '%"
                    . $filter['search_string'] . "%' OR " . "prd_regno_prt_3 LIKE '%" . $filter['search_string'] . "%' OR prd_regno_prt_4 LIKE '%" .
                    $filter['search_string'] . "%' OR prd_number LIKE '%" . $filter['search_string'] . "%' OR prd_id = " . $filter['search_string'] . " ) ");
          }
          if (isset($filter['prd_brand']) && $filter['prd_brand'] > 0) {
               $this->db->where($this->table . '.prd_brand', $filter['prd_brand']);
          }

          if (isset($filter['prd_model']) && $filter['prd_model'] > 0) {
               $this->db->where($this->table . '.prd_model', $filter['prd_model']);
          }

          if (isset($filter['prd_variant']) && ($filter['prd_variant'] > 0)) {
               $this->db->where($this->table . '.prd_variant', $filter['prd_variant']);
          }
          //Data
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          $this->db->order_by($this->table . '.prd_id', 'DESC');
          $productsArray = $this->db->get($this->table)->result_array();
          // echo $this->db->last_query();
          // debug($productsArray);
          if (!empty($productsArray)) {
               foreach ($productsArray as $key => $value) {
                    $prodImages = $this->db->get_where(TABLE_PREFIX_RANA . 'prod_images', array('pdi_prod_id' => $value['prd_id']))->result_array();
                    $value['product_images'] = $prodImages;
                    $data['data'][] = $value;
               }
          }
          return $data;
     }

     function getSingleProduct($id)
     {
          $this->load->model('brand_model');
          $this->db->select($this->table . '.*, ' . TABLE_PREFIX_RANA . 'brand.*, ' . $this->tbl_model . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' .
               $this->tbl_showroom . '.*,' . $this->tbl_vehicle_colors . '.vc_color AS prd_color');
          $this->db->join(TABLE_PREFIX_RANA . 'brand', TABLE_PREFIX_RANA . 'brand.brd_id = ' . $this->table . '.prd_brand', 'left');
          $this->db->join($this->tbl_vehicle_colors, 'vc_id = prd_color_id', 'left');
          $this->db->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->table . '.prd_location', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->table . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->table . '.prd_variant', 'left');
          $this->db->join($this->tbl_users, $this->tbl_users . '.id = ' . $this->table . '.prd_user_id', 'left');
          if ($id) {
               $this->db->where($this->table . '.prd_id', $id);
          }
          $productsArray = $this->db->get($this->table)->row_array();
          $products['product_details'] = array();
          $products['product_specification'] = array();
          $products['product_images'] = array();
          if (!empty($productsArray)) {
               $prodSpecifications = $this->db->order_by("spe_id", "asc")->get_where(TABLE_PREFIX_RANA . 'prod_specifications', array('spe_prod_id' => $productsArray['prd_id']))->result_array();
               $products['product_features'] = $this->db->select("GROUP_CONCAT(pft_feature_id) AS features")->get_where($this->tbt_prod_features, array('pft_prod_id' => $productsArray['prd_id']))->row_array();
               $prodImages = $this->db->get_where(TABLE_PREFIX_RANA . 'prod_images', array('pdi_prod_id' => $productsArray['prd_id']))->result_array();
               $products['product_specification'] = $prodSpecifications;
               $products['product_images'] = $prodImages;
               $products['product_details'] = $productsArray;
          }
          return $products;
     }

     public function addNewProduct($datas)
     {

          if (isset($datas['product']['prd_brand'])) {
               $datas['product']['prd_order'] = $this->db->select_max('prd_order')->where('prd_brand', $datas['product']['prd_brand'])
                    ->get($this->table)->row()->prd_order + 1;
          }
          $datas['prd_order'] = $this->getNextOrder();
          $datas['product']['prd_regno_prt_1'] = strtoupper($datas['product']['prd_regno_prt_1']);
          $datas['product']['prd_regno_prt_3'] = strtoupper($datas['product']['prd_regno_prt_3']);
          $datas['product']['prd_status'] = 1;
          $datas['product']['prd_rd_mini'] = isset($datas['product']['prd_rd_mini']) ? $datas['product']['prd_rd_mini'] : 0;
          $datas['product']['prd_fst_added_by'] = $this->uid;
          $datas['product']['prd_data_updated'] = $this->uid; //Data updated by
          $datas['product']['prd_date'] = date('Y-m-d H:i:s');
          $datas['product']['prd_price'] = !empty($datas['product']['prd_price']) ? str_replace(',', '', $datas['product']['prd_price']) : 0;
          if ($this->db->insert($this->table, array_filter($datas['product']))) {
               $lastId = $this->db->insert_id();

               $specifications = $datas['specification'];
               if ($specifications) {
                    for ($i = 0; $i < count($specifications['spe_specification']); $i++) {
                         if (!empty($specifications['spe_specification'][$i]) || !empty($specifications['spe_specification_detail'][$i])) {
                              $specifi = array(
                                   'spe_prod_id' => $lastId,
                                   'spe_specification' => $specifications['spe_specification'][$i],
                                   'spe_specification_detail' => $specifications['spe_specification_detail'][$i],
                              );
                              $this->db->insert(TABLE_PREFIX_RANA . 'prod_specifications', $specifi);
                         }
                    }
               }

               if (isset($datas['features']) && !empty($datas['features'])) {
                    foreach ($datas['features'] as $key => $value) {
                         $features = array(
                              'pft_prod_id' => $lastId,
                              'pft_feature_id' => $key,
                         );
                         $this->db->insert($this->tbt_prod_features, $features);
                    }
               }

               //SMS to customer
               $beforeOneWeek = date('Y-m-d', strtotime("-1 week")); //1 week ago
               $brand = $datas['product']['prd_brand'];
               $model = $datas['product']['prd_model'];
               $varnt = $datas['product']['prd_variant'];
               $currentProduct = $this->common_model->getVehicleName($brand, $model, $varnt);
               $selectArray = array(
                    $this->tbl_enquiry . '.enq_cus_name',
                    $this->tbl_enquiry . '.enq_cus_mobile',
                    $this->tbl_enquiry . '.enq_se_id',
                    $this->tbl_enquiry . ".enq_cus_status",
                    $this->tbl_users_admin . '.usr_active',
                    $this->tbl_users_admin . '.usr_first_name',
                    $this->tbl_users_admin . '.usr_phone',
                    $this->tbl_brand . '.brd_title',
                    $this->tbl_model . '.mod_title',
                    $this->tbl_variant . '.var_variant_name',
                    $this->tbl_showroom . '.shr_phone_num'
               );
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $relatedCustomers = $this->db->select($selectArray)
                    ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->join($this->tbl_users_admin, $this->tbl_users_admin . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users_admin . '.usr_showroom', 'LEFT')
                    ->where(array($this->tbl_vehicle . '.veh_brand' => $brand, $this->tbl_vehicle . '.veh_model' => $model))
                    ->where($this->tbl_enquiry . ".enq_next_foll_date >= DATE('" . $beforeOneWeek . "')")
                    ->where($this->tbl_enquiry . ".enq_cus_status", '1')->get($this->tbl_enquiry)->result_array();
               foreach ($relatedCustomers as $key => $value) {
                    $sms = '';
                    if ($value['usr_active'] == 1) { // Active members
                         $sms = "Dear " . $value['enq_cus_name'] . ", we've launched a new stock " . $currentProduct .
                              ", contact for more info " . $value['usr_first_name'] . ', ' . $value['usr_phone'] .
                              " - Royal Drive South India's Largest Pre-Owned Luxury Car Showroom";
                    } else { // Resigned members
                         $sms = "Dear " . $value['enq_cus_name'] . ", we've launched a new stock " . $currentProduct .
                              ", contact for more info " . $value['shr_phone_num'] .
                              " - Royal Drive South India's Largest Pre-Owned Luxury Car Showroom";
                    }
                    send_sms($sms, $value['enq_cus_mobile'], 'new product launch to customer', '1607100000000042909');
               }
               $mymsg = 'Dear jk, enq cnt : ' . count($relatedCustomers) . " prd no  " . $datas['product']['prd_number'] . " - Royal Drive South India's Largest Pre-Owned Luxury Car Showroom";
               send_sms($mymsg, 919745661946, 'new product launch to customer', '1607100000000042909');
               /**/
               return $lastId;
          } else {
               return false;
          }
     }

     public function addImages($image)
     {
          if ($this->db->insert(TABLE_PREFIX_RANA . 'prod_images', $image)) {
               return true;
          } else {
               return false;
          }
     }

     public function removePrductImage($id)
     {
          if ($id) {
               $this->db->where('pdi_id', $id);
               $image = $this->db->get(TABLE_PREFIX_RANA . 'prod_images')->result_array();
               $image = isset($image['0']) ? $image['0'] : array();
               if (isset($image['pdi_image']) && !empty($image['pdi_image'])) {
                    if (file_exists(FILE_UPLOAD_PATH . 'product/' . $image['pdi_image'])) {
                         unlink(FILE_UPLOAD_PATH . 'product/' . $image['pdi_image']);
                         @unlink(FILE_UPLOAD_PATH . 'product/thumb_' . $image['pdi_image']);
                    }
                    $this->db->where('pdi_id', $id);
                    $this->db->delete(TABLE_PREFIX_RANA . 'prod_images');
                    return true;
               }
          }
          return false;
     }

     public function updateProduct($datas)
     {

          if (isset($datas['prd_id']) && !empty($datas['prd_id'])) {

               $datas['product']['prd_new_arrivals'] = isset($datas['product']['prd_new_arrivals']) ? $datas['product']['prd_new_arrivals'] : 0;
               $datas['product']['prd_loan_avail'] = isset($datas['product']['prd_loan_avail']) ? $datas['product']['prd_loan_avail'] : 0;
               $datas['product']['prd_regno_prt_1'] = strtoupper($datas['product']['prd_regno_prt_1']);
               $datas['product']['prd_regno_prt_3'] = strtoupper($datas['product']['prd_regno_prt_3']);
               $this->db->where('prd_id', $datas['prd_id']);
               $datas['product'] = array_filter($datas['product']);
               $datas['product']['prd_wrapp_color'] = isset($datas['product']['prd_wrapp_color']) ? $datas['product']['prd_wrapp_color'] : '';
               $datas['product']['prd_order'] = isset($datas['product']['prd_order']) ? $datas['product']['prd_order'] : 0;
               $datas['product']['prd_price'] = isset($datas['product']['prd_price']) ? $datas['product']['prd_price'] : 0;
               $datas['product']['prd_km_run'] = isset($datas['product']['prd_km_run']) ? $datas['product']['prd_km_run'] : 0;
               $datas['product']['prd_sync'] = 0;
               $datas['product']['prd_insurance_validity'] = isset($datas['product']['prd_insurance_validity']) ? $datas['product']['prd_insurance_validity'] : '';
               $datas['product']['prd_insurance_idv'] = isset($datas['product']['prd_insurance_idv']) ? $datas['product']['prd_insurance_idv'] : 0;
               if ($this->db->update($this->table, $datas['product'])) {
                    $prodId = $datas['prd_id'];
                    if (isset($datas['specification']) && !empty($datas['specification'])) {
                         $specifications = $datas['specification'];

                         $this->db->delete(TABLE_PREFIX_RANA . 'prod_specifications', array('spe_prod_id' => $prodId));
                         if ($specifications) {
                              for ($i = 0; $i < count($specifications['spe_specification']); $i++) {
                                   if (!empty($specifications['spe_specification'][$i]) || !empty($specifications['spe_specification_detail'][$i])) {
                                        $specifi = array(
                                             'spe_prod_id' => $prodId,
                                             'spe_specification' => $specifications['spe_specification'][$i],
                                             'spe_specification_detail' => $specifications['spe_specification_detail'][$i],
                                        );
                                        $this->db->insert(TABLE_PREFIX_RANA . 'prod_specifications', $specifi);
                                   }
                              }
                         }
                    }
                    if (isset($datas['features']) && !empty($datas['features'])) {
                         $this->db->delete($this->tbt_prod_features, array('pft_prod_id' => $prodId));
                         foreach ($datas['features'] as $key => $value) {
                              $features = array(
                                   'pft_prod_id' => $prodId,
                                   'pft_feature_id' => $key,
                              );
                              $this->db->insert($this->tbt_prod_features, $features);
                         }
                    }
                    return true;
               } else {
                    return false;
               }
          } else {
               return false;
          }
     }

     public function deleteProduct($id)
     {
          if (!empty($id)) {
               $this->db->delete($this->table, array('prd_id' => $id));
               $this->db->delete(TABLE_PREFIX_RANA . 'prod_specifications', array('spe_prod_id' => $id));

               $this->db->where('pdi_prod_id', $id);
               $images = $this->db->get(TABLE_PREFIX_RANA . 'prod_images')->result_array();
               $this->db->delete(TABLE_PREFIX_RANA . 'prod_images', array('pdi_prod_id' => $id));
               if (!empty($images)) {
                    foreach ($images as $key => $value) {
                         if (file_exists(FILE_UPLOAD_PATH . 'product/' . $value['pdi_image'])) {
                              unlink(FILE_UPLOAD_PATH . 'product/' . $value['pdi_image']);
                              @unlink(FILE_UPLOAD_PATH . 'product/thumb_' . $image['pdi_image']);
                         }
                    }
               }

               return true;
          } else {
               return false;
          }
     }

     /* related to excel import */

     function getBrandIdByBrandName($brandName)
     {
          $brandName = trim($brandName);
          if (!empty($brandName)) {
               $result = $this->db->select('brd_id')->from(TABLE_PREFIX_RANA . 'brand')->like('brd_title', $brandName)->get()->row_array();
               if (isset($result['brd_id']) && !empty($result['brd_id'])) {
                    return $result['brd_id'];
               } else {
                    return null;
               }
          } else {
               return null;
          }
     }

     function getCategoryIdByCategoryName($categoryName)
     {
          $categoryName = trim($categoryName);
          if (!empty($categoryName)) {
               $result = $this->db->select('cat_id')->from(TABLE_PREFIX_RANA . 'category')->like('cat_title', $categoryName)->get()->row_array();
               if (isset($result['cat_id']) && !empty($result['cat_id'])) {
                    return $result['cat_id'];
               } else {
                    return null;
               }
          } else {
               return null;
          }
     }

     function importNewProduct($datas)
     {
          if (!empty($datas)) {
               $datas['prd_from_excel'] = 1;
               if ($this->db->insert(TABLE_PREFIX_RANA . 'products', $datas)) {
                    return $this->db->insert_id();
               }
          }
     }

     function addNewProductSpecification($datas)
     {
          if (!empty($datas)) {
               if ($this->db->insert(TABLE_PREFIX_RANA . 'prod_specifications', $datas)) {
                    return $this->db->insert_id();
               }
          }
     }

     function addNewProductImage($datas)
     {
          if (!empty($datas)) {
               if ($this->db->insert(TABLE_PREFIX_RANA . 'prod_images', $datas)) {
                    return $this->db->insert_id();
               }
          }
     }

     public function getProductByBrandId($brandId = '')
     {
          $this->load->model('brand_model');
          $this->db->select($this->table . '.*, ' . TABLE_PREFIX_RANA . 'category.cat_id AS sub_category,' . TABLE_PREFIX_RANA . 'category.cat_title AS sub_category_name , ' . TABLE_PREFIX_RANA . 'brand.*, '
               . 'cat1.cat_id AS category_id, cat1.cat_title AS category_name')->from($this->table);
          $this->db->join(TABLE_PREFIX_RANA . 'brand', TABLE_PREFIX_RANA . 'brand.brd_id = ' . $this->table . '.prd_brand', 'left');
          $this->db->join(TABLE_PREFIX_RANA . 'category', TABLE_PREFIX_RANA . 'category.cat_id = ' . $this->table . '.prd_category ', 'left');
          $this->db->join(TABLE_PREFIX_RANA . 'category cat1', 'cat1.cat_id = ' . TABLE_PREFIX_RANA . 'category.cat_parent ', 'left');
          if ($brandId) {
               $this->db->where($this->table . '.prd_brand', $brandId);
          }

          $productsArray = $this->db->get()->result_array();
          $products['product_details'] = array();
          $products['product_specification'] = array();
          $products['product_images'] = array();
          if (!empty($productsArray)) {
               foreach ($productsArray as $key => $value) {
                    $prodSpecifications = $this->db->order_by("spe_id", "asc")->get_where(TABLE_PREFIX_RANA . 'prod_specifications', array('spe_prod_id' => $value['prd_id']))->result_array();
                    $prodImages = $this->db->get_where(TABLE_PREFIX_RANA . 'prod_images', array('pdi_prod_id' => $value['prd_id']))->result_array();

                    $value['fit_to'] = $this->brand_model->getFitTo($value['prd_brand']);
                    $value['product_specification'] = $prodSpecifications;
                    $value['product_images'] = $prodImages;

                    $products['product_details'][] = $value;
               }
          }
          return $products;
     }

     function getNextOrder($max = false)
     {
          if ($max) {
               return $this->db->count_all_results($this->table);
          } else {
               return $this->db->select_max('prd_order')->get($this->table)->row()->prd_order + 1;
          }
     }

     function arrangeProductOrder($datas)
     {

          $product = $this->db->select('*')->from($this->table)->where('prd_id', $datas['product'])->get()->row_array();

          $productInNewOrder = $this->db->select('*')
               ->from($this->table)
               ->where(array('prd_order' => $datas['newOrder'], 'prd_brand' => $datas['brand']))->get()->row_array();

          if (!empty($productInNewOrder) && isset($productInNewOrder['prd_id'])) {
               $this->db->update($this->table, array('prd_order' => $product['prd_order']), 'prd_id = ' . $productInNewOrder['prd_id']);
          }

          if ($this->db->update($this->table, array('prd_order' => $datas['newOrder']), 'prd_id = ' . $datas['product'])) {
               return true;
          } else {
               return false;
          }
     }

     function changesStatus($field, $prdId, $status)
     {
          if (!empty($prdId)) {
               if ($field == 'prd_booked') {
                    $update['prd_booking_status'] = ($status == 1) ? 28 : 1;
               }
               if ($field == 'prd_soled') {
                    $update['prd_booking_status'] = ($status == 1) ? 40 : 1;
                    $update['prd_booked'] = 1;
               }
               $update[$field] = $status;
               if ($field == 'prd_status') {
                    if ($status == 1) {
                         $update['prd_verified_by'] = $this->uid;
                    } else {
                         $update['prd_verified_by'] = 0;
                    }
               }
               $update['prd_sync'] = 0;
               $this->db->where('prd_id', $prdId);
               $this->db->update($this->table, $update);
               //return $status . '-' .  $this->db->last_query();
               return true;
          } else {
               return false;
          }
     }

     function setDefaultImage($imgId, $prodId)
     {
          $this->db->where('prd_id', $prodId)->update($this->table, array('prd_sync' => 0));

          $this->db->where('pdi_prod_id', $prodId);
          $this->db->update($this->tbt_prod_images, array('pdi_is_default' => 0));

          $this->db->where('pdi_id', $imgId);
          $this->db->update($this->tbt_prod_images, array('pdi_is_default' => 1));
          return true;
     }

     function getValuationProduct($data)
     {
          return $this->db->order_by('val_id', 'DESC')->limit(1)->get_where($this->tbl_valuation, array(
               'UPPER(val_prt_1)' => strtoupper($data['regNo1']),
               'val_prt_2' => $data['regNo2'],
               'UPPER(val_prt_3)' => strtoupper($data['regNo3']),
               'val_prt_4' => $data['regNo4']
          ))->row_array();
     }

     function getProductValuation($valId)
     {
          $select = array(
               'val_id',
               'val_fuel',
               'val_reg_date',
               'val_insurance',
               'val_veh_type',
               'val_arai_tstd_fuel_efncy',
               'val_torque',
               'val_power',
               'val_transmission',
               'val_drive_train',
               'val_wrnty_type',
               'val_service_type',
               'val_lst_service_place',
               'val_minif_month',
               'val_minif_year',
               'val_new_vehicle_price',
               'val_last_service',
               'val_last_service_km',
               'val_wrnty_nxt_ser_date',
               'val_wrnty_nxt_ser_km',
               'val_wrnty_type',
               'val_wrnty_validity',
               'val_color',
               'val_tyre_1',
               'val_tyre_1_wek',
               'val_tyre_1_yer',
               'val_tyre_2',
               'val_tyre_2_wek',
               'val_tyre_2_yer',
               'val_tyre_3',
               'val_tyre_3_wek',
               'val_tyre_3_yer',
               'val_tyre_4',
               'val_tyre_4_wek',
               'val_tyre_4_yer',
               'val_tyre_5',
               'val_tyre_5_wek',
               'val_tyre_5_yer',
               'val_tyre_6',
               'val_tyre_6_wek',
               'val_tyre_6_yer',

               'val_tyre_1_com',
               'val_tyre_2_com',
               'val_tyre_3_com',
               'val_tyre_4_com',
               'val_tyre_5_com',
               'val_tyre_6_com',
               $this->tbl_showroom . '.*'
          );
          return $this->db->select($select)
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'LEFT')
               ->get_where($this->tbl_valuation, array($this->tbl_valuation . '.val_id' => $valId))->row_array();
     }

     function pendingVerification()
     {
          $selArray = array(
               $this->table . '.prd_id',
               $this->table . '.prd_number',
               $this->table . '.prd_regno_prt_1',
               $this->table . '.prd_regno_prt_2',
               $this->table . '.prd_regno_prt_3',
               $this->table . '.prd_regno_prt_4',
               $this->tbl_brand . '.*',
               $this->tbl_model . '.*',
               $this->tbl_variant . '.*'
          );
          $this->db->select($selArray);
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->table . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->table . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->table . '.prd_variant', 'left');
          $this->db->where(array($this->table . '.prd_verified_by' => 0, 'prd_photo_upld_by > ' => 0));
          return $this->db->get($this->table)->result_array();
     }

     function pendingPhotoupload()
     {
          $selArray = array(
               $this->table . '.prd_id',
               $this->table . '.prd_number',
               $this->table . '.prd_regno_prt_1',
               $this->table . '.prd_regno_prt_2',
               $this->table . '.prd_regno_prt_3',
               $this->table . '.prd_regno_prt_4',
               $this->tbl_brand . '.*',
               $this->tbl_model . '.*',
               $this->tbl_variant . '.*'
          );
          $this->db->select($selArray);
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->table . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->table . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->table . '.prd_variant', 'left');
          $this->db->where($this->table . '.prd_photo_upld_by', 0);
          return $this->db->get($this->table)->result_array();
     }

     function upldphotostockvehicle($filter = array())
     {
          $selArray = array(
               $this->table . '.prd_id',
               $this->table . '.prd_number',
               $this->table . '.prd_rd_mini',
               $this->table . '.prd_regno_prt_1',
               $this->table . '.prd_regno_prt_2',
               $this->table . '.prd_regno_prt_3',
               $this->table . '.prd_regno_prt_4',
               $this->tbl_brand . '.*',
               $this->tbl_model . '.*',
               $this->tbl_variant . '.*'
          );
          if (isset($filter['prd_rd_mini']) && ($filter['prd_rd_mini'] == 0 || $filter['prd_rd_mini'] == 1)) {
               $this->db->where(array($this->table . '.prd_rd_mini' => $filter['prd_rd_mini']));
          }
          $this->db->select($selArray);
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->table . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->table . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->table . '.prd_variant', 'left');
          $this->db->where(array($this->table . '.prd_status' => 1));
          //'prd_photo_upld_by' => 0
          return $this->db->get($this->table)->result_array();
     }

     function updatePhotoloaded($prdId)
     {
          if (check_permission('product', 'canuploadprdimage_notify')) {
               $this->db->where('prd_id', $prdId)->update($this->table, array('prd_photo_upld_by' => $this->uid, 'prd_sync' => 0));
               generate_log(array(
                    'log_title' => 'Update product images',
                    'log_desc' => 'Update product images',
                    'log_controller' => 'update-prod-images',
                    'log_action' => 'U',
                    'log_ref_id' => $prdId,
                    'log_added_by' => $this->uid
               ));
          }
          return true;
     }

     function verifyProduct($prdId)
     {
          $this->db->where('prd_id', $prdId)->update($this->table, array('prd_sync' => 0, 'prd_status' => 1, 'prd_verified_by' => $this->uid));
          generate_log(array(
               'log_title' => 'Verify product',
               'log_desc' => 'Verify product',
               'log_controller' => 'verify-prod',
               'log_action' => 'U',
               'log_ref_id' => $prdId,
               'log_added_by' => $this->uid
          ));
          return true;
     }

     function getProdImagesByVehRegNumber($data)
     {
          return $this->db->select('prd_id')->order_by('prd_id', 'DESC')->limit(1)->get_where($this->table, array(
               'UPPER(prd_regno_prt_1)' => strtoupper($data['regNo1']),
               'prd_regno_prt_2' => $data['regNo2'],
               'UPPER(prd_regno_prt_3)' => strtoupper($data['regNo3']),
               'prd_regno_prt_4' => $data['regNo4']
          ))->row_array();
     }

     function updateWalkaround($prdId, $video)
     {
          $this->db->where('prd_id', $prdId)->update($this->table, array('prd_sync' => 0, 'prd_video' => $video));
          generate_log(array(
               'log_title' => 'Update product walkaround',
               'log_desc' => 'Update product walkaround',
               'log_controller' => 'update-prod-walkaround',
               'log_action' => 'U',
               'log_ref_id' => $prdId,
               'log_added_by' => $this->uid
          ));
          return true;
     }
     function getHealthCardValData($valId)
     {
          $select = array(
               'val_id',
               'val_fuel',
               'val_brand',
               'val_model',
               'val_variant',
               'val_stock_num',
               'val_km',
               'val_prt_1',
               'val_prt_2',
               'val_prt_3',
               'val_prt_4',
               'val_no_of_owner',
               'val_milage',
               'val_reg_date',
               'val_insurance',
               'val_insurance_comp_date',
               'val_insurance_comp_idv',
               'val_veh_type',
               'val_arai_tstd_fuel_efncy',
               'val_torque',
               'val_power',
               'val_transmission',
               'val_drive_train',
               'val_wrnty_type',
               'val_service_type',
               'val_lst_service_place',
               'val_minif_month',
               'val_minif_year',
               'val_new_vehicle_price',
               'val_last_service',
               'val_last_service_km',
               'val_wrnty_nxt_ser_date',
               'val_wrnty_nxt_ser_km',
               'val_wrnty_type',
               'val_wrnty_validity',
               'val_color',
               'val_tyre_1',
               'val_tyre_1_wek',
               'val_tyre_1_yer',
               'val_tyre_2',
               'val_tyre_2_wek',
               'val_tyre_2_yer',
               'val_tyre_3',
               'val_tyre_3_wek',
               'val_tyre_3_yer',
               'val_tyre_4',
               'val_tyre_4_wek',
               'val_tyre_4_yer',
               'val_tyre_5',
               'val_tyre_5_wek',
               'val_tyre_5_yer',
               'val_tyre_6',
               'val_tyre_6_wek',
               'val_tyre_6_yer',
               'val_tyre_1_com',
               'val_tyre_2_com',
               'val_tyre_3_com',
               'val_tyre_4_com',
               'val_tyre_5_com',
               'val_tyre_6_com',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_vehicle_colors . '.vc_color',
          );

          $this->db->select($select);
          $this->db->from($this->tbl_valuation);
          $this->db->where(array($this->tbl_valuation . '.val_id' => $valId));
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left');
          $this->db->join($this->tbl_vehicle_colors, 'vc_id = ' . $this->tbl_valuation . '.val_color', 'left');

          return $this->db->get()->row_array();
     }
     function getValDetails()
     {
          // $this->db->select('val_id, val_stock_num,val_veh_no, val_prt_1, val_prt_2, val_prt_3, val_prt_4');
          $this->db->select('val_id, val_stock_num,val_veh_no');
          $this->db->from($this->tbl_valuation);
          $this->db->group_by('val_veh_no');
          $this->db->order_by('val_id', 'desc');


          $query = $this->db->get();
          $result = $query->result_array();

          return $result;
     }

     function getTyreCompanay($tyc_id = '')
     {
          $this->db->where($this->tbl_tyres_comp . '.tyc_id', $tyc_id);
          $res = $this->db->get($this->tbl_tyres_comp)->row_array();
          return $res['tyc_name'];
     }
     function refurbDetails($val_id)
     {
          $EvaluationVehicle['upgradeDetails'] = $this->db->get_where($this->tbl_valuation_upgrade_details, array('upgrd_master_id' => $val_id))->result_array();
          return $EvaluationVehicle;
     }
     public function addNewHealthCard($datas)
     {
          $datas['master']['hc_prd_id'] = $datas['hc_prd_id'];
          $datas['master']['hc_val_id'] = $datas['hc_val_id'];
          $datas['master']['hc_brd_id'] = $datas['hc_brd_id'];
          $datas['master']['hc_mod_id'] = $datas['hc_mod_id'];
          $datas['master']['hc_var_id'] = $datas['hc_var_id'];
          $datas['master']['hc_veh_type'] = $datas['hc_veh_type'];
          $datas['master']['hc_minif_month'] = $datas['hc_minif_month'];
          $datas['master']['hc_minif_year'] = $datas['hc_minif_year'];
          $datas['master']['hc_prd_color'] = $datas['hc_prd_color'];
          $datas['master']['hc_prd_fual'] = $datas['hc_prd_fual'];
          $datas['master']['hc_reg_date'] = (isset($datas['hc_reg_date']) && !empty($datas['hc_reg_date'])) ? date('Y-m-d', strtotime($datas['hc_reg_date'])) : NULL;
          $datas['master']['hc_arai_tstd_fuel_efncy'] = $datas['hc_arai_tstd_fuel_efncy'];
          $datas['master']['hc_on_road_price'] = $datas['hc_on_road_price'];
          $datas['master']['hc_rd_price'] = $datas['hc_rd_price'];
          $datas['master']['hc_eng_cc'] = $datas['hc_eng_cc'];
          $datas['master']['hc_power'] = $datas['hc_power'];
          $datas['master']['hc_torque'] = $datas['hc_torque'];
          $datas['master']['hc_transmission'] = $datas['hc_transmission'];
          $datas['master']['hc_drive_train'] = $datas['hc_drive_train'];
          $datas['master']['hc_insurance'] = $datas['hc_insurance'];
          $datas['master']['hc_pucc_valid']  = (isset($datas['hc_pucc_valid']) && !empty($datas['hc_pucc_valid'])) ? date('Y-m-d', strtotime($datas['hc_pucc_valid'])) : NULL;
          $datas['master']['hc_prd_insurance_idv'] = $datas['hc_prd_insurance_idv'];
          $datas['master']['hc_prd_insurance_validity'] = (isset($datas['hc_prd_insurance_validity']) && !empty($datas['hc_prd_insurance_validity'])) ? date('Y-m-d', strtotime($datas['hc_prd_insurance_validity'])) : NULL;
          $datas['master']['hc_wrnty_validity'] = (isset($datas['hc_wrnty_validity']) && !empty($datas['hc_wrnty_validity'])) ? date('Y-m-d', strtotime($datas['hc_wrnty_validity'])) : NULL;
          $datas['master']['hc_wrnty_km'] = $datas['hc_wrnty_km'];
          $datas['master']['hc_wrnty_type'] = $datas['hc_wrnty_type'];
          $datas['master']['hc_wrnty_nxt_ser_date'] = (isset($datas['hc_wrnty_nxt_ser_date']) && !empty($datas['hc_wrnty_nxt_ser_date'])) ? date('Y-m-d', strtotime($datas['hc_wrnty_nxt_ser_date'])) : NULL;
          $datas['master']['hc_wrnty_nxt_ser_km'] = !empty($datas['hc_wrnty_nxt_ser_km']) ? $datas['hc_wrnty_nxt_ser_km'] : 0;
          $datas['master']['hc_service_type'] = !empty($datas['hc_service_type']) ? $datas['hc_service_type'] : 0;
          $datas['master']['hc_last_service'] = (isset($datas['hc_last_service']) && !empty($datas['hc_last_service'])) ? date('Y-m-d', strtotime($datas['hc_last_service'])) : NULL;
          $datas['master']['hc_last_service_km'] = $datas['hc_last_service_km'];
          $datas['master']['hc_lst_service_place'] = $datas['hc_lst_service_place'];
          $datas['master']['hc_next_serv_date'] = (isset($datas['hc_next_serv_date']) && !empty($datas['hc_next_serv_date'])) ? date('Y-m-d', strtotime($datas['hc_next_serv_date'])) : NULL;
          $datas['master']['hc_next_serv_km'] = !empty($datas['hc_next_serv_km']) ? $datas['hc_next_serv_km'] : 0;
          $datas['master']['hc_additonal_serv_info'] = $datas['hc_additonal_serv_info'];
          $datas['master']['hc_calim_or_replace'] = $datas['hc_calim_or_replace'];
          $datas['master']['hc_km'] = (isset($datas['hc_km']) && !empty($datas['hc_km'])) ? $datas['hc_km'] : 0;
          $datas['master']['hc_no_of_owner'] = $datas['hc_no_of_owner'];
          $datas['master']['hc_added_by'] =  $this->uid;
          $datas['master']['hc_disclaimer'] =  (isset($datas['disclaimer']) && !empty($datas['disclaimer'])) ? $datas['disclaimer'] : '';

          if ($this->db->insert($this->tbl_health_card, array_filter($datas['master']))) {
               $lastId = $this->db->insert_id();
               $datas['tyre']['hct_master_id '] =  $lastId; //tbl_tyre_and_break_pad

               // Tyre 2 values
               $datas['tyre']['hct_tyre_2_com'] = $datas['valuation']['val_tyre_2_com'];
               $datas['tyre']['hct_tyre_2'] = $datas['valuation']['val_tyre_2']; //b m s
               $datas['tyre']['hct_tyre_2_yer'] = $datas['valuation']['val_tyre_2_yer'];

               // Tyre 1 values
               $datas['tyre']['hct_tyre_1_com'] = $datas['valuation']['val_tyre_1_com'];
               $datas['tyre']['hct_tyre_1'] = $datas['valuation']['val_tyre_1'];
               $datas['tyre']['hct_tyre_1_yer'] = $datas['valuation']['val_tyre_1_yer'];

               // Tyre 4 values
               $datas['tyre']['hct_tyre_4_com'] = $datas['valuation']['val_tyre_4_com'];
               $datas['tyre']['hct_tyre_4'] = $datas['valuation']['val_tyre_4'];
               $datas['tyre']['hct_tyre_4_yer'] = $datas['valuation']['val_tyre_4_yer'];

               // Tyre 3 values
               $datas['tyre']['hct_tyre_3_com'] = $datas['valuation']['val_tyre_3_com'];
               $datas['tyre']['hct_tyre_3'] = $datas['valuation']['val_tyre_3'];
               $datas['tyre']['hct_tyre_3_yer'] = $datas['valuation']['val_tyre_3_yer'];

               //brkpd
               $datas['tyre']['hct_bp_fl'] = $datas['valuation']['val_bp_fl'];
               $datas['tyre']['hct_bp_fr'] = $datas['valuation']['val_bp_fr'];
               $datas['tyre']['hct_bp_rl'] = $datas['valuation']['val_bp_rl'];
               $datas['tyre']['hct_bp_rr'] = $datas['valuation']['val_bp_rr'];


               $this->db->insert($this->tbl_health_card_tyre_and_break_pad, $datas['tyre']);

               $datas['battery']['hcb_master_id '] = $lastId;
               $datas['battery']['hcb_battery_brand'] = $datas['valuation']['val_battery_make'];
               $datas['battery']['hcb_warranty_upto']  = (isset($datas['valuation']['val_battery_warranty']) && !empty($datas['valuation']['val_battery_warranty'])) ? date('Y-m-d', strtotime($datas['valuation']['val_battery_warranty'])) : NULL;
               $datas['battery']['hcb_battery_year'] = !empty($datas['valuation']['hcb_battery_year']) ? $datas['valuation']['hcb_battery_year'] : 0;
               $datas['battery']['hcb_current_capacity'] =  (isset($datas['valuation']['hcb_current_capacity']) && !empty($datas['valuation']['hcb_current_capacity'])) ? $datas['valuation']['hcb_current_capacity'] : 0;
               $datas['battery']['hcb_created_at'] = date('Y-m-d H:i:s');
               $this->db->insert($this->tbl_health_card_battery, $datas['battery']);


               // if (isset($datas['upgradedetails']) && !empty($datas['upgradedetails'])) {
               //      $this->upgradeDetails($_POST['upgradedetails'], $lastId);
               // }
               //if($this->uid==100){

               if (isset($datas['upgradedetails']) && !empty($datas['upgradedetails'])) {
                    // debug($datas['upgradedetails']);
                    $this->upgradeDetails($datas['upgradedetails'], $lastId);
               }
               // exit;
               // }

               return true;
          } else {
               return false; // Return false if the insertion fails
          }
     }

     // function upgradeDetails($data, $lastId)
     // {
     //      if (!empty($data)) {
     //           $count = count($data['upgrd_key']);
     //           for ($i = 0; $i < $count; $i++) {
     //                $upgrKey = (isset($data['upgrd_key'][$i]) && !empty($data['upgrd_key'][$i])) ? $data['upgrd_key'][$i] : 0;
     //                $upgrVal = (isset($data['upgrd_value'][$i]) && !empty($data['upgrd_value'][$i])) ? $data['upgrd_value'][$i] : 0;
     //                $this->db->insert($this->tbl_health_card_refurb_details, array(
     //                     'hcr_master_id ' => $lastId, 'hcr_key' => $upgrKey, 'hcr_value' => $upgrVal,
     //                     'hcr_created_at' => date('Y-m-d H:i:s')
     //                ));
     //           }
     //      }
     // }

     function upgradeDetails($data, $lastId)
     {
          if (!empty($data)) {
               $count = count($data['rf_id']);
               for ($i = 0; $i < $count; $i++) {
                    $upgrKey = (isset($data['upgrd_key'][$i]) && !empty($data['upgrd_key'][$i])) ? $data['upgrd_key'][$i] : 0;
                    $rf_id = (isset($data['rf_id'][$i]) && !empty($data['rf_id'][$i])) ? $data['rf_id'][$i] : 0;
                    $this->db->insert($this->tbl_health_card_refurb_details, array(
                         'hcr_master_id ' => $lastId,
                         'hcr_key' => $upgrKey,
                         'hcr_rf_id' => $rf_id,
                         'hcr_created_at' => date('Y-m-d H:i:s')
                    ));
               }
          }
     }

     function getHealthCard($prd_id)
     {

          $selectArray = array(
               $this->tbl_health_card . '.hc_id',
               $this->tbl_health_card . '.hc_prd_id',
               $this->tbl_health_card . '.hc_val_id',
               $this->tbl_health_card . '.hc_km',
               $this->tbl_health_card . '.hc_veh_type',
               $this->tbl_health_card . '.hc_minif_month',
               $this->tbl_health_card . '.hc_minif_year',
               $this->tbl_health_card . '.hc_prd_fual',
               $this->tbl_health_card . '.hc_reg_date',
               $this->tbl_health_card . '.hc_arai_tstd_fuel_efncy',
               $this->tbl_health_card . '.hc_on_road_price',
               $this->tbl_health_card . '.hc_rd_price',
               $this->tbl_health_card . '.hc_eng_cc',
               $this->tbl_health_card . '.hc_power',
               $this->tbl_health_card . '.hc_torque',
               $this->tbl_health_card . '.hc_transmission',
               $this->tbl_health_card . '.hc_drive_train',
               $this->tbl_health_card . '.hc_insurance',
               $this->tbl_health_card . '.hc_pucc_valid',
               $this->tbl_health_card . '.hc_prd_insurance_idv',
               $this->tbl_health_card . '.hc_prd_insurance_validity',
               $this->tbl_health_card . '.hc_wrnty_validity',
               $this->tbl_health_card . '.hc_wrnty_km',
               $this->tbl_health_card . '.hc_wrnty_type',
               $this->tbl_health_card . '.hc_wrnty_nxt_ser_date',
               $this->tbl_health_card . '.hc_wrnty_nxt_ser_km',
               $this->tbl_health_card . '.hc_service_type',
               $this->tbl_health_card . '.hc_last_service',
               $this->tbl_health_card . '.hc_last_service_km',
               $this->tbl_health_card . '.hc_lst_service_place',
               $this->tbl_health_card . '.hc_next_serv_date',
               $this->tbl_health_card . '.hc_next_serv_km',
               $this->tbl_health_card . '.hc_additonal_serv_info',
               $this->tbl_health_card . '.hc_calim_or_replace',
               $this->tbl_health_card . '.hc_km',
               $this->tbl_vehicle_colors . '.vc_color',
               $this->tbl_health_card_battery . '.hcb_battery_brand',
               $this->tbl_health_card_battery . '.hcb_warranty_upto',
               $this->tbl_health_card_battery . '.hcb_battery_year',
               $this->tbl_health_card_battery . '.hcb_current_capacity',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_fl',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_fr',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_rl',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_rr',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name'
          );
          $this->db->select($selectArray);
          // $this->db->select($this->tbl_health_card.'.*');

          $this->db->join($this->tbl_vehicle_colors, 'vc_id = hc_prd_color', 'left');
          $this->db->join($this->tbl_health_card_battery, $this->tbl_health_card_battery . '.hcb_master_id = ' . $this->tbl_health_card . '.hc_id', 'left');
          $this->db->join($this->tbl_health_card_tyre_and_break_pad, $this->tbl_health_card_tyre_and_break_pad . '.hct_master_id  = ' . $this->tbl_health_card . '.hc_id', 'left');
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_health_card . '.hc_brd_id', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_health_card . '.hc_mod_id', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_health_card . '.hc_var_id', 'left');

          $this->db->where($this->tbl_health_card . '.hc_prd_id', $prd_id);

          $data['main'] = $this->db->get($this->tbl_health_card)->row_array();
          // $data['main'] = $this->db->get($this->tbl_health_card)->result_array();
          //debug($data['main']);
          // $this->updateHealthCard(1);
          //  $this->deleteHealthCard(6);


          $data['vehicle'] = $this->getVeh($prd_id);
          $data['rfDetails'] = $this->getRefurbs($data['main']['hc_id']);
          //debug($data);
          return $data;
     }

     function getRefurbs($master_id)
     {
          $this->db->select('hcr_master_id,hcr_key, hcr_rf_id')
               ->from($this->tbl_health_card_refurb_details)
               ->where('hcr_master_id', $master_id);

          return $this->db->get()->result_array();
     }

     function getVeh($id)
     { //dnt nd
          $this->load->model('brand_model');
          $this->db->select(
               TABLE_PREFIX_RANA . 'brand.brd_title, ' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
          );
          $this->db->join(TABLE_PREFIX_RANA . 'brand', TABLE_PREFIX_RANA . 'brand.brd_id = ' . $this->table . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->table . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->table . '.prd_variant', 'left');

          $this->db->where($this->table . '.prd_id', $id);
          $products = $this->db->get($this->table)->row_array();

          return $products;
     }

     public function deleteHealthCard($hc_id)
     {
          $this->db->where('hc_id', $hc_id);
          $result = $this->db->delete($this->tbl_health_card);
          if ($result) {

               $this->db->where('hct_master_id', $hc_id);
               $this->db->delete($this->tbl_health_card_tyre_and_break_pad);

               $this->db->where('hcb_master_id', $hc_id);
               $this->db->delete($this->tbl_health_card_battery);

               $this->db->where('hcr_master_id', $hc_id);
               $this->db->delete($this->tbl_health_card_refurb_details);
          }

          return $result;
     }
     public function updateHealthCardTest($hc_id)
     {
          $data = array('hc_id' => 7);

          $this->db->where('hc_id', 5);
          $result = $this->db->update($this->tbl_health_card, $data);

          return $result; // This will be true if the update operation was successful, false otherwise
     }

     function getPrdIdByValId($val_id)
     {
          // $this->db->select('*')
          //          ->from($this->table);


          // return $this->db->get()->result_array();


          $data = $this->db->select('prd_id')
               ->get_where($this->table, ['prd_valuation_id' => $val_id])
               ->row_array();
          return $data['prd_id'];
     }


     //  function isExistByvalId($val_id) {
     //      $this->db->where('hc_val_id', $val_id);
     //      $query = $this->db->get('cpnl_health_card');
     //      if ($query->num_rows() > 0) {
     //           return true;

     //      }
     //      return false;
     //  }


     function getHealthCardByValId($val_id)
     {

          $selectArray = array(
               //  '*',
               $this->tbl_health_card . '.hc_id',
               $this->tbl_health_card . '.hc_prd_id',
               $this->tbl_health_card . '.hc_val_id',
               $this->tbl_health_card . '.hc_km',
               $this->tbl_health_card . '.hc_veh_type',
               $this->tbl_health_card . '.hc_minif_month',
               $this->tbl_health_card . '.hc_minif_year',
               $this->tbl_health_card . '.hc_prd_fual',
               $this->tbl_health_card . '.hc_reg_date',
               $this->tbl_health_card . '.hc_arai_tstd_fuel_efncy',
               $this->tbl_health_card . '.hc_on_road_price',
               $this->tbl_health_card . '.hc_rd_price',
               $this->tbl_health_card . '.hc_eng_cc',
               $this->tbl_health_card . '.hc_power',
               $this->tbl_health_card . '.hc_torque',
               $this->tbl_health_card . '.hc_transmission',
               $this->tbl_health_card . '.hc_drive_train',
               $this->tbl_health_card . '.hc_insurance',

               $this->tbl_health_card . '.hc_pucc_valid',
               $this->tbl_health_card . '.hc_prd_insurance_idv',
               $this->tbl_health_card . '.hc_prd_insurance_validity',
               $this->tbl_health_card . '.hc_wrnty_validity',

               $this->tbl_health_card . '.hc_wrnty_km',
               $this->tbl_health_card . '.hc_wrnty_type',
               $this->tbl_health_card . '.hc_wrnty_nxt_ser_date',
               $this->tbl_health_card . '.hc_wrnty_nxt_ser_km',
               $this->tbl_health_card . '.hc_service_type',
               $this->tbl_health_card . '.hc_last_service',

               $this->tbl_health_card . '.hc_last_service_km',
               $this->tbl_health_card . '.hc_lst_service_place',
               $this->tbl_health_card . '.hc_next_serv_date',
               $this->tbl_health_card . '.hc_next_serv_km',


               $this->tbl_health_card . '.hc_additonal_serv_info',
               $this->tbl_health_card . '.hc_calim_or_replace',
               $this->tbl_health_card . '.hc_km',
               $this->tbl_health_card . '.hc_no_of_owner',
               $this->tbl_health_card . '.hc_disclaimer',

               $this->tbl_vehicle_colors . '.vc_color',

               $this->tbl_health_card_battery . '.hcb_battery_brand',
               $this->tbl_health_card_battery . '.hcb_warranty_upto',
               $this->tbl_health_card_battery . '.hcb_battery_year',
               $this->tbl_health_card_battery . '.hcb_current_capacity',

               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_fl',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2',

               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_fr',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_rl',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4',

               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_rr',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               // $this->tbl_model . '.mod_id',
               $this->tbl_variant . '.var_variant_name',
               // $this->tbl_variant . '.var_id',
          );
          $this->db->select($selectArray);
          // $this->db->select($this->tbl_health_card.'.*');

          $this->db->join($this->tbl_vehicle_colors, 'vc_id = hc_prd_color', 'left');
          $this->db->join($this->tbl_health_card_battery, $this->tbl_health_card_battery . '.hcb_master_id = ' . $this->tbl_health_card . '.hc_id', 'left');
          $this->db->join($this->tbl_health_card_tyre_and_break_pad, $this->tbl_health_card_tyre_and_break_pad . '.hct_master_id  = ' . $this->tbl_health_card . '.hc_id', 'left');

          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_health_card . '.hc_brd_id', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_health_card . '.hc_mod_id', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_health_card . '.hc_var_id', 'left');

          $this->db->where($this->tbl_health_card . '.hc_val_id', $val_id);

          $data['main'] = $this->db->get($this->tbl_health_card)->row_array();
          // $data['main'] = $this->db->get($this->tbl_health_card)->result_array();
          //debug($data['main']);
          // $this->updateHealthCard(1);
          //  $this->deleteHealthCard(6);


          //$data['vehicle'] = $this->getVeh($prd_id);
          $data['rfDetails'] = $this->getRefurbs($data['main']['hc_id']);
          //debug($data);
          return $data;
     }

     function getRfDtlsForHealthCard($evalId = '')
     {
          if ($evalId) {
               $this->db->select('upgrd_id,upgrd_key,upgrd_value,upgrd_refurb_actual_cost,actual_job_description,upgrd_refurb_remarks')
                    ->where($this->tbl_valuation_upgrade_details . '.upgrd_master_id', $evalId);
               $data = $this->db->get($this->tbl_valuation_upgrade_details)->result();
               return $data;
          }
     }

     function getHealthCardByHcId($hc_id)
     {

          $selectArray = array(
               //'*',
               $this->tbl_health_card . '.hc_id',
               $this->tbl_health_card . '.hc_prd_id',
               $this->tbl_health_card . '.hc_val_id',
               $this->tbl_health_card . '.hc_km',
               $this->tbl_health_card . '.hc_veh_type',
               $this->tbl_health_card . '.hc_minif_month',
               $this->tbl_health_card . '.hc_minif_year',
               $this->tbl_health_card . '.hc_prd_fual',
               $this->tbl_health_card . '.hc_prd_color',
               $this->tbl_health_card . '.hc_reg_date',
               $this->tbl_health_card . '.hc_arai_tstd_fuel_efncy',
               $this->tbl_health_card . '.hc_on_road_price',
               $this->tbl_health_card . '.hc_rd_price',
               $this->tbl_health_card . '.hc_eng_cc',
               $this->tbl_health_card . '.hc_power',
               $this->tbl_health_card . '.hc_torque',
               $this->tbl_health_card . '.hc_transmission',
               $this->tbl_health_card . '.hc_drive_train',
               $this->tbl_health_card . '.hc_insurance',

               $this->tbl_health_card . '.hc_pucc_valid',
               $this->tbl_health_card . '.hc_prd_insurance_idv',
               $this->tbl_health_card . '.hc_prd_insurance_validity',
               $this->tbl_health_card . '.hc_wrnty_validity',
               $this->tbl_health_card . '.hc_wrnty_km',
               $this->tbl_health_card . '.hc_wrnty_type',
               $this->tbl_health_card . '.hc_wrnty_nxt_ser_date',
               $this->tbl_health_card . '.hc_wrnty_nxt_ser_km',
               $this->tbl_health_card . '.hc_service_type',
               $this->tbl_health_card . '.hc_last_service',

               $this->tbl_health_card . '.hc_last_service_km',
               $this->tbl_health_card . '.hc_lst_service_place',
               $this->tbl_health_card . '.hc_next_serv_date',
               $this->tbl_health_card . '.hc_next_serv_km',

               $this->tbl_health_card . '.hc_additonal_serv_info',
               $this->tbl_health_card . '.hc_calim_or_replace',
               $this->tbl_health_card . '.hc_km',

               $this->tbl_health_card . '.hc_brd_id',
               $this->tbl_health_card . '.hc_mod_id',
               $this->tbl_health_card . '.hc_var_id',

               $this->tbl_health_card . '.hc_no_of_owner',
               $this->tbl_health_card . '.hc_disclaimer',

               $this->tbl_vehicle_colors . '.vc_color',

               $this->tbl_health_card_battery . '.hcb_battery_brand',
               $this->tbl_health_card_battery . '.hcb_warranty_upto',
               $this->tbl_health_card_battery . '.hcb_battery_year',
               $this->tbl_health_card_battery . '.hcb_current_capacity',

               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_1_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_fl',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2',

               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_2_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_fr',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_3_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_rl',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4',

               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4_com',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_tyre_4_yer',
               $this->tbl_health_card_tyre_and_break_pad . '.hct_bp_rr',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               // $this->tbl_model . '.mod_id',
               $this->tbl_variant . '.var_variant_name',
               // $this->tbl_variant . '.var_id',
          );
          $this->db->select($selectArray);
          // $this->db->select($this->tbl_health_card.'.*');

          $this->db->join($this->tbl_vehicle_colors, 'vc_id = hc_prd_color', 'left');
          $this->db->join($this->tbl_health_card_battery, $this->tbl_health_card_battery . '.hcb_master_id = ' . $this->tbl_health_card . '.hc_id', 'left');
          $this->db->join($this->tbl_health_card_tyre_and_break_pad, $this->tbl_health_card_tyre_and_break_pad . '.hct_master_id  = ' . $this->tbl_health_card . '.hc_id', 'left');

          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_health_card . '.hc_brd_id', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_health_card . '.hc_mod_id', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_health_card . '.hc_var_id', 'left');

          $this->db->where($this->tbl_health_card . '.hc_id', $hc_id);

          $data['main'] = $this->db->get($this->tbl_health_card)->row_array();
          // $data['main'] = $this->db->get($this->tbl_health_card)->result_array();
          //debug($data['main']);
          // $this->updateHealthCard(1);
          //  $this->deleteHealthCard(6);


          //$data['vehicle'] = $this->getVeh($prd_id);
          $data['rfDetails'] = $this->getRefurbs($data['main']['hc_id']);
          //debug($data);
          return $data;
     }


     //update Hc
     public function updateHealthCard($datas)
     {
          $health_card_id = $datas['hc_id'];
          unset($data['hc_prd_id']);
          $datas['master']['hc_prd_id'] = $datas['hc_prd_id'];
          $datas['master']['hc_brd_id'] = $datas['hc_brd_id'];
          $datas['master']['hc_mod_id'] = $datas['hc_mod_id'];
          $datas['master']['hc_var_id'] = $datas['hc_var_id'];
          $datas['master']['hc_veh_type'] = $datas['hc_veh_type'];
          $datas['master']['hc_minif_month'] = $datas['hc_minif_month'];
          $datas['master']['hc_minif_year'] = $datas['hc_minif_year'];
          $datas['master']['hc_prd_color'] = $datas['hc_prd_color'];
          $datas['master']['hc_prd_fual'] = $datas['hc_prd_fual'];
          $datas['master']['hc_reg_date'] = (isset($datas['hc_reg_date']) && !empty($datas['hc_reg_date'])) ? date('Y-m-d', strtotime($datas['hc_reg_date'])) : NULL;
          $datas['master']['hc_arai_tstd_fuel_efncy'] = $datas['hc_arai_tstd_fuel_efncy'];
          $datas['master']['hc_on_road_price'] = $datas['hc_on_road_price'];
          $datas['master']['hc_rd_price'] = $datas['hc_rd_price'];
          $datas['master']['hc_eng_cc'] = $datas['hc_eng_cc'];
          $datas['master']['hc_power'] = $datas['hc_power'];
          $datas['master']['hc_torque'] = $datas['hc_torque'];
          $datas['master']['hc_transmission'] = $datas['hc_transmission'];
          $datas['master']['hc_drive_train'] = $datas['hc_drive_train'];
          $datas['master']['hc_insurance'] = $datas['hc_insurance'];
          $datas['master']['hc_pucc_valid']  = (isset($datas['hc_pucc_valid']) && !empty($datas['hc_pucc_valid'])) ? date('Y-m-d', strtotime($datas['hc_pucc_valid'])) : NULL;
          $datas['master']['hc_prd_insurance_idv'] = $datas['hc_prd_insurance_idv'];
          $datas['master']['hc_prd_insurance_validity'] = (isset($datas['hc_prd_insurance_validity']) && !empty($datas['hc_prd_insurance_validity'])) ? date('Y-m-d', strtotime($datas['hc_prd_insurance_validity'])) : NULL;
          $datas['master']['hc_wrnty_validity'] = (isset($datas['hc_wrnty_validity']) && !empty($datas['hc_wrnty_validity'])) ? date('Y-m-d', strtotime($datas['hc_wrnty_validity'])) : NULL;
          $datas['master']['hc_wrnty_km'] = $datas['hc_wrnty_km'];
          $datas['master']['hc_wrnty_type'] = $datas['hc_wrnty_type'];
          $datas['master']['hc_wrnty_nxt_ser_date'] = (isset($datas['hc_wrnty_nxt_ser_date']) && !empty($datas['hc_wrnty_nxt_ser_date'])) ? date('Y-m-d', strtotime($datas['hc_wrnty_nxt_ser_date'])) : NULL;
          $datas['master']['hc_wrnty_nxt_ser_km'] = !empty($datas['hc_wrnty_nxt_ser_km']) ? $datas['hc_wrnty_nxt_ser_km'] : 0;
          $datas['master']['hc_service_type'] = !empty($datas['hc_service_type']) ? $datas['hc_service_type'] : 0;
          $datas['master']['hc_last_service'] = (isset($datas['hc_last_service']) && !empty($datas['hc_last_service'])) ? date('Y-m-d', strtotime($datas['hc_last_service'])) : NULL;
          $datas['master']['hc_last_service_km'] = $datas['hc_last_service_km'];
          $datas['master']['hc_lst_service_place'] = $datas['hc_lst_service_place'];
          $datas['master']['hc_next_serv_date'] = (isset($datas['hc_next_serv_date']) && !empty($datas['hc_next_serv_date'])) ? date('Y-m-d', strtotime($datas['hc_next_serv_date'])) : NULL;
          $datas['master']['hc_next_serv_km'] = !empty($datas['hc_next_serv_km']) ? $datas['hc_next_serv_km'] : 0;
          $datas['master']['hc_additonal_serv_info'] = $datas['hc_additonal_serv_info'];
          $datas['master']['hc_calim_or_replace'] = $datas['hc_calim_or_replace'];
          $datas['master']['hc_km'] = (isset($datas['hc_km']) && !empty($datas['hc_km'])) ? $datas['hc_km'] : 0;
          $datas['master']['hc_no_of_owner'] = $datas['hc_no_of_owner'];
          $datas['master']['hc_added_by'] =  $this->uid;
          $datas['master']['hc_disclaimer'] =  (isset($datas['disclaimer']) && !empty($datas['disclaimer'])) ? $datas['disclaimer'] : '';
          // Perform the update operation

          $this->db->where('hc_id', $health_card_id);
          if ($this->db->update($this->tbl_health_card, $datas['master'])) {


               // Tyre 2 values
               $datas['tyre']['hct_tyre_2_com'] = $datas['valuation']['val_tyre_2_com'];
               $datas['tyre']['hct_tyre_2'] = $datas['valuation']['val_tyre_2']; //b m s
               $datas['tyre']['hct_tyre_2_yer'] = $datas['valuation']['val_tyre_2_yer'];

               // Tyre 1 values
               $datas['tyre']['hct_tyre_1_com'] = $datas['valuation']['val_tyre_1_com'];
               $datas['tyre']['hct_tyre_1'] = $datas['valuation']['val_tyre_1'];
               $datas['tyre']['hct_tyre_1_yer'] = $datas['valuation']['val_tyre_1_yer'];

               // Tyre 4 values
               $datas['tyre']['hct_tyre_4_com'] = $datas['valuation']['val_tyre_4_com'];
               $datas['tyre']['hct_tyre_4'] = $datas['valuation']['val_tyre_4'];
               $datas['tyre']['hct_tyre_4_yer'] = $datas['valuation']['val_tyre_4_yer'];

               // Tyre 3 values
               $datas['tyre']['hct_tyre_3_com'] = $datas['valuation']['val_tyre_3_com'];
               $datas['tyre']['hct_tyre_3'] = $datas['valuation']['val_tyre_3'];
               $datas['tyre']['hct_tyre_3_yer'] = $datas['valuation']['val_tyre_3_yer'];

               //brkpd
               $datas['tyre']['hct_bp_fl'] = $datas['valuation']['val_bp_fl'];
               $datas['tyre']['hct_bp_fr'] = $datas['valuation']['val_bp_fr'];
               $datas['tyre']['hct_bp_rl'] = $datas['valuation']['val_bp_rl'];
               $datas['tyre']['hct_bp_rr'] = $datas['valuation']['val_bp_rr'];

               $this->db->where('hct_master_id', $health_card_id);
               $this->db->update($this->tbl_health_card_tyre_and_break_pad, $datas['tyre']);



               $datas['battery']['hcb_battery_brand'] = $datas['valuation']['val_battery_make'];
               $datas['battery']['hcb_warranty_upto']  = (isset($datas['valuation']['val_battery_warranty']) && !empty($datas['valuation']['val_battery_warranty'])) ? date('Y-m-d', strtotime($datas['valuation']['val_battery_warranty'])) : NULL;
               $datas['battery']['hcb_battery_year'] = $datas['valuation']['hcb_battery_year'];
               $datas['battery']['hcb_current_capacity'] =  (isset($datas['valuation']['val_current_capacity']) && !empty($datas['valuation']['val_current_capacity'])) ? $datas['valuation']['val_current_capacity'] : 0;
               $datas['battery']['hcb_created_at'] = date('Y-m-d H:i:s');
               $this->db->where('hcb_master_id', $health_card_id);
               $this->db->update($this->tbl_health_card_battery, $datas['battery']);




               // if (isset($datas['upgradedetails']) && !empty($datas['upgradedetails'])) {
               //      $this->upgradeDetails($_POST['upgradedetails'], $lastId);
               // }
               //if($this->uid==100){

               if (isset($datas['upgradedetails']) && !empty($datas['upgradedetails'])) {
                    $this->deleteRefurb($health_card_id);
                    // debug($datas['upgradedetails']);
                    $this->upgradeDetails($datas['upgradedetails'], $health_card_id);
               }
               // exit;
               // }

               return true;
          } else {
               return false; // Return false if the insertion fails
          }
     }


     public function deleteRefurb($hc_id)
     { //for updation

          if ($hc_id) {


               $this->db->where('hcr_master_id', $hc_id);
               $this->db->delete($this->tbl_health_card_refurb_details);
          }

          return $result;
     }
}