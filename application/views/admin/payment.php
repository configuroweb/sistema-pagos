<?php
defined('BASEPATH') or exit('No direct script access allowed');

$current_session = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->SESSION;
$class_name = $this->db->get_where('class_tbl', array('ID' => $class_id))->row()->NAME;
$fees = $this->db->get_where('class_tbl', array('ID' => $class_id))->row()->FEES;

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
              <h1 class="m-0 text-dark"><?php echo ' Gestionar pago por el año ' . $class_name; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fa fa-bell"></i> Recuerda!</h5>
                <?php echo 'El pago total de ' . $class_name . ', para el año lectivo es: ' . $current_session . ' es de $' . number_format($fees); ?>
              </div>
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
                    <div class="card-body mt-3 table-responsive">

                      <table class="table table-hover table-bordered table-striped" id="example1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Padres</th>
                            <th>Estudiante</th>
                            <th>Monto Pagado</th>
                            <th>Pendiente</th>
                            <th>Estado</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $count = 1;
                          $this->db->where('CLASS', $class_id);
                          $this->db->where('SESSION', $current_session);
                          $student = $this->db->get('student')->result_array();
                          foreach ($student as $row) :
                            $amount_paid = $this->db->get_where('payment_tbl', array('STUDENT' => $row['ID'], 'SESSION' => $current_session))->row()->AMOUNT_PAID;
                            $amount_pending = $this->db->get_where('payment_tbl', array('STUDENT' => $row['ID'], 'SESSION' => $current_session))->row()->AMOUNT_PENDING;
                            $total_amount = $this->db->get_where('payment_tbl', array('STUDENT' => $row['ID'], 'SESSION' => $current_session))->row()->TOTAL_AMOUNT;
                          ?>
                            <tr>
                              <td><?php echo $count++; ?></td>
                              <td>
                                <?php echo $this->db->get_where('parent_tbl', array('ID' => $row['PARENT']))->row()->NAME . ' (' . $this->db->get_where('parent_tbl', array('ID' => $row['PARENT']))->row()->EMAIL . ')'; ?>
                              </td>
                              <td><?php echo $row['NAME']; ?></td>
                              <td><?php echo '$' . number_format($amount_paid) ?></td>
                              <td><?php echo '$' . number_format($amount_pending) ?></td>
                              <td class="text-center align-items-center"><?php if ($amount_paid >= $total_amount) {
                                                                            echo '<span class="badge badge-success badge-pill px-2">Completado</span>';
                                                                          } else {
                                                                            echo '<span class="badge badge-danger badge-pill px-2">Incompleto</span>';
                                                                          } ?></td>
                              <td class="text-center">
                                <?php
                                if ($amount_paid != $total_amount) :
                                ?>
                                  <a style="" href="<?php echo base_url() ?>admin/payment/single/<?php echo $class_id ?>/<?php echo $row['ID'] ?>" class="btn btn-sm btn-info">Pagar</a>
                                <?php
                                endif;
                                if ($amount_paid >= $total_amount) :
                                ?>
                                  <button class="btn btn-sm btn-primary" style="" data-toggle="modal" data-target="#promote<?php echo $row['ID']; ?>">Promover</button>
                                <?php
                                endif;
                                ?>
                              </td>
                            </tr>


                            <!-- Modal -->
                            <div class="modal fade" id="promote<?php echo $row['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog modal-dialog-centered modal-sm" role="form">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">PROMOTE <?php echo $row['NAME'] ?></h5>
                                  </div>
                                  <form method="POST" action="<?php echo base_url() ?>admin/promote/<?php echo $class_id ?>/<?php echo $row['ID'] ?>" enctype="multipart/form-data">
                                    <div class="modal-body">
                                      <div class="form-group">
                                        <label>NEW SESSION</label>
                                        <select name="session" onchange="return get_class(this.value)" class="form-control selectboxit">
                                          <option value="">--- ---</option>
                                          <?php for ($i = 0; $i < 20; $i++) : ?>
                                            <option value="<?php echo (2019 + $i); ?>-<?php echo (2019 + $i + 1); ?>" <?php if ($current_session == (2019 + $i) . '-' . (2019 + $i + 1)) echo 'selected'; ?>>
                                              <?php echo (2019 + $i); ?>-<?php echo (2019 + $i + 1); ?>
                                            </option>
                                          <?php endfor; ?>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label>NEW CLASS</label>
                                        <select name="class" required class="form-control" id="class_holder">
                                          <option value="">Select Session First</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" id="xx">PROMOTE</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>


                          <?php
                          endforeach;
                          ?>
                        </tbody>
                      </table>

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

      <?php if ($this->session->flashdata('completed') != '') { ?>
        new PNotify({
          title: 'Notificación',
          text: '<?php echo $this->session->flashdata('completed'); ?>',
          type: 'success'
        });
      <?php } ?>
    })
  </script>
  <!-- Auto Populate revenue heads -->
  <script>
    function get_class(session) {
      $.ajax({
        url: '<?php echo base_url(); ?>admin/get_class/' + session,
        success: function(response) {
          $('div select#class_holder').html(response);
        },
      });
    }
  </script>
  <!-- End auto populate -->
</body>

</html>