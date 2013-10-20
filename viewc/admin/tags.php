<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/header.php"; ?>
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/xform.js"></script>
<div class="c">

    <form date-async="true" id="manage_tag" method="post" action="<?php echo $data['rootUrl']; ?>admin/manage_tag">

    <table class="mt10 table table-striped table-bordered table-condensed">
    <thead><tr>
            <th scope="col">名称</th>
            <th scope="col">别名</th>
            <th scope="col">描述</th>
            <th scope="col">count</th>
            <th scope="col"><a href="javascript:;" class="icon-plus-sign" style="padding:3px;margin: 5px;"></th>
          </tr>
    </thead>
    <tbody>
      <tr id="preload" style="display:none">
      <td>
        <input class="span2" type="text" name="name" value="" />
      </td>
      <td>
         <input class="span2" type="text" name="slug" value="" />
      </td>
     <td>
        <input class="input-xlarge" type="text" name="description" value="" />
     </td>
      <td>
        <span class="span2 uneditable-input">count</span>
      </td>
      <td><button class="btn">添加</button></a></td>
      </tr>
      <?php foreach($data['tags'] as $k1=>$v1): ?>
      <tr data-id="<?php echo $v1->term_taxonomy_id; ?>">
      
      <td class="input-append" data-name="name" data-value="category/<?php echo $v1->slug; ?>"><a href="<?php echo $v1->name; ?>" target="_blank"><?php echo $v1->name; ?></a></td>
      <td class="input-append" data-name="slug" data-value="<?php echo $v1->slug; ?>"><?php echo $v1->slug; ?></td>
     <td class="input-append" data-name="description" data-value="<?php echo $v1->description; ?>"><?php echo $v1->description; ?></td>
      <td><?php echo $v1->count; ?></td>
      <td><a href="javascript:;" class="icon-remove" style="padding:3px;margin: 5px;"></a></td>
      </tr>
      <?php endforeach; ?>

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
$('#manage_category').xForm(options);
</script>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/footer.php"; ?>