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
              <h1 class="m-0 text-dark">DASHBOARD</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 text-right">
              <?php echo 'Periodo Lectivo: ' . $current_session; ?>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <hr>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box rounded-0 shadow border border-info">
                <div class="inner">
                  <h3>
                    <?php
                    $this->db->from('student');
                    $this->db->where('SESSION', $current_session);
                    $numquery = $this->db->get();
                    echo $numquery->num_rows();
                    ?>
                  </h3>

                  <p>Total de Estudiantes</p>
                </div>
                <div class="icon">
                  <i class="fa fa-graduation-cap"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box rounded-0 shadow border border-danger">
                <div class="inner">
                  <h3>
                    <?php
                    $this->db->from('parent_tbl');
                    $numquery = $this->db->get();
                    echo $numquery->num_rows();
                    ?>
                  </h3>

                  <p>Total de Padres</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box rounded-0 shadow border border-success">
                <div class="inner">
                  <h3>
                    <?php
                    $this->db->select('SUM(AMOUNT_PAID) as amt');
                    $this->db->where('SESSION', $current_session);
                    $q = $this->db->get('all_payments_tbl');
                    $r = $q->row();
                    echo '$' . number_format(isset($r->amt) ? $r->amt : 0);
                    ?>
                  </h3>
                  <p>Total de Ingresos</p>
                </div>
                <div class="icon">
                  <i class="fa fa-dollar"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="row">
            <div class="col-12">
              <canvas id="myChart" style="width: 100%; height: 400px;"></canvas>
            </div>
          </div>
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
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: [
          <?php
          $total = array();
          $t = 0;
          $this->db->distinct();
          $this->db->select();
          $this->db->group_by("SESSION");
          $p = $this->db->get('all_payments_tbl')->result_array();
          foreach ($p as $row) :

            $this->db->select('SUM(AMOUNT_PAID) as amt');
            $this->db->where('SESSION', $row['SESSION']);
            $q = $this->db->get('all_payments_tbl');
            $r = $q->row();
            array_push($total, $r->amt);

          ?> '<?php echo $row['SESSION'] ?>',
          <?php endforeach; ?>
        ],
        datasets: [{
          label: 'Payments Per Session',

          data: [
            <?php
            foreach ($total as $t) :
            ?> '<?php echo $t ?>',
            <?php
            endforeach;
            ?>,
          ],

          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>

</body>

</html>