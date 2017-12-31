<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
    <section class="content-header">
        <div class="col-md-4"><h1><?php echo htmlspecialchars( $user_title, ENT_COMPAT, 'UTF-8', FALSE ); ?></h1></div>
        <div class="col-md-8">
            <ol class="breadcrumb">
                <li><a href="<?php echo htmlspecialchars( $home_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-dashboard"></i>&nbsp;<?php echo htmlspecialchars( $home_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li><a href="<?php echo htmlspecialchars( $user_menu_link, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-users"></i>&nbsp;<?php echo htmlspecialchars( $user_menu_text, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <li class="active"><a href="/admin/users/create"><i class="fa fa-user"></i>&nbsp;<?php echo htmlspecialchars( $user_title_create, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo htmlspecialchars( $user_title_create, ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                    </div>
                    <form role="form" action="/admin/users/create" method="post">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desperson"><?php echo htmlspecialchars( $user_label_name, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="text" class="form-control" id="desperson" name="desperson" placeholder="<?php echo htmlspecialchars( $user_input_name, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deslogin"><?php echo htmlspecialchars( $user_label_login, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="text" class="form-control" id="deslogin" name="deslogin" placeholder="<?php echo htmlspecialchars( $user_input_login, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nrphone"><?php echo htmlspecialchars( $user_label_phone, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="tel" class="form-control" id="nrphone" name="nrphone" placeholder="<?php echo htmlspecialchars( $user_input_phone, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desemail"><?php echo htmlspecialchars( $user_label_email, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="email" class="form-control" id="desemail" name="desemail" placeholder="<?php echo htmlspecialchars( $user_input_email, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="despassword"><?php echo htmlspecialchars( $user_label_pass, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                    <input type="password" class="form-control" id="despassword" name="despassword" placeholder="<?php echo htmlspecialchars( $user_input_pass, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="checkbox" name="inadmin" value="1">&nbsp;<label><?php echo htmlspecialchars( $user_label_admin, ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><?php echo htmlspecialchars( $default_register_button, ENT_COMPAT, 'UTF-8', FALSE ); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>