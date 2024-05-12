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
        private string $rol = "user"
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
    public static function validation(array $data, array &$errores, array $arrayUsuarios, array $arrayEmail): array
    {
        $username = $data['username'];
        $password1 = $data['password'];
        $password2 = $data['password2'];
        $email = $data['email'];
        $nombre = $data['nombre'];
        $apellidos = $data['apellidos'];
        
        // USERNAME
        
        if (empty($username)) {
            $errores['username'] = "Usuario es obligatorio";
        } elseif (Validar::validar_array($username, $arrayUsuarios)) {
            $errores['username'] = "Usuario ya registrado";
        } elseif (strlen($username) < 4) {
            $errores['username'] = "Usuario debe tener más de 4 caracteres";
        } elseif (!Validar::son_letras($username)) {
            $errores['username'] = "Usuario contiene caracteres no permitidos";
        }

        // PASSWORD
        if (empty($password1)) {
            $errores['password'] = "Contraseña es obligatoria";
        } elseif ($password1 != $password2) {
            $errores['password'] = "Las contraseñas no coinciden";
            $errores['password2'] = "Las contraseñas no coinciden";
        } elseif (strlen($password1) <= 8) {
            $errores['password'] = "La contraseña debe tener más de 8 caracteres";
        }
        
        // EMAIL
        
        if (empty($email)) {
            $errores['email'] = "Email es obligatorio";
        } elseif (Validar::validar_array($email, $arrayEmail)) {
            $errores['email'] = "Email ya registrado";
        } elseif (!Validar::esEmail($email)) {
            $errores['email'] = "Email tiene un formato inválido";
        }

        # NOMBRE
        
        if (empty($nombre)) {
            $errores['nombre'] = "Nombre es obligatorio";
        } elseif (!Validar::son_letras($nombre)) {
            $errores['nombre'] = "Nombre contiene caracteres no permitidos";
        }

        #  APELLIDOS

        if (empty($apellidos)) {
            $errores['apellidos'] = "Apellidos son obligatorios";
        } elseif (!Validar::son_letras($apellidos)) {
            $errores['apellidos'] = "Apellidos contienen caracteres no permitidos";
        }

        return $errores;
    }
    public static function validationLogin(array $data,array &$errores) : array {
        $pass1 = $data['password'];
        $email = $data['email'];
        if (empty($pass1)) {
            $errores['password'] = "Contraseña obligatoria";
        }
        if (empty($email)) {
            $errores['email'] = "Email obligatorio";
        } elseif (!Validar::esEmail($email)) {
            $errores['email'] = "Email tiene caracteres extraños";
        }
        return $errores;
    }
}
