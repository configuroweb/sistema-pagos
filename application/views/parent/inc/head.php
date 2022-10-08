<head>
  <?php
  $current_session = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->SESSION;
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Gestión Pagos | <?php echo $page_title; ?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/pnotify/pnotify.custom.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/plugins/datatables/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/custom.css">
</head>