<?php header('Content-type: application/rss+xml');?>
<?php print '<?xml version="1.0" encoding="utf-8"?>';?>
<?php $authors=array();?>
<?php   function url3($id,$dt){
        Doo::loadHelper('DooUrlBuilder');
        if($timestamp=strtotime($dt)){
            return DooUrlBuilder::url($id, array('dt'=>$timestamp));
        }else{
            return DooUrlBuilder::url($id, array('dt'=>$dt));
        }
         
}
    function authorname($id){
        if(empty($authors)){
        Doo::loadModel('Users');
        $users=new users;
        $users=Doo::db()->find('Users');
       
        foreach ($users as $key => $value) {

            $authors[$value->ID]=$value->display_name;
            } 
       // $authors=$authors;
    }
        return $authors[$id];
}
    function cutstr($str,$length){
        Doo::loadHelper('DooTextHelper');
        $s=DooTextHelper::limitChar($str,$length,'...','utf-8');
        return $s;
}
?>
<rss version="2.0">
<channel>
<title><![CDATA[<?php echo $data['blogname']; ?>]]></title> 
<description><![CDATA[<?php echo $data['blogdescription']; ?>]]></description>
<link><?php echo $data['rootUrl']; ?></link>
<language>zh-cn</language>
<generator>bung</generator>
<?php foreach($data['posts'] as $k1=>$v1): ?>
<item>
	<title><?php echo $v1->post_title; ?></title>
	<link><?php echo substr($data['rootUrl'],0,-1).url3('s', $v1->post_date); ?></link>
	<description><![CDATA[<?php if (!empty($v1->post_excerpt)){
	echo $v1->post_excerpt;}
	else{echo cutstr($v1->post_content,300);}
	?>]]></description>
	<pubDate><?php echo $v1->post_date_gmt; ?></pubDate>
	<author><?php echo authorname($v1->post_author); ?></author>
	<guid><?php echo substr($data['rootUrl'],0,-1).url3('s', $v1->post_date); ?></guid>
</item>
<?php endforeach; ?>
</channel>
</rss>