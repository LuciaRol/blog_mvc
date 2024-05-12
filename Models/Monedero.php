<?php

namespace Models;
use DateTime;
use Lib\Pages;

class monedero{
    private string $concepto;
    private string $fecha;
    private float $importe;
    private array $todosLosDatos;


public function __construct(string $concepto, string $fecha, float $importe, array $todosLosDatos){
    $this->concepto = $concepto;
    $this->fecha = $fecha;
    $this->importe = $importe;
    $this->todosLosDatos = [];
}

    public function getConcepto(): string {
        return $this->concepto;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function getImporte(): float {
        return $this->importe;
    }

	public function getTodosLosDatos(): array {
        return $this->todosLosDatos;
    }

	

    public function setConcepto(string $concepto): void {
        $this->concepto = $concepto;
    }

	public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

	public function setImporte(float $importe): void {
        $this->importe = $importe;
    }

	public function setTodosLosDatos(array $todosLosDatos): void {
        $this->todosLosDatos = $todosLosDatos;
    }

    
    public static function leerRegistros(): array {
        // Leer el contenido del archivo monedero.txt si existe
        if (file_exists("monedero.txt")) {
            // Leer el contenido del archivo y dividirlo en líneas
            $lineas = file("monedero.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Procesar cada línea para obtener los datos individuales
            $registros = [];
            foreach ($lineas as $linea) {
                $datos = explode(",", $linea);
                $registros[] = [
                    'id' => $datos[0],
                    'concepto' => $datos[1],
                    'fecha' => $datos[2],
                    'importe' => $datos[3]
                ];
            }

            return $registros;
        } else {
            return [];
        }
    }
    public static function guardarRegistro(string $concepto, string $fecha, float $importe): void {
        // Leer los registros actuales para obtener el último ID y calcular el siguiente ID
        $registros = self::leerRegistros();
        $ultimoId = 0;

        // Calcular el último ID
        foreach ($registros as $registro) {
            $id = intval($registro['id']);
            if ($id > $ultimoId) {
                $ultimoId = $id;
            }
        }

        // Calcular el siguiente ID
        $id = $ultimoId + 1;

        // Abrir el archivo en modo escritura (si no existe, se creará)
        $archivo = fopen("monedero.txt", "a");

        // Escribir los datos del formulario junto con el ID en el archivo
        fwrite($archivo, "$id,$concepto,$fecha,$importe\n");

        // Cerrar el archivo
        fclose($archivo);
    }

    public static function borrarRegistro(int $id): void {
        // Leer los registros actuales del archivo
        $registros = self::leerRegistros();

        // Buscar el registro con el ID proporcionado
        $registroEncontrado = null;
        foreach ($registros as $key => $registro) {
            if ($registro['id'] == $id) {
                $registroEncontrado = $key;
                break;
            }
        }

        // Si se encuentra el registro, eliminarlo del array de registros
        if ($registroEncontrado !== null) {
            unset($registros[$registroEncontrado]);

            // Reindexar el array para evitar posibles inconsistencias de índices
            $registros = array_values($registros);

            // Escribir los registros actualizados de vuelta al archivo
            $archivo = fopen("monedero.txt", "w");
            foreach ($registros as $registro) {
                fwrite($archivo, implode(",", $registro) . "\n");
            }
            fclose($archivo);
        }
    }

    public static function buscarRegistros(string $terminoBusqueda): array {
        // Leer los registros actuales para realizar la búsqueda
        $registros = self::leerRegistros();

        // Filtrar los registros que coincidan con el término de búsqueda en el concepto
        $resultados = [];
        foreach ($registros as $registro) {
            if (stripos($registro['concepto'], $terminoBusqueda) !== false) {
                $resultados[] = $registro;
            }
        }

        return $resultados;
    }

    public static function contarTotalRegistros(): int {
        // Leer el contenido del archivo monedero.txt si existe
        if (file_exists("monedero.txt")) {
            // Leer el contenido del archivo y dividirlo en líneas
            $lineas = file("monedero.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Contar el número de registros (líneas)
            $totalRegistros = count($lineas);

            return $totalRegistros;
        } else {
            return 0;
        }
    }

    public static function calcularBalanceTotal(): float {
        // Leer los registros del archivo monedero.txt
        $registros = self::leerRegistros();
        
        // Inicializar la variable para almacenar el balance total
        $balanceTotal = 0.0;

        // Sumar los importes de todos los registros
        foreach ($registros as $registro) {
            $balanceTotal += floatval($registro['importe']);
        }

        return $balanceTotal;
    }

    public static function validacion($concepto, $fecha, $importe) {
        // Inicializamos un array para almacenar mensajes de error
        $errores = [];
    
        // Comprobamos si el concepto está vacío
        if (empty($concepto)) {
            $errores['concepto'] = "Es obligatorio introducir el concepto.";
        } 
    
         // Comprobamos si la fecha tiene un formato válido ('d-m-aaaa')
        $fechaParts = explode('-', $fecha);
        if (count($fechaParts) !== 3 || !checkdate($fechaParts[1], $fechaParts[0], $fechaParts[2])) { //Para ordenar correctamente la fecha con la funcion (m/d/yyyy)
            $errores[] = "La fecha es obligatoria ('d-m-aaaa').";
        }
        // Comprobamos si el importe es un número válido
        if (!is_numeric($importe) || $importe == 0) {
            $errores[] = "El importe debe ser un número.";
        }
    
        // Si hay errores, devolvemos un array con los mensajes de error
        if (!empty($errores)) {
            return $errores;
        }
    
        return;
    }


    public static function sanearCampos($concepto, $fecha, $importe): array {
        // Aplicar trim a todos los campos para eliminar espacios en blanco al inicio y al final
        $concepto = trim($concepto);
        $fecha = trim($fecha);
        $importe = trim($importe);
    
        // Sanear el concepto: filtrar solo letras (mayúsculas y minúsculas), números y espacios, eliminando otros caracteres
        $concepto = self::sanearString($concepto);
    
        // Sanear la fecha
        $fecha = self::sanearFecha($fecha);
    
        // Sanear el importe: eliminar todos los caracteres excepto los dígitos y el signo de puntuación para permitir números decimales
        $importe = filter_var($importe, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $importe = floatval($importe);
    
        return ['concepto' => $concepto, 'fecha' => $fecha, 'importe' => $importe];
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

    // Función para ordenar los registros
    public static function ordenarRegistros($registros, $orden) {
                
        // Ordenar los registros según la variable $orden
        if ($orden === 'concepto') {
            // Ordenar por concepto (sin distinción entre mayúsculas y minúsculas)
            usort($registros, function($a, $b) {
                // Convertir conceptos a minúsculas antes de comparar
                $conceptoA = strtolower($a['concepto']);
                $conceptoB = strtolower($b['concepto']);
                // Comparar los conceptos
                return strcmp($conceptoA, $conceptoB);
            });
        } elseif ($orden === 'fecha') {
            // Ordenar por fecha
            usort($registros, function($a, $b) {
                // Convertir fechas a timestamps y comparar
                return strtotime($a['fecha']) - strtotime($b['fecha']);
            });
        } elseif ($orden === 'importe') {
            // Ordenar por importe
            usort($registros, function($a, $b) {
                // Comparar los importes
                return $a['importe'] - $b['importe'];
            });
        }
        
        return $registros;
    }



    public static function editarRegistro(int $id, string $nuevoConcepto, string $nuevaFecha, float $nuevoImporte): void {
        // Leer los registros actuales del archivo
        $registros = self::leerRegistros();
    
        // Buscar el registro con el ID proporcionado
        $registroEncontrado = null;
        foreach ($registros as $key => $registro) {
            if ($registro['id'] == $id) {
                $registroEncontrado = $key;
                break;
            }
        }
    
        // Si se encuentra el registro, se modifica con los datos nuevos
        if ($registroEncontrado !== null) {
            $registros[$registroEncontrado]['concepto'] = $nuevoConcepto;
            $registros[$registroEncontrado]['fecha'] = $nuevaFecha;
            $registros[$registroEncontrado]['importe'] = $nuevoImporte;
    
            // Escribir los registros actualizados de vuelta al archivo
            $archivo = fopen("monedero.txt", "w");
            foreach ($registros as $registro) {
                fwrite($archivo, implode(",", $registro) . "\n");
            }
            fclose($archivo);
        }
    }
    
}