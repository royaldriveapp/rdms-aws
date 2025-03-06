<!DOCTYPE html>
<html lang="en">
     <head>
          <meta charset="utf-8">
          <title><?php echo $template['title']?></title>
          <base href="<?php echo base_url('assets/');?>/"/>
          <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png');?>" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <script>
               var site_url = "<?php echo site_url() . '/';?>";
               var none_image = "<?php echo $this->config->item('none_image');?>";
          </script>

          <?php echo $template['metadata']?>

          <!-- Bootstrap -->
          <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
          <!-- Font Awesome -->
          <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
          <!-- NProgress -->
          <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
          <!-- iCheck -->
          <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

          <!-- bootstrap-progressbar -->
          <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
          <!-- JQVMap -->
          <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
          <!-- bootstrap-daterangepicker -->
          <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

          <!-- Custom Theme Style -->
          <link href="../assets/css/custom.min.css" rel="stylesheet">

          <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
     </head>
     <body class="nav-md">
          <div class="container body">
               <div class="main_container">
                    <?php echo ($this->router->fetch_method() != 'login') ? $template['partials']['header'] : '';?>
                    <?php echo $template['partials']['flash_messages']?>
                    <?php echo $template['body']?>
                    <?php echo ($this->router->fetch_method() != 'login') ? $template['partials']['footer'] : '';?>
               </div>
          </div>
     </body>
</html>