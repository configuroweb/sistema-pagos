<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema de Pagos con Historial</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/pnotify/pnotify.custom.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/custom.css">
</head>

<body class="hold-transition login-page ">

  <div class="login-logo" style="margin-top: 15%;">
    Sistema de Pagos con Historial
  </div>
  <div class="login-logo" style="font-size: large; color:antiquewhite;">
    <a href="https://www.configuroweb.com/46-aplicaciones-gratuitas-en-php-python-y-javascript/#Aplicaciones-gratuitas-en-PHP,-Python-y-Javascript">Para más desarrollos ConfiguroWeb</a>
  </div>
  <div class="login-box" style="margin-top: 3%;">
    <!-- /.login-logo -->
    <div class="card rounded-0">
      <div class="card-body login-card-body">

        <form action="<?php echo base_url() ?>authe/valafclog/" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="email" autocomplete="off" class="form-control" placeholder="Correo">
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="pwd" autocomplete="off" class="form-control" placeholder="Contraseña">
          </div>
          <!-- /.col -->
          <div class="">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Acceder</button>
          </div>
          <!-- /.col -->
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo base_url() ?>assets/backend/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url() ?>assets/backend/pnotify/pnotify.custom.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url() ?>assets/backend/plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {

      <?php if ($this->session->flashdata('invalid_cred') != '') { ?>
        new PNotify({
          title: 'Notificación',
          text: '<?php echo $this->session->flashdata('invalid_cred'); ?>',
          type: 'error'
        });
      <?php } ?>

    })
  </script>
</body>

</html>