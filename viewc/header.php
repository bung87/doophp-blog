<!DOCTYPE HTML>
<html data-action="<?php echo $data['action']; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $data['title']; ?></title>
<meta name="keywords" content="<?php echo $data['keywords']; ?>" />
<meta name="description" content="<?php echo $data['description']; ?>" />
<base href="<?php echo $data['rootUrl']; ?>" />
<link rel='icon' href="/favicon.ico" />
<!--link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo $data['rootUrl']; ?>xmlrpc.php?rsd" /-->
<!--link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo $data['rootUrl']; ?>wlwmanifest.xml" /-->
<link rel="alternate" type="application/rss+xml" title="RSS"  href="/rss" />

<!--link rel="stylesheet" href="/css/syntaxhighlighter_3.0.83/shCoreDefault.css" /-->
<script src="/js/jquery-1.8.0.min.js"></script>
<script src="/js/google-code-prettify/prettify.js"></script>

<!--script src="/js/syntaxhighlighter_3.0.83/shCore.js"></script-->
<!--script src="/js/syntaxhighlighter_3.0.83/shAutoloader.js"></script-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="/js/excanvas.js"></script>
<![endif]-->
<script src="/js/jquery.tagcanvas.js"></script>
<script src="/js/notifier.js" async></script>
<script src="/js/plugin-cookie.js"></script>
<script src="/js/main.js"></script>
<link rel="stylesheet" href="/css/common.css" />
<link rel="stylesheet" href="/css/main.css" />
<link rel="stylesheet" href="/css/prettify.css"  />
</head>
<body>
	<div id="cover"></div>
<!--canvas id="myCanvas"></canvas-->
<div role="wrap">
	<div id="top"> <div class="c w pt5">
	
</div>
</div>
  <header id="header">
    <div class="w">
    	<h1><a href="./"><img src="./img/logo.png" alt="<?php echo $data['blogname']; ?>" /></a><i>beta</i></h1>
    	<div id="apps"><a id="RSS" href="./rss" >RSS</a></div>
    	<div id="searcher"><form id="searchform" name="keyform" method="get" action="./search">
			<input name="keyword" results='10' type='search' placeholder="<?php echo lang('search'); ?>" value="" />
			<button type="submit" id="search" value="true">GO</button>
			</form></div>
			<div id="language">
				<select>
				<option value="language" selected disable>Language</option>
				<option value="en">English</option>
				<option value="zh-cn">Chinese</option>
				<option value="ja">Japanese</option>
				</select>
			</div>
    </div>
		<div id="navwrap">
			<nav id="nav" class="c w br_b">
   				<ul>
					<li class="first"><a href="./"><?php echo lang('home'); ?></a></li>
					<li class="common"><a href="./diary"><?php echo lang('diary'); ?></a></li>
					
   				</ul>
   			</nav>
		</div>
  </header><!-- end #header-->
  
