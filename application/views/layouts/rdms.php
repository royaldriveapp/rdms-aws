<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
     <base href="<?php echo base_url('assets/'); ?>/" />
     <title><?php echo $template['title'] ?></title>
     <?php echo $template['metadata'] ?>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <link rel="icon" type="image/png" id="favicon" href="images/favicon.png" />
     <meta name="author" content="" />
     <meta name="robots" content="index, follow" />
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
     <!--CSS -->
     <link rel="stylesheet" type="text/css" href="css/rd.css" />
     <!--<link rel="stylesheet" type="text/css" href="styles/jk-style.css"/>-->
</head>

<body class="fixed-top">
     <header class="logo-menu">
          <nav class="navbar-default navbar-fixed-top" role="navigation" data-spy="affix" data-offset-top="200">
               <div class="container">
                    <div class="row">
                         <div class="col-sm-4"></div>
                         <div class="col-sm-4" style="text-align: center;padding: 10px;">
                              <img src="images/logo-royal-drive.svg" alt="Royal Drive" />
                         </div>
                         <div class="col-sm-4"></div>
                    </div>
               </div>
          </nav>
     </header>
     <?php echo $template['body'] ?>
     <?php echo $template['partials']['rdms_footer']; ?>
     <script src="scripts/jquery-3.3.1.min.js"></script>
     <script src="scripts/my.script.js" type="text/javascript"></script>
     <style>
          .phone {
               font-size: 23px !important;
               margin: 38px;
          }

          @media (max-width: 575px) {
               .top_nav .phone span {
                    display: block !important;
               }

               .top_nav .phone {
                    float: right;
               }

               .phone {
                    font-size: 23px;
                    margin-left: 15px;
                    margin: 35px;
               }
          }

          @media (max-width: 767px) {
               .top_nav {
                    width: 50%;
               }

               .phone {
                    margin: 33px;
               }
          }

          @media (max-width: 490px) {
               .phone {
                    font-size: 15px !important;
               }
          }
     </style>
</body>

</html>