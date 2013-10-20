<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//header.php"; ?>
<div id="container" class="c w">
<div id="main">
<article>
	<header><h2><a href="<?php echo TemplateTag::url3('s', $data['post']->post_date); ?>"><?php echo $data['post']->post_title; ?></a></h2><a href="javascript:;" class="btn_scale"></a></header>
	<section>
	<p class="att"><?php echo lang('author'); ?>：<?php echo TemplateTag::authorname($data['post']->post_author); ?> <?php echo lang('category'); ?>:
		<?php foreach($data['relcategories'] as $k1=>$v1): ?>
		<a href="category/<?php echo $v1->slug; ?>"><?php echo $v1->name; ?></a>
		<?php endforeach; ?>  
		<?php echo lang('postedon'); ?>：<time><?php echo $data['post']->post_date_gmt; ?></time>
	</p>

	<a class="count" href="<?php echo TemplateTag::url3('s', $data['post']->post_date); ?>#comments"><?php echo $data['post']->comment_count; ?></a>

	</section>
	<section id="content"><?php echo $data['post']->post_content; ?></section>
	<?php if( (!empty($data['reltags'])) ): ?>
	<section class="mt10">
		<i><?php echo lang('tags'); ?>:</i>
	<?php foreach($data['reltags'] as $k1=>$v1): ?>
	<a href="<?php echo TemplateTag::urlx('t', $v1->slug); ?>"><?php echo $v1->name; ?></a>
	<?php endforeach; ?>
	<section>
	<?php endif; ?>
</article>
<div class="c">
<!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
        <span class="bds_more">分享到：</span>
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
        <a class="bds_douban"></a>
        <a class="bds_diandian"></a>
        <a class="bds_fbook"></a>
        <a class="bds_twi"></a>
        <a class="bds_ms"></a>
        <a class="bds_linkedin"></a>
        <a class="bds_deli"></a>
        <a class="bds_mail"></a>
        <a class="bds_print"></a>
		<a class="shareCount"></a>
    </div>

<!-- Baidu Button END -->
</div>
<section id="comments" class="mt10">
	<?php if( $data['comments'] ): ?>
	<?php foreach($data['comments'] as $k1=>$v1): ?>
	<dl data-commentID="<?php echo $v1->comment_ID; ?>" class="c mt5">
		<dd class="l user">
			<img class="avt" src="<?php if( $v1->comment_author_avatar ): ?><?php echo $v1->comment_author_avatar; ?><?php else: ?>img/favicon_48.jpg<?php endif; ?>" width="48" height="48" />
			
		</dd>
	<dd><span><a href="<?php echo $v1->comment_author_url; ?>" target="_blank" rel="nofollow"><?php echo $v1->comment_author; ?></a></span> <?php echo $v1->comment_date; ?><a href="javascript:;" class="r reply"><?php echo lang('reply'); ?></a></dd>
	<dd><?php echo $v1->comment_content; ?></dd>
	</dl>
	<?php endforeach; ?>
	<?php endif; ?>


</section>

<section id="commentbox" style="display:none;">
<hgroup>
<h3><?php echo lang('comment'); ?></h3>
<h4 class="mb10"><a href="javascript:;" id="applynotifier">(如有回复通知我)</a></h4>
</hgroup>

<form action="<?php echo $data['rootUrl']; ?>comment" method="post" id="commentform" class="mt5">
	<?php if( isset($data['userinfo']) ): ?>
	<div class="user"><img class="avt" src="<?php echo $data['userinfo']->profileImageUrl; ?>" width="16" height="16" /><span><?php echo $data['userinfo']->screenName; ?></span></div>
		<?php if( empty($data['userinfo']->email) ): ?>
		<p class="mb5"><input type="email" name="email" id="email" value="" size="22" tabindex="2">
		<label for="email"><small><?php echo lang('mail'); ?> (不会公开) (<?php echo lang('required'); ?>)</small></label></p>
		<?php else: ?>
		<p class="mb5"><input type="email" name="email" id="email" value="<?php echo $data['userinfo']->email; ?>" size="22" tabindex="2">
		<label for="email"><small><?php echo lang('mail'); ?> (不会公开) (<?php echo lang('required'); ?>)</small></label></p>
		<?php endif; ?>
		<?php if( empty($data['userinfo']->url) ): ?>
		<p class="mb5"><input type="url" name="url" id="url" value="" size="22" tabindex="3">
		<label for="url"><small><?php echo lang('website'); ?></small></label></p>
		<?php else: ?>
		<p class="mb5"><input type="url" name="url" id="url" value="<?php echo $data['userinfo']->url; ?>" size="22" tabindex="3">
		<label for="url"><small><?php echo lang('website'); ?></small></label></p>
		<?php endif; ?>
	<?php else: ?>
	<script id='denglu_login_js' type='text/javascript' charset='utf-8'></script>
	<script type='text/javascript' charset='utf-8'>
	(function() {
		var _dl_time = new Date().getTime();
		var _dl_login = document.getElementById('denglu_login_js');
		_dl_login.id = _dl_login.id + '_' + _dl_time;
		_dl_login.src = 'http://open.denglu.cc/connect/logincode?appid=9420dengV9t39iv91dprSkkI1NznY3&v=1.0.2&widget=5&styletype=2&size=272_90&style=popup&asyn=true&time=' + _dl_time;
	})();
	</script>
	<p class="mb5"><input type="text" name="author" id="author" value="" size="22" tabindex="1">
	<label for="author"><small><?php echo lang('nickname'); ?> (<?php echo lang('required'); ?>)</small></label></p>
	<p class="mb5"><input type="email" name="email" id="email" value="" size="22" tabindex="2">
	<label for="email"><small><?php echo lang('mail'); ?>  (<?php echo lang('required'); ?>)</small></label></p>
	<p class="mb5"><input type="url" name="url" id="url" value="" size="22" tabindex="3">
	<label for="url"><small><?php echo lang('website'); ?></small></label></p>
	<?php endif; ?>
<input type="hidden" name="formhidden" value="1">
 <input type="hidden" name="comment_post_ID" value="<?php echo $data['post']->ID; ?>" id="comment_post_ID">
<input type="hidden" name="comment_parent" id="comment_parent" value="0">
<p><textarea name="comment" id="comment" cols="56" rows="10" tabindex="4"></textarea></p>
<p><input class="btn" name="submit" type="submit" id="submit"  tabindex="5" value="<?php echo lang('comment'); ?>">
<input type="hidden" name="comment_post_ID" value="<?php echo $data['post']->ID; ?>">
</p>
</form>

</section>

</div><!-- end #main-->
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//side.php"; ?>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//footer.php"; ?>
