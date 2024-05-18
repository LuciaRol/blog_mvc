<?php

namespace Models;

use Models\Validar;

class Usuarios
{
    public function __construct(
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $username,
        private string $contrasena,
        private string $rol
    ) {
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): self
    {
        $this->contrasena = $contrasena;
        return $this;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function setRol(string $rol): self
    {
        $this->rol = $rol;
        return $this;
    }
    /**
     * Crea un usuario a partir de un array
     */
    public static function fromArray(array $data): Usuarios
    {
        return new Usuarios(
            $data['nombre'] ?? '',
            $data['apellidos'] ?? '',
            $data['email'] ?? '',
            $data['usuario'] ?? '',
            $data['contrasena'] ?? '',
            $data['rol'] ?? 'usur' // Si el rol no está presente, se establecerá como 'usur' por defecto
        );
    }
    
}
