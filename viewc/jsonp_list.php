<?php header('Content-Type: application/javascript');?>
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
<?php $responseData=array();$i=0;?>
<?php foreach($data['posts'] as $k1=>$v1): ?>
<?php 
$responseData[$i]['title']=$v1->post_title;
$responseData[$i]['link']=substr($data['rootUrl'],0,-1).url3('s', $v1->post_date);
/*$responseData[$i]['content']=$v1->post_content;
$responseData[$i]['pubdate']=$v1->post_date_gmt;
$responseData[$i]['author']=authorname($v1->post_author);*/
$i++;
?>
<?php endforeach; ?>
<?php 
$res=json_encode($responseData);
print $_GET['callback'].'('.$res.')';
?>
