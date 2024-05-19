<?php

namespace Models;
use DateTime;

class Validacion {

    public static function validar($titulo, $descripcion, $categoria, $fecha) {
        // Inicializamos un array para almacenar mensajes de error
        $errores = [];
    
        // Comprobamos si el título está vacío o contiene solo espacios en blanco
        if (empty($titulo) || trim($titulo) === '') {
            $errores['titulo'] = "Es obligatorio introducir el título.";
        } 
    
        // Comprobamos si la descripción está vacía o contiene solo espacios en blanco
        if (empty($descripcion) || trim($descripcion) === '') {
            $errores['descripcion'] = "Es obligatorio introducir la descripción.";
        } 
    
        // Comprobamos si la categoría está vacía o contiene solo espacios en blanco
        if (empty($categoria) || trim($categoria) === '') {
            $errores['categoria'] = "Es obligatorio introducir la categoría.";
        } 
    
        // Comprobamos si la fecha no es válida o está vacía
        if (empty($fecha) || !strtotime($fecha)) {
            $errores['fecha'] = "La fecha no es válida.";
        }
    
        // Si hay errores, devolvemos un array con los mensajes de error
        return $errores;
    }

    public static function sanearCampos($titulo, $descripcion, $categoria, $fecha): array {
        // Aplicar trim a todos los campos para eliminar espacios en blanco al inicio y al final
        $titulo = trim($titulo);
        $descripcion = trim($descripcion);
        $categoria = trim($categoria);
        $fecha = trim($fecha);
    
        // Sanear el titulo: filtrar solo letras (mayúsculas y minúsculas), números y espacios, eliminando otros caracteres
        $titulo = self::sanearString($titulo);
    
        // Sanear la descripcion
        $descripcion = self::sanearString($descripcion);
    
        // Sanear la categoria
        $categoria = self::sanearString($categoria);
    
        // Sanear la fecha
        $fecha = self::sanearFecha($fecha);
    
        return ['titulo' => $titulo, 'descripcion' => $descripcion, 'categoria' => $categoria, 'fecha' => $fecha];
    }
    
    
    // Función para sanear strings
    public static function sanearString(string $texto): string {
        // Filtrar solo letras (mayúsculas y minúsculas), números, ñ, vocales acentuadas y espacios, eliminando otros caracteres
        return preg_replace('/[^A-Za-z0-9\sáéíóúÁÉÍÓÚñÑÁÉÍÓÚáéíóú]+/u', '', $texto);
    }
    

    public static function sanearFecha($fecha): ?string {
        // Verificamos si la fecha tiene el formato correcto ('dd/mm/yyyy' o 'dd-mm-yyyy')
        if (preg_match('/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/', $fecha, $matches)) {
            // Intentamos convertir la fecha a un formato UNIX timestamp
            $dia = $matches[1];
            $mes = $matches[2];
            $anio = $matches[3];
            
            // Verificamos si la fecha es válida
            if (checkdate($mes, $dia, $anio)) {
                // Creamos un objeto DateTime utilizando el timestamp
                $timestamp = strtotime("$anio-$mes-$dia");
                $fecha_parseada = new DateTime();
                $fecha_parseada->setTimestamp($timestamp);
        
                // Devolvemos la fecha formateada como 'd-m-Y'
                return $fecha_parseada->format('d-m-Y');
            }
        }
        
        // Si la fecha no tiene el formato correcto o no es válida, devolvemos null
        return null;
    }
}