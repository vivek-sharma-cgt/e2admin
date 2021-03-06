<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this); 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
        <title>Admin</title>
        <?php $this->head() ?>
</head>
<body class="hold-transition skin-purple-light sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=Url::toRoute('dashboard/index')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?=Html::img(Url::toRoute('@imagepath').'/avatar3.png',['class' => 'user-image']);?>
              <span class="hidden-xs text-uppercase"><?=!empty(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : '';?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
               <?=Html::img(Url::toRoute('@imagepath').'/avatar3.png',['class' => 'img-circle']);?>
                <p class="text-uppercase">
                <?=!empty(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : '';?>
                  <small></small>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=Url::toRoute('user/profile')?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                <?php 
                  echo Html::beginForm(['/site/logout'],'post');
                  echo Html::submitButton(
                      'Sign out',
                      ['class' => 'btn btn-default btn-flat']
                  );
                  echo Html::endForm();
                ?>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
        <?=Html::img(Url::toRoute('@imagepath').'/avatar3.png',['class' => 'img-circle']);?>
        </div>
        <div class="pull-left info">
          <p><?=!empty(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : '';?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class=" treeview">
          <a href="<?=Url::toRoute('dashboard/index')?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class=" treeview">
          <a href="<?=Url::toRoute('user/index')?>">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
        <li class=" treeview">
          <a href="#">
            <i class="fa fa-universal-access"></i> <span>Access Control</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=Url::toRoute('roles/index')?>"><i class="fa fa-circle-o"></i>Roles</a></li>
            <li><a href="<?=Url::toRoute('permission/index')?>"><i class="fa fa-circle-o"></i>Permissions</a></li>
          </ul>
        </li> 
        <li class=" treeview">
          <a href="<?=Url::toRoute('cms/index')?>">
            <i class="fa fa-pencil"></i> <span>CMS Manager</span>
          </a>
        </li>
        <li class=" treeview">
          <a href="<?=Url::toRoute('emails/index')?>">
            <i class="fa fa-envelope"></i> <span>Email Manager</span>
          </a>
        </li>
        <li class=" treeview">
          <a href="<?=Url::toRoute('settings/index')?>">
            <i class="fa fa-sliders"></i> <span>Settings</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <?=$this->title?>
        <small><?php echo !empty($this->description) ? $this->description  : ''?></small>
      </h1>
      <ol class="breadcrumb">
      <?=Breadcrumbs::widget([
          'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]);?>
      </ol>
    </section>
     <section class="content" id="main_content">
    <?=$content?>
    </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">CGT Technosoft</a>.</strong>
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  //$.widget.bridge('uibutton', $.ui.button);
</script>

<?php $this->endBody() ?>
<div class="loader"><div class="spinner-loader"></div></div>
</body>
</html>
<?php $this->endPage() ?>