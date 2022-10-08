<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link bg-light bg-gradient">
    <img src="<?php echo base_url() ?>uploads/logo.png" alt="School Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Gestión de Pagos</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url() ?>assets/backend/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->session->userdata('login_name'); ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo base_url() ?>admin" class="nav-link rounded-0 <?php if ($page_name == 'dashboard') echo 'active'; ?>">
            <i class="nav-icon fa fa-dashboard"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <?php
        if ($this->session->userdata('login_priv') == 'admin') :
        ?>

          <li class="nav-item has-treeview  <?php if ($page_name == 'management') echo 'menu-open'; ?>">
            <a href="#" class="nav-link rounded-0 <?php if ($page_name == 'management') echo 'active'; ?>">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                Configuración
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/management/class" class="nav-link rounded-0  <?php if ($page_s_name == 'class') echo 'active'; ?>">
                  <i class="fa fa-angle-double-right nav-icon"></i>
                  <p>Años</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/management/term" class="nav-link rounded-0  <?php if ($page_s_name == 'term') echo 'active'; ?>">
                  <i class="fa fa-angle-double-right nav-icon"></i>
                  <p>Periodos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/management/users" class="nav-link rounded-0 <?php if ($page_s_name == 'users') echo 'active'; ?>">
                  <i class="fa fa-angle-double-right nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/management/settings" class="nav-link rounded-0  <?php if ($page_s_name == 'settings') echo 'active'; ?>">
                  <i class="fa fa-angle-double-right nav-icon"></i>
                  <p>Configuración Goblal</p>
                </a>
              </li>

            </ul>
          </li>

        <?php
        endif;
        ?>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>admin/parent" class="nav-link rounded-0 <?php if ($page_name == 'parent') echo 'active'; ?>">
            <i class="nav-icon fa fa-users"></i>
            <p>
              Gestionar Padres
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview  <?php if ($page_name == 'enrollment') echo 'menu-open'; ?>">
          <a href="#" class="nav-link rounded-0 <?php if ($page_name == 'enrollment') echo 'active'; ?>">
            <i class="nav-icon fa fa-user-plus"></i>
            <p>
              Matriculas de Estudiantes
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php
            $this->db->where('SESSION', $current_session);
            $class = $this->db->get('class_tbl')->result_array();
            foreach ($class as $row) :
            ?>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/enrollment/class/<?php echo $row['ID'] ?>" class="nav-link rounded-0  <?php if ($page_s_name == $row['ID']) echo 'active'; ?>">
                  <i class="fa fa-angle-double-right nav-icon"></i>
                  <p><?php echo 'Año: ' . $row['NAME']; ?></p>
                </a>
              </li>
            <?php
            endforeach;
            ?>
          </ul>
        </li>

        <li class="nav-item has-treeview  <?php if ($page_name == 'payment') echo 'menu-open'; ?>">
          <a href="#" class="nav-link rounded-0 <?php if ($page_name == 'payment') echo 'active'; ?>">
            <i class="nav-icon fa fa-dollar"></i>
            <p>
              Sección de Pagos
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php
            $this->db->where('SESSION', $current_session);
            $class = $this->db->get('class_tbl')->result_array();
            foreach ($class as $row) :
            ?>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/payment/class/<?php echo $row['ID'] ?>" class="nav-link rounded-0  <?php if ($page_s_name == 'p' . $row['ID']) echo 'active'; ?>">
                  <i class="fa fa-angle-double-right nav-icon"></i>
                  <p><?php echo 'Año: ' . $row['NAME']; ?></p>
                </a>
              </li>
            <?php
            endforeach;
            ?>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>admin/payment/due_payment" class="nav-link rounded-0 <?php if ($page_s_name == 'due_pay') echo 'active'; ?>">
                <i class="fa fa-angle-double-right nav-icon"></i>
                <p>Pagos Realizados</p>
              </a>
            </li>
            <!-- <li class="nav-item">
                <a href="<?php //echo base_url() 
                          ?>admin/payment/none_payment" class="nav-link rounded-0 <?php //if($page_s_name=='none_pay') echo 'active'; 
                                                                                  ?>">
                  <i class="fa fa-angle-double-right nav-icon"></i>
                  <p>YET TO START PAYMENT</p>
                </a>
              </li> -->
          </ul>
        </li>


        <li class="nav-item">
          <a href="<?php echo base_url() ?>authe/logout" class="nav-link rounded-0">
            <i class="nav-icon fa fa-power-off"></i>
            <p>
              Cerrar Sesión
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>