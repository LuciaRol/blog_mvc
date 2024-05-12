<?php

    namespace Models;
    use DateTime;
    class Validar{
        function __construct()
        {
            
        }
        /**
         * Función para comprobar que el string del parámetro coincida con el patron.
         *
         * @param string $texto parámetro para comprobar
         * @return boolean true si coincide, false si no.
         */
        public static function son_letras(string $texto): bool
        {
                // Patrón de validación
                $patron = "/^([áúíéóñÁÉÍÓÚÑa-zA-Z0-9.º\s]*)$/";
                return preg_match($patron, $texto);
        }
        /**
         * Función para comprobar que el string del parámetro coincida con el patron.
         *
         * @param string $texto parámetro para comprobar
         * @return boolean true si coincide, false si no.
         */
        public static function esEmail(string $texto): bool
        {
                // Patrón de validación
                $patron = '/^\\S+@\\S+\\.\\S+$/';
                return preg_match($patron, $texto);
        }
        /**
         * Función para comprobar que el string del parámetro coincida con el patron.
         *
         * @param string $texto parámetro para comprobar
         * @return boolean true si coincide, false si no.
         */
        public static function esNumero(string $texto): bool
        {
                // Patrón de validación
                $patron = "/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{3,6}$/";
                return preg_match($patron, $texto);
        }
        /**
         * Función para comprobar que la fecha tenga el formato adecuado.
         *
         * @param string $fecha comprueba que el string tenga el formato adecuado
         * @return bool true si lo tiene y false si no lo tiene y false si el año 
         * introducido es mayor al año actual.
         */
        public static function validarFecha(string $fecha): bool
        {
                $d = DateTime::createFromFormat('d-m-Y', $fecha);
                if ($d) {
                $currentYear = (int)date('Y');
                $year = (int)$d->format('Y');
                if ($year > $currentYear) {
                        return false;
                }
                return $d->format('d-m-Y') === $fecha;
                } else {
                return false;
                }
        }
        /**
         * Función validar_array
         * Comprueba que el string pasado como parámetro este contenido en el array de los posibles valores correctos.
         * @param string $tipo parámetro a comprobar de tipo string
         * @return bool return de tipo bool devuelve true si el parámetro esta contenido en el array.
         */
        public static function validar_array(string $tipo, array $array = ["","facil","medio","dificil"]):bool{
                return in_array($tipo,$array);
        }

        public static function validarRol($rol, &$errores) :array {
                $array = ["user","admin"];
                if (!in_array($rol,$array)) {
                       $errores["rol"]="Rol no aceptado";
                }
                return $errores;
        }
    }