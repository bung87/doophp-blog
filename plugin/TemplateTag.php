<?php

//register global/PHP functions to be used with your template files
//You can move this to common.conf.php   $config['TEMPLATE_GLOBAL_TAGS'] = array('isset', 'empty');
//Every public static methods in TemplateTag class (or tag classes from modules) are available in templates without the need to define in TEMPLATE_GLOBAL_TAGS 
Doo::conf()->TEMPLATE_GLOBAL_TAGS = array('upper', 'tofloat', 'sample_with_args', 'debug', 'url', 'url2', 'function_deny', 'isset', 'empty','lang');


//Define as class (optional)

class TemplateTag {
    private static $authors=array();

    public static function getdate($datetime){
        $arr=explode(' ', $datetime);
        return $arr[0];
}
    public static function gettime($datetime){
        $arr=explode(' ', $datetime);
        return $arr[1];
}
    public static function cutstr($str,$length){
        Doo::loadHelper('DooTextHelper');
        $s=DooTextHelper::limitChar($str,$length,'...','utf-8');
        return $s;
}
    public static function authorname($id){
        if(empty(self::$authors)){
        Doo::loadModel('Users');
        $users=new users;
        $users=Doo::db()->find('Users');
       
        foreach ($users as $key => $value) {

            self::$authors[$value->ID]=$value->display_name;
            } 
        $authors=self::$authors;
    }
        return self::$authors[$id];
}
    public static function url3($id,$dt){
        Doo::loadHelper('DooUrlBuilder');
        if($timestamp=strtotime($dt)){
            return DooUrlBuilder::url($id, array('dt'=>$timestamp));
        }else{
            return DooUrlBuilder::url($id, array('dt'=>$dt));
        }
         
}
    public static function urlx($id, $param=null, $addRootUrl=false){
    Doo::loadHelper('DooUrlBuilder');
    if($param!=null){
       return DooUrlBuilder::url($id,array('x'=>$param), $addRootUrl);       
    }
    }
}

function lang($str){
  return  Doo::conf()->LANGUAGES[$str];
}
function upper($str){
    return strtoupper($str);
}

function tofloat($str){
    return sprintf("%.2f", $str);
}

function sample_with_args($str, $prefix){
    return $str .' with args: '. $prefix;
}

function debug($var){
    if(!empty($var)){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

//This will be called when a function NOT Registered is used in IF or ElseIF statment
function function_deny($var=null){
   echo '<span style="color:#ff0000;">Function denied in IF or ElseIF statement!</span>';
   exit;
}


//Build URL based on route id
function url($id, $param=null, $addRootUrl=false){
    Doo::loadHelper('DooUrlBuilder');
    // param pass in as string with format
    // 'param1=>this_is_my_value, param2=>something_here'

    if($param!=null){
        $param = explode(', ', $param);
        $param2 = null;
        foreach($param as $p){
            $splited = explode('=>', $p);
            $param2[$splited[0]] = $splited[1];
        }
        return DooUrlBuilder::url($id, $param2, $addRootUrl);
    }

    return DooUrlBuilder::url($id, null, $addRootUrl);
}


//Build URL based on controller and method name
function url2($controller, $method, $param=null, $addRootUrl=false){
    Doo::loadHelper('DooUrlBuilder');
    // param pass in as string with format
    // 'param1=>this_is_my_value, param2=>something_here'

    if($param!=null){
        $param = explode(', ', $param);
        $param2 = null;
        foreach($param as $p){
            $splited = explode('=>', $p);
            $param2[$splited[0]] = $splited[1];
        }
        return DooUrlBuilder::url2($controller, $method, $param2, $addRootUrl);
    }

    return DooUrlBuilder::url2($controller, $method, null, $addRootUrl);
}

?>
