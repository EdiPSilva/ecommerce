<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/categories">Categorias</a></li>
    <li class="active"><a href="/admin/categories/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/products/create" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="desproduct"><?php echo htmlspecialchars( $product_label_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              <input type="text" class="form-control" id="desproduct" name="desproduct" placeholder="<?php echo htmlspecialchars( $product_input_name, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="vlprice"><?php echo htmlspecialchars( $product_label_price, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              <input type="number" class="form-control" id="vlprice" name="vlprice" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_price, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="vlwidth"><?php echo htmlspecialchars( $product_label_width, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              <input type="number" class="form-control" id="vlwidth" name="vlwidth" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_width, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="vlheight"><?php echo htmlspecialchars( $product_label_height, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              <input type="number" class="form-control" id="vlheight" name="vlheight" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_height, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="vllength"><?php echo htmlspecialchars( $product_label_length, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              <input type="number" class="form-control" id="vllength" name="vllength" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_length, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="vlweight"><?php echo htmlspecialchars( $product_label_weight, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              <input type="number" class="form-control" id="vlweight" name="vlweight" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_weight, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="desurl"><?php echo htmlspecialchars( $product_label_url, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
              <input type="text" class="form-control" id="desurl" name="desurl" placeholder="<?php echo htmlspecialchars( $product_input_url, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success"><?php echo htmlspecialchars( $default_register_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->