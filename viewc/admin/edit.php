<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/header.php"; ?>
<link href="css/bootstrap-wysihtml5.css" type="text/css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet">
<link href="css/jquery_ui/smoothness/jquery-ui-1.8.21.custom.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/datepicker_setting.js"></script>
<style type="text/css">
.tags{float:left;}
.tags li{float:left;margin:5px;}
.tags a{color:#555;text-shadow:1px 1px 1px #fff;padding:3px 5px;text-decoration:none;}
#preview {margin-top:20px;}
#preview .image{padding: 2px;
border: 1px solid #CCC;position:relative;display: inline-block;}
.image img{width:80px;height:80px;}
.upload_delete{position: absolute;
right: -16px;
top: -16px;
text-indent: -9999px;
width: 16px;
height: 16px;background:url(<?php echo $data['rootUrl']; ?>img/admin/no.png) no-repeat;}
</style>

<div id="msg"></div>
  <form action="<?php echo $data['rootUrl']; ?>admin/post" method="post" enctype="multipart/form-data" id="addlog" name="addlog" class="c" autocomplete="off">
        <input type="hidden" id="post_type" name="post_type" value="<?php echo $data['post']->post_type; ?>">
         <input type="hidden" id="post_id" name="ID" value="<?php echo $data['post']->ID; ?>">
        <div class="c wysihtml5-toolbar">
          <input autofocus="autofocus" class="l" type="text" maxlength="200" name="title" id="title" placeholder="输入日志标题" value="<?php echo $data['post']->post_title; ?>" />
        <div id="radioset" class="l">
          <span class="l">状态:</span>
          <div class="l btn-group">
            <?php if( $data['post']->post_status=='publish' ): ?>
          <label class="l btn wysihtml5-command-active" for="radio1"><input class="hidden" type="radio" id="radio1" name="post_status" value="<?php echo $data['post']->post_status; ?>" checked="checked">公开</label>
          <label class="l btn" for="radio2"><input class="hidden" type="radio" id="radio2" name="post_status" value="trash" >草稿</label>
          <?php else: ?>
          <label class="l btn" for="radio1"><input class="hidden" type="radio" id="radio1" name="post_status" value="publish">公开</label>
         <label class="l btn wysihtml5-command-active" for="radio2"><input class="hidden" type="radio" id="radio2" name="post_status" value="<?php echo $data['post']->post_status; ?>" checked="checked">草稿</label>
         <?php endif; ?>
        </div>
        </div>
       </div>
		<input type="hidden" name="def_term" value="<?php echo $data['curterm']; ?>">
<?php if( isset($data['reltags']) ): ?>
    <input type="hidden" name="def_tag" value="<?php echo $data['reltags']; ?>">
    <?php endif; ?>
  <textarea name="content" class="br" id="textarea" value=""></textarea>
		  <div style="margin:10px 0px 5px 0px;">
          <input  type="text" name="tag" id="tag" maxlength="200" placeholder="日志标签，半角逗号分隔" style="width:432px;" value="<?php if( isset($data['reltags']) ): ?><?php echo $data['reltags']; ?><?php endif; ?>" />
          <select name="sort" id="sort" style="width:130px;">
	              <option value="-1">选择分类...</option>
		          <?php foreach($data['terms'] as $k1=>$v1): ?>
	            	<option value="<?php echo $v1['term_id']; ?>" <?php if( $v1['term_id']==$data['curterm'] ): ?>selected="selected"<?php endif; ?>><?php echo $v1['name']; ?></option>
              <?php endforeach; ?>
	        </select>
          发布日期：
	      <input maxlength="200" type="date" name="postdate" id="postdate" value="<?php echo TemplateTag::getdate($data['post']->post_date); ?>"/>
        <input type="time" name="posttime" value="<?php echo TemplateTag::gettime($data['post']->post_date); ?>" />
		  </div>
      <ul id="myTab" class="nav nav-tabs">
              <li><a href="#collapseOne" data-toggle="tab">附件</a></li>
              <li><a href="#collapseTwo" data-toggle="tab">标签</a></li>
              <li><a href="#collapseThree" data-toggle="tab">高级选项</a></li>
 
            </ul>
      <div id="myTabContent" class="tab-content">
          <div id="collapseOne" class="tab-pane fade">
        <div id="uploadbox" class="c"><input id="fileImage" type="file" size="30" name="fileselect[]" multiple />
          <button type="button" id="uploadbtn" class="btn btn-primary">开始上传</button>
          <div id="uploadInf"></div>
          <div id="preview"></div>
        </div>
      </div>
        <div id="collapseTwo" class="tab-pane fade">
        <div id="tagbox" class="c">
          <ul class="tags">
          <?php foreach($data['tags'] as $k1=>$v1): ?>
          <li><a href="<?php echo $v1['slug']; ?>"><?php echo $v1['name']; ?></a></li>
          <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div id="collapseThree" class="tab-pane fade">
        <div id="advancedbox" class="c">
          <fieldset>
        <div class="control-group"><b>日志摘要：</b><br />
      <textarea id="excerpt" name="excerpt" class="br"></textarea>
         </td>
        <div class="control-group"><span id="alias_msg_hook"></span><b>链接别名：</b>(用于自定义日志链接。需要启用链接别名)<span id="alias_msg_hook"></span><br />
      <input type="text" name="post_name" id="alias" value="<?php echo $data['post']->post_name; ?>" style="width:711px;" />
         </div>  
       <div class="control-group"><b>引用通告：</b>(每行一条引用地址)<br />
      <textarea name="pingurl" id="pingurl" class="br input"></textarea>
       </div>
       <div class="control-group"><b>日志访问密码：</b>
          <input type="text" value="" name="password" value="<?php echo $data['post']->post_password; ?>" id="password" style="width:80px;" />
         
      </div>
        
<div class="control-group">
          <label class="checkbox" for="top"><input type="checkbox" value="y" name="top" id="top" />日志置顶</label>
         </div>
        
<div class="control-group">
          <label class="checkbox" for="allow_remark"> <input type="checkbox" value="<?php echo $data['post']->comment_status; ?>" name="allow_remark" id="allow_remark" checked="checked" />允许评论</label>
          </div>
        
 <div class="control-group">
          <label class="checkbox" for="allow_tb"><input type="checkbox" value="open" id="allow_tb" name="allow_tb" checked="checked" />允许引用</label>
          </div>
        </div>
    </fieldset></div>  
    </div>
      </div>

	<table cellspacing="1" cellpadding="4" width="720" border="0">
		<tr>
          <td align="center"><br>
          <input type="submit" value="发布日志" class="btn btn-primary" />
          <!-- <input type="hidden" name="author" id="author" value= />	  -->
          <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="btn" />
		  </td>
        </tr>
    </table>
  </form>
<hr style="clear:left;border:none" />

<script src="js/wysihtml5-0.3.0_rc2.js"></script>
<script src="js/bootstrap-wysihtml5-0.0.2.js"></script>
<script src="js/advanced.js"></script>
<script src="js/uploadsetting.js"></script>
<script type="text/javascript">
  var wysihtml5Editor = $('#textarea').wysihtml5({
    "stylesheets":          ['<?php echo $data['rootUrl']; ?>css/syntaxhighlighter_3.0.83/shCoreDefault.css'],
	// "scripts":          ['<?php echo $data['rootUrl']; ?>js/syntaxhighlighter_3.0.83/shCore.js','<?php echo $data['rootUrl']; ?>js/syntaxhighlighter_3.0.83/shAutoloader.js','<?php echo $data['rootUrl']; ?>js/syntaxhighlighter_3.0.83/shAutoloaderSet.js'],
    "parserRules":  wysihtml5ParserRules,
  "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
  "emphasis": true, //Italics, bold, etc. Default true
  "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
  "html": true, //Button which allows you to edit the generated HTML. Default false
  "link": true, //Button to insert a link. Default true
  "image": true, //Button to insert an image. Default true
  "source":true
}).data("wysihtml5").editor.setValue(<?php echo $data['post']->post_content; ?>);

</script>
<script type="text/javascript">
$(function(){
  $('#myTab a:last').tab('show');
  $( "#postdate" ).datepicker();
    $("#radioset").delegate('input','click',
    function (){
      $("#radioset label").removeClass('wysihtml5-command-active');
      $(this).parent().toggleClass('wysihtml5-command-active');
    
    }
    );
setting.url='<?php echo $data['rootUrl']; ?>admin/attachment';
   
  uploadcon=new Upload(setting);
  uploadcon.init();
// wysihtml5Editor.composer.commands.exec("insertHTML",'<?php echo $data['post']->post_content; ?>');
});
</script>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/footer.php"; ?>