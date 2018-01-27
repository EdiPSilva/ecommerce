<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/res/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo htmlspecialchars( $desperson, ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i><?php echo htmlspecialchars( $status, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li><a href="<?php echo htmlspecialchars( $home_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-dashboard"></i> <span><?php echo htmlspecialchars( $home_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
        <li><a href="<?php echo htmlspecialchars( $user_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-users"></i> <span><?php echo htmlspecialchars( $user_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
        <li><a href="<?php echo htmlspecialchars( $category_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-tags"></i> <span><?php echo htmlspecialchars( $category_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
        <li><a href="<?php echo htmlspecialchars( $product_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-cubes"></i> <span><?php echo htmlspecialchars( $product_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
        <li><a href="/admin/orders"><i class="fa fa-shopping-cart"></i> <span>Pedidos</span></a></li>
        <!-- <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li> -->
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>