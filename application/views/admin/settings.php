<?php
defined('BASEPATH') or exit('No se permite el acceso directo al script');

// Settings Data
$name = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->NAME;
$address = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->ADDRESS;
$phone = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->PHONE;
$session = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->SESSION;
$bank = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->BANK;
$acc_name = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->ACC_NAME;
$acc_number = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->ACC_NUMBER;
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'inc/head.php'; ?>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include 'inc/navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include 'inc/aside.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Configuración Global</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="card card-danger card-outline">
                <div class="card-header">
                  <h5 class="m-0">Configuración General Sistema</h5>
                </div>
                <div class="card-body">
                  <form action="<?php echo base_url() ?>admin/action/main_settings" method="POST">
                    <div class="form-group">
                      <label>Nombre Colegio</label>
                      <input type="text" name="name" value="<?php echo $name ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Teléfono Colegio</label>
                      <input type="text" name="phone" value="<?php echo $phone ?>" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Dirección de Colegio</label>
                      <input type="text" name="address" value="<?php echo $address ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Banco</label>
                      <input type="text" name="bank" value="<?php echo $bank ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Nombre Cuenta Colegio</label>
                      <input type="text" name="acc_name" value="<?php echo $acc_name ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Número de Cuenta Colegio</label>
                      <input type="text" name="acc_number" value="<?php echo $acc_number ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Año Lectivo</label>
                      <select name="session" class="form-control selectboxit">
                        <option value="">--- ---</option>
                        <?php for ($i = 0; $i < 20; $i++) : ?>
                          <option value="<?php echo (2019 + $i); ?>-<?php echo (2019 + $i + 1); ?>" <?php if ($session == (2019 + $i) . '-' . (2019 + $i + 1)) echo 'selected'; ?>>
                            <?php echo (2019 + $i); ?>-<?php echo (2019 + $i + 1); ?>
                          </option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Información</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-info card-outline">
                <div class="card-header">
                  <h5 class="m-0">Otras Configuraciones</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="<?php echo base_url() ?>admin/sub_action/update_logo" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="field-1" class="col-sm-3 control-label">LOGO</label><br>
                      <input type="file" name="logo">
                    </div>
                    <button type="submit" class="btn btn-info">Actualizar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include 'inc/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <?php include 'inc/rscript.php'; ?>
  <script>
    $(function() {
      <?php if ($this->session->flashdata('completed') != '') { ?>
        new PNotify({
          title: 'Notificación',
          text: '<?php echo $this->session->flashdata('completed'); ?>',
          type: 'success'
        });
      <?php } ?>
    });
  </script>
</body>

</html>