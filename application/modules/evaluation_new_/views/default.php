<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml">
     <head>
          <base href="<?php echo base_url('assets/');?>/"/>
          <title><?php echo $template['title']?></title>
          <?php echo $template['metadata']?>
          
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <link rel="icon" type="image/png" id="favicon" href="images/favicon.png" />
          <meta name="author" content=""/>
          <meta name="robots" content="index, follow"/>
          <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
          <!--CSS -->
          <link rel="stylesheet" type="text/css" href="styles/rd.css"/>
          <link rel="stylesheet" type="text/css" href="styles/jk-style.css"/>
          <!--Icon Fonts-->
          <link rel="stylesheet" media="screen" href="styles/font-awesome.min.css"/>
          <!-- Extras -->
          <link rel="stylesheet" type="text/css" href="styles/animate.css"/>

          <!-- Blog Og Tags -->
          <?php
            if ($controller == 'blog' && $method == 'index' && (isset($_GET['ci']) && !empty($_GET['ci']))) {
                 $id = encryptor($_GET['ci'], 'D');
                 $blogog = $this->blog->getBlog($id);
                 $img = isset($blogog['images'][0]['bimg_image']) ? $blogog['images'][0]['bimg_image'] : '';
                 ?>
                 <meta property="og:url"           content="<?php echo site_url() . 'blog/' . $blogog['blog_slug'] . '?ci=' . $_GET['ci'];?>" />
                 <meta property="og:type"          content="website" />
                 <meta property="og:title"         content="<?php echo $blogog['blog_title'];?>" />
                 <meta property="og:description"   content="<?php echo strip_tags($blogog['blog_desc']); ?>" />
                 <meta property="og:image"         content="<?php echo site_url() . 'assets/uploads/blog/' . $img;?>" />
            <?php }?>
          <!-- Blog Og Tags -->
          <?php //echo $blogog['blog_title'];?>
          <?php //echo strip_tags($blogog['blog_desc']); ?>
          <script>
               var site_url = "<?php echo site_url();?>";
               var none_image = "<?php echo $this->config->item('none_image');?>";
          </script>
          <!-- Global site tag (gtag.js) - Google Analytics -->
          <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111086231-2"></script>
          <script>
               window.dataLayer = window.dataLayer || [];
               function gtag(){dataLayer.push(arguments);}
               gtag('js', new Date());

               gtag('config', 'UA-111086231-2');
          </script>
          <script  src="scripts/jquery-3.3.1.min.js"></script>
         
     </head>
     <body class="fixed-top">
          <?php echo $template['partials']['header'];?>
          <?php echo $template['partials']['flash_messages']?>
          <?php echo $template['body']?>
          <?php echo $template['partials']['footer'];?>
     </body>
</html>