<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/header.php"; ?>
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/xform.js"></script>
<div class="c">

    <form date-async="true" id="manage_link" method="post" action="<?php echo $data['rootUrl']; ?>admin/manage_link">

    <table class="mt10 table table-striped table-bordered table-condensed">
    <thead><tr>
            <th scope="col">名称</th>
            <th scope="col">描述</th>
            <th scope="col">URL</th>
            <th scope="col">REL</th>   
            <th scope="col">更新日期</th>
            <th scope="col"><a href="javascript:;" class="icon-plus-sign" style="padding:3px;margin: 5px;"></th>
          </tr>
    </thead>
    <tbody>
      <tr id="preload" style="display:none">
      <td>
        <input class="span2" type="text" name="link_name" value="" />
      </td>
      <td>
         <input class="span2" type="text" name="link_description" value="" />
      </td>
     <td>
        <input class="input-xlarge" type="text" name="link_url" value="" />
     </td>
      <td>
        <input class="span2" type="text" name="link_rel" value="" />
      </td>
      <td>
        <span class="span2 uneditable-input">创建日期</span>
      </td>
      <td><button class="btn">添加</button></a></td>
      </tr>
      <?php if( $data['count'] ): ?>
      <?php foreach($data['links'] as $k1=>$v1): ?>
      <tr data-id="<?php echo $v1->link_id; ?>">
      
      <td class="input-append" data-name="link_name" data-value="<?php echo $v1->link_name; ?>"><a href="<?php echo $v1->link_url; ?>" target="_blank"><?php echo $v1->link_name; ?></a></td>

      <td class="input-append" data-name="link_description" data-value="<?php echo $v1->link_description; ?>"><?php echo $v1->link_description; ?></td>
     <td class="input-append" data-name="link_url" data-value="<?php echo $v1->link_url; ?>"><?php echo $v1->link_url; ?></td>
      <td class="input-append" data-name="link_rel" data-value="<?php echo $v1->link_rel; ?>"><?php echo $v1->link_rel; ?></td>
      <td class="input-append" data-name="link_updated" data-value="<?php echo $v1->link_updated; ?>"><?php echo $v1->link_updated; ?></td>
      <td><a href="javascript:;" class="icon-remove" style="padding:3px;margin: 5px;"></a></td>
      </tr>
      <?php endforeach; ?>
      <?php else: ?>
      还没有友链哦:0
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
$('#manage_link').xForm(options);
</script>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/footer.php"; ?>