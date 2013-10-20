<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/admin/header.php"; ?>
<script type="text/javascript" src="<?php echo $data['rootUrl']; ?>js/xform.js"></script>
<div class="c">
    <h1>管理默认分类</h1>
    <form date-async="true" id="manage_category" method="post" action="<?php echo $data['rootUrl']; ?>admin/manage_category">

    <table class="mt10 table table-striped table-bordered table-condensed">
    <thead><tr>
            <th scope="col">名称</th>
            <th scope="col">别名</th>
           
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

      <td><button class="btn">添加</button></a></td>
      </tr>
      <?php foreach($data['categories'] as $k1=>$v1): ?>
      <tr data-id="<?php echo $v1->term_id; ?>">
      
      <td class="input-append" data-name="name" data-value="<?php echo $v1->slug; ?>"><a href="./category/<?php echo $v1->slug; ?>" target="_blank"><?php echo $v1->name; ?></a></td>
      <td class="input-append" data-name="slug" data-value="<?php echo $v1->slug; ?>"><?php echo $v1->slug; ?></td>
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