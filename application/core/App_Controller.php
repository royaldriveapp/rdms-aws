<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

/**
 * Base Controller
 *
 */
class App_Controller extends CI_Controller
{

     /**
      * Site Title
      * 
      * @var string
      */
     public $site_title = '';

     /**
      * Page Title
      * 
      * @var string
      */
     public $page_title = '';

     /**
      * Page Meta Keywords
      * 
      * @var string
      */
     public $page_meta_keywords = '';

     /**
      * Page Meta Description
      * 
      * @var string
      */
     public $page_meta_description = '';

     /**
      * JS Calls on DOM Ready
      * 
      * @var array 
      */
     public $js_domready = array();

     /**
      * JS Calls on window load
      * 
      * @var array 
      */
     public $js_windowload = array();

     /**
      * Body classes
      * 
      * @var array 
      */
     public $body_class = array();

     /**
      * Current section
      * 
      * @var string
      */
     public $current_section = '';

     /**
      * User access
      * @var array 
      */
     public $userAccess = '';

     /**
      * Logged user group
      * @var string 
      */
     public $usr_grp = '';

     /**
      * logged user id
      * @var int 
      */
     public $uid = '';

     /**
      * Class Constructor
      */
     public function __construct()
     {
          // Call Parent Constructor
          parent::__construct();

          // Site Page Title
          $this->site_title = $this->config->item('app_title');

          // Initialize array with assets we use site wide
          $this->assets_css = array();
          $this->assets_js = array();

          $this->template->set('is_frontend', true);

          //$this->output->enable_profiler(TRUE);
          $this->template->set('controller', strtolower($this->router->fetch_class()));
          $this->template->set('method', strtolower($this->router->fetch_method()));
          $this->usr_grp = $this->session->userdata('grp_slug');
          $this->uid = $this->session->userdata('usr_user_id');
          $this->shrm = $this->session->userdata('usr_showroom');
          $this->grp_id = $this->session->userdata('grp_id');
          $this->div = $this->session->userdata('usr_division');
          $this->desi = $this->session->userdata('desig_slug');
          $this->desi_id = $this->session->userdata('desig_id');

          /* If user logged in */
          $logedUserDetails = $this->session->userdata('gtech_logged_user');
          if (!empty($logedUserDetails)) {
               $this->template->set('logged_username', $logedUserDetails['first_name']);
               $this->template->set('logged_uid', $logedUserDetails['id']);

               // analytics counts
               $analytics = $this->common_model->analytics();
               $this->template->set('analytics', $analytics);
          }
          /**/
          //if (strtolower($this->router->fetch_class()) != 'user') {
          if (strtolower($this->router->fetch_class()) != 'user' && strtolower($this->router->fetch_class()) != 'rdms') {
               $this->lock_in();
          }

          if ($this->uid != 0) {
               $this->userAccess = $this->common_model->getUser($this->session->userdata('usr_user_id'));
               $this->userAccess = isset($this->userAccess['cua_access']) ? $this->userAccess['cua_access'] : '';
               //$this->userAccess = isset($this->userAccess['rol_access']) ? $this->userAccess['rol_access'] : ''; jsk//
               if (!$this->check_permission($this->router->fetch_class(), $this->router->fetch_method())) {
                    if (strtolower($this->router->fetch_class()) != 'user_permission' && strtolower($this->router->fetch_method()) != 'access_denied') {
                         redirect('user_permission/access_denied');
                    }
               }
          }
          //Which status are shown as my inquiry
          $this->myEnqStatuses = array(1, assign_to_other_staff, inquiry_reopened);
          //Which status are shown as my register
          $this->myRegStatuses = array(reg_new_register, reg_alrd_inq_punched);

          /**
           * 14 - CRE
           * 18 - Sales Consultant
           * 37 - Admin and Hostess
           * 43 - Telesales Coordinator
           * 59 - Tele Purchase Coordinator
           */
          $this->mandatory = json_decode('{
               "fields":[
               {
                    "d_id": "14",
                    "content": "vreg_division,vreg_showroom,vreg_contact_mode,vreg_entry_date,vreg_cust_name,vreg_cust_phone,vreg_district,vreg_customer_remark"
               },
               {
                    "d_id": "59",
                    "content": "vreg_assigned_to,vreg_customer_remark,vreg_call_type"
               },
               {
                    "d_id": "43",
                    "content": "vreg_assigned_to,vreg_customer_remark,vreg_call_type"
               },
               {
                    "d_id": "37",
                    "content": "vreg_division,vreg_showroom,vreg_contact_mode,vreg_entry_date,vreg_cust_name,vreg_cust_phone,vreg_district,vreg_customer_remark,vreg_call_type"
               },
               {
                    "d_id": "18",
                    "content": "vreg_division,vreg_showroom,vreg_contact_mode,vreg_entry_date,vreg_cust_name,vreg_cust_phone,vreg_district,vreg_customer_remark,vreg_call_type"
               }
               ]
            }', true);
     }

