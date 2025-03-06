<!DOCTYPE html>
<html lang="en">
     <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <!-- Meta, title, CSS, favicons, etc. -->
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">

          <title>Gentelella Alela! | </title>

          <!-- Bootstrap -->
          <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
          <!-- Font Awesome -->
          <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
          <!-- NProgress -->
          <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
          <!-- Animate.css -->
          <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

          <!-- Custom Theme Style -->
          <link href="../assets/css/custom.min.css" rel="stylesheet">
     </head>

     <body class="login">
          <div>
               <a class="hiddenanchor" id="signup"></a>
               <a class="hiddenanchor" id="signin"></a>

               <div class="login_wrapper">
                    <div class="animate form login_form">
                         <section class="login_content">
                              <?php echo form_open('user/login', array('class' => ''))?>
                              <h1>Login Form</h1>
                              <div>
                                   <?php echo form_input($identity) ?>
                              </div>
                              <div>
                                   <?php echo form_input($password) ?>
                              </div>
                              <div>
                                   <input type="submit" class="btn btn-default submit"/>
                              </div>

                              <div class="clearfix"></div>
                              <?php echo form_close()?>
                         </section>
                    </div>
               </div>
          </div>
     </body>
</html>
