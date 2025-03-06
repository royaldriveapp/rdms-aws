<!DOCTYPE html>
<html lang="en">
     <head>
          <meta charset="UTF-8">
          <title><?php echo $template['title']?></title>
          <base href="<?php echo base_url('assets/');?>/"/>
          <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png');?>" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <script>
               var site_url = "<?php echo site_url();?>";
               var none_image = "<?php echo $this->config->item('none_image');?>";
          </script>

          <?php echo $template['metadata']?>
          <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
          <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900&subset=latin,latin-ext'>
          <link rel="stylesheet" href="css/login-style.css">
     </head>
     <body>
          <?php echo ($this->router->fetch_class() != 'user') ? $template['partials']['header'] : '';?>
          <?php echo $template['partials']['flash_messages']?>
          <?php echo $template['body']?>
          <?php echo ($this->router->fetch_class() != 'user') ? $template['partials']['footer'] : '';?>
     </body>
     
     <script src="../vendors/jquery/dist/jquery.min.js"></script>
     <script src="js/login.js"></script>
</body>
</html>