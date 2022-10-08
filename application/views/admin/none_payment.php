<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
            <h3 class="m-0 text-dark">List of Students That Are Yet To Make Payment</h3>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
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

                <table class="table table-bordered table-striped" id="example1">
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th>PARENT</th>
                      <th>NAME</th>
                      <th>CLASS</th>
                      <th>DUE</th>
                      <th>ACTIONS</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $count = 1;
                    $this->db->where('SESSION', $current_session);
                    $payments = $this->db->get('all_payments_tbl')->result_array();
                    foreach ($payments as $row):
                      
                    ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td>
                        <?php 
                        $parent = $this->db->get_where('student',array('ID'=>$row['STUDENT']))->row()->PARENT;
                        echo $this->db->get_where('parent_tbl',array('ID'=>$parent))->row()->NAME.' ('.$this->db->get_where('parent_tbl',array('ID'=>$parent))->row()->EMAIL.')'; 
                        ?>
                      </td>
                      <td><?php echo $this->db->get_where('student',array('ID'=>$row['STUDENT']))->row()->NAME; ?></td>
                      <td><?php echo $this->db->get_where('class_tbl',array('ID'=>$row['CLASS']))->row()->NAME; ?></td>
                      <td><span style="color: red; font-weight: bolder;">
                        <?php
                        echo date("d",strtotime($row['EXPIRE_DATE'])).'/'. date("F",strtotime($row['EXPIRE_DATE'])).'/'. date("Y",strtotime($row['EXPIRE_DATE']))
                        ?> 
                        </span></td>
                      <td>
                        <a style="padding: 2px; font-size: 12px;" href="<?php echo base_url() ?>admin/payment/single/<?php echo $row['CLASS'].'/'.$row['STUDENT'] ?>" class="btn btn-sm btn-info">VIEW PAYMENT</a>
                      </td>
                    </tr>
                    <?php  
                    endforeach;
                    ?>
                  </tbody>
                </table>

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
  $('#example1').DataTable();
</script>

</body>
</html>
