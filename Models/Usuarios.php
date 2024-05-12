<?php

namespace Models;

use Models\Validar;

class Usuarios
{
    protected static $errores;
    public function __construct(
        private string|null $id = null,
        private string $usuario,
        private string $contrasena,
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $fecha_nacimiento,
        private string $movil,
        private string $rol,
        private string $lastCommit
    ) {
    }
    /**
     * Get the value of id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of usuario
     */
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of contrasena
     */
    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    /**
     * Set the value of contrasena
     */
    public function setContrasena(string $contrasena): self
    {
        $this->contrasena = $contrasena;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of fecha_nacimiento
     */
    public function getFechaNacimiento(): string
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Set the value of fecha_nacimiento
     */
    public function setFechaNacimiento(string $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    /**
     * Get the value of movil
     */
    public function getMovil(): string
    {
        return $this->movil;
    }

    /**
     * Set the value of movil
     */
    public function setMovil(string $movil): self
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get the value of rol
     */
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     */
    public function setRol(string $rol): self
    {
        $this->rol = $rol;

        return $this;
    }
    /**
     * Get the value of rol
     */
    public function getLastCommit(): string
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     */
    public function setLastCommit(string $lastCommit): self
    {
        $this->lastCommit = $lastCommit;

        return $this;
    }
    /**
     * Crea un usuario a partir de un array
     */
    public static function fromArray(array $data): Usuarios
    {
        return new Usuarios(
            $data['id'] ?? null,
            $data['usuario'] ?? '',
            $data['contrasena'] ?? "",
            $data['nombre'] ?? '',
            $data['apellidos'] ?? "",
            $data['email'] ?? "",
            $data['fecha_nacimiento'] ?? '',
            $data['movil'] ?? "",
            $data['rol'] ?? "user",
            $data['lastCommit'] ?? "",
        );
    }
    public static function validation(array $data, array &$errores, array $arrayUsuarios, array $arrayEmail): array
    {
        $user = $data['user'];
        $pass1 = $data['password'];
        $pass2 = $data['password2'];
        $email = $data['email'];
        $name = $data['name'];
        $subname = $data['subname'];
        $date = $data['date'];
        $movil = $data['movil'];
        ##############
        #    USER    #
        ##############
        if (empty($user)) {
            $errores['usuario'] = "Usuario campo obligatorio";
        } elseif(Validar::validar_array($user, $arrayUsuarios)){
            $errores['usuario']="Usuario registrado";
        }elseif (strlen($user) < 4) {
            $errores['usuario'] = "Usuario debe tener más de 4 caracteres";
        } elseif (!Validar::son_letras($user)) {
            $errores['usuario'] = "Usuario tiene caracteres no permitidos";
        }
        ##############
        #  PASSWORD  #
        ##############
        if (empty($pass1)) {
            $errores['password'] = "Contraseña obligatoria";
        } elseif ($pass1 != $pass2) {
            $errores['password'] = "Las contraseñas no coinciden";
            $errores['password2'] = "Las contraseñas no coinciden";
        }
        if (strlen($pass1) <= 8) {
            $errores['password'] = "Contraseña debe tener más de 8 caracteres";
        }
        #Comprobar que tenga una buena forma;
        ##############
        #   EMAIL    #
        ##############
        if (empty($email)) {
            $errores['email'] = "Email obligatorio";
        } elseif(Validar::validar_array($email, $arrayEmail)){
            $errores['email']="Email registrado";
        }elseif (!Validar::esEmail($email)) {
            $errores['email'] = "Email tiene caracteres extraños";
        }
        ##############
        #    NAME    #
        ##############
        if (empty($name)) {
            $errores['name'] = "Nombre obligatorio";
        } elseif ( !Validar::son_letras($name)) {
            $errores['name'] = "Nombre tiene caracteres extraños";
        }
        ##############
        #  SUBNAME   #
        ##############
        if (empty($subname)) {
            $errores['subname'] = "Apellidos obligatorios";
        } elseif (!Validar::son_letras($subname)) {
            $errores['subname'] = "Apellidos tiene caracteres extraños";
        }
        ##############
        #    DATE    #
        ##############
        if (empty($date)) {
            $errores['date'] = "Fecha de nacimiento obligatoria";
        } elseif( !Validar::validarFecha($date)){
            $errores['date'] = "Fecha incorrecta";
        }
        ##############
        #    MOVIL   #
        ##############
        if (empty($movil)) {
            $errores['movil'] = "Movil obligatorio";
        } elseif(!Validar::esNumero($movil)){
            $errores['movil'] = "Formato de número incorrecto";
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
