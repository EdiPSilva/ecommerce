<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
    <section class="content-header">
        <div class="col-md-4"><h1><?php echo htmlspecialchars( $product_title, ENT_COMPAT, 'UTF-8', FALSE ); ?></h1></div>
        <div class="col-md-8">
            <ol class="breadcrumb">
                <li><a href="<?php echo htmlspecialchars( $home_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-dashboard"></i>&nbsp;<?php echo htmlspecialchars( $home_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li><a href="<?php echo htmlspecialchars( $product_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-cubes"></i>&nbsp;<?php echo htmlspecialchars( $product_title, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li><a href="/admin/products/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-edit"></i>&nbsp;<?php echo htmlspecialchars( $product_title_edit, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            <h3 class="box-title"><?php echo htmlspecialchars( $product_title_edit, ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                        </div>
                    </div>
                    <form role="form" action="/admin/products/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desproduct"><?php echo htmlspecialchars( $product_label_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="text" class="form-control" id="desproduct" name="desproduct" placeholder="<?php echo htmlspecialchars( $product_input_name, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $product["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="vlprice"><?php echo htmlspecialchars( $product_label_price, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="number" class="form-control" id="vlprice" name="vlprice" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_price, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $product["vlprice"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="vlwidth"><?php echo htmlspecialchars( $product_label_width, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="number" class="form-control" id="vlwidth" name="vlwidth" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_width, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $product["vlwidth"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="vlheight"><?php echo htmlspecialchars( $product_label_height, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="number" class="form-control" id="vlheight" name="vlheight" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_height, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $product["vlheight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="vllength"><?php echo htmlspecialchars( $product_label_length, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="number" class="form-control" id="vllength" name="vllength" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_length, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $product["vllength"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="vlweight"><?php echo htmlspecialchars( $product_label_weight, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="number" class="form-control" id="vlweight" name="vlweight" step="0.01" placeholder="<?php echo htmlspecialchars( $product_input_weight, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $product["vlweight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file"><?php echo htmlspecialchars( $product_label_photo, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="file" class="form-control" id="file" name="file" value="<?php echo htmlspecialchars( $product["vlweight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                    <div class="box box-widget">
                                        <div class="box-body">
                                            <img class="img-responsive" id="image-preview" src="<?php echo htmlspecialchars( $product["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Photo">
                                        </div>
                                    </div>
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
<script>
    document.querySelector('#file').addEventListener('change', function()
    {
        var file = new FileReader();
        file.onload = function()
        {
            document.querySelector('#image-preview').src = file.result;
        }
        file.readAsDataURL(this.files[0]);
    });
</script>