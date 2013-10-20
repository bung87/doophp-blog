<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//header.php"; ?>

<div id="container" class="c w">
<div id="main">
<?php if( $data['count'] ): ?>
<?php foreach($data['posts'] as $k1=>$v1): ?>
<article>
	<header><h2><a href="<?php echo TemplateTag::url3('d', $v1->post_date); ?>"><?php echo $v1->post_title; ?></a></h2></header>
	<section>
	<p class="att">作者：<?php echo TemplateTag::authorname($v1->post_author); ?> 发布于：<time><?php echo $v1->post_date_gmt; ?></time>
	</p>
	<?php if( !empty($v1->post_excerpt) ): ?>
	<?php echo $v1->post_excerpt; ?>
	<?php else: ?>
	<?php echo TemplateTag::cutstr($v1->post_content, 300); ?>
	<?php endif; ?>
	<?php if( (empty($v1->comment_count)) ): ?>
	<a class="count" href="<?php echo TemplateTag::url3('d', $v1->post_date); ?>#comments">还没有评论</a>
	<?php else: ?>
	<a class="count" href="<?php echo TemplateTag::url3('d', $v1->post_date); ?>#comments">评论(<?php echo $v1->comment_count; ?>)</a>
	<?php endif; ?>
	</p>
	</section>
</article>	 
<?php endforeach; ?>
<?php else: ?>
 还没有日记哦:)
<?php endif; ?>
<nav id="pagenavi">
	<?php echo $data['pager']; ?>
</nav>

</div><!-- end #main-->
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//side.php"; ?>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//footer.php"; ?>
