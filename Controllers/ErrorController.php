<?php
namespace Controllers;

class ErrorController{
    public static function show_error404():string{
        return "<h2>Error 404: La página que buscas no existe.</h2>";
    }
}