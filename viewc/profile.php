<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//header.php"; ?>

<div id="container" class="c w">
<div id="main">
<article>
	<header><h2>关于我</h2></header>
	<section id="content" itemscope itemtype="http://schema.org/Person">
		<!-- or itemtype="http://data-vocabulary.org/Person" schema is new feature-->
			<p>大家好！我是<span itemprop="nickname">十六</span>。</p>
			<p><a itemprop="url" href="http://fan16.net">fan16.net</a>是我独自开发的。</p>
			<p>也是第一次尝试一个完整应用的前后端开发。</p>
			<p>我出生于<span itemprop="birthDate">1987年12月23日</span></p>
			<p>目前的职业是<span itemprop="jobTitle">前端工程师</span></p>
			<p>我在<span itemprop="workLocation">北京</span>一家互联网公司供职</p>
			<p>可以通过我的邮箱<span itemprop="email">zh.bung#gmail.com</span>联系我</p>

	</section>
	<section class="piclist c">
		<h3>我最近在听的（2周）</h3>
		<p>数据来源于<a href="http://www.douban.com" target="_blank">豆瓣</a>API</p>
		<ul class="l">
			<?php foreach($data['albums'] as $k1=>$v1): ?>
			<li class="l"><a href="<?php echo $v1['link']; ?>" target="_blank"><img src="<?php echo $v1['img']; ?>" /></a><p><?php echo $v1['title']; ?></p></li>
			<?php endforeach; ?>
		</ul>
	<section>
</article>

</div><!-- end #main-->
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//side.php"; ?>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//footer.php"; ?>
