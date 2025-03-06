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
          <link rel="stylesheet" type="text/css" href="css/rd.css"/>
          <!--<link rel="stylesheet" type="text/css" href="styles/jk-style.css"/>-->
     </head>
     <body class="fixed-top">
          <header class="logo-menu"> 
               <!-- Nav Menu Section -->
               <nav class="navbar-default navbar-fixed-top" role="navigation" data-spy="affix" data-offset-top="200">
                    <!-- Nav Menu Section -->
                    <div class="container">
                         <div class="navbar navbar-inverse">
                              <div class="top_nav" style="margin: 0px;">
                                   <div>      	
                                        <div class="socia_icons">
                                             <a class="navbar-brand" href="javascript:void(0);" style="padding: 8px;">
                                                  <img width="150" src="images/rdsmart-logo.png" alt="Royal Drive Smart"/>
                                             </a>
                                             <a class="navbar-brand" href="javascript:void(0);" style="padding: 8px;">
                                                  <img width="150" src="images/carelogo.png" alt="Royal Drive Care"/>
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
                              <div class="navbar-header">
                                   <a class="navbar-brand" href="javascript:void(0);" style="padding: 8px;">
                                        <img src="images/logo-royal-drive.svg" alt="Royal Drive"/>
                                   </a>
                              </div>
                         </div>
                    </div>
               </nav>
          </header>
          <?php echo $template['body']?>
          
          <script  src="scripts/jquery-3.3.1.min.js"></script>
          <script src="scripts/my.script.js" type="text/javascript"></script>
          <style>
               .phone {
                    font-size: 23px !important;
                    margin:38px;
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