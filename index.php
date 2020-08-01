<?php require_once('lib/library.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <title>Farm Mgt. System</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="themenate.com/assets/images/logo/favicon.png">

    <!-- plugins css -->
    <link rel="stylesheet" href="themenate.com/assets/vendors/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="themenate.com/assets/vendors/PACE/themes/blue/pace-theme-minimal.css" />
    <link rel="stylesheet" href="themenate.com/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.min.css" />

    <!-- core css -->
    <link href="themenate.com/assets/css/ei-icon.css" rel="stylesheet">
    <link href="themenate.com/assets/css/themify-icons.css" rel="stylesheet">
    <link href="themenate.com/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="themenate.com/assets/css/animate.min.css" rel="stylesheet">
    <link href="themenate.com/assets/css/app.css" rel="stylesheet">
    <link href="themenate.com/assets/css/mystylesheet.css" rel="stylesheet">
    <link href="the-sweetalert-js/sweetalert.css" rel="stylesheet" type="text/css">
</head>
<?php

if(isset($_POST['login'])){
    $msg = $lib->login($_POST['email-log'],$_POST['pword-log']);
    
    
}
   /*  if(isset($_POST['register'])){

    $FNAME = $_POST['full-name'];
    $EMAIL = $_POST['email'];
    $SEX = $_POST['sex'];
    $PHONE = $_POST['phone'];
    $PASS = $_POST['pass'];
    $CPASS = $_POST['cpass'];
    $REGISTER = $_POST['register'];
        $query = "INSERT INTO managers VALUES (null,'".$FNAME."','".$EMAIL."','".$SEX."','0','".$PASS."','".$PHONE."','0','0') ";

        $lib->sqlQuery($query);
    }  */   
    // full-name email sex phone pass cpass register


?>
<body>
    <div class="app">
        <div class="authentication">
            <div class="sign-up">
                <div class="row no-mrg-horizon">
                    <div class="col-md-4 no-pdd-horizon d-none d-md-block">
                        <div class="full-height bg" style="background-image: url('themenate.com/assets/images/signup-bg2.jpg')">
                            <div class="vertical-align full-height pdd-horizon-70">
                                <div class="table-cell">
                                    <div class="row">
                                        <div class="mr-auto ml-auto col-md-10">
                                            <div class="text-right">
                                                <img class="img-responsive mrg-left-auto mrg-btm-15" src="themenate.com/assets/images/logo/logo-white.png" alt="" width="170">
                                                
                                                <p style="color:brown !important;" class="text-white lead text-opacity lh-1-7">Farm Management System<br>The software helps in automating farm activities such as record management, data storage, monitoring and analyzing farming activities, as well as streamlining production and work schedules.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 bg-white no-pdd-horizon">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="full-height height-100">
                                    <div class="vertical-align full-height pdd-horizon-70">
                                        <div class="table-cell">
                                            <div class="pdd-horizon-15">
                                                <h1 class="mrg-btm-30  text-center">
                                                    <strong>Log In To Your Farm</strong>  
                                                </h1>
                                                <p style="color:red;"><?php print @$msg; ?></p>
                                                <form id="login" method="post" action="" enctype="multipart/formdata">
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Email</label>
                                                        <input type="text" name="email-log" class="form-control" placeholder="Email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Password</label>
                                                        <input type="password" name="pword-log" class="form-control" placeholder="Password">
                                                    </div>
                                                    <div class="checkbox font-size-13 mrg-btm-20">
                                                        <input id="agreement" name="agreement" type="checkbox" checked="">
                                                        <label for="agreement">Remember Me</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" name="login" class="btn btn-primary btn-block border-radius-6 login">Log In</button>
                                                    </div>
                                                </form>
                                                <p>Not Registered?
                                                <button data-toggle="modal" data-target="#default-modal" class="btn btn-sm btn-primary signup-btn">Sign Up</button>
                                                <hr>
                                                <small>By signing up you agree to out <a href="#">Terms & Policy</a></small><!-- 
                                                <div class="col-lg-4 col-md-12 text-right pdd-top-5">
                                                        <button data-toggle="modal" data-target="#default-modal" class="btn btn-sm btn-primary">Trigger</button>
                                                </div> -->
                    <div class="modal fade" id="default-modal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="text-center">Create Account</h4>
                                </div>
                                <div class="modal-body">
                                                <form id="signup-form" action="" method="POST" enctype="multipart/formdata">
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Full Name*</label>
                                                        <input type="text" name="full-name" class="form-control" placeholder="Full Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Email Address*</label>
                                                        <input type="email" name="email" class="form-control" placeholder="Email Address">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Gender*</label>
                                                        <!-- <input type="text" name="sex" class="form-control" placeholder="Gender"> -->
                                                        <select name="sex" id="" class="form-control">
                                                            <option value="">Select your gender</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Phone No.*</label>
                                                        <input type="text" name="phone" class="form-control" placeholder="Phone No.">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Password*</label>
                                                        <input type="password" name="pass" class="form-control" placeholder="Password">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="text-normal text-dark">Confirm Password*</label>
                                                        <input type="password" name="cpass" class="form-control" placeholder="Confirm Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" name="register" class="btn btn-primary btn-block border-radius-6 register">Register</button>
                                                    </div>
                                                </form>
                                </div>
                                <div class="modal-footer no-border">
                                    <div class="text-right">
                                        <button class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                                        <!-- <button class="btn btn-primary btn-sm" data-dismiss="modal">OK</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="themenate.com/assets/js/jquery_3_3_1.js"></script>
    <script src="themenate.com/assets/js/vendor.js"></script>
    <script src="themenate.com/assets/js/app.min.js"></script>
    <script type="text/javascript" src="the-sweetalert-js/sweetalert.min.js"></script>
    <script type="text/javascript" src="the-sweetalert-js/sweetalert.js"></script>
    <script>
        $(document).ready(function () {
            
            $('.register').click(function (e) { 

                e.preventDefault();

                var data = $('#signup-form :input').serializeArray();

                console.log(data);
            $.ajax({
                type: "POST",
                url: "ajax_process.php",
                async:true,
                cache:false,
                data: data,
                dataType: "html",
                success: function (response) {
                        console.log(response);
                        if(response !== 'Registration successful, login to continue!') {
                            swal('Sorry',response,'error');
                        }else if(response == 'Registration successful, login to continue!') {
                            swal('Congratulations',response,'success');
                        }else {
                             
                        }
                        
                }

                });
            });

            
        });




    </script>
    <!-- page js -->

</body>

</html>