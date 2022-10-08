<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
    <div class="text-muted"><?= $this->db->get_where('settings_tbl',array('ID'=>1))->row()->NAME ?> - Parent Side</div>
    
  </nav>