     /**
      * Check user can access particular method in each controller.
      * @param array $access
      * @param string $controller
      * @param string $method
      * @return boolean
      */
     public function check_permission($controller = '', $method = '')
     {
          $access = $this->userAccess;
          if ($this->session->userdata('usr_user_id') == ADMIN_ID) {
               return true;
          }

          $controller = $controller ?: $this->router->fetch_class();
          $method = $method ?: $this->router->fetch_method();

          if (is_serialized($access)) {
               $access = unserialize($access);
          }

          $controller = strtolower(trim($controller));
          $method = strtolower(trim($method));
          $modules_exclude = $this->config->item('modules_exclude');

          if (
               isset($modules_exclude[$controller]) && !empty($modules_exclude[$controller]) &&
               is_array($modules_exclude[$controller]) && key_exists($method, $modules_exclude[$controller])
          ) {
               return true;
          }

          if (!empty($access) && is_array($access)) {

               if (
                    isset($access[$controller]) && !empty($access[$controller]) &&
                    is_array($access[$controller]) && in_array($method, $access[$controller])
               ) {
                    return true;
               } else {
                    return false;
               }
          } else {
               return false;
          }
     }

     /**
      * Prepare BASE Javascript
      */
     private function prepare_base_javascript()
     {
          $str = "<script type=\"text/javascript\">\n";

          if (count($this->js_domready) > 0) {
               $str .= "$(document).ready(function() {\n";
               $str .= implode("\n", $this->js_domready) . "\n";
               $str .= "});\n";
          }

          if (count($this->js_windowload) > 0) {
               $str .= "$(window).load(function() {\n";
               $str .= implode("\n", $this->js_windowload) . "\n";
               $str .= "});\n";
          }

          $str .= "</script>\n";
          $this->template->append_metadata($str);
     }

     /**
      * Set CSS Meta
      */
     private function set_styles()
     {
          if (count($this->assets_css) > 0) {
               foreach ($this->assets_css as $asset)
                    $this->template->append_metadata('<link rel="stylesheet" type="text/css" href="' . $this->config->item('base_url') . 'assets/styles/' . $asset . '" media="screen" />');
          }

          // Webkit based browsers
          //$this->template->append_metadata('<link rel="stylesheet" type="text/css" href="' . $this->config->item('base_url') . 'assets/css/cross_browser/webkit.css" media="screen" />');
          // Internet Explorer styles
          //$this->template->append_metadata('<!--[if IE 6]><link rel="stylesheet" type="text/css" href="' . $this->config->item('base_url') . 'assets/css/cross_browser/ie6.css" media="screen" /><![endif]-->');
          //$this->template->append_metadata('<!--[if IE 7]><link rel="stylesheet" type="text/css" href="' . $this->config->item('base_url') . 'assets/css/cross_browser/ie7.css" media="screen" /><![endif]-->');
          //$this->template->append_metadata('<!--[if IE 8]><link rel="stylesheet" type="text/css" href="' . $this->config->item('base_url') . 'assets/css/cross_browser/ie8.css" media="screen" /><![endif]-->');
          //$this->template->append_metadata('<!--[if IE 9]><link rel="stylesheet" type="text/css" href="' . $this->config->item('base_url') . 'assets/css/cross_browser/ie9.css" media="screen" /><![endif]-->');
     }

     /**
      * Set Javascript Meta
      */
     private function set_javascript()
     {
          if (count($this->assets_js) > 0) {
               foreach ($this->assets_js as $asset)
                    if (stristr($asset, 'http') === FALSE)
                         $this->template->append_metadata('<script type="text/javascript" src="' . $this->config->item('base_url') . 'assets/scripts/' . $asset . '"></script>');
                    else
                         $this->template->append_metadata('<script type="text/javascript" src="' . $asset . '"></script>');
          }

          //$this->template->append_metadata('<!--[if lt IE 9]><script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->');
     }

     /**
      * Locks in controller and/or methods
      */
     public function lock_in()
     {
          if (!$this->ion_auth->logged_in()) {
               $this->session->set_flashdata('app_error', 'Please log in first.');
               redirect('user/login');
          }
     }

     /**
      * Make sure user is admin
      */
     public function admins_only()
     {
          // Make sure user is logged in
          if (!$this->ion_auth->logged_in())
               redirect('admin/login');

          if (!$this->ion_auth->in_group('admin')) {
               $this->session->set_flashdata('app_error', 'Please log in first.');
               redirect('dashboard');
          }
     }

     /**
      * Renders page
      */
     public function render_page($page, $data = array())
     {
          // Renders the whole page
          $this->template
               ->set_metadata('keywords', $this->page_meta_keywords)
               ->set_metadata('description', $this->page_meta_description)
               ->set_metadata('canonical', site_url($this->uri->uri_string()), 'link')
               ->title($this->page_title, $this->site_title);

          $this->set_styles();
          $this->set_javascript();
          $this->prepare_base_javascript();

          // Set global template vars
          $this->template
               ->set('current_section', $this->current_section)
               ->set('user_logged_in', $this->ion_auth->logged_in())
               ->set('body_class', implode(' ', $this->body_class));

          $this->template
               ->set_partial('flash_messages', 'partials/flash_messages')
               ->set_partial('header', 'partials/header')
               ->set_partial('footer', 'partials/footer')
               ->set_partial('rdms_footer', 'partials/rdms_footer');

          // Renders the main layout
          $this->template->build($page, $data);
     }
}
