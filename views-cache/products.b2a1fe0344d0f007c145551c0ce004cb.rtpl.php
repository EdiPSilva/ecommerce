<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="/admin/products">Produtos</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-header">
              <a href="/admin/products/create" class="btn btn-success"><?php echo htmlspecialchars( $product_button_create, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
            </div>

            <div class="box-body no-padding table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="col-sm-1">#</th>
                    <th class="col-sm-4"><?php echo htmlspecialchars( $product_column_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                    <th class="col-sm-1"><?php echo htmlspecialchars( $product_column_price, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                    <th class="col-sm-1"><?php echo htmlspecialchars( $product_column_width, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                    <th class="col-sm-1"><?php echo htmlspecialchars( $product_column_height, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                    <th class="col-sm-1"><?php echo htmlspecialchars( $product_column_length, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                    <th class="col-sm-1"><?php echo htmlspecialchars( $product_column_weight, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                    <th class="col-sm-2"><?php echo htmlspecialchars( $product_column_ations, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>

                  <tr>
                    <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["vlprice"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["vlwidth"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["vlheight"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["vllength"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["vlweight"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td>
                      <a href="/admin/products/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i><?php echo htmlspecialchars( $default_update_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                      <a href="/admin/products/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i><?php echo htmlspecialchars( $default_delete_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                    </td>
                  </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->