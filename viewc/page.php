<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//header.php"; ?>

<div id="container" class="c w">
<div id="main">
<article>
	<header><h2><a href="<?php echo TemplateTag::urlx('p', $data['post']->post_name); ?>"><?php echo $data['post']->post_title; ?></a></h2></header>
	<section>
	<p class="att">作者：<?php echo TemplateTag::authorname($data['post']->post_author); ?> 发布于：<time><?php echo $data['post']->post_date_gmt; ?></time>
	</p>

	<a class="count" href="<?php echo TemplateTag::urlx('p', $data['post']->post_name); ?>#comments"><?php echo $data['post']->comment_count; ?></a>

	</section>
	<section id="content"><?php echo $data['post']->post_content; ?></section>
</article>
<section id="comments" class="mt10">
	<?php if( $data['comments'] ): ?>
	<?php foreach($data['comments'] as $k1=>$v1): ?>
	<dl class="c mt5">
		<dd class="l user">
			<img class="avt" src="<?php echo $v1->comment_author_avatar; ?>" width="48" height="48" />
			
		</dd>
	<dd><span><?php echo $v1->comment_author; ?></span> <?php echo $v1->comment_date; ?></dd>
	<dd><?php echo $v1->comment_content; ?></dd>
	</dl>
	<?php endforeach; ?>
	<?php endif; ?>


</section>
<section id="commentbox" style="display:none;">
<hgroup>
<h3>评论</h3>
<h4 class="mb10"><a href="javascript:;" id="applynotifier">(如有回复通知我)</a></h4>
</hgroup>
 <?php if( isset($data['userinfo']) ): ?>
	<div class="user"><img class="avt" src="<?php echo $data['userinfo']->profileImageUrl; ?>" width="16" height="16" /><span><?php echo $data['userinfo']->screenName; ?></span> <a id="logout" href="javascript:;">退出</a> </div>
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
	<?php endif; ?>
<form action="<?php echo $data['rootUrl']; ?>comment" method="post" id="commentform" class="mt5">
	<?php if( isset($data['userinfo']) ): ?>
	<div class="user"><img class="avt" src="<?php echo $data['userinfo']->profileImageUrl; ?>" width="16" height="16" /><span><?php echo $data['userinfo']->screenName; ?></span></div>
		<?php if( empty($data['userinfo']->email) ): ?>
		<p class="mb5"><input type="email" name="email" id="email" value="" size="22" tabindex="2">
		<label for="email"><small>邮箱 (不会公开) (必填)</small></label></p>
		<?php else: ?>
		<p class="mb5"><input type="email" name="email" id="email" value="<?php echo $data['userinfo']->email; ?>" size="22" tabindex="2">
		<label for="email"><small>邮箱 (不会公开) (必填)</small></label></p>
		<?php endif; ?>
		<?php if( empty($data['userinfo']->url) ): ?>
		<p class="mb5"><input type="url" name="url" id="url" value="" size="22" tabindex="3">
		<label for="url"><small>个人主页</small></label></p>
		<?php else: ?>
		<p class="mb5"><input type="url" name="url" id="url" value="<?php echo $data['userinfo']->url; ?>" size="22" tabindex="3">
		<label for="url"><small>个人主页</small></label></p>
		<?php endif; ?>
	<?php else: ?>
	<p class="mb5"><input type="text" name="author" id="author" value="" size="22" tabindex="1">
	<label for="author"><small>昵称 (必填)</small></label></p>
	<p class="mb5"><input type="email" name="email" id="email" value="" size="22" tabindex="2">
	<label for="email"><small>邮箱 (不会公开) (必填)</small></label></p>
	<p class="mb5"><input type="url" name="url" id="url" value="" size="22" tabindex="3">
	<label for="url"><small>个人主页</small></label></p>
	<?php endif; ?>
	<input type="hidden" name="formhidden" value="1">
 <input type="hidden" name="comment_post_ID" value="<?php echo $data['post']->ID; ?>" id="comment_post_ID">
<input type="hidden" name="comment_parent" id="comment_parent" value="0">
<p><textarea name="comment" id="comment" cols="56" rows="10" tabindex="4"></textarea></p>
<p><input class="btn" name="submit" type="submit" id="submit"  tabindex="5" value="评论">
<input type="hidden" name="comment_post_ID" value="<?php echo $data['post']->ID; ?>">
</p>
</form>

</section>

</div><!-- end #main-->
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//side.php"; ?>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc//footer.php"; ?>
