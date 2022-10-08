<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
              <h1 class="m-0 text-dark">Gestionar Periodos</h1>
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
                    <div class="card-header card-danger">
                      <!-- <h3 class="card-title"></h3> -->
                      <div class="card-tools">

                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body mt-3">

                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" href="#courses" role="tab" data-toggle="tab">Periodos</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#add" role="tab" data-toggle="tab">Agregar Periodos</a>
                        </li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active table-responsive" id="courses">

                          <table class="table table-hover table-bordered table-striped" id="example1">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Año</th>
                                <th>Periodo</th>
                                <th>Tarifa</th>
                                <th>Acción</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $count = 1;
                              $this->db->where('SESSION', $current_session);
                              $term = $this->db->get('term_tbl')->result_array();
                              foreach ($term as $row) :
                              ?>
                                <tr>
                                  <td><?php echo $count++; ?></td>
                                  <td><?php echo $this->db->get_where('class_tbl', array('ID' => $row['CLASS_ID']))->row()->NAME; ?></td>
                                  <td><?php echo $row['NAME']; ?></td>
                                  <td><?php echo '$' . number_format($row['FEES']); ?></td>
                                  <td class="text-center">
                                    <a href="<?php echo base_url() ?>admin/options/edit_term/<?php echo $row['ID']; ?>" class="btn btn-sm btn-success btn-flat">Editar</a>
                                    <a href="<?php echo base_url() ?>admin/action/delete_term/<?php echo $row['ID']; ?>" class="btn btn-sm btn-flat btn-danger btn-flat" onclick="if(confirm(`¿Deseas eliminar este periodo?`) === false) event.preventDefault();">Eliminar</a>
                                  </td>
                                </tr>
                              <?php
                              endforeach;
                              ?>
                            </tbody>
                          </table>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="add">

                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <form role="form" method="POST" action="<?php echo base_url() ?>admin/action/new_term" enctype="multipart/form-data">
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
                                        <option value="<?php echo $row['ID'] ?>"><?php echo $row['NAME']; ?></option>
                                      <?php
                                      endforeach;
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Periodo</label>
                                    <input autocomplete="off" value="<?php ?>" type="text" name="tname" class="form-control" required>
                                  </div>
                                  <div class="form-group">
                                    <label>Tarifa por Periodo</label>
                                    <input autocomplete="off" type="tel" value="<?php  ?>" name="tfees" class="form-control money" required>
                                  </div>
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Agregar Nuevo Periodo</button>
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
    // $('select').on('change', function() {
    //   var id = this.value;
    // });
  </script>

</body>

</html>