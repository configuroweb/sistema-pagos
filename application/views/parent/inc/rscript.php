<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/backend/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>assets/backend/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/pnotify/pnotify.custom.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/money-js/simple.money.format.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url() ?>assets/backend/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/backend/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/backend/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/Chart.min.js"></script>

<script>
  $(function () {
    
<?php if($this->session->flashdata('due_payment') != ''){ ?>
    new PNotify({
        title: 'Payment Due',
        text: '<span style="font-weight: bolder;">PAYMENTS ARE DUE.</span>',
        type: 'error'
    });
<?php } ?>

  });
</script>