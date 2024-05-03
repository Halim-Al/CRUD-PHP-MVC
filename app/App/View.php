<?php 
namespace Halim\CrudMvc\App;



class View
{

    public static function render(string $view, $model)
    {
        require __DIR__ . '/../View/header.php';
        require __DIR__ . '/../View/' . $view . '.php';
        require __DIR__ . '/../View/footer.php';
    }

    public static function jsviewer(string $view){
        return __DIR__ . '/../public/js/' . $view . '.js';
    }

    
    public static function redirect(string $url)
    {
        header("Location: $url");
        if (getenv("mode") != "test") {
            exit();
        }
    }

}


?>