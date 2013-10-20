<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/header.php"; ?>
<div class="c">
    <form method="post" action="<?php echo $data['rootUrl']; ?>admin/manage_post">
    <select name="action" style="margin:0 8px 0 0;">
<option value="-1" selected="selected">批量操作</option>
    <option value="edit" class="hide-if-no-js">编辑</option>
    <option value="trash">移至回收站</option>
      <option value="del">删除</option>
</select><input type="submit" value="应用" class="btn btn-primary">
	<table class="mt10 table table-striped table-bordered table-condensed">
<thead><tr>
<th scope="col"><input type="checkbox" /></th>
<th scope="col">标题</th>
<th scope="col">作者</th>
<th scope="col">分类</th>
<th scope="col">标签</th>
<th scope="col">评论</th>
<th scope="col">日期</th>
<th scope="col">status</th>
</tr>
</thead>
<tbody>

<?php foreach($data['posts'] as $k1=>$v1): ?>
<tr>
<th scope="row"><input name="posts[]" value="<?php echo $v1->ID; ?>" type="checkbox" /></th>
<td><a href="<?php echo TemplateTag::url3('e', $v1->post_date); ?>" target="_blank"><?php echo $v1->post_title; ?></a></td>
<td><?php echo $v1->author; ?></td>
<td><?php echo $v1->term; ?></td>
<td></td>
<td></td>
<td><?php echo $v1->post_date_gmt; ?></td>
<td><?php echo $v1->post_status; ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table></form>
<nav id="pagenavi">
    <?php echo $data['pager']; ?>
</nav>



</div>
<script>
$(document).ready(function(){
    $(".box2").focus(function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();
    });
    $(".box2").keyup(function(){
       var t=$(this).val();
       var n = 140 - t.length;
       if (n>=0){
         $(".tbutton span").html("(你还可以输入"+n+"字)");
       }else {
         $(".tbutton span").html("<span style=\"color:#FF0000\">(已超出"+Math.abs(n)+"字)</span>");
       }
    });
});
function closet(){
    $(".tbutton").hide();
    $(".tbutton span").html("(你还可以输入140字)");
    $(".box2").val('为今天写点什么吧……').css('height','17px').bind('focus',function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();});
}
function checkt(){
    var t=$(".box2").val();
    var n=140 - t.length;
    if (n<0){return false;}
}
</script>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/footer.php"; ?>