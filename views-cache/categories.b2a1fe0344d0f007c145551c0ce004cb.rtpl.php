<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
    <section class="content-header">
        <div class="col-md-4"><h1><?php echo htmlspecialchars( $category_title, ENT_COMPAT, 'UTF-8', FALSE ); ?></h1></div>
        <div class="col-md-8">
            <ol class="breadcrumb">
                <li><a href="<?php echo htmlspecialchars( $home_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-dashboard"></i>&nbsp;<?php echo htmlspecialchars( $home_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li><a href="<?php echo htmlspecialchars( $category_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-tags"></i>&nbsp;<?php echo htmlspecialchars( $category_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="col-sm-9">
                            <h3><?php echo htmlspecialchars( $category_title_list, ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                        </div>
                        <div class="col-sm-3">
                            <a href="/admin/categories/create" class="btn btn-success pull-right"><i class="fa fa-plus"></i>&nbsp;<?php echo htmlspecialchars( $category_button_create, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1">#</th>
                                        <th class="col-sm-8"><?php echo htmlspecialchars( $category_column_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                                        <th class="col-sm-3"><?php echo htmlspecialchars( $category_column_actions, ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter1=-1;  if( isset($categories) && ( is_array($categories) || $categories instanceof Traversable ) && sizeof($categories) ) foreach( $categories as $key1 => $value1 ){ $counter1++; ?>

                                        <tr>
                                            <td class="col-sm-1"><?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                            <td class="col-sm-8"><?php echo htmlspecialchars( $value1["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                            <td class="col-sm-3">
                                                <div class="col-sm-4">
                                                    <a href="/admin/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/products" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Produtos</a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a href="/admin/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> <?php echo htmlspecialchars( $default_update_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a href="/admin/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <?php echo htmlspecialchars( $default_delete_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                                                </div>
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