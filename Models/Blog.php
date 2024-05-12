<?php

namespace Models;
use DateTime;
use Lib\Pages;

class Blog
{
    private string $usuario_id;
    private string $categoria_id;
    private string $titulo;
    private string $descripcion;
    private string $fecha;

    public function __construct(string $usuario_id, string $categoria_id, string $titulo, string $descripcion, string $fecha)
    {
        $this->usuario_id = $usuario_id;
        $this->categoria_id = $categoria_id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
    }

    public static function fromArray(array $data): Blog
    {
        return new Blog(
            $data['usuario_id'] ?? '',
            $data['categoria_id'] ?? '',
            $data['titulo'] ?? '',
            $data['descripcion'] ?? '',
            $data['fecha'] ?? ''
        );
    }

    // Getters
    public function getUsuarioId(): string
    {
        return $this->usuario_id;
    }

    public function getCategoriaId(): string
    {
        return $this->categoria_id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    // Setters
    public function setUsuarioId(string $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function setCategoriaId(string $categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }
}