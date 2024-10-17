<?php

function data_submitted() {
    $_AAux= array();
    if (!empty($_POST))
        $_AAux =$_POST;
    else
        if(!empty($_GET)) {
            $_AAux =$_GET;
        }
    if (count($_AAux)){
        foreach ($_AAux as $indice => $valor) {
            if ($valor=="")
                $_AAux[$indice] = 'null'	;
        }
    }
    return $_AAux;
}

function dismount($object) {
    $reflectionClass = new ReflectionClass(get_class($object));
    $array = array();
    foreach ($reflectionClass->getProperties() as $property) {
        $property->setAccessible(true);
        $array[$property->getName()] = $property->getValue($object);
        $property->setAccessible(false);
    }
    return $array;
}

function convert_array($param) {
    $_AAux= array();
    if (!empty($param)) {
        if (count($param)){
            foreach($param as $obj) {
                array_push($_AAux,dismount($obj));    
            }
        }
    }
    
    return $_AAux;
}

spl_autoload_register(function ($clase) {
    //echo "Cargamos la clase  ".$clase."<br>" ;
    $directorys = array(
        $GLOBALS['ROOT'].'modelo/',
        $GLOBALS['ROOT'].'control/',
        $GLOBALS['ROOT'].'modelo/conector/',
        $GLOBALS['ROOT'].'utiles/',
    );
    // print_r($directorys) ;
    foreach($directorys as $directory){
        if(file_exists($directory.$clase . '.php')){
             //echo "se incluyo".$directory.$clase . '.php';
            require_once($directory.$clase . '.php');
            return;
        }
    }


});

?>
