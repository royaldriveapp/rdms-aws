<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
<style type="text/css">
     .a2a_svg { border-radius: 20px !important; height: 22px !important;width: 22px !important;}
     .a2a_svg svg { width: 22px !important; padding:2px !important; }
</style>
<section class="inner_pages blog">
     <div class="container">
          <div class="row"> 
               <div class="col-md-9">
                    <?php foreach ((array) $blogs as $key => $value) {
                           $url = site_url('blog/' . $value['blog_slug'] . '?ci=') . encryptor($value['blog_id']);
                           ?>
                           <div class="blog_content">
                                <h2><?php echo $value['blog_title'];?></h2>
                                <div class="author_share">
                                     <p class="author">Author: <?php echo $value['blog_author'];?></p>
                                     <div class="top_nav pull-right" >
                                          <div class="socia_icons">
                                               <div class="a2a_kit a2a_kit_size_32 a2a_default_style" 
                                                    data-a2a-url="<?php echo $url;?>" 
                                                    data-a2a-title="<?php echo $value['blog_title']?>">
                                                    <a class="a2a_button_facebook indproduct-social"></a>
                                                    <a class="a2a_button_twitter indproduct-social"></a>
                                                    <a class="a2a_button_google_plus indproduct-social"></a>
                                                    <a class="a2a_button_whatsapp indproduct-social"></a>
                                               </div>
                                          </div>
                                     </div>
                                     <?php
                                     $img = isset($value['images'][0]['bimg_image']) ? $value['images'][0]['bimg_image'] : '';
                                     echo img(array('src' => './assets/uploads/blog/' . $img, 'alt' => $value['blog_title']));
                                     ?>
                                     <div class="blg_cntnt">
                                          <?php
                                          $desc = strip_tags($value['blog_desc']);
                                          echo get_snippet($value['blog_desc'], 70);
                                          ?>
                                     </div>
                                     <a href="<?php echo $url;?>" class="readmore">Read more</a>
                                </div> 
                           </div>
                      <?php }?>

                    <div class="text-center">
                         <?php echo $links;?>
                    </div>  
               </div>

               <div class="col-md-3">
                    <!--                    <div class="search_blog">
                                             <input type="text" class="form-control datepicker" placeholder="Search">
                                        </div>-->
                    <div class="search_blog categories">
                         <h2>Categories</h2>
                         <ul>
                              <li><a href="<?php echo site_url('blog');?>">All</a></li>
                              <?php foreach ((array) $anasiz['category'] as $key => $value) {?>
                                     <li><a href="<?php echo site_url('blog/category/' . $value['bcat_slug'] . '?cid=' . encryptor($value['bcat_id']));?>"><?php echo $value['bcat_title'] . ' (' . sprintf("%02d", $value ['count']) . ')';?></a></li>
                                <?php }?>
                         </ul>
                    </div>
                    <div class="search_blog new_tags">
                         <h2>New Tags</h2>
                         <ul class="list-inline">
                              <?php foreach ((array) $anasiz['tags'] as $key => $value) {?>
                                     <li><a href="<?php echo site_url('blog/tag/' . $value['btag_slug'] . '?cid=' . encryptor($value['btag_id']));?>"><?php echo $value['btag_title'];?></a></li>
                                <?php }?>
                         </ul>
                    </div>
                    <div class="blog_content follow">
                         <h2>Follow Royal Drive</h2>
                         <div class="top_nav" >
                              <div class="socia_icons">
                                   <a class="social" href="https://www.facebook.com/royaldrivellp" target="_blank">
                                        <i class="fa fa-facebook fa-2x">
                                        </i>
                                   </a>
                                   <a class="social" href="https://twitter.com/DrivePre?s=08" target="_blank">
                                        <i class="fa fa-twitter fa-2x">
                                        </i>
                                   </a>
                                   <a class="social" href="https://www.instagram.com/royaldrivellp/" target="_blank">
                                        <i class="fa fa-instagram fa-2x">
                                        </i>
                                   </a>
                                   <a class="social" href="https://api.whatsapp.com/send?phone=919539069090" target="_blank">
                                        <i class="fa fa-whatsapp fa-2x">
                                        </i>
                                   </a>
                                   <a class="social" href="https://www.youtube.com/channel/UCVxYCu-mOfV3fkBRQjOS0yw" target="_blank">
                                        <i class="fa fa-youtube-play fa-2x">
                                        </i>
                                   </a>
                              </div>   
                         </div>
                    </div>
               </div>
          </div>
</section>

<style>
     @media (min-width:991px) {
          .col-md-3 {float:left !important;}
     }
     @media (max-width:991px){
          .col-md-3 {float:left !important;}
     }
</style>