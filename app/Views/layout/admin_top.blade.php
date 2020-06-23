<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>用户反馈中心</title>
    <link href="<?php echo resource('css/admin.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo resource('css/reset.css')?>" rel="stylesheet" type="text/css">
    <script src="<?php echo resource('js/jquery-3.2.1.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo resource('js/vue.js')?>" type="text/javascript"></script>
    <script src="<?php echo resource('js/admin.js')?>" type="text/javascript"></script>
</head>
<?php $LOGIN_USER_INFO = Session::get('loginUser')?>
<body>
<div class="clearfix" id="Box">
    <div class="left">
        <img class="logo" src="<?php echo resource('image/001.png')?>" />
        <div>
            <span class="admin"><?php echo $LOGIN_USER_INFO['user']?></span>
            <span class="logout"><a href="<?php echo url('/logout')?>">退出</a></span>
        </div>
        <ul>
            <li @classOn('/');><a href="<?php echo url('/')?>">首页</a></li>
            <li @classOn('/user/lists/view');><a href="<?php echo url('/user/lists/view')?>">用户管理</a></li>
            <li @classOn('/devices-manage');><a href="<?php echo url('/devices-manage')?>">授权管理</a></li>
        </ul>
    </div>
    <div class="right">
