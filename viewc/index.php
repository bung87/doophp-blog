<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//header.php"; ?>

<div id="container" class="c w">
<div id="main">

 <?php foreach($data['posts'] as $k1=>$v1): ?>
<article>
	<header><h2><a href="<?php echo TemplateTag::url3('s', $v1->post_date); ?>"><?php echo $v1->post_title; ?></a></h2></header>
	<section>
	<p class="att"><?php echo lang('author'); ?>：<?php echo TemplateTag::authorname($v1->post_author); ?> <?php echo lang('category'); ?>:<a href="category/<?php echo $v1->cateslug; ?>"><?php echo $v1->catename; ?></a> <?php echo lang('postedon'); ?>：<time><?php echo $v1->post_date_gmt; ?></time>
	</p>
	<div>
	<?php if( !empty($v1->post_excerpt) ): ?>
	<p><?php echo $v1->post_excerpt; ?></p>
	<?php else: ?>
	<p><?php echo TemplateTag::cutstr($v1->post_content, 300); ?></p>
	<?php endif; ?>
	
	</div>
	<?php if( (empty($v1->comment_count)) ): ?>
	<a class="count" href="<?php echo TemplateTag::url3('s', $v1->post_date); ?>#comments"><?php echo lang('nocomment'); ?></a>
	<?php else: ?>
	<a class="count" href="<?php echo TemplateTag::url3('s', $v1->post_date); ?>#comments"><?php echo lang('comment'); ?>(<?php echo $v1->comment_count; ?>)</a>
	<?php endif; ?>
	</section>
</article>	 
 <?php endforeach; ?>

<nav id="pagenavi">
	<?php echo $data['pager']; ?>
</nav>

</div><!-- end #main-->

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//side.php"; ?>


<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//footer.php"; ?>
