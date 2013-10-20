
<aside id="sidebar" class="br">
<ul>
<li>
<h3><span><?php echo lang('category'); ?></span></h3>
<ul>
	
<?php foreach($data['categories'] as $k1=>$v1): ?>

<li><a href="<?php echo $data['rootUrl']; ?>category/<?php echo $v1['slug']; ?>"><?php echo $v1['name']; ?></a>	<a class="catfeed" href="rss/<?php echo $v1['slug']; ?>" title="<?php echo lang('subscibe'); ?><?php echo $v1['slug']; ?>"><?php echo lang('subscibe'); ?></a></li>

<?php endforeach; ?>
</ul></li>

<li>
<h3><span><?php echo lang('archives'); ?></span></h3>
<ul>
<?php foreach($data['archives'] as $k1=>$v1): ?>

<li><a rel='archives' href="<?php echo $data['rootUrl']; ?>a/<?php echo $v1['year']; ?>/<?php echo $v1['month']; ?>"><?php echo $v1['year']; ?>-<?php echo $v1['month']; ?></a>  <i><?php echo $v1['posts']; ?> posts</i></li>

<?php endforeach; ?>
</ul></li>

<li>
<h3><span><?php echo lang('links'); ?></span></h3>
<ul>
<?php foreach($data['links'] as $k1=>$v1): ?>

<li><a href="<?php echo $v1->link_url; ?>"><?php echo $v1->link_name; ?></a></li>

<?php endforeach; ?>
</ul></li>

<li>
	

<h3><span><?php echo lang('tags'); ?></span></h3>
<div id="tags">
<ul class="tags">
<?php foreach($data['tags'] as $k1=>$v1): ?>
<li><a rel="tag" class="button" href="<?php echo $data['rootUrl']; ?>tag/<?php echo $v1['slug']; ?>"><?php echo $v1['name']; ?></a></li>
<?php endforeach; ?>
</ul>
</div>
  <div id="tagCloudcontainer">
      <canvas width="200" height="200" id="tagCloud">
        <p>Anything in here will be replaced on browsers that support the canvas element</p>
      </canvas>
    </div>
</li>

</ul>
</aside>