<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<base href="<?php echo $data['rootUrl']; ?>" />
<link href="<?php echo $data['rootUrl']; ?>css/common.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $data['rootUrl']; ?>css/admin.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $data['rootUrl']; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/html5upload.js"></script>
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/bootstrap.js"></script>
<style>

</style>
<title><?php echo $data['blogname']; ?> - 管理中心</title>
</head>
<body>
<div class="c w">
<header id="header">
<nav class="navbar navbar-static">
              <div class="navbar-inner">
                <div class="container" style="width: auto;">
                  <a class="brand" href="#"></a>
                  <ul class="nav" role="navigation">
                    <li class="dropdown">
                      <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Blog <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                        <li><a tabindex="-1" href="admin/write/post">Write</a></li>
                        <li><a tabindex="-1" href="admin/posts">管理</a></li>
                        <li><a tabindex="-1" href="admin/drafts">草稿</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="admin/trashes">回收站</a></li>
                      </ul>
                    </li>
                      <li class="dropdown">
                      <a id="drop2" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">页面<b class="caret"></b></a>
                       <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">

                        <li><a tabindex="-1" href="admin/write/page">Write</a></li>
                        <li><a tabindex="-1" href="admin/pages">管理</a></li>
                      </ul>
                    </li>
                      <li class="dropdown">
                      <a id="drop3" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">日记<b class="caret"></b></a>
                       <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">

                        <li><a tabindex="-1" href="admin/write/diary">Write</a></li>
                        <li><a tabindex="-1" href="admin/diaries">管理</a></li>
                      </ul>
                    </li>
                     <li>
                      <a href="admin/categories" role="button">分类</a>
                    </li>
                    
                    <li>
                      <a href="admin/tags" role="button">标签</a>
                    </li>
                   <li>
                      <a href="admin/links" role="button">链接</a>
                    </li>
                      <li id="fat-menu" class="dropdown">
                      <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">评论 <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                        <li><a tabindex="-1" href="admin/comments/all">所有评论</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="admin/comments/unapproved">未通过</a></li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="nav pull-right">
                    <li id="fat-menu" class="dropdown">
                      <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user" style="background-color:#fff;margin-right:5px;"></i><?php echo $data['user']['username']; ?> <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                        <li><a tabindex="-1" href="admin/comments/all">档案</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="admin/logout">退出</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
	
</header>
