<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class blog extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->load->model('blog_model', 'blog');
            $this->load->library('pagination');
       }

       function index($page = 0) {
            
            $data['anasiz'] = $this->blog->getBlogAnalisiz();
            if (isset($_GET['ci'])) {
                 $data['blog'] = $this->blog->getBlog(encryptor($_GET['ci'], 'D'));
                 $this->render_page(strtolower(__CLASS__) . '/detail', $data);
            } else {
                 
                 $blogs = $this->blog->getBlog();
                 $this->load->library("pagination");
                 $config = getPaginationDesign();
                 $config["base_url"] = site_url() . '/' . strtolower(__CLASS__);
                 $config["total_rows"] = count($blogs);
                 $config["per_page"] = 2;
                 $config["uri_segment"] = 2;
                 $this->pagination->initialize($config);
                 $data["links"] = $this->pagination->create_links();
                 $data['blogs'] = $this->blog->getBlog('', $config["per_page"], $page);
                 $this->render_page(strtolower(__CLASS__) . '/index', $data);
            }
       }

       function category($page = 0) {
            $data['anasiz'] = $this->blog->getBlogAnalisiz();
            $id = encryptor($_GET['cid'], 'D');
            $blogs = $this->blog->getBlogByCategory($id);
            $this->load->library("pagination");
            $config = getPaginationDesign();
            $config["base_url"] = site_url() . '/' . strtolower(__CLASS__);
            $config["total_rows"] = count($blogs);
            $config["per_page"] = 2;
            $config["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();
            $data['blogs'] = $this->blog->getBlogByCategory($id, $config["per_page"], $page);
            $this->render_page(strtolower(__CLASS__) . '/index', $data);
       }
       
       function tag($page = 0) {
            $data['anasiz'] = $this->blog->getBlogAnalisiz();
            $id = encryptor($_GET['cid'], 'D');
            $blogs = $this->blog->getBlogByTag($id);
            $this->load->library("pagination");
            $config = getPaginationDesign();
            $config["base_url"] = site_url() . '/' . strtolower(__CLASS__);
            $config["total_rows"] = count($blogs);
            $config["per_page"] = 2;
            $config["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();
            $data['blogs'] = $this->blog->getBlogByTag($id, $config["per_page"], $page);
            $this->render_page(strtolower(__CLASS__) . '/index', $data);
       }
  } 