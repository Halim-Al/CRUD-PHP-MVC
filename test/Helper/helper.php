<?php 

namespace Halim\CrudMvc\App{

    function header(string $value){
        echo $value;
    }
}

namespace Halim\CrudMvc\Service{
    function setcookie(string $name, string $value){
        echo "$name: $value";
    }
}

?>