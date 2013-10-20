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
        <input type="hidden" id="post_type" name="post_type" value="<?php echo $data['type']; ?>">
        <div class="c wysihtml5-toolbar">
          <input autofocus="autofocus" class="l" type="text" maxlength="200" name="title" id="title" placeholder="输入日志标题" />
        <div id="radioset" class="l">
          <span class="l">状态:</span>
          <div class="l btn-group">
            <label class="l btn wysihtml5-command-active" for="radio1"><input class="hidden" type="radio" id="radio1" name="post_status" value="publish" checked="checked">公开</label>
          <label class="l btn" for="radio2"><input class="hidden" type="radio" id="radio2" name="post_status" value="draft">草稿</label>
          <!--label class="l btn" for="radio3"><input class="hidden" type="radio" id="radio3" name="post_status" value="pending">等待复审</label-->
        </div>
        </div>
       </div>
		<input type="hidden" name="def_term" value="0">
  <textarea name="content" class="br" id="textarea"></textarea>
		  <div style="margin:10px 0px 5px 0px;">
          <input  type="text" name="tag" id="tag" maxlength="200" placeholder="日志标签，半角逗号分隔" style="width:432px;" />
          <select name="sort" id="sort" style="width:130px;">
	              <option value="-1">选择分类...</option>
		          <?php foreach($data['terms'] as $k1=>$v1): ?>
	            	<option value="<?php echo $v1['term_id']; ?>"><?php echo $v1['name']; ?></option>
              <?php endforeach; ?>
	        </select>
          发布日期：
	      <input maxlength="200" type="date" name="postdate" id="postdate" value=""/>
        <input type="time" name="posttime" value="" />
		  </div>
      <ul id="myTab" class="nav nav-tabs">
              <li><a href="#collapseOne" data-toggle="tab">附件</a></li>
              <li><a href="#collapseTwo" data-toggle="tab">标签</a></li>
              <li><a href="#collapseThree" data-toggle="tab" class="active">高级选项</a></li>
              <!--li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#dropdown1" data-toggle="tab">@fat</a></li>
                  <li><a href="#dropdown2" data-toggle="tab">@mdo</a></li>
                </ul>
              </li-->
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
        <div class="control-group"><span id="alias_msg_hook"></span><b>链接别名：</b>(用于自定义日志链接。需要<a href="./permalink.php" target="_blank">启用链接别名</a>)<span id="alias_msg_hook"></span><br />
      <input type="text" name="post_name" id="alias" style="width:711px;" />
         </div>  
       <div class="control-group"><b>引用通告：</b>(每行一条引用地址)<br />
      <textarea name="pingurl" id="pingurl" class="br input"></textarea>
       </div>
       <div class="control-group"><b>日志访问密码：</b>
          <input type="text" value="" name="password" id="password" style="width:80px;" />
         
      </div>
        
<div class="control-group">
          <label class="checkbox" for="top"><input type="checkbox" value="y" name="top" id="top" />日志置顶</label>
         </div>
        
<div class="control-group">
          <label class="checkbox" for="allow_remark"> <input type="checkbox" value="open" name="allow_remark" id="allow_remark" checked="checked" />允许评论</label>
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
  $('#textarea').wysihtml5({
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
});
</script>
<script type="text/javascript">
$(function(){
  $('#myTab a:last').tab('show');
  $( "#postdate" ).datepicker();
  //$(".collapse").collapse();
  //$("#radioset").buttonset();
  $("#radioset").delegate('input','click',
    function (){
      $("#radioset label").removeClass('wysihtml5-command-active');
      $(this).parent().toggleClass('wysihtml5-command-active');
    
    }
    );
 setting.url='<?php echo $data['rootUrl']; ?>admin/attachment';
  uploadcon=new Upload(setting);
  uploadcon.init();
      /* $('input[type=date]').datepicker({  
        //showButtonPanel:true,  //default false
        changeYear:true,
        changeMonth:true,
        showAnim:'fadeIn',
        duration:'normal'
        }); */
        var d=new Date(),y=d.getFullYear(),m=d.getMonth()+1,dd=d.getDate(),hh=d.getHours(),mm=d.getMinutes();
        m=m<10 ? '0'+m : m;
        dd=dd<10 ? '0'+dd : dd;
        $('input[type=date]').val(y+'-'+m+'-'+dd);
        hh=hh<10 ? '0'+hh : hh;
         mm=mm<10 ? '0'+mm : mm;
        $('input[type=time]').val(hh+':'+mm);
            });
</script>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/footer.php"; ?>