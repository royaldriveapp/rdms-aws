<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class blog_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();

            $this->tbl_blogs = TABLE_PREFIX_PORTAL . 'blogs';
            $this->tbl_blogs_tags = TABLE_PREFIX_PORTAL . 'blog_tags';
            $this->tbl_blog_images = TABLE_PREFIX_PORTAL . 'blog_images';
            $this->tbl_blogs_category = TABLE_PREFIX_PORTAL . 'blog_category';
            $this->tbl_blog_tags_assoc = TABLE_PREFIX_PORTAL . 'blog_tags_assoc';
       }

       function getBlogByTag($id = '', $limit = '', $start = '') {

            $products = array();

            $blogid = explode(',', $this->db->select('GROUP_CONCAT(bgtg_blog) AS bgtg_blog')
                            ->where('bgtg_tag', $id)->get($this->tbl_blog_tags_assoc)->row()->bgtg_blog);

            if (!empty($blogid)) {
                 $this->db->select($this->tbl_blogs . '.*,' . $this->tbl_blogs_category . '.*')->from($this->tbl_blogs)
                         ->join($this->tbl_blogs_category, $this->tbl_blogs_category . '.bcat_id = ' . $this->tbl_blogs . '.blog_category');

                 $this->db->where_in('blog_id', $blogid);
                 $this->db->order_by('blog_added_on', 'DESC');
                 if (!empty($limit)) {
                      $this->db->limit($limit, $start);
                 }

                 $products = $this->db->get()->result_array();
                 if (!empty($products)) {
                      foreach ($products as $key => $value) {
                           $products[$key]['images'] = $this->db->get_where($this->tbl_blog_images, array('bimg_blog' => $value['blog_id']))->result_array();

                           $products[$key]['tagIds'] = explode(',', $this->db->select('GROUP_CONCAT(bgtg_tag) AS bgtg_tag')
                                           ->where(array('bgtg_blog' => $value['blog_id']))
                                           ->get($this->tbl_blog_tags_assoc)->row()->bgtg_tag);

                           $products[$key]['tags'] = $this->db->select($this->tbl_blog_tags_assoc . '.*,' . $this->tbl_blogs_tags . '.*')
                                           ->join($this->tbl_blogs_tags, $this->tbl_blogs_tags . '.btag_id = ' . $this->tbl_blog_tags_assoc . '.bgtg_tag')
                                           ->where($this->tbl_blog_tags_assoc . '.bgtg_blog', $value['blog_id'])->get($this->tbl_blog_tags_assoc)->result_array();
                      }
                 }
            }
            return $products;
       }

       function getBlogByCategory($id = '', $limit = '', $start = '') {

            $this->db->select($this->tbl_blogs . '.*,' . $this->tbl_blogs_category . '.*')->from($this->tbl_blogs)
                    ->join($this->tbl_blogs_category, $this->tbl_blogs_category . '.bcat_id = ' . $this->tbl_blogs . '.blog_category');

            if ($id) {
                 $this->db->where('blog_category', $id);
            }
            $this->db->order_by('blog_added_on', 'DESC');
            if (!empty($limit)) {
                 $this->db->limit($limit, $start);
            }

            $products = $this->db->get()->result_array();
            if (!empty($products)) {
                 foreach ($products as $key => $value) {
                      $products[$key]['images'] = $this->db->get_where($this->tbl_blog_images, array('bimg_blog' => $value['blog_id']))->result_array();

                      $products[$key]['tagIds'] = explode(',', $this->db->select('GROUP_CONCAT(bgtg_tag) AS bgtg_tag')
                                      ->where(array('bgtg_blog' => $value['blog_id']))
                                      ->get($this->tbl_blog_tags_assoc)->row()->bgtg_tag);

                      $products[$key]['tags'] = $this->db->select($this->tbl_blog_tags_assoc . '.*,' . $this->tbl_blogs_tags . '.*')
                                      ->join($this->tbl_blogs_tags, $this->tbl_blogs_tags . '.btag_id = ' . $this->tbl_blog_tags_assoc . '.bgtg_tag')
                                      ->where($this->tbl_blog_tags_assoc . '.bgtg_blog', $value['blog_id'])->get($this->tbl_blog_tags_assoc)->result_array();
                 }
            }
            return $products;
       }

       function getBlog($id = '', $limit = '', $start = '') {

            $this->db->select($this->tbl_blogs . '.*,' . $this->tbl_blogs_category . '.*')->from($this->tbl_blogs)
                    ->join($this->tbl_blogs_category, $this->tbl_blogs_category . '.bcat_id = ' . $this->tbl_blogs . '.blog_category');

            if ($id) {
                 $this->db->where('blog_id', $id);
            }
            if (!empty($limit)) {
                 $this->db->limit($limit, $start);
            }

            $products = array();
            $this->db->order_by($this->tbl_blogs . '.blog_added_on', 'DESC');
            $productsArray = $this->db->get()->result_array();
            if (!empty($productsArray)) {
                 foreach ($productsArray as $key => $value) {
                      $value['images'] = $this->db->get_where($this->tbl_blog_images, array('bimg_blog' => $value['blog_id']))->result_array();

                      $value['tagIds'] = explode(',', $this->db->select('GROUP_CONCAT(bgtg_tag) AS bgtg_tag')
                                      ->where(array('bgtg_blog' => $value['blog_id']))
                                      ->get($this->tbl_blog_tags_assoc)->row()->bgtg_tag);

                      $value['tags'] = $this->db->select($this->tbl_blog_tags_assoc . '.*,' . $this->tbl_blogs_tags . '.*')
                                      ->join($this->tbl_blogs_tags, $this->tbl_blogs_tags . '.btag_id = ' . $this->tbl_blog_tags_assoc . '.bgtg_tag')
                                      ->where($this->tbl_blog_tags_assoc . '.bgtg_blog', $value['blog_id'])->get($this->tbl_blog_tags_assoc)->result_array();
                      if ($id) {
                           $products = $value;
                      } else {
                           $products[] = $value;
                      }
                 }
            }
            return $products;
       }

       function getBlogAnalisiz() {

            $data['tags'] = $this->db->select($this->tbl_blog_tags_assoc . '.bgtg_tag, COUNT(' . $this->tbl_blog_tags_assoc . '.bgtg_blog) AS count,' . $this->tbl_blogs_tags . '.*')
                            ->join($this->tbl_blogs_tags, $this->tbl_blogs_tags . '.btag_id = ' . $this->tbl_blog_tags_assoc . '.bgtg_tag', 'LEFT')
                            ->group_by($this->tbl_blog_tags_assoc . '.bgtg_tag')->get($this->tbl_blog_tags_assoc)->result_array();

            $data['category'] = $this->db->select($this->tbl_blogs . '.blog_category, COUNT(' . $this->tbl_blogs . '.blog_category) AS count,' . $this->tbl_blogs_category . '.*')
                            ->join($this->tbl_blogs_category, $this->tbl_blogs . '.blog_category = ' . $this->tbl_blogs_category . '.bcat_id', 'LEFT')
                            ->group_by($this->tbl_blogs . '.blog_category')->get($this->tbl_blogs)->result_array();
            return $data;
       }

  }
  