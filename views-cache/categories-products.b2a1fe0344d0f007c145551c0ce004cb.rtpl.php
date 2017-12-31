<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
    <section class="content-header">
        <div class="col-md-6"><h1><?php echo htmlspecialchars( $category_products_in_category, ENT_COMPAT, 'UTF-8', FALSE ); ?></h1></div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li><a href="<?php echo htmlspecialchars( $home_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-dashboard"></i>&nbsp;<?php echo htmlspecialchars( $home_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li><a href="<?php echo htmlspecialchars( $category_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-tags"></i>&nbsp;<?php echo htmlspecialchars( $category_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li><a href="/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-tag"></i>&nbsp;<?php echo htmlspecialchars( $category["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li class="active"><a href="/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/products"><i class="fa fa-link"></i>&nbsp;Produtos</a></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12" style="padding: 0">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo htmlspecialchars( $category_all_products, ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th><?php echo htmlspecialchars( $category_column_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                                        <th style="width: 240px">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter1=-1;  if( isset($productsNotRelated) && ( is_array($productsNotRelated) || $productsNotRelated instanceof Traversable ) && sizeof($productsNotRelated) ) foreach( $productsNotRelated as $key1 => $value1 ){ $counter1++; ?>

                                        <tr>
                                            <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                            <td><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                            <td>
                                                <a href="/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/products/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i>&nbsp;<?php echo htmlspecialchars( $default_add_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo htmlspecialchars( $category["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th><?php echo htmlspecialchars( $category_column_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                                        <th style="width: 240px">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter1=-1;  if( isset($productsRelated) && ( is_array($productsRelated) || $productsRelated instanceof Traversable ) && sizeof($productsRelated) ) foreach( $productsRelated as $key1 => $value1 ){ $counter1++; ?>

                                    <tr>
                                        <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                        <td><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                        <td>
                                        <a href="/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/products/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/remove" class="btn btn-danger btn-xs pull-right"><i class="fa fa-arrow-left"></i>&nbsp;<?php echo htmlspecialchars( $default_remove_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>        
            </div>        
        </div>
    </section>
</div>