<?php


//������� �������������� �������� �������           
function __autoload($className) 
{
    $className  = str_replace('_','/',$className,$count);
//  echo $className.'<br>';
    if($count > 0) {
        $class_path = strtolower($className).".php";
        $class_path = substr($class_path,0,strripos($class_path,'/')+1).ucfirst(substr($class_path,strripos($class_path,'/')+1));
    }
    else {
        $class_path = 'admin/system/'.$className.".php";
    }
//echo $class_path.'<br/>';
    if(file_exists(ROOT.'/'.$class_path))
        require_once(ROOT.'/'.$class_path);
}


