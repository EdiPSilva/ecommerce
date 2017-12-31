<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="col-md-4">
    <h1><?php echo htmlspecialchars( $title_create, ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
  </div>
  <div class="col-md-8">
    <ol class="breadcrumb">
      <li><a href="<?php echo htmlspecialchars( $home_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-dashboard"></i>&nbsp;<?php echo htmlspecialchars( $home_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
      <li><a href="<?php echo htmlspecialchars( $user_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-users"></i>&nbsp;<?php echo htmlspecialchars( $user_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
      <li class="active"><a href="/admin/users/create"><i class="fa fa-user-plus"></i>&nbsp;<?php echo htmlspecialchars( $user_menu_button_create, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
    </ol>
  </div>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <!-- <div class="box-header with-border">
          <h3 class="box-title">Novo Usuário</h3>
        </div> -->
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-footer">
          <form role="form" action="/admin/users/create" method="post">
            <div class="col-md-6">
              <div class="form-group">
                <label for="desperson"><?php echo htmlspecialchars( $label_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                <input type="text" class="form-control" id="desperson" name="desperson" placeholder="<?php echo htmlspecialchars( $input_name, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="deslogin"><?php echo htmlspecialchars( $label_login, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                <input type="text" class="form-control" id="deslogin" name="deslogin" placeholder="<?php echo htmlspecialchars( $input_login, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nrphone"><?php echo htmlspecialchars( $label_phone, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                <input type="tel" class="form-control" id="nrphone" name="nrphone" placeholder="<?php echo htmlspecialchars( $input_phone, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="desemail"><?php echo htmlspecialchars( $label_email, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                <input type="email" class="form-control" id="desemail" name="desemail" placeholder="<?php echo htmlspecialchars( $input_email, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="despassword"><?php echo htmlspecialchars( $label_pass, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                <input type="password" class="form-control" id="despassword" name="despassword" placeholder="<?php echo htmlspecialchars( $input_pass, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
            </div>
            <div class="col-md-6" style="margin-top:26px"></div>
            <div class="col-md-3">
              <div class="form-group">
                <input type="checkbox" name="inadmin" value="1">&nbsp;<label><?php echo htmlspecialchars( $label_admin, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <button type="submit" class="btn btn-success pull-right"><?php echo htmlspecialchars( $user_menu_button_finish, ENT_COMPAT, 'UTF-8', FALSE ); ?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->