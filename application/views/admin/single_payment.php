<?php
defined('BASEPATH') or exit('No direct script access allowed');

$class_name = $this->db->get_where('class_tbl', array('ID' => $class_id))->row()->NAME;
$student_name = $this->db->get_where('student', array('ID' => $student_id))->row()->NAME;

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
            <div class="col-sm-12">
              <h1 class="m-0 text-dark">Pagos Relacionados con el Estudiante <?php echo $student_name; ?></h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <?php

          $this->db->where('SESSION', $current_session);
          $this->db->where('CLASS_ID', $class_id);
          $term = $this->db->get('term_tbl')->result_array();

          foreach ($term as $row) :
            $term_id = $row['ID'];
            $total_fees = $row['FEES'];

            $this->db->select('SUM(AMOUNT_PAID) as amt');
            $this->db->where('STUDENT', $student_id);
            $this->db->where('SESSION', $current_session);
            $this->db->where('CLASS', $class_id);
            $this->db->where('TERM', $term_id);
            $q = $this->db->get('all_payments_tbl');
            $r = $q->row();
            $amount_paid = $r->amt;


            $pending_amount = $total_fees - $amount_paid;
          ?>
            <div class="card card-danger card-outline rounded-0">
              <div class="card-header">
                <h3 class="card-title">Pago Realizado por el Periodo <b><?php echo $row['NAME']; ?></b></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"> Ampliar <i class="fa fa-expand"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-7">
                    <div class="card card-info rounded-0">
                      <div class="card-header rounded-0">
                        <h3 class="card-title">
                          <i class="fa fa-dollar"></i>
                          Cuotas
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body table-responsive">
                        <table id="example2" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Monto</th>
                              <th>Fecha del Pago</th>
                              <th>Fecha de Expiración</th>
                              <th>Silenciar alerta</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $count = 1;
                            $this->db->where('STUDENT', $student_id);
                            $this->db->where('CLASS', $class_id);
                            $this->db->where('TERM', $row['ID']);
                            $this->db->order_by('ID', 'DESC');
                            $payments = $this->db->get('all_payments_tbl')->result_array();
                            foreach ($payments as $pay) :
                            ?>
                              <tr>
                                <td><?php echo $count++; ?></td>
                                <td>$ <?php echo number_format($pay['AMOUNT_PAID']) ?></td>
                                <td><?php echo date("d", strtotime($pay['CREATION_DATE'])) . '/' . date("F", strtotime($pay['CREATION_DATE'])) . '/' . date("Y", strtotime($pay['CREATION_DATE'])) ?></td>
                                <td><?php echo date("d", strtotime($pay['EXPIRE_DATE'])) . '/' . date("F", strtotime($pay['EXPIRE_DATE'])) . '/' . date("Y", strtotime($pay['EXPIRE_DATE'])) ?></td>
                                <td>
                                  <a href="<?php echo base_url() ?>admin/payment/<?php
                                                                                  if ($pay['ALERT'] == 0) {
                                                                                    echo 'mute';
                                                                                  } else {
                                                                                    echo 'unmute';
                                                                                  } ?>/<?php echo $pay['ID'] . '/' . $student_id . '/' . $pay['CLASS'] ?>" class="btn <?php if ($pay['ALERT'] == 0) {
                                                                                                                                                                        echo 'btn-warning';
                                                                                                                                                                      } else {
                                                                                                                                                                        echo 'btn-info';
                                                                                                                                                                      } ?> btn-sm"><?php if ($pay['ALERT'] == 0) {
                                                                                                                                                                                      echo 'Silenciar';
                                                                                                                                                                                    } else {
                                                                                                                                                                                      echo 'No Silenciar';
                                                                                                                                                                                    } ?></a>
                                </td>
                              </tr>
                            <?php
                            endforeach;
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="card card-danger rounded-0">
                      <div class="card-header rounded-0">
                        <h3 class="card-title">
                          <i class="fa fa-dollar"></i>
                          Realizar Nuevo Pago
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <form class="form-horizontal" method="POST" action="<?php echo base_url() ?>admin/payment_actions/new_pay/<?php echo $class_id ?>/<?php echo $student_id . '/' . $row['ID'] ?>" enctype="multipart/form-data">
                          <div class="card-body">
                            <div class="form-group">
                              <label for="">Monto Total Pagable por el Periodo</label>
                              <input type="text" value="$ <?php echo number_format(isset($total_fees) ? $total_fees : 0); ?>" disabled class="form-control">
                            </div>
                            <div class="form-group">
                              <label for="">Total Total Pagado</label>
                              <input type="text" value="$ <?php echo number_format(isset($amount_paid) ? $amount_paid : 0); ?>" disabled class="form-control" id="" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Pago Pendiente</label>
                              <input type="text" value="$ <?php echo number_format(isset($pending_amount) ? $pending_amount : 0); ?>" disabled class="form-control" id="" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Nuevo Pago</label>
                              <input autocomplete="off" <?php if ($amount_paid >= $total_fees) echo 'disabled'; ?> type="text" required name="new_pay" class="form-control money" id="" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Fecha de Expiración del Pago</label>
                              <input autocomplete="off" <?php if ($amount_paid >= $total_fees) echo 'disabled'; ?> type="date" required name="ex_date" class="form-control">
                            </div>

                          </div>
                          <!-- /.card-body -->

                          <div class="card-footer">
                            <button type="submit" <?php if ($amount_paid >= $total_fees) echo 'disabled'; ?> class="btn btn-primary">Procesar Pago</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          <?php
          endforeach;
          ?>
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

    })

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

    $('.money').simpleMoneyFormat();
  </script>

</body>

</html>