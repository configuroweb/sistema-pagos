<?php
defined('BASEPATH') or exit('No direct script access allowed');

// All term data
$tname = $this->db->get_where('term_tbl', array('ID' => $term_id))->row()->NAME;
$tfees = $this->db->get_where('term_tbl', array('ID' => $term_id))->row()->FEES;
$cid = $this->db->get_where('term_tbl', array('ID' => $term_id))->row()->CLASS_ID;
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
              <h1 class="m-0 text-dark">Editar Periodo</h1>
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
                    <!-- <div class="card-header card-info"> -->
                    <!-- <h3 class="card-title"></h3> -->
                    <!-- <div class="card-tools">
                          
                      </div>
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body mt-3">

                      <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                          <form role="form" method="POST" action="<?php echo base_url() ?>admin/sub_action/edit_term/<?php echo $term_id; ?>" enctype="multipart/form-data">
                            <div class="card-body">
                              <div class="form-group">
                                <label>Selecciona Año</label>
                                <select class="form-control" name="class">
                                  <option>--- --- ---</option>
                                  <?php
                                  $this->db->where('SESSION', $current_session);
                                  $class = $this->db->get('class_tbl')->result_array();
                                  foreach ($class as $row) :
                                  ?>
                                    <option value="<?php echo $row['ID'] ?>" <?php if ($cid == $row['ID']) echo 'selected'; ?>><?php echo $row['NAME']; ?></option>
                                  <?php
                                  endforeach;
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nombre</label>
                                <input autocomplete="off" value="<?php echo $tname ?>" type="text" name="tname" class="form-control">
                              </div>
                              <div class="form-group">
                                <label>Valor Tarifa Periodo</label>
                                <input autocomplete="off" type="tel" value="<?php echo $tfees ?>" name="tfees" class="form-control money">
                              </div>
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary">Editar Periodo</button>
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
          title: 'Notificación',
          text: '<?php echo $this->session->flashdata('completed'); ?>',
          type: 'success'
        });
      <?php } ?>
    });
  </script>

</body>

</html>