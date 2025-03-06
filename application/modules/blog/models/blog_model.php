<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class blog_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();

            $this->tbl_blogs = TABLE_PREFIX . 'blogs';
            $this->tbl_blogs_tags = TABLE_PREFIX . 'blog_tags';
            $this->tbl_blog_images = TABLE_PREFIX . 'blog_images';
            $this->tbl_blogs_category = TABLE_PREFIX . 'blog_category';
            $this->tbl_blog_tags_assoc = TABLE_PREFIX . 'blog_tags_assoc';
       }

       function getBlog($id = '') {
            $this->db->select($this->tbl_blogs . '.*,' . $this->tbl_blogs_category . '.*')->from($this->tbl_blogs)
                    ->join($this->tbl_blogs_category, $this->tbl_blogs_category . '.bcat_id = ' . $this->tbl_blogs . '.blog_category');

            if ($id) {
                 $this->db->where('blog_id', $id);
            }
            $products = array();
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

       function getNextOrder($max = false) {
            if ($max) {
                 return $this->db->count_all_results($this->tbl_blogs);
            } else {
                 return $this->db->select_max('blog_order')->get($this->tbl_blogs)->row()->blog_order + 1;
            }
       }

       function newBlog($datas) {
            if (isset($datas['blog']) && !empty($datas['blog'])) {
                 $datas['blog']['blog_slug'] = slugify($datas['blog']['blog_title']);
                 if ($this->db->insert($this->tbl_blogs, $datas['blog'])) {
                      $lastId = $this->db->insert_id();
                      if (isset($datas['tags']) && !empty($datas['tags'])) {

                           foreach ($datas['tags'] as $key => $value) {
                                $this->db->insert($this->tbl_blog_tags_assoc, array('bgtg_blog' => $lastId, 'bgtg_tag' => $value));
                           }
                      }
                      return $lastId;
                 } else {
                      return false;
                 }
            } else {
                 return false;
            }
       }

       function updateBlog($datas, $id) {
            if (!empty($datas['blog']) && !empty($id)) {
                 $this->db->where('blog_id', $id);
                 $datas['blog']['blog_slug'] = slugify($datas['blog']['blog_title']);
                 if ($this->db->update($this->tbl_blogs, $datas['blog'])) {
                      if (isset($datas['tags']) && !empty($datas['tags'])) {
                           $this->db->where('bgtg_blog', $id);
                           $this->db->delete($this->tbl_blog_tags_assoc);
                           foreach ($datas['tags'] as $key => $value) {
                                $this->db->insert($this->tbl_blog_tags_assoc, array('bgtg_blog' => $id, 'bgtg_tag' => $value));
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

       public function addImages($image) {
            if ($this->db->insert($this->tbl_blog_images, $image)) {
                 return true;
            } else {
                 return false;
            }
       }

       function removeNewsImage($id) {
            if ($id) {
                 $this->db->where('bimg_id', $id);
                 $image = $this->db->get($this->tbl_blog_images)->row_array();

                 if (isset($image['bimg_image']) && !empty($image['bimg_image'])) {
                      if (file_exists(UPLOAD_PATH . 'blog/' . $image['bimg_image'])) {
                           unlink(UPLOAD_PATH . 'blog/' . $image['bimg_image']);
                      }
                      if (file_exists(UPLOAD_PATH . 'blog/thumb_' . $image['bimg_image'])) {
                           unlink(UPLOAD_PATH . 'blog/thumb_' . $image['bimg_image']);
                      }
                      $this->db->where('bimg_id', $id);
                      $this->db->delete($this->tbl_blog_images);
                      return true;
                 }
            }
            return false;
       }

       function deleteBlog($id) {
            if (!empty($id)) {
                 $this->db->where('blog_id', $id);
                 if ($this->db->delete($this->tbl_blogs)) {
                      return true;
                 } else {
                      return false;
                 }
            } else {
                 return false;
            }
       }

       function blogCategories($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_blogs_category, array('bcat_id' => $id))->row_array();
            }
            return $this->db->get($this->tbl_blogs_category)->result_array();
       }

       function deleteCategory($id) {
            if ($id) {
                 $this->db->where('bcat_id', $id);
                 $this->db->delete($this->tbl_blogs_category);
                 return true;
            }
            return false;
       }

       function updateCategory($data) {
            if (!empty($data)) {
                 $id = isset($data['bcat_id']) ? $data['bcat_id'] : 0;
                 unset($data['bcat_id']);
                 $data['bcat_slug'] = slugify($data['bcat_title']);
                 $this->db->where('bcat_id', $id);
                 $this->db->update($this->tbl_blogs_category, $data);
                 return true;
            }
            return false;
       }

       function newCategory($data) {
            if (!empty($data)) {
                 $data['bcat_slug'] = slugify($data['bcat_title']);
                 $this->db->insert($this->tbl_blogs_category, $data);
                 return true;
            }
            return false;
       }

       /* Tag */

       function blogTags($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_blogs_tags, array('btag_id' => $id))->row_array();
            }
            return $this->db->get($this->tbl_blogs_tags)->result_array();
       }

       function deleteTag($id) {
            if ($id) {
                 $this->db->where('btag_id', $id);
                 $this->db->delete($this->tbl_blogs_tags);
                 return true;
            }
            return false;
       }

       function updateTag($data) {
            if (!empty($data)) {
                 $id = isset($data['btag_id']) ? $data['btag_id'] : 0;
                 unset($data['btag_id']);
                 $data['btag_slug'] = slugify($data['btag_title']);
                 $this->db->where('btag_id', $id);
                 $this->db->update($this->tbl_blogs_tags, $data);
                 return true;
            }
            return false;
       }

       function newTag($data) {
            if (!empty($data)) {
                 $data['btag_slug'] = slugify($data['btag_title']);
                 $this->db->insert($this->tbl_blogs_tags, $data);
                 return true;
            }
            return false;
       }

  }
  