<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
    <section class="content-header">
        <div class="col-md-4"><h1><?php echo htmlspecialchars( $category_title, ENT_COMPAT, 'UTF-8', FALSE ); ?></h1></div>
        <div class="col-md-8">
            <ol class="breadcrumb">
                <li><a href="<?php echo htmlspecialchars( $home_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-dashboard"></i>&nbsp;<?php echo htmlspecialchars( $home_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li><a href="<?php echo htmlspecialchars( $category_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-tags"></i>&nbsp;<?php echo htmlspecialchars( $category_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li class="active"><a href="/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-edit"></i>&nbsp;<?php echo htmlspecialchars( $category_title_register, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            <h3 class="box-title"><?php echo htmlspecialchars( $category_title_edit, ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                        </div>
                    </div>
                    <form role="form" action="/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descategory"><?php echo htmlspecialchars( $category_label_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="text" class="form-control" id="descategory" name="descategory" placeholder="<?php echo htmlspecialchars( $category_input_name, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $category["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success"><?php echo htmlspecialchars( $default_update_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>