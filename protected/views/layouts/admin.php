<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/admin/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/admin/css/todc-bootstrap.css" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/js/bootstrap.min.js"></script>
        
        <?php foreach($this->clips as $k=>$v) if(strpos($k, 'extraCSS') === 0 || strpos($k, 'widgetCSS') === 0) echo $v;?>
        <?php foreach($this->clips as $k=>$v) if(strpos($k, 'extraJS') === 0 || strpos($k, 'widgetJS') === 0) echo $v;?>

	<title>Администраторский раздел</title>
</head>

<body style="margin:0px">

<?php if(!user()->isGuest):?>
<div class="navbar navbar-googlenav navbar-inverse navbar-fixed-top">
  <div class="navbar-inner" style="-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;">
    <div class="container">
 
      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
 
      <ul class="nav">
        <li class="__js_pageMain"><a href="<?=app()->createUrl('admin')?>">Главная страница</a></li>
        <li class="__js_pageSites dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Сайты <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?=app()->createUrl('admin/sites/new/1')?>">Добавить новый</a></li>
            <li><a href="<?=app()->createUrl('admin/sites')?>">Редактировать</a></li>
            <li class="divider"></li>
            <li><a href="#">Редактировать домены</a></li>
          </ul>
        </li>
        <li class="__js_pageBlocks"><a href="#">Инфоблоки</a></li>
        <li class="__js_pageFileManager"><a href="#">Файл-менеджер</a></li>
      </ul>
      <ul class="nav pull-right">
        <li class="divider-vertical"></li>
        <li><a href="#"><?=$this->user->username?></a></li>
        <li class="divider-vertical"></li>
        <li><a href="<?=app()->createUrl('admin/logout')?>">Выход</a></li>
      </ul>
 
    </div>
  </div>
</div>
<?php endif;?>
    
<div class="container" style="margin-top:60px">
<div class="row">
<?php echo $content; ?>
</div>
</div>
    
</body>
</html>