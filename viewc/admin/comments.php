<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/header.php"; ?>
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/xform.js"></script>
<div class="c">

    <form date-async="true" id="manage_comment" method="post" action="<?php echo $data['rootUrl']; ?>admin/manage_comment">

    <table class="mt10 table table-striped table-bordered table-condensed">
    <thead><tr>
            <th scope="col">昵称</th>
            <th scope="col">邮箱</th>
            <th scope="col">主页</th>
            <th scope="col">所在BLOG</th>
            <th scope="col">approved</th>
            <th scope="col"><a href="javascript:;" class="icon-plus-sign" style="padding:3px;margin: 5px;"></th>
          </tr>
    </thead>
    <tbody>
      <tr id="preload" style="display:none">
      <td>
        <input class="span2" type="text" name="comment_author" value="" />
      </td>
      <td>
         <input class="span2" type="text" name="comment_author_email" value="" />
      </td>
     <td>
        <input class="input-xlarge" type="text" name="comment_author_url" value="" />
     </td>
      <td>
        <span class="span2 uneditable-input">所在BLOG</span>
      </td>
       <td>
         <input class="span2" type="text" name="comment_approved" value="" />
      </td>
      <td><button class="btn">添加</button></a></td>
      </tr>
      <?php if( $data['count'] ): ?>
      <?php foreach($data['comments'] as $k1=>$v1): ?>
      <tr data-id="<?php echo $v1->comment_ID; ?>">
      
      <td class="input-append" data-name="comment_author" data-value="comment_author"><?php echo $v1->comment_author; ?></td>
      <td class="input-append" data-name="comment_author_email" data-value="<?php echo $v1->comment_author_email; ?>"><?php echo $v1->comment_author_email; ?></td>
     <td class="input-append" data-name="comment_author_url" data-value="<?php echo $v1->comment_author_url; ?>"><a href="<?php echo $v1->comment_author_url; ?>" target="_blank"><?php echo $v1->comment_author_url; ?></a></td>

      <td><a href="s/<?php echo $v1->post_url; ?>" target="_blank"><?php echo $v1->post_title; ?>(<?php echo $v1->comment_count; ?>)</a></td>
      <td class="input-append" data-name="comment_approved" data-value="<?php echo $v1->comment_approved; ?>"><?php echo $v1->comment_approved; ?></td>
      <td><a href="javascript:;" class="icon-remove" style="padding:3px;margin: 5px;"></a></td>
      </tr>
      <?php endforeach; ?>
      <?php else: ?>
      还没有评论哦:0
      <?php endif; ?>
    </tbody>
    </table>
    </form>
<nav id="pagenavi">
    <?php echo $data['pager']; ?>
</nav>



</div>
<script type="text/javascript">
var options={params:{insert:'add',update:'update','delete':'remove'},
          tplid:'preload',
          selecter:{add:'.icon-plus-sign',del:'.icon-remove',edit:'.icon-edit'}};
$('#manage_comment').xForm(options);
</script>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/footer.php"; ?>