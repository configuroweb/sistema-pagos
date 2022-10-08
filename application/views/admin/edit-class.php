<?php
defined('BASEPATH') or exit('No se permite el acceso directo al script');

// All class data
$cname = $this->db->get_where('class_tbl', array('ID' => $class_id))->row()->NAME;
$cfees = $this->db->get_where('class_tbl', array('ID' => $class_id))->row()->FEES;
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
              <h1 class="m-0 text-dark">Editar Año</h1>
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
            <div class="col-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-info">
                      <!-- <h3 class="card-title"></h3> -->
                      <div class="card-tools">

                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body mt-3">

                      <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                          <form role="form" method="POST" action="<?php echo base_url() ?>admin/sub_action/edit_class/<?php echo $class_id; ?>" enctype="multipart/form-data">
                            <div class="card-body">
                              <div class="form-group">
                                <label>Año</label>
                                <input autocomplete="off" value="<?php echo $cname ?>" type="text" name="cname" class="form-control">
                              </div>
                              <div class="form-group">
                                <label>Valor Tarifa</label>
                                <input autocomplete="off" type="tel" value="<?php echo $cfees ?>" name="cfees" class="form-control money">
                              </div>
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary">Editar Año</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-2"></div>
                      </div>
                    </div>
                  </div>
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
      $("#example1").DataTable();
      $('.money').simpleMoneyFormat();
      <?php if ($this->session->flashdata('completed') != '') { ?>
        new PNotify({
          title: 'Notification',
          text: '<?php echo $this->session->flashdata('completed'); ?>',
          type: 'success'
        });
      <?php } ?>
    });
  </script>

</body>

</html>