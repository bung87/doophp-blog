<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/header.php"; ?>
<div id="main" class="c">
<div id="content" class="l">
    <div class="c">
        <div class="l"><a href="./blogger.php"><img src="avtar" height="52" width="52" /></a></div>
        <form method="post" action="twitter.php?action=post">
        <div class="msg2"><a href="blogger.php"><?php echo $data['user']['username']; ?></a> (有<span class=care2><b><?php echo $data['postsnum']; ?></b></span>篇日志，<span class=care2><b>sta_tw</b></span>条碎语)</div>
        <div class="box_1"><textarea class="box2" name="t">为今天写点什么吧 ……</textarea></div>
        <div class="tbutton" style="display:none;"><input type="submit" value="发布" onclick="return checkt();"/> <a href="javascript:closet();">取消</a> <span>(你还可以输入140字)</span></div>
        </form>
		
    </div>
	<details id="admindex_servinfo" open="open">
<summary>服务器信息</summary>
<ul>
	<li>PHP版本：<?php echo $data['phpversion']; ?></li>
	<li>MySQL版本：<?php echo $data['mysqlversion']; ?></li>
	<li>服务器环境：<?php echo $data['serverapp']; ?></li>
	<li>GD图形处理库：<?php echo $data['gd_ver']; ?></li>
	<li>安全模式：<?php echo $data['safe_mode']; ?></li>
	<li>服务器允许上传最大文件：<?php echo $data['uploadfile_maxsize']; ?></li>
	<li><a href="./admin/phpinfo" target="_blank">更多信息&raquo;</a></li>
</ul>

</details>
</div>


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