<?php

namespace Models;
use DateTime;
use Lib\Pages;

class Blog
{
    private string $titulo;
    private string $descripcion;
    private string $fecha;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $username;
    private string $rol;
    private string $categoria;

    public function __construct(string $titulo, string $descripcion, string $fecha, string $nombre, string $apellidos, string $email, string $username, string $rol, string $categoria)
    {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->username = $username;
        $this->rol = $rol;
        $this->categoria = $categoria;
    }

    public static function fromArray(array $data): Blog
    {
        return new Blog(
            $data['titulo'] ?? '',
            $data['descripcion'] ?? '',
            $data['fecha'] ?? '',
            $data['nombre'] ?? '',
            $data['apellidos'] ?? '',
            $data['email'] ?? '',
            $data['username'] ?? '',
            $data['rol'] ?? '',
            $data['categoria'] ?? ''
        );
    }

    // Getters
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

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    // Setters
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

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }
}
