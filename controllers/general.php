<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class general extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->load->model('enquiry/enquiry_model', 'enquiry');
       }

       function ses() {
          debug($this->session->userdata);
       }

       function doUploadFromEditor() {
            $newFileName = rand(9999999, 0);
            $config['upload_path'] = FILE_UPLOAD_PATH . 'editor/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name'] = $newFileName;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                 debug($this->upload->display_errors());
            } else {
                 $data = $this->upload->data();
                 $array = array(
                     'filelink' => '../assets/uploads/editor/' . $data['file_name']
                 );

                 echo json_encode($array);
                 exit;
            }
       }

       function clearEnquiry() {
            if ($this->common_model->clearEnquiry()) {
                 $this->session->set_flashdata('app_success', 'Database cleaned successfully!');
            } else {
                 $this->session->set_flashdata('app_error', 'Error occured!');
            }
            redirect(__CLASS__ . '/dbclean');
       }

       function cleanEvaluation() {
            if ($this->common_model->cleanEvaluation()) {
                 $this->session->set_flashdata('app_success', 'Database cleaned successfully!');
            } else {
                 $this->session->set_flashdata('app_error', 'Error occured!');
            }
            redirect(__CLASS__ . '/dbclean');
       }

       function dbclean() {
            $this->load->view('dbclean');
       }

       function setFollo() {
            $g = $this->common_model->db->get('cpnl_vehicle')->result_array();
            foreach ($g as $key => $value) {
                 $this->common_model->db->where('foll_cus_id = ' . $value['veh_enq_id'], ' AND foll_cus_vehicle_id IS NULL', false);
                 $this->common_model->db->update('cpnl_followup', array('foll_cus_vehicle_id' => $value['veh_id']));
            }
       }

       function showme() {
            debug($this->session->userdata);
       }

       function deleteEnqDependent($enqId) {
            if (!empty($enqId)) {
                 $this->common_model->db->where('enq_id', $enqId);
                 $this->common_model->db->delete(TABLE_PREFIX . 'enquiry');

                 $this->common_model->db->where('foll_cus_id', $enqId);
                 $this->common_model->db->delete(TABLE_PREFIX . 'followup');

                 $this->common_model->db->where('veh_enq_id', $enqId);
                 $this->common_model->db->delete(TABLE_PREFIX . 'vehicle');

                 $this->common_model->db->where('vst_enq_id', $enqId);
                 $this->common_model->db->delete(TABLE_PREFIX . 'vehicle_status');
                 return true;
            } else {
                 return false;
            }
       }

       function bulkUpdate() {
            $enqid = array(2156, 2155, 2118, 2111, 2110, 2109, 2108, 2107, 2106, 2105, 2104, 2103, 2102, 2101, 2100, 2099, 2098, 2097, 2096, 2086, 2076, 2075, 2074, 2073, 2071, 2068, 2067, 2031, 2027,
                2023, 1984, 1983, 1982, 1981, 1980, 1978, 1977, 1976, 1975, 1974, 1973, 1964, 1963, 1962, 1961, 1958, 1941, 1928, 1927, 1926, 1925, 1914, 1909, 1908, 1907, 1905, 1904, 1903,
                1841, 1573, 1571, 914, 118, 112);
            $count = 0;
            foreach ($enqid as $key => $enqId) {
                 $enquiry = $this->common_model->db->select('enq_se_id')->where('enq_id', $enqId)->get(TABLE_PREFIX . 'enquiry')->row_array();
                 $vehicle = $this->common_model->db->select('veh_id')->where('veh_enq_id', $enqId)->get(TABLE_PREFIX . 'vehicle')->result_array();

                 if (!empty($vehicle)) {
                      foreach ($vehicle as $key => $veh) {
                           $count = $count + 1;
                           $addedBy = isset($enquiry['enq_se_id']) ? $enquiry['enq_se_id'] : 0;
                           $followup = array(
                               'foll_cus_id' => $enqId,
                               'foll_cus_vehicle_id' => $veh['veh_id'],
                               'foll_status' => 2,
                               'foll_remarks' => 'nill',
                               'foll_contact' => 1,
                               'foll_action_plan' => 'nill',
                               'foll_next_foll_date' => '2018-05-23 00:00:00',
                               'foll_added_by' => $addedBy
                           );
                           $this->common_model->db->insert(TABLE_PREFIX . 'followup', $followup);
                      }
                 }
            }
       }

       function bulkUpdateMissed() {
            $vehIds = $this->common_model->db->select('veh_id, enq_se_id')->where('enq_se_id != 6 AND enq_se_id != 2')
                            ->order_by('enq_se_id', 'ASC')
                            ->get(TABLE_PREFIX . 'view_enquiry_vehicle_master')->result_array();
            if (!empty($vehIds)) {
                 foreach ($vehIds as $key => $veh) {
                      $allMissedFollowupArray = $this->common_model->db->select('foll_id')
                                      ->where("foll_cus_vehicle_id = " . $veh['veh_id'] . " AND DATEDIFF(foll_next_foll_date, CURDATE()) <= -3 AND (foll_customer_feedback IS NULL OR foll_customer_feedback = '')")
                                      ->get(TABLE_PREFIX . 'followup')->result_array();

                      if (!empty($allMissedFollowupArray)) {
                           foreach ($allMissedFollowupArray as $key => $followup) {
                                $this->common_model->db->where('foll_id', $followup['foll_id']);
                                $this->common_model->db->update(TABLE_PREFIX . 'followup', array('foll_next_foll_date' => '2018-05-29'));
                           }
                      }
                 }
            }
       }

       function setNewFollowupDate() {
            $follId = array(1, 7, 16, 24, 25, 26, 27, 29, 30, 32, 33, 44, 45, 46, 50, 62, 63, 64, 65, 66, 67, 69, 70, 71, 72, 73, 87, 91, 92, 95, 100, 106, 108, 110, 111, 112, 113, 115, 116, 117, 118, 119, 120, 121, 122, 123, 130, 131, 132, 133, 134, 135, 136, 138, 146, 149, 150, 151, 152, 153, 155, 159, 160, 161, 162, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 175, 176, 179, 180, 181, 182, 183, 190, 191, 192, 194, 197, 204, 205, 208, 209, 210, 211, 213, 214, 215, 216, 217, 218, 220, 221, 222, 223, 224, 225, 226, 227, 230, 231, 232, 233, 237, 239, 240, 241, 242, 243, 244, 245, 246, 261, 262, 264, 272, 273, 274, 276, 277, 278, 279, 280, 281, 286, 287, 293, 294, 295, 299, 300, 301, 306, 312, 313, 314, 315, 317, 320, 321, 323, 324, 325, 327, 331, 332, 334, 335, 336, 338, 342, 343, 346, 357, 361, 362, 363, 364, 365, 368, 369, 370, 371, 373, 374, 375, 376, 377, 378, 379, 380, 381, 394, 411, 412, 413, 414, 415, 416, 417, 418, 423, 434, 436, 439, 442, 445, 446, 447, 448, 449, 450, 451, 452, 453, 454, 460, 465, 467, 469, 470, 471, 472, 473, 474, 475, 476, 477, 478, 479, 480, 481, 482, 483, 485, 488, 489, 490, 491, 492, 493, 494, 495, 496, 497, 499, 500, 502, 503, 504, 512, 513, 514, 515, 521, 523, 526, 527, 528, 529, 530, 531, 532, 533, 534, 535, 536, 537, 538, 539, 540, 541, 614, 615, 616, 617, 618, 619, 620, 621, 648, 675, 676, 678, 679, 681, 682, 683, 684, 685, 689, 692, 693, 697, 699, 701, 702, 703, 704, 705, 706, 707, 708, 709, 713, 714, 798, 802, 818, 819, 820, 821, 822, 823, 824, 825, 827, 828, 829, 831, 837, 838, 839, 840, 841, 842, 843, 847, 848, 849, 850, 851, 853, 854, 855, 856, 857, 858, 872, 886, 887, 888, 890, 912, 921, 922, 925, 928, 929, 930, 931, 932, 949, 959, 960, 963, 964, 966, 971, 976, 977, 978, 982, 983, 984, 994, 995, 996, 997, 999, 1000, 1001, 1002, 1004, 1006, 1007, 1008, 1009, 1011, 1014, 1015, 1016, 1022, 1023, 1024, 1025, 1026, 1027, 1028, 1029, 1030, 1031, 1032, 1033, 1034, 1035, 1036, 1038, 1039, 1040, 1042, 1043, 1044, 1045, 1046, 1047, 1048, 1049, 1059, 1060, 1061, 1086, 1162, 1163, 1166, 1168, 1170, 1171, 1172, 1176, 1179, 1180, 1182, 1183, 1185, 1186, 1187, 1189, 1190, 1191, 1192, 1194, 1225, 1226, 1227, 1228, 1229, 1231, 1241, 1242, 1243, 1244, 1245, 1246, 1247, 1261, 1262, 1270, 1275, 1276, 1277, 1278, 1279, 1280, 1281, 1282, 1283, 1286, 1288, 1290, 1291, 1292, 1293, 1294, 1295, 1296, 1297, 1298, 1299, 1300, 1301, 1303, 1304, 1305, 1307, 1308, 1310, 1319, 1320, 1321, 1323, 1329, 1330, 1331, 1333, 1335, 1336, 1337, 1338, 1339, 1340, 1341, 1342, 1344, 1345, 1346, 1347, 1348, 1349, 1350, 1351, 1352, 1353, 1354, 1355, 1356, 1357, 1358, 1359, 1360, 1380, 1381, 1382, 1383, 1391, 1392, 1395, 1396, 1397, 1407, 1410, 1411, 1412, 1413, 1414, 1415, 1416, 1417, 1418, 1419, 1420, 1421, 1422, 1423, 1424, 1425, 1426, 1427, 1428, 1429, 1430, 1431, 1432, 1433, 1434, 1435, 1436, 1437, 1438, 1439, 1440, 1441, 1442, 1449, 1451, 1453, 1457, 1459, 1460, 1461, 1462, 1463, 1464, 1473, 1474, 1475, 1476, 1477, 1478, 1479, 1480, 1481, 1482, 1483, 1484, 1485, 1486, 1487, 1496, 1498, 1526, 1527, 1528, 1529, 1530, 1531, 1532, 1533, 1534, 1535, 1536, 1537, 1539, 1540, 1541, 1542, 1543, 1544, 1545, 1546, 1547, 1548, 1549, 1550, 1551, 1552, 1553, 1554, 1555, 1556, 1557, 1558, 1559, 1562, 1563, 1564, 1565, 1566, 1567, 1568, 1569, 1571, 1572, 1573, 1575, 1576, 1577, 1579, 1580, 1584, 1585, 1586, 1587, 1588, 1589, 1590, 1591, 1592, 1593, 1594, 1595, 1596, 1597, 1603, 1613, 1614, 1615, 1616, 1618, 1619, 1620, 1621, 1622, 1646, 1649, 1651, 1652, 1653, 1654, 1655, 1656, 1657, 1659, 1660, 1667, 1668, 1669, 1670, 1671, 1672, 1673, 1674, 1675, 1676, 1677, 1678, 1680, 1681, 1682, 1683, 1684, 1686, 1687, 1689, 1695, 1697, 1698, 1699, 1700, 1705, 1706, 1707, 1708, 1709, 1710, 1711, 1717, 1718, 1719, 1720, 1721, 1722, 1728, 1730, 1731, 1732, 1733, 1734, 1735, 1736, 1737, 1738, 1739, 1740, 1741, 1742, 1743, 1744, 1745, 1746, 1747, 1759, 1760, 1761, 1763, 1764, 1765, 1766, 1767, 1769, 1772, 1773, 1774, 1775, 1776, 1777, 1778, 1779, 1780, 1781, 1782, 1783, 1784, 1786, 1787, 1788, 1790, 1791, 1792, 1794, 1795, 1796, 1799, 1800, 1801, 1802, 1803, 1804, 1806, 1807, 1808, 1810, 1811, 1812, 1814, 1817, 1821, 1822, 1823, 1824, 1827, 1828, 1829, 1830, 1831, 1833, 1834, 1835, 1836, 1837, 1838, 1839, 1840, 1841, 1843, 1844, 1845, 1846, 1848, 1849, 1850, 1851, 1855, 1856, 1857, 1858, 1859, 1860, 1861, 1867, 1868, 1869, 1870, 1871, 1877, 1878, 1887, 3534, 1948, 3297, 2028, 2042, 2043, 2044, 2045, 2046, 2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062, 2063, 2064, 2065, 2066, 2136, 2137, 2138, 2139, 2140, 2141, 2142, 2143, 2144, 2145, 2171, 2172, 2173, 2174, 2175, 2176, 2177, 2178, 2179, 2180, 2181, 2182, 2183, 2184, 2185, 2186, 2187, 2188, 2189, 2190, 2191, 2192, 2193, 2194, 2195, 2196, 2197, 2198, 2199, 2200, 2201, 2292, 2293, 2294, 2295, 2324, 2325, 2326, 2327, 2328, 2329, 2330, 2331, 2332, 2333, 2334, 2335, 2336, 2337, 2338, 2339, 2340, 2341, 2342, 2363, 2365, 2367, 2368, 2369, 2370, 2371, 2372, 2373, 2374, 2375, 2376, 2377, 2378, 2379, 2380, 2381, 2382, 2383, 2384, 2385, 2386, 2387, 2388, 2389, 2390, 2391, 2392, 2393, 2394, 2395, 2396, 2397, 2398, 2399, 2400, 2401, 2402, 2403, 2404, 2405, 2406, 2407, 2408, 2409, 2410, 2411, 2412, 2413, 2414, 2415, 2416, 2417, 2418, 2419, 2420, 2426, 2427, 2428, 2430, 2445, 2446, 2447, 2448, 2449, 2450, 2451, 2452, 2453, 2454, 2455, 2456, 2457, 2458, 2459, 2460, 2461, 2462, 2463, 2464, 2465, 2466, 2467, 2468, 2469, 2470, 2471, 2472, 2473, 2474, 2493, 2494, 2495, 2496, 2497, 2498, 2499, 2500, 2501, 2502, 2503, 2504, 2505, 2506, 2507, 2508, 2509, 2510, 2511, 2512, 2513, 2514, 2515, 2516, 2517, 2518, 2519, 2520, 2521, 2522, 2523, 2524, 2525, 2526, 2527, 2528, 2529, 2530, 2531, 2532, 2533, 2546, 2567, 2579, 2580, 2581, 2582, 2600, 2599, 2595, 2594, 2602, 2603, 2604, 2605, 2606, 2607, 2608, 2609, 2610, 2611, 2614, 2615, 2621, 2622, 2624, 2625, 2626, 2627, 2628, 2629, 2631, 2632, 2633, 2634, 2635, 2636, 2637, 2638, 2639, 2640, 2641, 2642, 2643, 2644, 2645, 2646, 2647, 2648, 2649, 2650, 2651, 2652, 2653, 2654, 2655, 2656, 2657, 2658, 2661, 2662, 2663, 2664, 2665, 2666, 2667, 2668, 2675, 2677, 2727, 2683, 2684, 2685, 2691, 2692, 2695, 2696, 2718, 2740, 2744, 2765, 2766, 2768, 2770, 2773, 2874, 2885, 2917, 2919, 3034, 3043, 3171, 3222, 3551);

            foreach ($follId as $key => $value) {
                 $this->common_model->db->where('foll_id', $value);
                 $this->common_model->db->update(TABLE_PREFIX . 'followup', array('foll_next_foll_date' => '2018-06-09'));
            }
       }

       function memberLookup($lokUdId) {
            if (!empty($lokUdId)) {
                 $search = isset($_GET['criteria']) ? $_GET['criteria'] : '';
                 $members = $this->common_model->memberLookup($lokUdId, $search);
                 die(json_encode($members));
            }
            return null;
       }

       function clearEnquiryQuestions() {
            $enq = $this->db->select('enq_id, enq_cus_status, enq_cus_presenet_vehicle, enq_cus_family_members, enq_cus_vehicle_user, enq_cus_money, '
                            . 'enq_cus_authority, enq_cus_need')->get('cpnl_enquiry')->result_array();

            foreach ($enq as $key => $value) {
                 if (!empty($value['enq_cus_presenet_vehicle'])) {
                      $this->db->insert('cpnl_enquiry_questions', array(
                          'enqq_enq_id' => $value['enq_id'],
                          'enqq_question_id' => 5,
                          'enqq_answer' => $value['enq_cus_presenet_vehicle']
                      ));
                 }
                 if (!empty($value['enq_cus_family_members'])) {
                      $this->db->insert('cpnl_enquiry_questions', array(
                          'enqq_enq_id' => $value['enq_id'],
                          'enqq_question_id' => 14,
                          'enqq_answer' => $value['enq_cus_family_members']
                      ));
                 }
                 if ($value['enq_cus_status'] == 1) { // Sell
                      if (!empty($value['enq_cus_need'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 23,
                               'enqq_answer' => $value['enq_cus_need']
                           ));
                      }

                      if (!empty($value['enq_cus_authority'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 24,
                               'enqq_answer' => $value['enq_cus_authority']
                           ));
                      }

                      if (!empty($value['enq_cus_money'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 22,
                               'enqq_answer' => $value['enq_cus_money']
                           ));
                      }
                 } else if ($value['enq_cus_status'] == 2) { // Buy
                      if (!empty($value['enq_cus_need'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 26,
                               'enqq_answer' => $value['enq_cus_need']
                           ));
                      }

                      if (!empty($value['enq_cus_authority'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 39,
                               'enqq_answer' => $value['enq_cus_authority']
                           ));
                      }

                      if (!empty($value['enq_cus_money'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 37,
                               'enqq_answer' => $value['enq_cus_money']
                           ));
                      }
                 } else if ($value['enq_cus_status'] == 3) { // Exchange
                      if (!empty($value['enq_cus_need'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 49,
                               'enqq_answer' => $value['enq_cus_need']
                           ));
                      }

                      if (!empty($value['enq_cus_authority'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 33,
                               'enqq_answer' => $value['enq_cus_authority']
                           ));
                      }

                      if (!empty($value['enq_cus_money'])) {
                           $this->db->insert('cpnl_enquiry_questions', array(
                               'enqq_enq_id' => $value['enq_id'],
                               'enqq_question_id' => 45,
                               'enqq_answer' => $value['enq_cus_money']
                           ));
                      }
                 }
            }
       }

       function issAssignedAddedby() {
            $reg = $this->db->get_where(TABLE_PREFIX . 'register_master', 'vreg_added_by = vreg_assigned_to AND vreg_inquiry != 0')->result_array();
            foreach ($reg as $key => $value) {
                 $enq = $this->db->get_where(TABLE_PREFIX . 'enquiry', array('enq_id' => $value['vreg_inquiry']))->row_array();
                 if (!empty($enq)) {
                      $this->db->where('vreg_id', $value['vreg_id']);
                      $this->db->update(TABLE_PREFIX . 'register_master', array('vreg_assigned_to' => $enq['enq_se_id']));
                 }
            }
       }

       function darUpdation() {
            $foll = $this->db->get(TABLE_PREFIX . 'dar_followup')->result_array();
            foreach ($foll as $key => $value) {
                 $this->db->where('foll_id', $value['darf_followup']);
                 $this->db->update(TABLE_PREFIX . 'followup', array('foll_is_dar_submited' => 1));
            }
       }

       function forceaction() {

            ini_set("memory_limit", -1);
//            Request for delete
//            $statusFrom = 8;
//            $statusTo = 99;
//            $data['enh_remarks'] = 'Force action for delete by super admin';
//            $controll = 'force-del-admin';
//            Request loss
//            $statusFrom = 4;
//            $statusTo = 5;
//            $data['enh_remarks'] = 'Force action for loss of sale / purchase by super admin';
//            $controll = 'force-loss-admin';
//            Request for drop

            $dateFrom = "DATE('" . date("Y-m-d", strtotime("-2 Months")) . "')";

            $dateTo = "DATE('" . date("Y-m-d") . "')";
            $statusTo = 3;
            $data['enh_remarks'] = 'Bulk enquiries moved to drop from date: ' . $dateTo;
            $controll = 'force-drop-admin-cron';

            $reqDelete = $this->db->query("SELECT DISTINCT(foll_cus_id) FROM cpnl_followup WHERE fol_t = 0 ORDER BY foll_id DESC")->result_array();

            foreach ($reqDelete as $key => $value) {
                 if (!empty($value)) {
                      $isFollwd = $this->db->get_where('cpnl_followup', 'foll_cus_id = ' . $value['foll_cus_id'] .
                                      ' AND DATE(foll_entry_date) BETWEEN ' . $dateFrom . ' AND ' . $dateTo)->row_array();
                      if (empty($isFollwd)) {
                           $data['enh_added_by'] = 100;
                           $data['enh_added_on'] = date('Y-m-d H:i:s');
                           $data['enh_enq_id'] = $value['foll_cus_id'];
                           $data['enh_status'] = $statusTo;
                           if ($this->db->insert('cpnl_enquiry_history', $data)) {
                                $enqHistoryId = $this->db->insert_id();
                                $this->db->where('enq_id', $value['foll_cus_id']);
                                $this->db->update('cpnl_enquiry', array('enq_current_status' => $statusTo, 'enq_current_status_history' => $enqHistoryId));
                                generate_log(array(
                                    'log_title' => 'Bulk enquiries moved to drop',
                                    'log_desc' => $data['enh_remarks'],
                                    'log_controller' => $controll,
                                    'log_action' => 'C',
                                    'log_ref_id' => $enqHistoryId,
                                    'log_added_by' => $this->uid
                                ));
                           }
                      }

                      $this->db->where('foll_cus_id', $value['foll_cus_id']);
                      $this->db->update('cpnl_followup', array('fol_t' => 1));
                 }
            }
            echo 'Finished';
            exit;
       }

       function historyse() {
            $f = $this->db->get_where('cpnl_enquiry_history', array('enh_current_sales_executive' => 0))->result_array();
            if (!empty($f)) {
                 foreach ($f as $key => $value) {
                      echo $value['enh_enq_id'] . '<br>';
                      $se = $this->db->select('enq_se_id')->get_where('cpnl_enquiry', array('enq_id' => $value['enh_enq_id']))->row()->enq_se_id;
                      if ($se) {
                           $this->db->where('enh_enq_id', $value['enh_enq_id'])
                                   ->update('cpnl_enquiry_history', array('enh_current_sales_executive' => $se));
                      }
                 }
            }
            echo 'Finished';
            exit;
       }

       function userasscess() {
            $ass = $this->db->get('cpnl_user_access')->result_array();

            foreach ($ass as $key => $value) {
                 $usrers = $this->db->select('cpnl_users.usr_id, cpnl_users.usr_username, cpnl_users_groups.*, cpnl_groups.*')
                                 ->join('cpnl_users_groups', 'cpnl_users_groups.user_id = cpnl_users.usr_id', 'LEFT')
                                 ->join('cpnl_groups', 'cpnl_users_groups.group_id = cpnl_groups.id', 'LEFT')
                                 ->where('cpnl_groups.id', $value['cua_group_id'])
                                 ->get('cpnl_users')->result_array();

                 foreach ($usrers as $key => $usrer) {
                      $this->db->insert('cpnl_user_access', array(
                          'cua_group_id' => $value['cua_group_id'],
                          'cua_user_id' => $usrer['usr_id'],
                          'cua_access' => $value['cua_access'],
                          'cua_desig' => $usrer['grp_slug'],
                          'cua_date' => $value['cua_date']
                      ));
                 }
            }
       }

       function missmod() {
            $f = $this->db->query('SELECT enq_id, enq_cus_mobile, enq_mode_enq FROM ' . TABLE_PREFIX . 'enquiry WHERE enq_mode_enq IS NULL')->result_array();
            foreach ($f as $key => $value) {
                 $reg = $this->db->select('vreg_contact_mode')->like('vreg_cust_phone', $value['enq_cus_mobile'], 'both')
                                 ->get('cpnl_register_master')->row_array();
                 $mod = isset($reg['vreg_contact_mode']) ? $reg['vreg_contact_mode'] : 0;
                 $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('enq_mode_enq' => $mod));
            }
       }

       function callbridge() {
            $callbridge = $this->db->get('cpnl_callcenterbridging')->result_array();
            foreach ($callbridge as $key => $value) {
                 if (!empty($value['ccb_AgentNumber'])) {
                      $cusMobile = substr($value['ccb_AgentNumber'], -10);
                      $users = $this->db->select('usr_id, usr_phone, usr_first_name, usr_username')->like('usr_phone', $cusMobile, 'before')
                                      ->get('cpnl_users')->row_array();
                      if (!empty($users)) {
                           $this->db->where('ccb_id', $value['ccb_id'])->update('cpnl_callcenterbridging', array(
                               'ccb_authorized_person' => $users['usr_username'],
                               'ccb_authorized_person_id' => $users['usr_id']
                           ));
                      }
                 }
            }
       }

       function regtocall() {
            $reg = $this->db->select('vreg_id,vreg_cust_phone,vreg_first_owner, vreg_voxbay_ref')
                            ->where('vreg_voxbay_ref != 0')->get('cpnl_register_master')->result_array();

            foreach ($reg as $key => $value) {
                 $cusMobile = substr($value['vreg_cust_phone'], -10);
                 $call = $this->db->select('ccb_id,ccb_punched_by,ccb_callerNumber,ccb_register_ref,ccb_authorized_person')
                                 ->like('ccb_callerNumber', $cusMobile, 'both')->get('cpnl_callcenterbridging')->result_array();

                 $ids = array_column($call, 'ccb_id');

                 $this->db->where_in('ccb_id', $ids)->update('cpnl_callcenterbridging', array('ccb_register_ref' => $value['vreg_id']));

                 echo '--call Ids--';
                 debug($ids, 0);
                 echo '--Reg--<br>';
                 debug($value, 0);
                 echo '--Call--';
                 debug($call, 0);
                 echo '<br>-------------------------------------------------------------------------------<br>';
            }
       }

       function calltoreg() {
            $callNotInReg = $this->db->where("(ccb_punched_by = 0 OR ccb_register_ref = 0) AND ccb_callerNumber != ''")
                            ->get('cpnl_callcenterbridging')->result_array();

            foreach ($callNotInReg as $key => $value) {
                 $custNmberLstTen = substr($value['ccb_callerNumber'], -10);
                 $reg = $this->db->select('vreg_entry_date, vreg_added_on, vreg_id, vreg_cust_phone, vreg_first_owner, vreg_voxbay_ref, vreg_assigned_to, vreg_first_owner, vreg_voxbay_ref')
                                 ->like('vreg_cust_phone', $custNmberLstTen, 'both')->get('cpnl_register_master')->row_array();

                 if (!empty($reg)) {
                      debug($value, 0);
                      echo '-----------------------';
                      debug($reg, 0);
                 }
            }
       }

       function bindvehicle() {
            $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_showroom = TABLE_PREFIX . 'showroom';
            $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
            $this->tbl_quick_tc_report = TABLE_PREFIX . 'quick_tc_repor';

            $selectArray = array(
                $this->tbl_quick_tc_report . '.*',
                $this->tbl_enquiry . '.enq_entry_date',
                $this->tbl_enquiry . '.enq_id',
                $this->tbl_enquiry . '.enq_cus_name',
                $this->tbl_enquiry . '.enq_cus_whatsapp',
                $this->tbl_enquiry . '.enq_cus_mobile',
                $this->tbl_users . '.usr_username',
                $this->tbl_showroom . '.*'
            );
            $return = $this->db->select($selectArray)
                            ->join($this->tbl_enquiry, $this->tbl_quick_tc_report . '.qtr_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
                            ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
                            ->get($this->tbl_quick_tc_report)->result_array();
//            debug($return);
            foreach ($return as $key1 => $value1) {
                 $vehicles = $this->db->select($this->tbl_vehicle . '.veh_id,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                 ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                 ->where($this->tbl_vehicle . '.veh_enq_id', $value1['qtr_enq_id'])->get($this->tbl_vehicle)->result_array();
                 $vehicleName = array();
                 if (!empty($vehicles)) {
                      foreach ($vehicles as $key2 => $value2) {
                           $vehicleName[] = $value2['brd_title'] . ',' . $value2['mod_title'] . ',' . $value2['var_variant_name'];
                      }
                 }
                 $veh = implode('/', $vehicleName);
                 $this->db->where('qtr_id', $value1['qtr_id'])->update($this->tbl_quick_tc_report, array('qtr_vehile' => $veh));
            }
       }

       function dd() {
            //$this->db->insert('test', array('date' => date('Y-m-d h:i:s'), 'date_two' => date('Y-m-d h:i:s')));
            $f = $this->db->select('ccb_callerNumber, ccb_id')->get_where('cpnl_callcenterbridging', array('ccb_can_show' => 1))->result_array();
            foreach ($f as $key => $value) {
                 $cusMobile = substr($value['ccb_callerNumber'], -10);

                 $reg = $this->db->like('vreg_cust_phone', $cusMobile, 'both')->get('cpnl_register_master')->result_array();
                 $enq = $this->db->like('enq_cus_mobile', $cusMobile, 'both')->get('cpnl_enquiry')->result_array();
                 echo '---';
                 if (!empty($reg) || !empty($eng)) {
                      //debug($reg, 0);
                      //debug($enq, 0);
                      debug($value, 0);
                      echo '<br>===================================<br>';
                 }
            }
       }

       function assign() {

            $f = $this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
                            ->where(array('ccb_misd_old' => 1, 'ccb_can_show' => 1))
                            ->group_by('ccb_opt_ph')->get('cpnl_callcenterbridging')->result_array();

            debug($f);


            $limit = 168;

            $f = $this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
                            ->where(array('ccb_misd_old' => 1, 'ccb_can_show' => 1))->limit($limit, 0)
                            ->group_by('ccb_opt_ph')->get('cpnl_callcenterbridging')->result_array();

            foreach ($f as $key => $value) {
                 $this->db->where('ccb_id', $value['ccb_id'])->update('cpnl_callcenterbridging', array('ccb_force_assign' => 36));
            }

            $f = $this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
                            ->where(array('ccb_misd_old' => 1, 'ccb_can_show' => 1))->limit($limit, $limit + 1)
                            ->group_by('ccb_opt_ph')->get('cpnl_callcenterbridging')->result_array();

            foreach ($f as $key => $value) {
                 $this->db->where('ccb_id', $value['ccb_id'])->update('cpnl_callcenterbridging', array('ccb_force_assign' => 54));
            }

            $f = $this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
                            ->where(array('ccb_misd_old' => 1, 'ccb_can_show' => 1))->limit($limit, $limit + $limit + 1)
                            ->group_by('ccb_opt_ph')->get('cpnl_callcenterbridging')->result_array();

            foreach ($f as $key => $value) {
                 $this->db->where('ccb_id', $value['ccb_id'])->update('cpnl_callcenterbridging', array('ccb_force_assign' => 56));
            }

            $f = $this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
                            ->where(array('ccb_misd_old' => 1, 'ccb_can_show' => 1))->limit($limit, $limit + $limit + $limit + 1)
                            ->group_by('ccb_opt_ph')->get('cpnl_callcenterbridging')->result_array();

            foreach ($f as $key => $value) {
                 $this->db->where('ccb_id', $value['ccb_id'])->update('cpnl_callcenterbridging', array('ccb_force_assign' => 59));
            }

            $f = $this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
                            ->where(array('ccb_misd_old' => 1, 'ccb_can_show' => 1))->limit($limit, $limit + $limit + $limit + $limit + 1)
                            ->group_by('ccb_opt_ph')->get('cpnl_callcenterbridging')->result_array();

            foreach ($f as $key => $value) {
                 $this->db->where('ccb_id', $value['ccb_id'])->update('cpnl_callcenterbridging', array('ccb_force_assign' => 61));
            }
       }

       function follcmd() {
            $f = $this->db->query('SELECT * FROM `cpnl_followup` WHERE `cpnl_followup`.`foll_is_cmnt` = 1')->result_array();
            if ($f) {
                 foreach ($f as $key => $value) {
                      $enqDetails = $this->db->select('enq_se_id')->get_where('cpnl_enquiry', array('enq_id' => $value['foll_cus_id']))->row_array();
                      $salesStaff = isset($enqDetails['enq_se_id']) ? $enqDetails['enq_se_id'] : 0;

                      $this->db->insert('cpnl_followup_view_log', array(
                          'fvl_enq_id' => $value['foll_cus_id'],
                          'fvl_foll_id' => $value['foll_id'],
                          'fvl_sales_staff' => $salesStaff,
                          'fvl_read_by' => 0,
                          'fvl_read_on' => null
                      ));
                 }
            }
       }

       function quickFolWarm() {
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $this->tbl_followup = TABLE_PREFIX . 'followup';

            $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', array(1, 2));
            $this->db->where("DATE(" . $this->tbl_enquiry . ".enq_next_foll_date) < DATE('2020-06-30')");
            $this->db->where($this->tbl_enquiry . '.is_exe', 0);
            $ArrSelect = array(
                $this->tbl_enquiry . '.enq_cus_name',
                $this->tbl_enquiry . '.enq_id',
                $this->tbl_enquiry . '.enq_cus_mobile',
                $this->tbl_enquiry . '.enq_next_foll_date',
                $this->tbl_enquiry . '.enq_cus_whatsapp',
                $this->tbl_enquiry . '.enq_cus_when_buy',
                $this->tbl_enquiry . '.enq_mode_enq'
            );

            $return = $this->db->select($ArrSelect)->order_by('enq_next_foll_date', 'DESC')->get($this->tbl_enquiry)->result_array();

            if (!empty($return)) {
                 foreach ($return as $key => $value) {
                      $lastFollup = $this->db->select('foll_id, foll_cus_id, foll_status')->order_by('foll_id', 'DESC')
                                      ->where('foll_cus_id', $value['enq_id'])
                                      ->where('foll_status != 0 AND foll_is_cmnt = 0')->limit(1)->get($this->tbl_followup)->row_array();

                      if (!empty($lastFollup) && isset($lastFollup['foll_id'])) {
                           $this->db->where('foll_id', $lastFollup['foll_id'])->update($this->tbl_followup, array('foll_status' => 3));
                      }

                      $this->db->where('enq_id', $value['enq_id'])->update($this->tbl_enquiry, array('enq_cus_when_buy' => 3));

                      $foll = array(
                          'foll_cus_id' => $value['enq_id'],
                          'foll_entry_date' => date('Y-m-d h:i:s'),
                          'foll_status' => 3,
                          'foll_remarks' => 'Quickly changed hot and hot plus followup statuses on next followup date before june 2020, set inquiry and followup statuses are same',
                          'foll_added_by' => ADMIN_ID,
                          'foll_updated_by' => ADMIN_ID,
                          'foll_is_cmnt' => 1
                      );

                      $this->db->insert('cpnl_followup', $foll);
                      $folId = $this->db->insert_id();
                      $value['new_foll_id'] = $folId;
                      generate_log(array(
                          'log_title' => 'Bulk hot hot plus inquies changed to warm',
                          'log_desc' => serialize($value),
                          'log_controller' => 'quk-chg-follstatus-warm-with-folow',
                          'log_action' => 'C',
                          'log_ref_id' => $value['enq_id'],
                          'log_added_by' => 100
                      ));
                      $this->db->where('enq_id', $value['enq_id'])->update($this->tbl_enquiry, array('is_exe' => 1));
                 }
            }
       }

       function quickAssignDropedCases() {
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $enq = $this->db->select('enq_id, enq_current_status, enq_se_id')->order_by('enq_id', 'DESC')->limit(200, 200)
                            ->get_where($this->tbl_enquiry, array('enq_current_status' => 3))->result_array();

            foreach ((array) $enq as $inqKey => $value) {
                 $vehicleDetails = $this->db->query("SELECT GROUP_CONCAT( IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , "
                                 . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title) , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
                                 . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
                                 . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
                                 . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
                                 . "WHERE cpnl_vehicle.veh_enq_id = " . $value['enq_id'])->row_array();

                 $veh = isset($vehicleDetails['vehicle']) ? $vehicleDetails['vehicle'] : '';

                 $f = $this->db->get_where('cpnl_quick_tc_report', array('qtr_enq_id' => $value['enq_id']))->row_array();
                 if (empty($f)) {
                      $this->db->insert('cpnl_quick_tc_report', array(
                          'qtr_enq_id' => $value['enq_id'],
                          'qtr_se_id' => $value['enq_se_id'],
                          'qtr_assigned_to' => 342,
                          'qtr_vehile' => $veh,
                          'qtr_assigned_by' => $this->uid,
                          'qtr_assigned_on' => date('Y-m-d h:i:s')
                      ));

                      generate_log(array(
                          'log_title' => 'Quick assign droped cases',
                          'log_desc' => serialize($value),
                          'log_controller' => 'quk-assign-droped-cases',
                          'log_action' => 'C',
                          'log_ref_id' => $value['enq_id'],
                          'log_added_by' => $this->uid
                      ));

                      array(
                          'enh_status' => 1,
                          'enh_enq_id' => $value['enq_se_id'],
                          'enh_added_by' => $this->uid,
                          'enh_added_on' => date('Y-m-d h:i:s'),
                          'enh_remarks' => 'Quickly assign dropped cases to ibina for only call them',
                          'enh_current_sales_executive' => 342,
                      );
                 }
            }
            debug($enq);
       }

       function updateStatus() {

            /* $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
              $this->tbl_followup = TABLE_PREFIX . 'followup';
              $f = $this->db->select($this->tbl_followup . '.foll_id, ' . $this->tbl_followup . '.foll_cus_id, foll_status,' . $this->tbl_enquiry . '.enq_cus_when_buy')
              ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
              ->order_by($this->tbl_followup . '.foll_id', 'DESC')
              ->where($this->tbl_followup . '.foll_status', 0)->get($this->tbl_followup)->result_array();
              foreach ($f as $key => $value) {
              $this->db->where('foll_id', $value['foll_id'])
              ->update($this->tbl_followup, array('foll_status' => $value['enq_cus_when_buy']));
              } */

            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $this->tbl_followup = TABLE_PREFIX . 'followup';

            try {
                 $enq = $this->db->order_by('enq_id', 'DESC')->select('enq_id, enq_cus_when_buy')
                                 ->get_where($this->tbl_enquiry, array('is_exe' => 0))->limit(100)->result_array();
            } catch (Exception $exc) {
                 echo $exc->getTraceAsString();
                 exit;
            }
            exit;

            /* foreach ($enq as $key => $value) {
              $follow = $this->db->select('foll_id, foll_cus_id, foll_status')->order_by('foll_id', 'DESC')
              ->where('foll_cus_id', $value['enq_id'])
              ->where('foll_status != 0 AND foll_is_cmnt = 0')->limit(1)->get($this->tbl_followup)->row_array();

              if ($value['enq_cus_when_buy'] != $follow['foll_status']) {
              echo 'Diffrent : ' . $value['enq_cus_when_buy'] . '-' . $follow['foll_status'] . '<br>';
              debug($follow, 0);
              $this->db->where('enq_id', $value['enq_id'])
              ->update($this->tbl_enquiry, array('is_exe' => 1, 'enq_cus_when_buy' => $follow['foll_status']));
              } else {
              echo $value['enq_cus_when_buy'] . '-' . $follow['foll_status'] . '<br>';
              }
              } */
       }

       function checkFoll() {
            $f = $this->db->query("SELECT distinct(log_ref_id) FROM `cpnl_general_log` WHERE `log_controller` LIKE '%update-foll-date-enq%' AND `log_added_by` = 36")
                    ->result_array();

            foreach ($f as $key => $value) {
                 $fol = $this->db->query("SELECT enq_se_id FROM `cpnl_enquiry` WHERE `enq_id` = " . $value['log_ref_id'])->row_array();
                 if ($fol['enq_se_id'] != 36) {
                      echo 'Log Enq id : ' . $value['log_ref_id'] . '-' . $fol['enq_se_id'] . '<br>';
                      $enqDetsil = $this->db->select('enq_id, enq_se_id')->get_where('cpnl_enquiry', array('enq_id' => $value['log_ref_id']))->result_array();
                      if (!empty($enqDetsil)) {
                           debug($enqDetsil, 0);
                      }
                      echo '<br>----<br>';
                 }
            }
       }

       function crosschecksrom() {
            $f = $this->db->select('cpnl_enquiry.enq_id, cpnl_enquiry.enq_se_id, cpnl_enquiry.enq_showroom_id, '
                                    . 'cpnl_users.usr_id, cpnl_users.usr_showroom, cpnl_users.usr_username')
                            ->join('cpnl_users', 'cpnl_users.usr_id = cpnl_enquiry.enq_se_id')->get('cpnl_enquiry')->result_array();

            foreach ($f as $key => $value) {
                 if ($value['enq_showroom_id'] != $value['usr_showroom']) {
                      $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('enq_showroom_id' => $value['usr_showroom']));
                      echo $this->db->last_query() . '<br>';
                 }
            }
            debug($f);
       }

       function outDatingInsurance() {
            $this->common_model->outDatingInsurance();
       }

       function vehicleno() {
            $f = $this->db->select('val_id, val_veh_no')->where("val_veh_no != ''")
//                            ->where('val_prt_1 IS NULL AND val_prt_2 IS NULL AND val_prt_3 IS NULL AND val_prt_4 IS NULL')
                            ->get('cpnl_valuation')->result_array();
            foreach ($f as $key => $value) {
                 $num = str_replace(' ', '-', trim($value['val_veh_no']));
                 $vehNo = explode('-', $value['val_veh_no']);
                 if (count($vehNo) <= 1) {
                      $vehNo = explode(' ', $value['val_veh_no']);
                 }
                 $update = array(
                     'val_veh_no' => strtoupper(trim($num)),
                     'val_prt_1' => isset($vehNo['0']) ? strtoupper(trim($vehNo['0'])) : '',
                     'val_prt_2' => isset($vehNo['1']) ? trim($vehNo['1']) : '',
                     'val_prt_3' => isset($vehNo['2']) ? strtoupper(trim($vehNo['2'])) : '',
                     'val_prt_4' => isset($vehNo['3']) ? trim($vehNo['3']) : ''
                 );
                 $this->db->where('val_id', $value['val_id'])->update('cpnl_valuation', $update);
            }
       }

       function setlastfollowup() {
            $f = $this->db->select('cpnl_enquiry.enq_id, cpnl_enquiry.enq_se_id, cpnl_enquiry.enq_showroom_id')->get('cpnl_enquiry')->result_array();
            foreach ($f as $key => $value) {
                 $f[$key]['fol_added_by'] = $this->db->select('foll_added_by')->order_by('foll_id', 'DESC')
                                 ->get_where('cpnl_followup', array('foll_cus_id' => $value['enq_id']))->row()->foll_added_by;
            }
            debug($f);
       }

       function getcalltimeout() {
            $f = $this->db->select("ccb_id, ccb_callDate, ccb_punched_on, ccb_callStatus_id, ccb_authorized_person, "
                                    . "TIMESTAMPDIFF(MINUTE, ccb_callDate, vreg_first_added_on) AS minutediff, DATEDIFF(ccb_callDate, vreg_first_added_on) AS diffdays, "
                                    . " cpnl_register_master.vreg_first_added_on", false)
                            ->join('cpnl_register_master', 'cpnl_register_master.vreg_id = cpnl_callcenterbridging.ccb_register_ref', 'LEFT')
                            ->where('ccb_callStatus_id != ' . VB_CONNECTED . " AND ccb_callDate != ''" . " AND ccb_authorized_person_id > 0")
                            ->where("(DATE(cpnl_callcenterbridging.ccb_callDate) >= DATE('2020-11-01 09:00:00') AND "
                                    . "DATE(cpnl_callcenterbridging.ccb_callDate) <= DATE('2020-11-30 18:00:00'))")
                            ->get('cpnl_callcenterbridging')->result_array();

            //echo $this->db->last_query();
            $dummy = array();
            foreach ($f as $key => $value) {
                 $dummy[$value['ccb_authorized_person']][] = $value['minutediff'];
            }
            debug($dummy, 0);
            debug($f);
       }

       function needToPurchase() {
            $f = "SELECT *  FROM cpnl_register_master WHERE vreg_assigned_to = 561 AND vreg_added_by = 56 AND vreg_id != 25648";
            $ff = $this->db->query($f)->result_array();

            foreach ($ff as $key => $value) {
                 $this->db->where('vreg_id', $value['vreg_id'])->update('cpnl_register_master', array(
                     'vreg_department' => 8,
                     'vreg_assigned_to' => 0
                 ));
                 $this->db->insert('cpnl_register_history', array(
                     'regh_register_master' => $value['vreg_id'],
                     'regh_assigned_to' => 0,
                     'regh_assigned_by' => $value['vreg_first_owner'],
                     'regh_added_date' => date('Y-m-d H:i:s'),
                     'regh_added_by' => ADMIN_ID,
                     'regh_remarks' => $value['vreg_customer_remark'],
                     'regh_system_cmd' => 'Admin re-assigned set of purchase inquiry to athulya after discussion coo, purchase mgr, jk, athulya'
                 ));
                 generate_log(array(
                     'log_title' => 'Quick assign purchase inquiry',
                     'log_desc' => serialize($value),
                     'log_controller' => 'quk-assign-purchase-inquiry',
                     'log_action' => 'C',
                     'log_ref_id' => $value['vreg_id'],
                     'log_added_by' => $this->uid
                 ));
            }
            debug($ff);
       }

       function telereport() {
          //Y-M-D
          echo 'Here';exit;
          $dataFrom = '2021-08-01';
          $dataTo = '2021-08-31';
          $data = array();
          echo $dataFrom . ' - ' . $dataTo . '<br>';
          echo '<br><b>Total calls end in cre machine</b></br>';
          while (strtotime($dataFrom) <= strtotime($dataTo)) {
               $weekday = date("D", strtotime($dataFrom));
               if(strtolower($weekday) != 'sun') {
                    $d = $this->db->query("SELECT ccb_authorized_person_id, COUNT(*) AS cnt FROM `cpnl_callcenterbridging` WHERE (ccb_callDate >= '" . 
                    $dataFrom . " 9:00:00' AND ccb_callDate <= '" . $dataFrom . " 18:00:00') AND ccb_callStatus_id > 0 GROUP BY ccb_authorized_person_id")->result_array();
                    foreach ($d as $key => $value) {
                         $data[$value['ccb_authorized_person_id']] = $data[$value['ccb_authorized_person_id']] + $value['cnt'];
                    }
               }
               $dataFrom = date("Y-m-d", strtotime("+1 day", strtotime($dataFrom)));
          }
          foreach ($data as $key => $value) {
               if($value > 0) {
                    echo $this->db->get_where('cpnl_users', array('usr_id' => $key))->row()->usr_first_name . ' - ' . $value . '<br>';
               }
          }

          $dataFrom = '2021-08-01';
          $dataTo = '2021-08-31';
          $data = array();

          echo '<br><b>Connected only in cre machine</b></br>';
          while (strtotime($dataFrom) <= strtotime($dataTo)) {
               $weekday = date("D", strtotime($dataFrom));
               if(strtolower($weekday) != 'sun') {
                    $d = $this->db->query("SELECT ccb_authorized_person_id, COUNT(*) AS cnt FROM `cpnl_callcenterbridging` WHERE (ccb_callDate >= '" . 
                    $dataFrom . " 9:00:00' AND ccb_callDate <= '" . $dataFrom . " 18:00:00') AND ccb_callStatus_id = 18 GROUP BY ccb_authorized_person_id")->result_array();

                    foreach ($d as $key => $value) {
                         $data[$value['ccb_authorized_person_id']] = $data[$value['ccb_authorized_person_id']] + $value['cnt'];
                    }
               }
               $dataFrom = date("Y-m-d", strtotime("+1 day", strtotime($dataFrom)));
          }
          foreach ($data as $key => $value) {
               if($value > 0) {
                    echo $this->db->get_where('cpnl_users', array('usr_id' => $key))->row()->usr_first_name . ' - ' . $value . '<br>';
               }
          }

          $dataFrom = '2021-08-01';
          $dataTo = '2021-08-31';
          $data = array();

          echo '<br><b>Call back with in 15 mnts</b></br>';
          while (strtotime($dataFrom) <= strtotime($dataTo)) {
               $weekday = date("D", strtotime($dataFrom));
               if(strtolower($weekday) != 'sun') {
                    $d = $this->db->query("SELECT ccb_authorized_person_id, COUNT(*) AS cnt FROM `cpnl_callcenterbridging` WHERE (ccb_callDate >= '" .
                                   $dataFrom . " 9:00:00' AND ccb_callDate <= '" . $dataFrom . " 18:00:00') AND (ccb_callStatus_id != 18 AND ccb_callStatus_id > 0) AND ccb_punch_time <= 15"
                                   . " GROUP BY ccb_authorized_person_id")->result_array();
                    foreach ($d as $key => $value) {
                         $data[$value['ccb_authorized_person_id']] = $data[$value['ccb_authorized_person_id']] + $value['cnt'];
                    }
               }
               $dataFrom = date("Y-m-d", strtotime("+1 day", strtotime($dataFrom)));
            }
          foreach ($data as $key => $value) {
               if($value > 0) {
                    echo $this->db->get_where('cpnl_users', array('usr_id' => $key))->row()->usr_first_name . ' - ' . $value . '<br>';
               }
          }
          exit;
       }

       function quickassign1() {
          //. ' + 10 days'
          $nextFolDate = date('Y-m-d H:i:s');
          $nextFolDate = date('Y-m-d H:i:s', strtotime($nextFolDate));
          //echo $nextFolDate;exit;
            $enquiry = $this->db->limit(10)->get_where('cpnl_enquiry', array('enq_se_id' => 51, 'enq_current_status' => 1, 'is_exe' => 0))->result_array();
            debug($enquiry);
            foreach ($enquiry as $key => $enq) {
                 $fol =  $this->db->order_by('foll_id', 'DESC')->limit(1)->get_where('cpnl_followup', array('foll_cus_id' => $enq['enq_id']))->row_array();

                 if(!empty($fol)) {
                    //Update enquiry
                    $this->db->where('enq_id', $enq['enq_id'])->update('cpnl_enquiry', array(
                         'enq_se_id' => 569, 'is_exe' => 1, 'enq_next_foll_date' => $nextFolDate)); // Anas khan

                    //Insert new followup
                    $foll = array(
                         'foll_cus_id' => $enq['enq_id'],
                         'foll_showroom' => 0,
                         'foll_sales_staff' => '',
                         'foll_cus_vehicle_id' => $fol['foll_cus_vehicle_id'],
                         'foll_entry_date' => date('Y-m-d H:i:s'),
                         'foll_status' => $fol['foll_status'],
                         'foll_remarks' => 'Enquiry reassigned from midhun to anas khan',
                         'foll_can_show_all' => 0,
                         'foll_customer_feedback_added_date' => date('Y-m-d H:i:s'),
                         'foll_contact' => $fol['foll_contact'],
                         'foll_action_plan' => $fol['foll_action_plan'],
                         'foll_next_foll_date' => $nextFolDate,
                         'foll_added_by' => ADMIN_ID,
                         'foll_updated_by' => 0,
                         'foll_is_dar_submited' => 0,
                         'foll_is_cmnt' => 0
                    );
                    //Reset new followup on enquiry

                    //Enquiry history
                 }
            }
       }

       function reassignresignedstaffenq() {
          //. ' + 10 days'
          exit;
          //Reset
          //$this->db->where('is_exe', 1)->update('cpnl_enquiry', array('enq_se_id' => 51, 'is_exe' => 0)); // Anas khan
          //exit;
          //debug(count($this->db->get_where('cpnl_enquiry', array('enq_se_id' => 717, 'is_exe' => 0, 'enq_current_status' => 1))->result_array()));

          $fr = 856;//Danish
          $to = 697;//
          $count = 73;
          
          $toName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $to))->row()->usr_username;
          $frName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $fr))->row()->usr_username;

          $nextFolDate = date('Y-m-d H:i:s');
          $nextFolDate = date('Y-m-d H:i:s', strtotime($nextFolDate. ' + 3 days'));
          
          $enquiry = $this->db->query("SELECT `cpnl_enquiry`.`enq_id`, `cpnl_enquiry`.`enq_next_foll_date`, `cpnl_enquiry`.`enq_added_by`, `cpnl_enquiry`.`enq_cus_name`, 
                                   `cpnl_enquiry`.`enq_cus_mobile`, `cpnl_enquiry`.`enq_cus_whatsapp`, `cpnl_enquiry`.`enq_entry_date`, `cpnl_enquiry`.`enq_added_by`, 
                                   `cpnl_enquiry`.`enq_se_id`, `cpnl_enquiry`.`enq_mode_enq`, `cpnl_users`.`usr_id`, `cpnl_users`.`usr_first_name`, 
                                   `enqaddedby`.`usr_first_name` AS enq_added_by_name, `enqaddedby`.`usr_id` AS enq_added_by_id 
                                   FROM (`cpnl_enquiry`) 
                                   LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_enquiry`.`enq_se_id` 
                                   LEFT JOIN `cpnl_users` enqaddedby ON `enqaddedby`.`usr_id` = `cpnl_enquiry`.`enq_added_by` 
                                   WHERE `cpnl_enquiry`.`enq_se_id` = " . $fr . " AND `cpnl_enquiry`.`enq_current_status` IN (1, 15, 14) 
                                   AND (DATEDIFF(DATE(cpnl_enquiry.enq_next_foll_date), DATE('2022-07-01')) <= -3) 
                                   AND DATE(cpnl_enquiry.enq_entry_date) < DATE('2022-05-01') LIMIT " . $count)->result_array();
          
          //echo $frName . ' - ' . $toName . '<br>';
          //debug($enquiry);
          
          if(!empty($enquiry)) {
            foreach ($enquiry as $key => $enq) {

                 generate_log(array(
                    'log_title' => 'Quick assign enquiry ' . $frName . ' to ' . $toName,
                    'log_desc' => serialize($enq),
                    'log_controller' => 'quk-assign-inquiry-' . $frName . '-' . $toName,
                    'log_action' => 'C',
                    'log_ref_id' => $enq['enq_id'],
                    'log_added_by' => $this->uid
                 ));
                 
                 $fol =  $this->db->order_by('foll_id', 'DESC')->limit(1)->get_where('cpnl_followup', array('foll_cus_id' => $enq['enq_id']))->row_array();
                 if(!empty($fol)) {

                    //Comment
                    $comment = $frName . "'s " . ' enquires reassigned to  ' . $toName . ', suggested by Ummerali';
                    $follCmd['foll_remarks'] = $comment;
                    $follCmd['foll_cus_id'] = $enq['enq_id'];
                    $follCmd['foll_parent'] = 0;
                    $follCmd['foll_cus_vehicle_id'] = 0;
                    $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                    $follCmd['foll_customer_feedback'] = '';
                    $follCmd['foll_can_show_all'] = 1;
                    $follCmd['foll_contact'] = 0;
                    $follCmd['foll_action_plan'] = '';
                    $follCmd['foll_added_by'] = $this->uid;
                    $follCmd['foll_updated_by'] = $this->uid;
                    $follCmd['foll_is_dar_submited'] = 0;
                    $follCmd['foll_is_cmnt'] = 1;
                    $this->db->insert('cpnl_followup', $follCmd);

                    //Insert new followup
                    $foll = array(
                         'foll_cus_id' => $enq['enq_id'],
                         'foll_showroom' => 4,
                         'foll_sales_staff' => $to,
                         'foll_cus_vehicle_id' => $fol['foll_cus_vehicle_id'],
                         'foll_entry_date' => date('Y-m-d H:i:s'),
                         'foll_status' => $fol['foll_status'],
                         'foll_remarks' => $frName . "'s enquires reassigned to " . $toName,
                         'foll_can_show_all' => 0,
                         'foll_customer_feedback_added_date' => date('Y-m-d H:i:s'),
                         'foll_contact' => $fol['foll_contact'],
                         'foll_action_plan' => $fol['foll_action_plan'],
                         'foll_next_foll_date' => $nextFolDate,
                         'foll_added_by' => $this->uid,
                         'foll_updated_by' => 0,
                         'foll_is_dar_submited' => 0,
                         'foll_is_cmnt' => 0
                    );
                    $this->db->insert('cpnl_followup', $foll);
                    //Reset new followup on enquiry

                    //Enquiry history
                    $enqHtry = array(
                         'enh_enq_id' => $enq['enq_id'],
                         'enh_current_sales_executive' => $to,
                         'enh_status' => 1,
                         'enh_remarks' => 'Missed followup enquiries of sales officer ' . $frName . ' quickly assigned to tele caller ' . $toName . ', due to resignation of ' . $frName
                    );

                    $this->db->insert('cpnl_enquiry_history', $enqHtry);
                    $hisId = $this->db->insert_id();
                    
                    //Update enquiry
                    $this->db->where('enq_id', $enq['enq_id'])->update('cpnl_enquiry', array(
                         'enq_last_viewd' => $to, 'enq_se_id' => $to, 'is_exe' => 1, 'enq_next_foll_date' => $nextFolDate, 'enq_current_status_history' => $hisId));
                 } else {
                      echo 'Empty followup : ' . $enq['enq_id'] . '<br>';
                 }
            }
            echo $count . ' enquires assign from ' . $frName . ' to ' . $toName;
          } else {
               echo 'Empty';
          }
       }

       function evelationPending() {
            
            $f = $this->db->query("SELECT enq_id FROM `cpnl_enquiry` WHERE (DATE(enq_entry_date) >= DATE('2021-01-01') AND DATE(enq_entry_date) <= DATE('2021-02-03')) AND enq_cus_status = 2")->result_array();

            echo $this->db->last_query();
            debug($f);
       }

       function getReturned() {

          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
            $selectArray = array(
                'cpnl_register_master.vreg_cust_name',
                'cpnl_register_master.vreg_cust_place',
                'cpnl_register_master.vreg_cust_phone',
                'cpnl_register_master.vreg_customer_remark',
                'cpnl_register_master.vreg_last_action',
                'cpnl_register_master.vreg_added_by',
                'cpnl_register_master.vreg_assigned_to',
                'cpnl_register_master.vreg_inquiry',
                'cpnl_register_master.vreg_id',
                'cpnl_register_master.vreg_added_on',
                'assign.usr_first_name AS assign_usr_first_name',
                'assign.usr_last_name AS assign_usr_last_name',
                'addedby.usr_first_name AS addedby_usr_first_name',
                'addedby.usr_last_name AS addedby_usr_last_name',
                'cpnl_enquiry.enq_current_status'
            );
            $this->db->where_in('cpnl_register_master.vreg_status', $this->myRegStatuses);
            $this->db->where('(cpnl_enquiry.enq_current_status NOT IN (' . $enqExclude . ') OR ' . 'cpnl_enquiry.enq_current_status IS NULL)');
            $return['pendingRegisters'] = $this->db->select('vreg_assigned_to, COUNT(*)', false)
                            ->join('cpnl_users assign', 'assign.usr_id = ' . 'cpnl_register_master.vreg_assigned_to', 'LEFT')
                            ->join('cpnl_users addedby', 'addedby.usr_id = ' . 'cpnl_register_master.vreg_added_by', 'LEFT')
                            ->join('cpnl_enquiry', 'cpnl_enquiry.enq_id = ' . 'cpnl_register_master.vreg_inquiry', 'LEFT')
                            ->where_in('vreg_assigned_to', array(54,56,61))->where('(vreg_is_punched = 0)')
//                            ->where('MONTH(' . $this->tbl_register_master . '.vreg_added_on) = MONTH(CURRENT_DATE())')
                            //->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
                            ->group_by('vreg_assigned_to')->get('cpnl_register_master')->result_array();
            echo $this->db->last_query();
            debug($return, 0);
          /* */

          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $setc = $this->emp_details->teleCallers();
          foreach ($setc as $key => $value) {
               $f = $this->db->select('vreg_cust_name, vreg_first_owner, vreg_added_by, vreg_assigned_to, vreg_last_action, vreg_inquiry')
                ->join('cpnl_enquiry', 'cpnl_enquiry.enq_id = ' . 'cpnl_register_master.vreg_inquiry', 'LEFT')
                               ->where('vreg_assigned_to', $value['col_id'])
                               //->where('vreg_first_owner = vreg_assigned_to')->where_in('vreg_department', array(4, 6, 7, 8))
                               ->where('vreg_is_punched', 0)
                               ->where('(cpnl_enquiry.enq_current_status NOT IN (' . $enqExclude . ') OR ' . 'cpnl_enquiry.enq_current_status IS NULL)')
                               ->where_in('cpnl_register_master.vreg_status', $this->myRegStatuses)
                               ->get('cpnl_register_master')->result_array();;
               echo $value['col_title'] . ' - ' . count($f) . '<br>';
               //debug($f);
          }
          exit;
          //Sales staff and Telecaller

          echo $this->db->last_query();
          debug($f);
     }

     function telecaldar() {

          //Athullya
          echo 'Athullya';
          $owner = 56;
          $dateFrom = "'2021-03-01'";
          $dateTo = "'2021-03-31'";
          $darMaster = $this->db->select('darm_id, darm_added_on')->where(array('darm_added_by' => $owner))
                    ->where('DATE(darm_added_on) BETWEEN ' . $dateFrom . ' AND ' . $dateTo)->get('cpnl_dar_master')->result_array();
          $data = array();
          foreach ($darMaster as $key => $value) {
               $data['enq_count'] = $data['enq_count'] + $this->db->where(array('dare_master' => $value['darm_id']))->count_all_results('cpnl_dar_enquiry');
               $data['fol_count'] = $data['fol_count'] + $this->db->where(array('darf_master' => $value['darm_id']))->count_all_results('cpnl_dar_followup');
               $data['reg_count'] = $data['reg_count'] + $this->db->where(array('dvr_master' => $value['darm_id']))->count_all_results('cpnl_dar_veh_register');
               $data['reg_fol_count'] = $data['reg_fol_count'] + $this->db->where(array('darrf_dar_master' => $value['darm_id']))->count_all_results('cpnl_dar_reg_followup');
          }
          debug($data, 0);

          //Silpa
          echo 'Shilpa';
          $owner = 61;
          $dateFrom = "'2021-03-01'";
          $dateTo = "'2021-03-31'";
          $darMaster = $this->db->select('darm_id, darm_added_on')->where(array('darm_added_by' => $owner))
                    ->where('DATE(darm_added_on) BETWEEN ' . $dateFrom . ' AND ' . $dateTo)->get('cpnl_dar_master')->result_array();
          $data = array();
          foreach ($darMaster as $key => $value) {
               $data['enq_count'] = $data['enq_count'] + $this->db->where(array('dare_master' => $value['darm_id']))->count_all_results('cpnl_dar_enquiry');
               $data['fol_count'] = $data['fol_count'] + $this->db->where(array('darf_master' => $value['darm_id']))->count_all_results('cpnl_dar_followup');
               $data['reg_count'] = $data['reg_count'] + $this->db->where(array('dvr_master' => $value['darm_id']))->count_all_results('cpnl_dar_veh_register');
               $data['reg_fol_count'] = $data['reg_fol_count'] + $this->db->where(array('darrf_dar_master' => $value['darm_id']))->count_all_results('cpnl_dar_reg_followup');
          }
          debug($data, 0);

          //Aswathi
          echo 'Aswathi';
          $owner = 54;
          $dateFrom = "'2021-03-01'";
          $dateTo = "'2021-03-31'";
          $darMaster = $this->db->select('darm_id, darm_added_on')->where(array('darm_added_by' => $owner))
                    ->where('DATE(darm_added_on) BETWEEN ' . $dateFrom . ' AND ' . $dateTo)->get('cpnl_dar_master')->result_array();
          $data = array();
          foreach ($darMaster as $key => $value) {
               $data['enq_count'] = $data['enq_count'] + $this->db->where(array('dare_master' => $value['darm_id']))->count_all_results('cpnl_dar_enquiry');
               $data['fol_count'] = $data['fol_count'] + $this->db->where(array('darf_master' => $value['darm_id']))->count_all_results('cpnl_dar_followup');
               $data['reg_count'] = $data['reg_count'] + $this->db->where(array('dvr_master' => $value['darm_id']))->count_all_results('cpnl_dar_veh_register');
               $data['reg_fol_count'] = $data['reg_fol_count'] + $this->db->where(array('darrf_dar_master' => $value['darm_id']))->count_all_results('cpnl_dar_reg_followup');
          }
          debug($data);
     }

     function dropreqtodrop() {
          $reqfordropenq = $this->db->select('enq_id')->limit(1)->get_where('cpnl_enquiry', array('enq_current_status' => 2, 'is_exe'  => 0))->result_array();
          debug($reqfordropenq);

          foreach ($reqfordropenq as $key => $value) {
               $data['vst_enq_id'] = $value['enq_id'];
               $data['vst_status'] = 3;
               $data['vst_remarks'] = 'Bulk enquires for request for drop are moved as drop';
               $data['enh_added_by'] = $this->uid;

               if ($this->db->insert('cpnl_enquiry_history', $data)) {
                    $enqHistoryId = $this->db->insert_id();
                    
                    /* Folowup comment */
                    $curStatus = $this->db->get_where('cpnl_statuses', array('sts_value' => $data['enh_status']))->row_array();
                    $selectArray = array(
                        'cpnl_enquiry.enq_se_id',
                        'cpnl_enquiry.enq_cus_name',
                        'cpnl_enquiry.enq_cus_mobile',
                        'cpnl_users.usr_first_name'
                    );

                    $enqdetails = $this->db->select($selectArray)->join('cpnl_users', 'cpnl_users.usr_id = ' . 'cpnl_enquiry.enq_se_id', 'LEFT')
                                    ->get_where('cpnl_enquiry', array('enq_id' => $data['enh_enq_id']))->row_array();

                    $salesStaffName = isset($enqdetails['usr_first_name']) ? $enqdetails['usr_first_name'] : '';
                    $custName = isset($enqdetails['enq_cus_name']) ? $enqdetails['enq_cus_name'] : '';
                    $curStatusName = isset($curStatus['sts_des']) ? $curStatus['sts_des'] : '';

                    $comment = $salesStaffName . "'s " . ' customer ' . $custName . ' enquiry status has been changed to ' . $curStatusName .
                            ', satus changed by ' . $this->session->userdata('usr_username');

                    $follCmd['foll_remarks'] = $comment;
                    $follCmd['foll_cus_id'] = $data['enh_enq_id'];
                    $follCmd['foll_parent'] = 0;
                    $follCmd['foll_cus_vehicle_id'] = 0;
                    $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                    $follCmd['foll_customer_feedback'] = '';
                    $follCmd['foll_can_show_all'] = 1;
                    $follCmd['foll_contact'] = 0;
                    $follCmd['foll_action_plan'] = '';
                    $follCmd['foll_added_by'] = $this->uid;
                    $follCmd['foll_updated_by'] = $this->uid;
                    $follCmd['foll_is_dar_submited'] = 0;
                    $follCmd['foll_is_cmnt'] = 1;
                    $this->db->insert('cpnl_followup', $follCmd);

                    $enUpdate = array(
                        'enq_current_status' => $data['enh_status'],
                        'enq_current_status_history' => $enqHistoryId
                    );

                    if ($data['enh_status'] == loss_of_sale_or_buy || $data['enh_status'] == enq_lost ||
                            $data['enh_status'] == enq_req_drop || $data['enh_status'] == enq_droped) {
                         // To cold
                         $enUpdate = array(
                             'enq_current_status' => $data['enh_status'],
                             //'enq_cus_when_buy' => 4,
                             'enq_current_status_history' => $enqHistoryId
                         );
                    }
                    $this->db->where('enq_id', $data['enh_enq_id']);
                    $this->db->update('cpnl_enquiry', $enUpdate);
                    generate_log(array(
                        'log_title' => 'Change enquiry status',
                        'log_desc' => 'Status has been changed',
                        'log_controller' => strtolower(__CLASS__),
                        'log_action' => 'C',
                        'log_ref_id' => $enqHistoryId,
                        'log_added_by' => $this->uid
                    ));
                    return true;
               }
          }
     }

     

     function reassigndropped() {
          $datefrom = '2021-04-01';
          $dateto = '2021-04-30';

          $f = $this->db->select('enq_id, enq_se_id, enq_cus_name, enq_cus_mobile, enq_current_status, '
                  . 'cpnl_enquiry_history.enh_added_by, cpnl_enquiry_history.enh_added_on')
                  ->join('cpnl_enquiry_history', 'cpnl_enquiry_history.enh_id = cpnl_enquiry.enq_current_status_history', 'LEFT')
                  ->where("(DATE(cpnl_enquiry_history.enh_added_on) >= DATE('".$datefrom."') AND DATE(cpnl_enquiry_history.enh_added_on) <= DATE('".$dateto."'))")
                  ->get_where('cpnl_enquiry', array('enq_current_status' => 2, 'enq_showroom_id' => 2))->result_array();
          if(!empty($f)) {
               $this->db->insert('cpnl_quick_tc_report_master', array(
                         'qtrm_title' => 'Request for drop on 01-Aril-2021 to 30-Aril-2021 assigned aswathi for tele out',
                         'qtrm_added_by' => 100,
                         'qtrm_added_on' => date('Y-m-d H:i:s'),
                         'qtrm_assign_to' => serialize(array(54))
               ));
               $masterId = $this->db->insert_id();

               foreach ($f as $key => $value) {

                    $vehicleDetails = $this->db->query("SELECT GROUP_CONCAT( IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , "
                                         . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title) , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
                                         . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
                                         . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
                                         . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
                                         . "WHERE cpnl_vehicle.veh_enq_id = " . $value['enq_id'])->row_array();

                    $veh = isset($vehicleDetails['vehicle']) ? $vehicleDetails['vehicle'] : '';

                    $this->db->insert('cpnl_quick_tc_report', array(
                         'qtr_master_id' => $masterId,
                         'qtr_enq_id' => $value['enq_id'],
                         'qtr_se_id' => $value['enq_se_id'],
                         'qtr_assigned_to' => 54,
                         'qtr_assigned_by' => '100',
                         'qtr_vehile' => $veh,
                         'qtr_assigned_on' => date('Y-m-d H:i:s')
                    ));     
               }
          }
          debug($f);
     }

     function resignedstaffenq() {
          $ekmenq = $this->db->select('cpnl_enquiry.enq_id, cpnl_enquiry.enq_se_id, cpnl_enquiry.enq_cus_name, cpnl_enquiry.enq_cus_mobile, 
                                        cpnl_enquiry.enq_location, cpnl_enquiry.enq_cus_dist, cpnl_enquiry.enq_current_status, cpnl_users.usr_username,
                                        cpnl_district_statewise.std_district_name')
                         ->join('cpnl_users', 'cpnl_users.usr_id = cpnl_enquiry.enq_se_id', 'LEFT')
                         ->join('cpnl_district_statewise', 'cpnl_district_statewise.std_id = cpnl_enquiry.enq_cus_dist', 'LEFT')
                         ->where(array('cpnl_users.usr_active' => 0, 'cpnl_users.usr_showroom' => 2))->where_in('cpnl_enquiry.enq_cus_dist', array(12,6,1,11,7,3,13))
                         ->where('cpnl_enquiry.is_exe', 0)->get('cpnl_enquiry')->result_array();
          echo $this->db->last_query(); 
          debug($ekmenq);
     }

     function alldropped() {
          //exit;
          //597 - Arjun
          //582 - Rahul
          $executive = array(597, 582);

          /* Master */
          /*$this->db->insert('cpnl_quick_tc_report_master', array(
              'qtrm_desc' => "we had been decided to dropped and resigned staff's enquiries are assigned by the district",
              'qtrm_title' => 'Reassigned dropped enquires district wise',
              'qtrm_added_by' => $this->uid,
              'qtrm_added_on' => date('Y-m-d H:i:s'),
              'qtrm_assign_to' => serialize(array(597))
          ));*/
          $this->db->insert_id();
          $masterid = 39;
          generate_log(array(
              'log_title' => 'Quick enquiry assigned master',
              'log_desc' => 597,
              'log_controller' => 'quick-assign-master',
              'log_action' => 'C',
              'log_ref_id' => $masterid,
              'log_added_by' => $this->uid
          ));
          /* Master */

          $inq  = $this->db->select('cpnl_enquiry.enq_id, cpnl_enquiry.enq_se_id, cpnl_enquiry.enq_cus_name, cpnl_enquiry.enq_cus_mobile, 
                                        cpnl_enquiry.enq_location, cpnl_enquiry.enq_cus_dist, cpnl_enquiry.enq_current_status, cpnl_users.usr_username,
                                        cpnl_district_statewise.std_district_name')
                         ->join('cpnl_users', 'cpnl_users.usr_id = cpnl_enquiry.enq_se_id', 'LEFT')
                         ->join('cpnl_district_statewise', 'cpnl_district_statewise.std_id = cpnl_enquiry.enq_cus_dist', 'LEFT')
                         ->where(array('cpnl_users.usr_active' => 0, 'cpnl_users.usr_showroom' => 2))->where_in('cpnl_enquiry.enq_cus_dist', array(12,6,1,11,7,3,13))
                         ->where('cpnl_enquiry.is_exe', 0)->get('cpnl_enquiry')->result_array();

          foreach ((array) $inq as $inqKey => $value) {
               $vehicleDetails = $this->db->query("SELECT GROUP_CONCAT( IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , "
                                           . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title) , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
                                           . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
                                           . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
                                           . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
                                           . "WHERE cpnl_vehicle.veh_enq_id = " . $value['enq_id'])->row_array();

               $veh = isset($vehicleDetails['vehicle']) ? $vehicleDetails['vehicle'] : '';

               $this->db->insert('cpnl_quick_tc_report', array(
                               'qtr_master_id' => $masterid,
                               'qtr_enq_id' => $value['enq_id'],
                               'qtr_se_id' => $value['enq_se_id'],
                               'qtr_assigned_to' => 597,
                               'qtr_vehile' => $veh,
                               'qtr_assigned_by' => $this->uid,
                               'qtr_assigned_on' => date('Y-m-d H:i:s')
               ));

               $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('is_exe' => 1));
          }

          echo $this->db->last_query();
          debug($inq);
     }


     function qr() {
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $quickDetails = $this->db->select('cpnl_quick_tc_report.*, cpnl_enquiry.enq_id, enq_se_id, usr_username AS qassignto')
               ->join('cpnl_enquiry','cpnl_enquiry.enq_id = cpnl_quick_tc_report.qtr_enq_id', 'LEFT')
               ->join('cpnl_users','cpnl_users.usr_id = cpnl_quick_tc_report.qtr_assigned_to', 'LEFT')
               ->where_in('qtr_master_id', array(38,39,41))->where('cpnl_quick_tc_report.qtr_reply_by > 0')
               ->where('cpnl_enquiry.enq_id != 5840')->get('cpnl_quick_tc_report')->result_array();
          debug($quickDetails, 0);
          
          foreach ((array) $quickDetails as $inqKey => $value) {
               if($value['enq_se_id'] != $value['qtr_assigned_to']) {
                    $movarr = array(
                         'old_se_id' => $value['qtr_se_id'],
                         'new_se_id' => $value['qtr_assigned_to'],
                         'remark' => $value['qtr_replay'],
                         'enq_id' => $value['qtr_enq_id'],
                         'reassigndby' => $value['qassignto']
                    );

                    $this->enquiry->reassignenquiry($movarr);
                    generate_log(array(
                         'log_title' => 'Reassigned dropped enquires district wise not reassigned to consirn sales staff issue fixed',
                         'log_desc' => serialize($value),
                         'log_controller' => 'quick-assign-master',
                         'log_action' => 'C',
                         'log_ref_id' => $value['qtr_enq_id'],
                         'log_added_by' => $this->uid
                    ));
               }
          }
     }

     function reassignregister() {
          $fr = 575;//Ashraf
          $to = 700;//Hilna
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;

          $toName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $to))->row()->usr_username;
          $frName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $fr))->row()->usr_username;
          
          //$qry = 'SELECT * FROM `cpnl_register_master` WHERE `vreg_assigned_to` = ' . $fr . ' AND vreg_is_punched = 0 AND vreg_inquiry = 0 ORDER BY vreg_id ASC LIMIT 15';
          $data = $this->db->join('cpnl_enquiry', 'cpnl_enquiry.enq_id = cpnl_register_master.vreg_inquiry', 'left')
                         ->where(array('vreg_assigned_to' => $fr, 'vreg_is_punched' => 0, 'vreg_inquiry' => 0))->where("DATE(vreg_added_on) <= '2021-12-31'")
                         ->where_in('vreg_status', $this->myRegStatuses)
                         ->where('(cpnl_enquiry.enq_current_status NOT IN (' . $enqExclude . ') OR cpnl_enquiry.enq_current_status IS NULL)')
                         ->get('cpnl_register_master')->result_array();

          debug($data);
          $narration = "Reassigned some of " . $frName . "'s enquires to " . $toName . ", due to resignation of Pooja, assigned by " . $this->session->userdata('usr_username');
          foreach ((array) $data as $inqKey => $value) {
               $this->db->where('vreg_id', $value['vreg_id'])->update('cpnl_register_master', array('vreg_assigned_to' => $to, 'vreg_added_by' => $this->uid));
               $this->db->insert('cpnl_register_history', array(
                    'regh_phone_num' => $value['vreg_cust_phone'],
                    'regh_register_master' => $value['vreg_id'],
                    'regh_assigned_by' => $this->uid,
                    'regh_assigned_to' => $to,
                    'regh_added_date' => date('Y-m-d H:i:s'),
                    'regh_added_by' => $this->uid,
                    'regh_remarks' => $narration,
                    'regh_system_cmd' => $narration
               ));

               generate_log(array(
                    'log_title' => $narration,
                    'log_desc' => serialize($value),
                    'log_controller' => 'quick-assign-register-master',
                    'log_action' => 'C',
                    'log_ref_id' => $value['vreg_id'],
                    'log_added_by' => $this->uid
               ));
          }
     }

     function procreq() {
          //cua_user_id
          $usrDetails = $this->db->select('cpnl_users.usr_phone')
               ->join('cpnl_users', 'cpnl_users.usr_id = cpnl_user_access.cua_user_id', 'LEFT')
               ->like('cpnl_user_access.cua_access', 'procreq_sms', 'both')->where('usr_active', 1)->get('cpnl_user_access')->result_array();
          $phoneNumbers = !empty($usrDetails) ? implode(',', array_column($usrDetails, 'usr_phone')) : '';

          $sms = "Dear , you have a procurement request for ,please logon to RDMS - Royal Drive South India's Largest Pre-Owned Luxury Car Showroom";
          $tmpId = '1607100000000042909';
          send_sms($sms, $phoneNumbers, 'Procurement request sms', $tmpId);
          debug($phoneNumbers);
     }

     function setstockadded() {
          $data = $this->db->where('pcl_added_by = 0')->get('cpnl_purchase_check_list')->result_array();
          foreach ((array) $data as $inqKey => $value) {
               $log = $this->db->where('log_ref_id', $value['pcl_check_list_id'])
                           ->like('log_controller', 'insert-purchase-check-master', 'both')->get('cpnl_general_log')->row_array();

               $this->db->where('pcl_check_list_id', $value['pcl_check_list_id'])->update('cpnl_purchase_check_list', 
                           array('pcl_added_by' => $log['log_added_by']));
          }
     }

     function enqmodperreport() {

          $qry = "SELECT enq_mode_enq, count(enq_mode_enq) AS cnt FROM `cpnl_enquiry` WHERE `enq_entry_date` BETWEEN '2021-01-01' AND '2021-06-30' GROUP BY enq_mode_enq";
          $data = $this->db->query($qry)->result_array();
          
          $mod = unserialize(MODE_OF_CONTACT);
          $ttl = array_sum(array_column($data, 'cnt')) . '<br>';
          $cnt = 0;
          echo '<table border="1">';
          foreach ((array) $data as $inqKey => $value) {
               echo '<tr>'; 
                    echo '<td>' . $mod[$value['enq_mode_enq']] . '</td><td>' . round(($value['cnt'] * 100) / $ttl, 2) . '</td>';
               echo '</tr>';
          }
          echo '</table>';
     }

     function updateenquirynumber() {
          $enqs = $this->db->select('enq_id')->get_where('cpnl_enquiry', array('enq_number'  => '0'))->result_array();

          if(!empty($enqs)) {
               foreach ($enqs as $key => $value) {
                    $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('enq_number' => generate_vehicle_virtual_id($value['enq_id'])));
               }
          } else {
               echo 'Completed';
          }
     }

     function setRegisterShowrrom() {
          $f = $this->db->query('SELECT `cpnl_register_master`.`vreg_id`,vreg_cust_name, cpnl_users.usr_id, cpnl_users.usr_first_name, cpnl_users.usr_showroom FROM `cpnl_register_master` '.
               'LEFT JOIN cpnl_users ON cpnl_users.usr_id = cpnl_register_master.vreg_first_owner WHERE `vreg_source_branch` = 0')->result_array();
          foreach ((array) $f as $key => $value) {
               if($value['usr_showroom']) {
                    $this->db->where('vreg_id', $value['vreg_id'])->update('cpnl_register_master', array('vreg_source_branch' => $value['usr_showroom']));
               }
          }
          debug($f);
     }

     function evdoc() {
          $f = $this->db->select('val_id, val_document_details')->where('val_document_details IS NOT NULL')->get('cpnl_valuation')->result_array();
          foreach ((array) $f as $key => $value) {
               $this->db->insert('cpnl_valuation_doc_history', array(
                    'vdh_val_id' => $value['val_id'],
                    'vdh_cmd' => $value['val_document_details'],
                    'vdh_done_by_admin' => 1
               ));
          }
     }
     function getdelloc() {
          $numbers = array(
               8606251004,
8129900444,
8089930776,
9895955555,
9995206116,
8086931808,
9846482723,
8888889885,
9946022670,
8157817416,
7358824581,
8157902902,
9946442409,
9447929292,
7558892888,
9447328888,
9847002401,
7356421840,
9495233230,
9120042004,
7306130051,
8943784818,
7736179895,
9895358888,
7736729220,
9544839003,
8888889885,
9048467008,
7025461111,
9061707233,
9400703010,
9747221111,
9745203326,
9447166586,
9495137258,
9946777722,
9744850000,
9447322251);
          $id = array();          
          foreach ((array) $numbers as $key => $value) {
                 
               $callerNumber = substr($value, -10);
               $enquiry = $this->db->select('enq_id, enq_cus_mobile, enq_location, enq_cus_dist_old, enq_cus_city, cpnl_district_statewise.std_district_name, cpnl_city.cit_name')
                               ->join('cpnl_district_statewise', 'cpnl_district_statewise.std_id = cpnl_enquiry.enq_cus_dist', 'LEFT')

                               ->join('cpnl_city', 'cpnl_city.cit_id = cpnl_enquiry.enq_cus_city', 'LEFT')

                               ->like('enq_cus_mobile', $callerNumber, 'both')->get('cpnl_enquiry')->row_array();
                               if($enquiry['enq_id']) {
                                   $id[] = $enquiry['enq_id'];
                               }
          }

          $this->db->select('enq_id, enq_cus_mobile, enq_location, enq_cus_dist_old, enq_cus_city, cpnl_district_statewise.std_district_name, cpnl_city.cit_name')
                               ->join('cpnl_district_statewise', 'cpnl_district_statewise.std_id = cpnl_enquiry.enq_cus_dist', 'LEFT')
                               ->join('cpnl_city', 'cpnl_city.cit_id = cpnl_enquiry.enq_cus_city', 'LEFT')
                               ->where_in('enq_id', $id)->get('cpnl_enquiry')->result_array();
          echo $this->db->last_query();                     

          debug($id);
     }

     function postpondfollowup() {
          $fr = 555;
          
          $frName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $fr))->row()->usr_username;

          $nextFolDate = date('2021-12-28 00:00:00');
          // $nextFolDate = date('Y-m-d H:i:s', strtotime($nextFolDate. ' + 10 days'));
          
          $enquiry = $this->db->query("SELECT `cpnl_enquiry`.`enq_id`, `cpnl_enquiry`.`enq_next_foll_date`, `cpnl_enquiry`.`enq_added_by`, `cpnl_enquiry`.`enq_cus_name`, `cpnl_enquiry`.`enq_cus_mobile`, `cpnl_enquiry`.`enq_cus_whatsapp`, `cpnl_enquiry`.`enq_entry_date`, `cpnl_enquiry`.`enq_added_by`, `cpnl_enquiry`.`enq_se_id`, `cpnl_enquiry`.`enq_mode_enq`, `cpnl_users`.`usr_id`, `cpnl_users`.`usr_first_name`, `enqaddedby`.`usr_first_name` AS enq_added_by_name, `enqaddedby`.`usr_id` AS enq_added_by_id FROM (`cpnl_enquiry`) LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_enquiry`.`enq_se_id` LEFT JOIN `cpnl_users` enqaddedby ON `enqaddedby`.`usr_id` = `cpnl_enquiry`.`enq_added_by` WHERE `cpnl_enquiry`.`enq_se_id` = 555 AND `cpnl_enquiry`.`enq_current_status` IN (1, 15, 14) AND (DATEDIFF(DATE(cpnl_enquiry.enq_next_foll_date), DATE('2021-12-11')) <= -3) ORDER BY `cpnl_enquiry`.`enq_next_foll_date` DESC")->result_array();                
          
          //echo $frName;
          debug($enquiry);

          if(!empty($enquiry)) {
            foreach ($enquiry as $key => $enq) {

               generate_log(array(
                    'log_title' => 'Postponed missed followup of ' . $frName,
                    'log_desc' => serialize($enq),
                    'log_controller' => 'postponed-missed-followup',
                    'log_action' => 'C',
                    'log_ref_id' => $enq['enq_id'],
                    'log_added_by' => $this->uid
               ));
                 
                 $fol =  $this->db->order_by('foll_id', 'DESC')->limit(1)->get_where('cpnl_followup', array('foll_cus_id' => $enq['enq_id']))->row_array();
                 if(!empty($fol)) {

                    //Insert new followup
                    $foll = array(
                         'foll_cus_id' => $enq['enq_id'],
                         'foll_showroom' => 0,
                         'foll_sales_staff' => $fr,
                         'foll_cus_vehicle_id' => $fol['foll_cus_vehicle_id'],
                         'foll_entry_date' => date('Y-m-d H:i:s'),
                         'foll_status' => $fol['foll_status'],
                         'foll_remarks' => "Abhishek's missed followup postponed to 2021-12-28",
                         'foll_can_show_all' => 0,
                         'foll_customer_feedback_added_date' => date('Y-m-d H:i:s'),
                         'foll_contact' => $fol['foll_contact'],
                         'foll_action_plan' => $fol['foll_action_plan'],
                         'foll_next_foll_date' => $nextFolDate,
                         'foll_added_by' => ADMIN_ID,
                         'foll_updated_by' => 0,
                         'foll_is_dar_submited' => 0,
                         'foll_is_cmnt' => 0
                    );
                    $this->db->insert('cpnl_followup', $foll);
                    //Reset new followup on enquiry

                    //Enquiry history
                    $enqHtry = array(
                         'enh_enq_id' => $enq['enq_id'],
                         'enh_current_sales_executive' => $fr,
                         'enh_status' => 1,
                         'enh_remarks' => "Abhishek's missed followup postponed to 2021-12-28, current sale staff " . $frName
                    );

                    $this->db->insert('cpnl_enquiry_history', $enqHtry);
                    $hisId = $this->db->insert_id();
                    
                    //Update enquiry
                    $this->db->where('enq_id', $enq['enq_id'])->update('cpnl_enquiry', array('is_exe' => 1, 'enq_next_foll_date' => $nextFolDate, 
                                     'enq_current_status_history' => $hisId));
                 } else {
                      echo 'Empty followup : ' . $enq['enq_id'] . '<br>';
                 }
            }
          } else {
               echo 'Empty';
          }
     }

     function newev() {
          error_reporting(E_ALL);
          $this->tbl_valuation = 'cpnl_valuation';
          $this->tbl_valuation_features = 'cpnl_valuation_features';
          $this->tbl_valuation_ful_bd_chkup = 'cpnl_valuation_ful_bd_chkup';
          $this->tbl_valuation_upgrade_details = 'cpnl_valuation_upgrade_details';
          
          $datamaster = unserialize('a:8:{s:9:"valuation";a:134:{s:12:"val_division";s:1:"1";s:17:"val_sales_officer";s:3:"843";s:12:"val_showroom";s:1:"1";s:18:"val_valuation_date";s:10:"22-09-2022";s:13:"val_evaluator";s:3:"843";s:12:"val_location";s:0:"";s:11:"val_manager";s:3:"835";s:11:"val_in_time";s:8:"03:05 PM";s:12:"val_out_time";s:8:"04:08 PM";s:7:"val_mis";s:3:"641";s:9:"val_delco";s:3:"951";s:13:"val_cust_name";s:15:"MOHAMMED JILVAS";s:14:"val_cust_phone";s:10:"9563332299";s:14:"val_cust_email";s:0:"";s:8:"val_type";s:1:"1";s:15:"val_cust_source";s:1:"0";s:13:"val_reference";s:6:"SABEEL";s:17:"val_refferal_type";s:1:"1";s:17:"val_refferer_name";s:0:"";s:21:"val_first_dlvry_state";s:7:"KERALLA";s:23:"val_first_dlvry_dlrship";s:0:"";s:24:"val_first_dlvry_location";s:0:"";s:9:"val_admin";s:3:"900";s:18:"val_purchase_admin";s:3:"883";s:11:"val_apm_asm";s:1:"0";s:15:"val_tele_caller";s:1:"0";s:7:"val_tsc";s:3:"670";s:12:"val_rc_owner";s:15:"MOHAMMED JILVAS";s:9:"val_prt_1";s:2:"KL";s:9:"val_prt_2";s:2:"86";s:9:"val_prt_3";s:0:"";s:9:"val_prt_4";s:4:"4777";s:9:"val_brand";s:2:"34";s:9:"val_model";s:3:"188";s:11:"val_variant";s:4:"1825";s:13:"val_delv_date";s:0:"";s:8:"val_fuel";s:1:"1";s:12:"val_reg_date";s:10:"12-03-2022";s:9:"val_color";s:11:"CANDY WHITE";s:14:"val_model_year";s:4:"2021";s:14:"val_minif_year";s:4:"2021";s:6:"val_km";s:5:"21564";s:6:"val_ac";s:1:"2";s:11:"val_ac_zone";s:1:"1";s:15:"val_no_of_owner";s:1:"1";s:10:"val_eng_cc";s:3:"999";s:16:"val_transmission";s:1:"2";s:12:"val_veh_type";s:1:"7";s:15:"val_no_of_seats";s:1:"5";s:13:"val_engine_no";s:9:"DSH018803";s:13:"val_chasis_no";s:17:"MEXA21600MT122610";s:23:"val_insurance_comp_date";s:10:"15-02-2023";s:22:"val_insurance_comp_idv";s:6:"910000";s:21:"val_insurance_ll_date";s:0:"";s:20:"val_insurance_ll_idv";s:0:"";s:13:"val_insurance";s:1:"0";s:21:"val_insurance_company";s:0:"";s:13:"val_hypo_bank";s:0:"";s:20:"val_hypo_bank_branch";s:0:"";s:17:"val_hypo_loan_amt";s:0:"";s:18:"val_hypo_loan_date";s:0:"";s:19:"val_hypo_frclos_val";s:0:"";s:20:"val_hypo_frclos_date";s:0:"";s:18:"val_hypo_daily_int";s:0:"";s:22:"val_hypo_loan_end_date";s:0:"";s:18:"val_finance_remark";s:0:"";s:12:"val_air_bags";s:1:"4";s:11:"val_exhaust";s:1:"1";s:12:"val_no_of_pw";s:1:"4";s:9:"val_wrnty";s:1:"0";s:16:"val_last_service";s:10:"30-03-2022";s:19:"val_last_service_km";s:5:"15298";s:18:"val_wrnty_validity";s:0:"";s:12:"val_wrnty_km";s:0:"";s:15:"val_wrnty_extra";s:1:"1";s:25:"val_wrnty_service_req_aod";s:0:"";s:22:"val_wrnty_act_serv_aod";s:0:"";s:21:"val_ex_wrnty_validity";s:10:"01-01-2025";s:15:"val_ex_wrnty_km";s:0:"";s:15:"val_ser_package";s:1:"0";s:24:"val_wrnty_spl_ser_observ";s:0:"";s:22:"val_wrnty_nxt_ser_date";s:0:"";s:20:"val_wrnty_nxt_ser_km";s:0:"";s:23:"val_acc_history_remarks";s:0:"";s:21:"val_wrnty_ser_remarks";s:31:"ENGIN ECM MODEFIKASHAN MODIFADE";s:18:"val_next_serv_days";s:0:"";s:18:"val_next_serv_date";s:10:"30-03-2023";s:16:"val_next_serv_km";s:5:"30298";s:7:"val_pfr";s:2:"OK";s:7:"val_gws";s:2:"20";s:7:"val_pfl";s:2:"OK";s:7:"val_grg";s:2:"20";s:7:"val_pcr";s:2:"OK";s:8:"val_gdgr";s:2:"20";s:7:"val_pcl";s:2:"OK";s:9:"val_gdgls";s:2:"20";s:7:"val_prr";s:2:"OK";s:7:"val_qgr";s:2:"20";s:7:"val_prl";s:2:"OK";s:7:"val_qgi";s:2:"20";s:14:"val_tyre_2_wek";s:0:"";s:14:"val_tyre_2_yer";s:4:"2020";s:10:"val_tyre_2";s:2:"50";s:14:"val_tyre_1_wek";s:0:"";s:14:"val_tyre_1_yer";s:4:"2020";s:10:"val_tyre_1";s:2:"50";s:14:"val_tyre_4_wek";s:0:"";s:14:"val_tyre_4_yer";s:4:"2020";s:10:"val_tyre_4";s:2:"50";s:14:"val_tyre_3_wek";s:0:"";s:14:"val_tyre_3_yer";s:4:"2020";s:10:"val_tyre_3";s:2:"50";s:14:"val_tyre_5_wek";s:0:"";s:14:"val_tyre_5_yer";s:4:"2020";s:10:"val_tyre_5";s:2:"95";s:14:"val_tyre_6_wek";s:0:"";s:14:"val_tyre_6_yer";s:0:"";s:10:"val_tyre_6";s:0:"";s:16:"val_battery_make";s:0:"";s:16:"val_battery_year";s:0:"";s:16:"val_battery_desc";s:0:"";s:22:"val_struct_observation";s:0:"";s:12:"val_adj_cond";s:0:"";s:24:"val_suspt_purchase_price";s:7:"1070000";s:24:"val_suspt_price_road_tax";s:0:"";s:21:"val_new_vehicle_price";s:0:"";s:20:"val_price_market_est";s:0:"";s:15:"val_refurb_cost";s:5:"10000";s:14:"val_adj_ond_pm";s:0:"";s:10:"val_profit";s:0:"";s:18:"val_trade_in_price";s:0:"";s:18:"val_rfresh_job_did";s:0:"";s:20:"val_document_details";s:7:"FULL OK";s:11:"val_remarks";s:0:"";}s:8:"features";a:17:{i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";i:5;s:1:"5";i:6;s:1:"6";i:7;s:1:"7";i:16;s:2:"16";i:17;s:2:"17";i:18;s:2:"18";i:24;s:2:"24";i:31;s:2:"31";i:32;s:2:"32";i:33;s:2:"33";i:34;s:2:"34";i:35;s:2:"35";i:36;s:2:"36";}s:8:"fulbdchk";a:24:{i:1;s:1:"1";i:2;s:1:"5";i:3;s:1:"9";i:4;s:2:"13";i:5;s:2:"17";i:6;s:2:"21";i:7;s:2:"25";i:8;s:2:"32";i:9;s:2:"33";i:10;s:2:"37";i:20;s:2:"77";i:12;s:2:"45";i:11;s:2:"41";i:13;s:2:"49";i:15;s:2:"57";i:14;s:2:"56";i:17;s:2:"65";i:16;s:2:"61";i:19;s:2:"73";i:18;s:2:"69";i:21;s:2:"81";i:22;s:2:"85";i:23;s:2:"89";i:24;s:2:"93";}s:14:"upgradedetails";a:2:{s:9:"upgrd_key";a:2:{i:0;s:13:"RH-R-DOR DANT";i:1;s:51:"F-BUMBER CORNAR PAINTING AND REYARE BUMBER PAINTING";}s:11:"upgrd_value";a:2:{i:0;s:4:"5000";i:1;s:4:"5000";}}s:15:"complaint_title";a:1:{i:0;s:0:"";}s:14:"document_title";a:1:{i:0;s:0:"";}s:13:"document_type";a:1:{i:0;s:1:"1";}s:6:"eveimg";a:13:{s:7:"frame_1";s:0:"";s:7:"frame_2";s:0:"";s:7:"frame_3";s:0:"";s:7:"frame_4";s:0:"";s:7:"frame_5";s:0:"";s:7:"frame_6";s:0:"";s:7:"frame_7";s:0:"";s:7:"frame_8";s:0:"";s:7:"frame_9";s:0:"";s:8:"frame_10";s:0:"";s:8:"frame_11";s:0:"";s:8:"frame_12";s:0:"";s:8:"frame_13";s:0:"";}}');
          $data = $datamaster['valuation'];
          $features = $datamaster['features'];
          $fulbdchk = $datamaster['fulbdchk'];
          $upgradedetails = $datamaster['upgradedetails'];
          //debug($datamaster);
          if (!empty($data)) {
                 $this->db->db_debug = false;
                 foreach ($data as $key => $value) {
                      if (empty($data[$key])) {
                           unset($data[$key]);
                      }
                 }
                 $data['val_added_by'] = $this->uid;
                 $data['val_showroom'] = (isset($data['val_showroom']) && !empty($data['val_showroom'])) ?
                         $data['val_showroom'] : get_logged_user('usr_showroom');

                 $data['val_delv_date'] = (isset($data['val_delv_date']) && !empty($data['val_delv_date'])) ? date('Y-m-d', strtotime($data['val_delv_date'])) : NULL;
                 $data['val_reg_date'] = (isset($data['val_reg_date']) && !empty($data['val_reg_date'])) ? date('Y-m-d', strtotime($data['val_reg_date'])) : NULL;
                 $data['val_insurance_validity'] = (isset($data['val_insurance_validity']) && !empty($data['val_insurance_validity'])) ? date('Y-m-d', strtotime($data['val_insurance_validity'])) : NULL;
                 $data['val_last_service'] = (isset($data['val_last_service']) && !empty($data['val_last_service'])) ? date('Y-m-d', strtotime($data['val_last_service'])) : NULL;
                 $data['val_manf_date'] = (isset($data['val_manf_date']) && !empty($data['val_manf_date'])) ? date('Y-m-d', strtotime($data['val_manf_date'])) : NULL;
                 $data['val_valuation_date'] = (isset($data['val_valuation_date']) && !empty($data['val_valuation_date'])) ? date('Y-m-d', strtotime($data['val_valuation_date'])) : NULL;
                 $data['val_hypo_loan_date'] = (isset($data['val_hypo_loan_date']) && !empty($data['val_hypo_loan_date'])) ? date('Y-m-d', strtotime($data['val_hypo_loan_date'])) : NULL;
                 $data['val_hypo_frclos_date'] = (isset($data['val_hypo_frclos_date']) && !empty($data['val_hypo_frclos_date'])) ? date('Y-m-d', strtotime($data['val_hypo_frclos_date'])) : NULL;
                 $data['val_hypo_loan_end_date'] = (isset($data['val_hypo_loan_end_date']) && !empty($data['val_hypo_loan_end_date'])) ? date('Y-m-d', strtotime($data['val_hypo_loan_end_date'])) : NULL;
                 $data['val_insurance_comp_date'] = (isset($data['val_insurance_comp_date']) && !empty($data['val_insurance_comp_date'])) ? date('Y-m-d', strtotime($data['val_insurance_comp_date'])) : NULL;
                 $data['val_insurance_ll_date'] = (isset($data['val_insurance_ll_date']) && !empty($data['val_insurance_ll_date'])) ? date('Y-m-d', strtotime($data['val_insurance_ll_date'])) : NULL;
                 $data['val_ex_wrnty_validity'] = (isset($data['val_ex_wrnty_validity']) && !empty($data['val_ex_wrnty_validity'])) ? date('Y-m-d', strtotime($data['val_ex_wrnty_validity'])) : NULL;
                 $data['val_wrnty_nxt_ser_date'] = (isset($data['val_wrnty_nxt_ser_date']) && !empty($data['val_wrnty_nxt_ser_date'])) ? date('Y-m-d', strtotime($data['val_wrnty_nxt_ser_date'])) : NULL;
                 $data['val_next_serv_date'] = (isset($data['val_next_serv_date']) && !empty($data['val_next_serv_date'])) ? date('Y-m-d', strtotime($data['val_next_serv_date'])) : NULL;
                 $data['val_prt_1'] = (isset($data['val_prt_1']) && !empty($data['val_prt_1'])) ? $data['val_prt_1'] : '';
                 $data['val_prt_2'] = (isset($data['val_prt_2']) && !empty($data['val_prt_2'])) ? $data['val_prt_2'] : '';
                 $data['val_prt_3'] = (isset($data['val_prt_3']) && !empty($data['val_prt_3'])) ? $data['val_prt_3'] : '';
                 $data['val_prt_4'] = (isset($data['val_prt_4']) && !empty($data['val_prt_4'])) ? $data['val_prt_4'] : '';
                 $data['val_veh_no'] = strtoupper($data['val_prt_1']) . '-' . $data['val_prt_2'] . '-' . strtoupper($data['val_prt_3']) . '-' . $data['val_prt_4'];
                 $data['val_top_up_loan'] = isset($data['val_top_up_loan']) ? 1 : 0;
                 $data['val_battery_warranty'] = isset($data['val_battery_warranty']) ? 1 : 0;
                 $this->db->insert($this->tbl_valuation, array_filter($data));
                 echo $this->db->last_query();
                 $id = $this->db->insert_id();
                 
                 foreach ($features as $key => $fet) {
                    $this->db->insert($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vfet_feature' => $fet));   
                 }

                 foreach ($fulbdchk as $key => $value) {
                    $this->db->insert($this->tbl_valuation_ful_bd_chkup, array('vfbc_valuation_master' => $id, 'vfbc_chkup_master' => $key, 'vfbc_chkup_details' => $value));
                 }

                 if (!empty($upgradedetails)) {
                    $count = count($upgradedetails);
                    for ($i = 0; $i < $count; $i++) {
                         $upgrKey = isset($upgradedetails['upgrd_key'][$i]) ? $upgradedetails['upgrd_key'][$i] : 0;
                         $upgrVal = isset($upgradedetails['upgrd_value'][$i]) ? $upgradedetails['upgrd_value'][$i] : 0;
                         $this->db->insert($this->tbl_valuation_upgrade_details, array(
                              'upgrd_master_id' => $id, 'upgrd_key' => $upgrKey, 'upgrd_value' => $upgrVal
                         ));
                    }
                 }
                 echo 'Success id : ' . $id;
            } 
      }

      function registerReassign() {
          $qry = "SELECT cpnl_register_master.*, assign.usr_first_name AS assign_usr_first_name, assign.usr_last_name AS assign_usr_last_name, addedby.usr_first_name AS addedby_usr_first_name, addedby.usr_last_name AS addedby_usr_last_name, exstse.usr_username AS exstse_usr_username, cpnl_events.evnt_title, rana_brand.brd_id, rana_brand.brd_title, rana_model.mod_id, rana_model.mod_title, rana_variant.var_id, rana_variant.var_variant_name, cpnl_enquiry.enq_current_status, cpnl_callcenterbridging.ccb_recording_URL, cpnl_callcenterbridging.ccb_callStatus_id, cpnl_departments.dep_name, cpnl_district_statewise.* FROM (`cpnl_register_master`) LEFT JOIN `cpnl_users` assign ON `assign`.`usr_id` = `cpnl_register_master`.`vreg_assigned_to` LEFT JOIN `cpnl_users` addedby ON `addedby`.`usr_id` = `cpnl_register_master`.`vreg_added_by` LEFT JOIN `cpnl_events` ON `cpnl_events`.`evnt_id` = `cpnl_register_master`.`vreg_event` LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_register_master`.`vreg_brand` LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_register_master`.`vreg_model` LEFT JOIN `cpnl_enquiry` ON `cpnl_enquiry`.`enq_id` = `cpnl_register_master`.`vreg_inquiry` LEFT JOIN `cpnl_users` exstse ON `cpnl_enquiry`.`enq_se_id` = `exstse`.`usr_id` LEFT JOIN `cpnl_callcenterbridging` ON `cpnl_callcenterbridging`.`ccb_id` = `cpnl_register_master`.`vreg_voxbay_ref` LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_register_master`.`vreg_varient` LEFT JOIN `cpnl_departments` ON `cpnl_departments`.`dep_id` = `cpnl_register_master`.`vreg_department` LEFT JOIN `cpnl_district_statewise` ON `cpnl_district_statewise`.`std_id` = `cpnl_register_master`.`vreg_district` WHERE `vreg_assigned_to` = '336' AND `vreg_is_punched` = 0 AND (cpnl_enquiry.enq_current_status NOT IN (4,6,2) OR cpnl_enquiry.enq_current_status IS NULL) AND `cpnl_register_master`.`vreg_status` IN (0, 1) AND `vreg_added_on` <= DATE('2021-12-31')";
          $rehmanEnquires =  $this->db->query($qry);          
          debug($rehmanEnquires);
      }

      function ramya() {
           //$f = $this->db->query("SELECT * FROM `cpnl_enquiry_history` WHERE `enh_remarks` 
           //LIKE 'All enquiries of sales officer Ramya Manoj quickly assigned to another sales officer Ambily C S, due to redesignated of Ramya Manoj' AND enh_enq_id != 2674")->result_array();
           
           $f = $this->db->select('enq_id')->where('enq_se_id', 804)->where_in('enq_current_status', $this->myEnqStatuses)->get('cpnl_enquiry')->result_array();
           
           foreach ($f as $key => $value) {

               $fol =  $this->db->order_by('foll_id', 'DESC')->get_where('cpnl_followup', array('foll_cus_id' => $value['enq_id']))->result_array();
               
               if(isset($fol[0]['foll_next_foll_date'])) {
                    $this->db->where('enq_id', $value['enq_id'])->update('cpnl_enquiry', array('enq_next_foll_date' => $fol[0]['foll_next_foll_date']));
               }


               /*error_reporting(E_ALL);
               $fol =  $this->db->order_by('foll_id', 'DESC')->get_where('cpnl_followup', array('foll_cus_id' => $value['enh_enq_id'], 'foll_is_cmnt' => 0))->result_array();
               echo $value['enh_enq_id'];
               $latest = $fol[1];
               $latest['foll_sales_staff'] = 804;
               
                    generate_log(array(
                         'log_title' => 'Reassign Remya Manoj enquires to her, due to request of Bava Sir, Manoj Sir',
                         'log_desc' => serialize($value),
                         'log_controller' => 'quk-assign-inquiry-remya',
                         'log_action' => 'C',
                         'log_ref_id' => $value['enh_enq_id'],
                         'log_added_by' => $this->uid
                    ));
               
                    //Comment
                    $comment = 'Reassign Remya Manoj enquires to her, due to request of Bava Sir, Manoj Sir';
                    $follCmd['foll_remarks'] = $comment;
                    $follCmd['foll_cus_id'] = $value['enh_enq_id'];
                    $follCmd['foll_parent'] = 0;
                    $follCmd['foll_cus_vehicle_id'] = 0;
                    $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                    $follCmd['foll_customer_feedback'] = '';
                    $follCmd['foll_can_show_all'] = 1;
                    $follCmd['foll_contact'] = 0;
                    $follCmd['foll_action_plan'] = '';
                    $follCmd['foll_added_by'] = $this->uid;
                    $follCmd['foll_updated_by'] = $this->uid;
                    $follCmd['foll_is_dar_submited'] = 0;
                    $follCmd['foll_is_cmnt'] = 1;
                    $this->db->insert('cpnl_followup', $follCmd);

                    //Insert new followup
                    unset($latest['foll_id']);
                    $this->db->insert('cpnl_followup', $latest);
                    //Reset new followup on enquiry

                    //Enquiry history
                    $enqHtry = array(
                         'enh_enq_id' => $value['enh_enq_id'],
                         'enh_current_sales_executive' => 804,
                         'enh_status' => 1,
                         'enh_remarks' => 'Siyas Sir (SM-Ernakulam) says that to reassign enquires of Noufal,Remya Manoj and Reneesh to Ambili on 05-03-2022'
                    );

                    $this->db->insert('cpnl_enquiry_history', $enqHtry);
                    $hisId = $this->db->insert_id();
                    
                    //Update enquiry
                    $this->db->where('enq_id', $value['enh_enq_id'])->update('cpnl_enquiry', array(
                         'enq_last_viewd' => 804, 'enq_se_id' => 804, 'is_exe' => 1, 'enq_next_foll_date' => $latest['foll_next_foll_date'], 
                         'enq_current_status_history' => $hisId));*/

           }
      }
}