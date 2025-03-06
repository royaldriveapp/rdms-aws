<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ihits_api_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl_users = TABLE_PREFIX . 'users';
        $this->tbl_groups = TABLE_PREFIX . 'groups';
        $this->tbl_api_log = TABLE_PREFIX . 'api_log';
        $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';

        define('IHITS_ROOT', "https://faapi.royaldrive.in/");
        define('IHITS_GENTOKEN', IHITS_ROOT . "api/Users/GetTokenGenerated");
        define('IHITS_SALES', IHITS_ROOT . "api/Sales/SaveSales");
        define('IHITS_SALES_TOKEN', IHITS_ROOT . "api/SalesToken/SaveSalesToken");
        define('IHITS_SOURCE', IHITS_ROOT . "api/Source/SaveSource");
        define('IHITS_SOURCE_TOKEN', IHITS_ROOT . "api/PurchaseToken/SavePurchaseToken");
        define('IHITS_EXPENSE', IHITS_ROOT . "api/Expense/SaveExpense");
    }

    function ihitsGetToken()
    {
        $apiData = array("userName" => "abc@123", "password" => "pass@123");
        $data_string = json_encode($apiData);
        $ch = curl_init(IHITS_GENTOKEN);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
            CURLOPT_RETURNTRANSFER => true
        ));

        $result = curl_exec($ch);
        $tokenRes = $result;
        curl_close($ch);
        $r = (array) json_decode($result);
        if (isset($r['data'])) {
            $Token = (array) json_decode($r['data']);
            return $Token['Token'];
        } else {
            return false;
        }
    }

    function ihitsSales($salesApi, $enqId = 0, $bookingId = 0, $val = 0)
    {
        //echo json_encode($salesApi);
        $token = $this->ihitsGetToken();
        $responce = '';
        if (!empty($token)) {
            $sales = curl_init(IHITS_SALES);
            curl_setopt_array($sales, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($salesApi),
                //    CURLOPT_HEADER => true,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($salesApi))),
                CURLOPT_RETURNTRANSFER => true
            ));
            $slsresult = curl_exec($sales);
            curl_close($sales);
            $responce = serialize(json_decode($slsresult));
        } else {
            return false;
        }
        $otherDetails['aplg_enq_id'] = $enqId;
        $otherDetails['aplg_booking_id'] = $bookingId;
        $otherDetails['aplg_valuation_id'] = $val;
        $otherDetails['aplg_bill_no'] = isset($salesApi['stockID']) ? $salesApi['stockID'] : '';
        $otherDetails['aplg_net_total'] = isset($salesApi['vbk_ttl_sale_amt']) ? $salesApi['vbk_ttl_sale_amt'] : 0;
        $this->apiLog(IHITS_SALES, serialize($salesApi), $responce, $token, $otherDetails);
        return $responce;
    }

    function apiLog($endPoint, $value, $res, $token, $otherDetails = array())
    {
        $otherDetails['aplg_end_point'] = $endPoint;
        $otherDetails['aplg_value'] = $value;
        $otherDetails['aplg_res'] = $res;
        $otherDetails['aplg_token'] = $token;
        $otherDetails['aplg_added_on'] = date('Y-m-d H:i:s');
        $otherDetails['aplg_added_by'] = $this->uid;
        $this->db->insert($this->tbl_api_log, $otherDetails);
    }

    function ihitsSource($sourceApi)
    {
        $sourceApi['val_model_year'] = (int)$sourceApi['val_model_year'];
        $sourceApi['val_refurb_cost'] = (float)$sourceApi['val_refurb_cost'];
        $sourceApi['enh_adv_amt'] = (float)$sourceApi['enh_adv_amt'];
        $sourceApi['enh_booking_amt'] = (float)$sourceApi['enh_booking_amt'];
        $sourceApi['enh_discount_amt'] = (float)$sourceApi['enh_discount_amt'];
        $sourceApi['tcS_Amt'] = (float)$sourceApi['tcS_Amt'];
        $sourceApi['val_engine_no'] = (string)$sourceApi['val_engine_no'];
        $sourceApi['val_chasis_no'] = (string)$sourceApi['val_chasis_no'];
        $sourceApi['val_sales_officer_name'] = (string)$sourceApi['val_sales_officer_name'];
        $sourceApi['val_showroom'] = (string)$sourceApi['val_showroom'];
        $sourceApi['enq_cus_address'] = (string)$sourceApi['enq_cus_address'];
        $sourceApi['enq_cus_ofc_address'] = (string)$sourceApi['enq_cus_ofc_address'];
        $sourceApi['enq_cus_dist'] = (string)$sourceApi['enq_cus_dist'];
        $sourceApi['enq_cus_state'] = (string)$sourceApi['enq_cus_state'];
        $sourceApi['enq_trans_mode'] = (string)$sourceApi['enq_trans_mode'];
        $sourceApi['val_type_title'] = (string)$sourceApi['val_type_title'];
        $sourceApi['engine_CC'] = (int)$sourceApi['engine_CC'];
        $sourceApi['gcCode'] = (int)$sourceApi['gcCode'];
        $sourceApi['fuelType'] = (string)$sourceApi['fuelType'];
        $otherDetails['aplg_enq_id'] = (isset($sourceApi['pr_enq_id']) && !empty($sourceApi['pr_enq_id'])) ? $sourceApi['pr_enq_id'] : 0;
        $otherDetails['aplg_added_by'] = $this->uid;
        $otherDetails['aplg_added_on'] = date('Y-m-d H:i:s');
        $otherDetails['aplg_booking_id'] = (isset($sourceApi['pr_id']) && !empty($sourceApi['pr_id'])) ? $sourceApi['pr_id'] : 0;
        $otherDetails['aplg_valuation_id'] = (isset($sourceApi['pr_val_id']) && !empty($sourceApi['pr_val_id'])) ? $sourceApi['pr_val_id'] : 0;
        //@log data//
        unset($sourceApi['pr_enq_id'], $sourceApi['pr_id'], $sourceApi['pr_val_id']);

        if (isset($sourceApi['enq_agreement_date'])) {
            // Create a DateTime object from the provided date string
            $providedDate = $sourceApi['enq_agreement_date'];
            $dateTime = new DateTime($providedDate);

            // Check if the date was successfully parsed
            if ($dateTime) {
                // Format the date as a string in the desired format (with milliseconds and 'Z' for UTC)
                $formattedDate = $dateTime->format('Y-m-d\TH:i:s.u\Z');
                $sourceApi['enq_agreement_date'] = $formattedDate;
            } else {
                // 
            }
        }

        // Check if val_stock_num is provided
        if (isset($sourceApi['val_stock_num'])) {
            // Ensure that val_stock_num is a string
            $sourceApi['val_stock_num'] = (string)$sourceApi['val_stock_num'];
        } else {
            // If val_stock_num is not provided, set it as an empty string
            $sourceApi['val_stock_num'] = '';
        }
        unset($sourceApi['PurchaseType']);
        $token = $this->ihitsGetToken();
        $source = curl_init(IHITS_SOURCE);
        curl_setopt_array($source, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($sourceApi),
            //    CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($sourceApi))),
            CURLOPT_RETURNTRANSFER => true
        ));
        $slsresult = curl_exec($source);
        curl_close($source);
        $responce = serialize(json_decode($slsresult));
        $this->apiLog(IHITS_SOURCE, serialize($sourceApi), $responce, $token, $otherDetails);
        return $responce;
    }

    function ihitsSourceTest($sourceApi)
    {
        $sourceApi['val_model_year'] = (int)$sourceApi['val_model_year'];
        $sourceApi['val_refurb_cost'] = (float)$sourceApi['val_refurb_cost'];
        $sourceApi['enh_adv_amt'] = (float)$sourceApi['enh_adv_amt'];
        $sourceApi['enh_booking_amt'] = (float)$sourceApi['enh_booking_amt'];
        $sourceApi['enh_discount_amt'] = (float)$sourceApi['enh_discount_amt'];
        $sourceApi['tcS_Amt'] = (float)$sourceApi['tcS_Amt'];
        $sourceApi['val_engine_no'] = (string)$sourceApi['val_engine_no'];
        $sourceApi['val_chasis_no'] = (string)$sourceApi['val_chasis_no'];
        $sourceApi['val_sales_officer_name'] = (string)$sourceApi['val_sales_officer_name'];
        $sourceApi['val_showroom'] = (string)$sourceApi['val_showroom'];
        $sourceApi['enq_cus_address'] = (string)$sourceApi['enq_cus_address'];
        $sourceApi['enq_cus_ofc_address'] = (string)$sourceApi['enq_cus_ofc_address'];
        $sourceApi['enq_cus_dist'] = (string)$sourceApi['enq_cus_dist'];
        $sourceApi['enq_cus_state'] = (string)$sourceApi['enq_cus_state'];
        $sourceApi['enq_trans_mode'] = (string)$sourceApi['enq_trans_mode'];
        $sourceApi['val_type_title'] = (string)$sourceApi['val_type_title'];
        $sourceApi['engine_CC'] = (int)$sourceApi['engine_CC'];
        $sourceApi['gcCode'] = (int)$sourceApi['gcCode'];
        $sourceApi['fuelType'] = (string)$sourceApi['fuelType'];
        $sourceApi['enq_agreement_date'] = $sourceApi['enq_agreement_date'];

        $otherDetails['aplg_enq_id'] = (isset($sourceApi['pr_enq_id']) && !empty($sourceApi['pr_enq_id'])) ? $sourceApi['pr_enq_id'] : 0;
        $otherDetails['aplg_added_by'] = $this->uid;
        $otherDetails['aplg_added_on'] = date('Y-m-d H:i:s');
        $otherDetails['aplg_booking_id'] = (isset($sourceApi['pr_id']) && !empty($sourceApi['pr_id'])) ? $sourceApi['pr_id'] : 0;
        $otherDetails['aplg_valuation_id'] = (isset($sourceApi['pr_val_id']) && !empty($sourceApi['pr_val_id'])) ? $sourceApi['pr_val_id'] : 0;
        //@log data//
        unset($sourceApi['pr_enq_id'], $sourceApi['pr_id'], $sourceApi['pr_val_id']);

        // if (isset($sourceApi['enq_agreement_date'])) {
        //     $providedDate = $sourceApi['enq_agreement_date'];
        //     $dateTime = new DateTime($providedDate);
        //     if ($dateTime) {
        //         $formattedDate = $dateTime->format('Y-m-d\TH:i:s.u\Z');
        //         $sourceApi['enq_agreement_date'] = $formattedDate;
        //     } else {
        //     }
        // }

        // Check if val_stock_num is provided
        if (isset($sourceApi['val_stock_num'])) {
            // Ensure that val_stock_num is a string
            $sourceApi['val_stock_num'] = (string)$sourceApi['val_stock_num'];
        } else {
            // If val_stock_num is not provided, set it as an empty string
            $sourceApi['val_stock_num'] = '';
        }
        unset($sourceApi['PurchaseType']);
        $token = $this->ihitsGetToken();
        $source = curl_init(IHITS_SOURCE);
        unset($sourceApi['aplg_booking_id']);
        unset($sourceApi['aplg_enq_id']);
        unset($sourceApi['aplg_valuation_id']);
        unset($sourceApi['aplg_refurb_id']);
        unset($sourceApi['aplg_net_total']);
        debug($sourceApi, 0);
        echo json_encode($sourceApi);
        curl_setopt_array($source, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($sourceApi),
            //    CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($sourceApi))),
            CURLOPT_RETURNTRANSFER => true
        ));
        $slsresult = curl_exec($source);
        curl_close($source);
        $responce = serialize(json_decode($slsresult));
        //$this->apiLog(IHITS_SOURCE, serialize($sourceApi), $responce, $token, $otherDetails);
        debug($responce, 0);
        return $responce;
    }

    function ihitsSaveExpense($details, $enqId = 0, $bookingId = 0, $val = 0, $rf = 0)
    {
        //echo json_encode($details);
        $token = $this->ihitsGetToken();
        $responce = '';
        if (!empty($token)) {
            $sales = curl_init(IHITS_EXPENSE);
            curl_setopt_array($sales, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($details),
                //    CURLOPT_HEADER => true,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($details))),
                CURLOPT_RETURNTRANSFER => true
            ));
            $slsresult = curl_exec($sales);
            //debug($slsresult, 0);
            curl_close($sales);
            $otherDetails['aplg_bill_no'] = isset($details['head'][0]['billNo']) ? $details['head'][0]['billNo'] : '';
            $otherDetails['aplg_enq_id'] = $enqId;
            $otherDetails['aplg_booking_id'] = $bookingId;
            $otherDetails['aplg_valuation_id'] = $val;
            $otherDetails['aplg_refurb_id'] = $rf;
            $otherDetails['aplg_net_total'] = isset($details['totalAmount']) ? $details['totalAmount'] : 0;
            $responce = serialize(json_decode($slsresult));
            $this->apiLog(IHITS_EXPENSE, serialize($details), $responce, $token, $otherDetails);
            return $responce;
        } else {
            return false;
        }
    }

    function log($postDatas, $filterDatas)
    {
        $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
        $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
        $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
        $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
        $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
        $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
        $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
        $totalRecords = $this->db->where('aplg_show_log_list', 1)->count_all_results($this->tbl_api_log);

        //-----------------------------------------------------------------------------------------
        if (!empty($searchValue)) {
            $this->db->where("(aplg_bill_no LIKE '%" . $searchValue . "%' OR aplg_value LIKE '%" . $searchValue . "%' OR aplg_res LIKE '%" .
                $searchValue . "%' OR aplg_end_point LIKE '%" . $searchValue . "%')");
        }
        // $this->db->not_like('aplg_res', 'successfully');
        $totalRecordwithFilter = $this->db->where('aplg_show_log_list', 1)->count_all_results($this->tbl_api_log);

        //----------------------------------------------------------------------------------------
        if (!empty($columnName) && !empty($columnSortOrder)) {
            $this->db->order_by($columnName, $columnSortOrder);
        }

        if (!empty($searchValue)) {
            $this->db->where("(aplg_bill_no LIKE '%" . $searchValue . "%' OR aplg_value LIKE '%" . $searchValue . "%' OR aplg_res LIKE '%" .
                $searchValue . "%' OR aplg_end_point LIKE '%" . $searchValue . "%')");
        }

        if ($rowperpage > 0) {
            $this->db->limit($rowperpage, $row);
        }
        // $this->db->not_like('aplg_res', 'successfully');
        $data = $this->db->select(array($this->tbl_api_log . '.*', $this->tbl_users . '.usr_username AS aplg_added_by'))
            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_api_log . '.aplg_added_by', 'left')
            ->where('aplg_show_log_list', 1)->get($this->tbl_api_log)->result_array();

        //Data
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        return $response;
    }

    function getLog($id)
    {
        return $this->db->select(array($this->tbl_api_log . '.*', $this->tbl_users . '.usr_username AS aplg_added_by'))
            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_api_log . '.aplg_added_by', 'left')
            ->where('aplg_id', $id)->get($this->tbl_api_log)->row_array();
    }

    function disable($id)
    {
        $this->db->where('aplg_id', $id)->update($this->tbl_api_log, array('aplg_show_log_list' => 0));
    }

    function ihitsSalesToken($salesApi, $enqId = 0, $bookingId = 0, $val = 0)
    {
        $saleData['brd_title'] = (string) $salesApi['brd_title'];
        $saleData['mod_title'] = (string) $salesApi['mod_title'];
        $saleData['vc_color'] = !empty($salesApi['vc_color']) ? (string) $salesApi['vc_color'] : "";
        $saleData['val_model_year'] = (int) $salesApi['val_model_year'];
        $saleData['val_engine_no'] = (string) $salesApi['val_engine_no'];
        $saleData['val_chasis_no'] = (string) $salesApi['val_chasis_no'];
        $saleData['val_veh_no'] = (string) $salesApi['val_veh_no'];
        $saleData['vbk_cust_name'] = (string) $salesApi['vbk_cust_name'];
        $saleData['vbk_per_address'] = (string) $salesApi['vbk_per_address'];
        $saleData['vbk_rd_trans_address'] = (string) $salesApi['vbk_rd_trans_address'];
        $saleData['vbk_state'] = (string) $salesApi['vbk_state'];
        $saleData['vbk_dist'] = (string) $salesApi['vbk_dist'];
        $saleData['vbk_sales_staff_name'] = (string) $salesApi['vbk_sales_staff_name'];
        $saleData['vbk_added_on'] = $salesApi['vbk_added_on'];
        $saleData['vbk_ttl_sale_amt'] = (int) $salesApi['vbk_ttl_sale_amt'];
        $saleData['vbk_advance_amt'] = (int) $salesApi['vbk_advance_amt'];
        $saleData['vbk_sale_type'] = (string) $salesApi['vbk_sale_type'];
        $saleData['shr_location'] = (string) $salesApi['shr_location'];
        $saleData['enq_trans_mode'] = (string) $salesApi['enq_trans_mode'];
        $saleData['var_variant_name'] = (string) $salesApi['var_variant_name'];
        $saleData['stockID'] = (string) $salesApi['stockID'];
        $saleData['dueDate'] = date('Y-m-d');
        $saleData['gcCode'] = (int) $salesApi['gcCode'];
        $saleData['dc'] = (int) $salesApi['dc'];
        //debug($saleData, 0);
        //echo json_encode($saleData);

        $token = $this->ihitsGetToken();
        //echo $token . '<br>';
        $responce = '';
        //echo IHITS_SALES_TOKEN;
        if (!empty($token)) {
            $sales = curl_init(IHITS_SALES_TOKEN);
            curl_setopt_array($sales, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($saleData),
                //    CURLOPT_HEADER => true,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($saleData))),
                CURLOPT_RETURNTRANSFER => true
            ));
            $slsresult = curl_exec($sales);
            curl_close($sales);
            $responce = serialize(json_decode($slsresult));
            //echo '<br>Responce<br>';
            //debug($responce);
        } else {
            return false;
        }
        $otherDetails['aplg_enq_id'] = $enqId;
        $otherDetails['aplg_booking_id'] = $bookingId;
        $otherDetails['aplg_valuation_id'] = $val;
        $otherDetails['aplg_bill_no'] = isset($saleData['stockID']) ? $saleData['stockID'] : 0;
        $otherDetails['aplg_net_total'] = isset($saleData['vbk_ttl_sale_amt']) ? $saleData['vbk_ttl_sale_amt'] : 0;
        $this->apiLog(IHITS_SALES_TOKEN, serialize($saleData), $responce, $token, $otherDetails);
        $this->db->where('vbk_id', $bookingId)->update($this->tbl_vehicle_booking_master, array('vbk_is_token_recvd' => 1));
        //debug($responce);
        return $responce;
    }

    function ihitsSalesTokenTest($salesApi, $enqId = 0, $bookingId = 0, $val = 0)
    {
        debug($salesApi, 0);
        $saleData['brd_title'] = (string) $salesApi['brd_title'];
        $saleData['mod_title'] = (string) $salesApi['mod_title'];
        $saleData['vc_color'] = !empty($salesApi['vc_color']) ? (string) $salesApi['vc_color'] : "";
        $saleData['val_model_year'] = (int) $salesApi['val_model_year'];
        $saleData['val_engine_no'] = (string) $salesApi['val_engine_no'];
        $saleData['val_chasis_no'] = (string) $salesApi['val_chasis_no'];
        $saleData['val_veh_no'] = (string) $salesApi['val_veh_no'];
        $saleData['vbk_cust_name'] = (string) $salesApi['vbk_cust_name'];
        $saleData['vbk_per_address'] = (string) $salesApi['vbk_per_address'];
        $saleData['vbk_rd_trans_address'] = (string) $salesApi['vbk_rd_trans_address'];
        $saleData['vbk_state'] = (string) $salesApi['vbk_state'];
        $saleData['vbk_dist'] = (string) $salesApi['vbk_dist'];
        $saleData['vbk_sales_staff_name'] = (string) $salesApi['vbk_sales_staff_name'];
        $saleData['vbk_added_on'] = $salesApi['vbk_added_on'];
        $saleData['vbk_ttl_sale_amt'] = (int) $salesApi['vbk_ttl_sale_amt'];
        $saleData['vbk_advance_amt'] = (int) $salesApi['vbk_advance_amt'];
        $saleData['vbk_sale_type'] = (string) $salesApi['vbk_sale_type'];
        $saleData['shr_location'] = (string) $salesApi['shr_location'];
        $saleData['enq_trans_mode'] = (string) $salesApi['enq_trans_mode'];
        $saleData['var_variant_name'] = (string) $salesApi['var_variant_name'];
        $saleData['stockID'] = (string) $salesApi['stockID'];
        $saleData['gcCode'] = (int) $salesApi['gcCode'];
        $saleData['dueDate'] = date('Y-m-d');
        $saleData['dc'] = (int) $salesApi['dc'];
        //echo json_encode($saleData);
        debug($saleData, 0);
        $token = $this->ihitsGetToken();
        //echo $token . '<br>';
        $responce = '';
        echo IHITS_SALES_TOKEN;
        if (!empty($token)) {
            $sales = curl_init(IHITS_SALES_TOKEN);
            curl_setopt_array($sales, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($saleData),
                //    CURLOPT_HEADER => true,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($saleData))),
                CURLOPT_RETURNTRANSFER => true
            ));
            $slsresult = curl_exec($sales);
            curl_close($sales);
            $responce = serialize(json_decode($slsresult));
            //echo '<br>Responce<br>';
            debug($responce);
        } else {
            return false;
        }
        $otherDetails['aplg_enq_id'] = $enqId;
        $otherDetails['aplg_booking_id'] = $bookingId;
        $otherDetails['aplg_valuation_id'] = $val;
        $otherDetails['aplg_bill_no'] = isset($saleData['stockID']) ? $saleData['stockID'] : 0;
        $otherDetails['aplg_net_total'] = isset($saleData['vbk_ttl_sale_amt']) ? $saleData['vbk_ttl_sale_amt'] : 0;
        $this->apiLog(IHITS_SALES_TOKEN, serialize($saleData), $responce, $token, $otherDetails);
        $this->db->where('vbk_id', $bookingId)->update($this->tbl_vehicle_booking_master, array('vbk_is_token_recvd' => 1));
        //debug($responce);
        //return $responce;
    }

    function ihitsPurchaseTokenTest($salesApi, $enqId = 0, $bookingId = 0, $val = 0)
    {
        debug($salesApi, 0);
        $saleData['brd_title'] = (string) $salesApi['brd_title'];
        $saleData['mod_title'] = (string) $salesApi['mod_title'];
        $saleData['vc_color'] = !empty($salesApi['vc_color']) ? (string) $salesApi['vc_color'] : "";
        $saleData['val_model_year'] = (int) $salesApi['val_model_year'];
        $saleData['val_engine_no'] = (string) $salesApi['val_engine_no'];
        $saleData['val_chasis_no'] = (string) $salesApi['val_chasis_no'];
        $saleData['val_veh_no'] = (string) $salesApi['val_veh_no'];
        $saleData['val_cust_name'] = (string) $salesApi['val_cust_name'];
        $saleData['enq_cus_address'] = (string) $salesApi['enq_cus_address'];
        $saleData['enq_cus_ofc_address'] = (string) $salesApi['enq_cus_ofc_address'];
        $saleData['enq_cus_state'] = (string) $salesApi['enq_cus_state'];
        $saleData['enq_cus_dist'] = (string) $salesApi['enq_cus_dist'];
        $saleData['val_sales_officer_name'] = (string) $salesApi['val_sales_officer_name'];
        $saleData['enq_agreement_date'] = $salesApi['enq_agreement_date'];
        $saleData['enh_booking_amt'] = (int) $salesApi['enh_booking_amt'];
        $saleData['enh_adv_amt'] = (int) $salesApi['enh_adv_amt'];
        $saleData['val_type_title'] = (string) $salesApi['purchaseType'];
        $saleData['val_showroom'] = (string) $salesApi['val_showroom'];
        $saleData['enq_trans_mode'] = (string) $salesApi['enq_trans_mode'];
        $saleData['var_variant_name'] = (string) $salesApi['var_variant_name'];
        $saleData['stockID'] = (string) $salesApi['stockID'];
        $saleData['dueDate'] = $salesApi['dueDate'];
        $saleData['purchaseType'] = (string)$salesApi['purchaseType'];
        $saleData['gcCode'] = (int)$salesApi['gcCode'];
        $saleData['ec'] = (int)$salesApi['ec'];
        echo count($saleData) . '<br>';
        //echo json_encode($saleData);
        //debug($saleData, 0);
        $token = $this->ihitsGetToken();
        //echo $token . '<br>';
        $responce = '';
        echo IHITS_SOURCE_TOKEN;
        debug($saleData, 0);
        if (!empty($token)) {
            echo json_encode($saleData);
            $sales = curl_init(IHITS_SOURCE_TOKEN);
            curl_setopt_array($sales, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($saleData),
                //    CURLOPT_HEADER => true,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($saleData))),
                CURLOPT_RETURNTRANSFER => true
            ));
            $slsresult = curl_exec($sales);
            curl_close($sales);
            $responce = serialize(json_decode($slsresult));
            //echo '<br>Responce<br>';
            debug($responce);
        } else {
            return false;
        }
        $otherDetails['aplg_enq_id'] = $enqId;
        $otherDetails['aplg_booking_id'] = $bookingId;
        $otherDetails['aplg_valuation_id'] = $val;
        $otherDetails['aplg_bill_no'] = isset($saleData['stockID']) ? $saleData['stockID'] : 0;
        $otherDetails['aplg_net_total'] = isset($saleData['vbk_ttl_sale_amt']) ? $saleData['vbk_ttl_sale_amt'] : 0;
        $this->apiLog(IHITS_SALES_TOKEN, serialize($saleData), $responce, $token, $otherDetails);
        $this->db->where('vbk_id', $bookingId)->update($this->tbl_vehicle_booking_master, array('vbk_is_token_recvd' => 1));
        debug($responce);
        //return $responce;
    }

    function ihitsPurchaseToken($salesApi, $enqId = 0, $bookingId = 0, $val = 0)
    {
        $saleData['brd_title'] = (string) $salesApi['brd_title'];
        $saleData['val_cust_name'] = (string) $salesApi['val_cust_name'];
        $saleData['mod_title'] = (string) $salesApi['mod_title'];
        $saleData['vc_color'] = !empty($salesApi['vc_color']) ? (string) $salesApi['vc_color'] : "";
        $saleData['val_model_year'] = (int) $salesApi['val_model_year'];
        $saleData['val_engine_no'] = (string) $salesApi['val_engine_no'];
        $saleData['val_chasis_no'] = (string) $salesApi['val_chasis_no'];
        $saleData['val_veh_no'] = (string) $salesApi['val_veh_no'];
        $saleData['enq_cus_address'] = (string) $salesApi['enq_cus_address'];
        $saleData['enq_cus_ofc_address'] = (string) $salesApi['enq_cus_ofc_address'];
        $saleData['enq_cus_state'] = (string) $salesApi['enq_cus_state'];
        $saleData['enq_cus_dist'] = (string) $salesApi['enq_cus_dist'];
        $saleData['val_sales_officer_name'] = (string) $salesApi['val_sales_officer_name'];
        $saleData['enq_agreement_date'] = $salesApi['enq_agreement_date'];
        $saleData['enh_booking_amt'] = (int) $salesApi['enh_booking_amt'];
        $saleData['enh_adv_amt'] = (int) $salesApi['enh_adv_amt'];
        $saleData['val_showroom'] = (string) $salesApi['val_showroom'];
        $saleData['enq_trans_mode'] = (string) $salesApi['enq_trans_mode'];
        $saleData['var_variant_name'] = (string) $salesApi['var_variant_name'];
        $saleData['stockID'] = (string) $salesApi['stockID'];
        $saleData['dueDate'] = $salesApi['dueDate'];
        $saleData['purchaseType'] = (string) $salesApi['purchaseType'];
        $saleData['gcCode'] = (int) $salesApi['gcCode'];
        $saleData['val_type_title'] = (string) $salesApi['val_type_title'];
        $saleData['ec'] = (int) $salesApi['ec'];

        $token = $this->ihitsGetToken();
        $responce = '';
        if (!empty($token)) {
            $sales = curl_init(IHITS_SOURCE_TOKEN);
            curl_setopt_array($sales, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($saleData),
                //    CURLOPT_HEADER => true,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization: Bearer ' . $token, 'Content-Length: ' . strlen(json_encode($saleData))),
                CURLOPT_RETURNTRANSFER => true
            ));
            $slsresult = curl_exec($sales);
            curl_close($sales);
            $responce = serialize(json_decode($slsresult));
        } else {
            return false;
        }
        $otherDetails['aplg_enq_id'] = $enqId;
        $otherDetails['aplg_booking_id'] = $bookingId;
        $otherDetails['aplg_valuation_id'] = $val;
        $otherDetails['aplg_bill_no'] = isset($saleData['stockID']) ? $saleData['stockID'] : '';
        $otherDetails['aplg_net_total'] = isset($saleData['vbk_ttl_sale_amt']) ? $saleData['vbk_ttl_sale_amt'] : 0;
        $this->apiLog(IHITS_SOURCE_TOKEN, serialize($saleData), $responce, $token, $otherDetails);
        return $responce;
    }
}
