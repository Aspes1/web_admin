<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
  <meta name="author" content="Lukasz Holeczek">
  <meta name="keyword" content="CoreUI Bootstrap 4 Admin Template">
  <link rel="shortcut icon" href="<?php echo base_url('assets/src/img/icon.png') ?>">

  <title>Web Admin</title>

  <!-- Icons -->
  <link href="<?php echo base_url('assets/node_modules/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/node_modules/simple-line-icons/css/simple-line-icons.css') ?>" rel="stylesheet">



  <!-- Main styles for this application -->
  <link href="<?php echo base_url('assets/src/css/style.css') ?>" rel="stylesheet">


  <!-- Styles required by this views -->

</head>

<body class="app flex-row align-items-center">
  <div class="container" id="login">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
              <h1>Login</h1>
              <p class="text-muted">Sign In to your account</p>
              <?php echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>'); ?>
              <?php
                if($this->session->flashdata('login_error')):
                    echo'<div class="alert alert-danger" role="alert">';
                    echo $this->session->flashdata('login_error');
                    echo "</div>";
                elseif($this->session->flashdata('need_login')):
                    echo'<div class="alert alert-warning" role="alert">';
                    echo $this->session->flashdata('need_login');
                    echo "</div>";
                endif;
               ?>
               <?php echo form_open('login/auth'); ?>
              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Username">
              </div>
              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password">
              </div>
              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="text" class="form-control" id="mac_address" name="mac_address" readonly>
              </div>
              <div class="row">
                <div class="col-3" style="margin-right:10px;">
                  <button type="submit" name="submit" class="btn btn-primary px-4">Login</button>
                </div>
                <div class="col-3">
                  <button type="button" class="btn btn-success" onclick="launchQZ();">Launch Plugin</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <!-- <div class="card-body text-center">
              <div>
                <h2>Sign up</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <button type="button" class="btn btn-primary active mt-3">Register Now!</button>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap and necessary plugins -->
  <script src="<?php echo base_url('assets/node_modules/jquery/dist/jquery.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/node_modules/popper.js/dist/umd/popper.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

  <!-- qz.io scripts  -->
  <script type="text/javascript" src="<?php echo base_url('assets/src/js/qz/dependencies/rsvp-3.1.0.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/src/js/qz/dependencies/sha-256.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/src/js/qz/qz-tray.js') ?>"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      startConnection();
      setTimeout(function(){ listNetworkInfo(); }, 2000);
    });

    /// Connection ///
    function launchQZ() {
        if (!qz.websocket.isActive()) {
            window.location.assign("qz:launch");
            //Retry 5 times, pausing 1 second between each attempt
            startConnection({ retries: 5, delay: 1 });
            setTimeout(function(){
              location.reload();
            }, 5000);
        }
    }

    function listNetworkInfo() {
        qz.websocket.getNetworkInfo().then(function(data) {
            if (data.macAddress == null) { data.macAddress = 'UNKNOWN'; }

            var macFormatted = '';
            for(var i = 0; i < data.macAddress.length; i++) {
                macFormatted += data.macAddress[i];
                if (i % 2 == 1 && i < data.macAddress.length - 1) {
                    macFormatted += ":";
                }
            }

            $('#mac_address').val(macFormatted);

        }).catch(displayError);
    }

    function startConnection(config) {
        if (!qz.websocket.isActive()) {

            qz.websocket.connect(config).then(function() {

            }).catch(handleConnectionError);
        } else {
            displayMessage('An active connection with QZ already exists.', 'alert-warning');
        }
    }

    function displayError(err) {
        console.error(err);
        displayMessage(err, 'alert-danger');
    }

    function handleConnectionError(err) {

        if (err.target != undefined) {
            if (err.target.readyState >= 2) { //if CLOSING or CLOSED
                displayError("Connection to QZ Tray was closed");
            } else {
                displayError("A connection error occurred, check log for details");
                console.error(err);
            }
        } else {
            displayError(err);
        }
    }
  </script>

</body>
</html>
