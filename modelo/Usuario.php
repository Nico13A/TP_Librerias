<?php

class Usuario extends BaseDatos {
    private $dni;
    private $nombre;
    private $email;
    private $mensajeOperacion;

    public function __construct()
    {
        parent::__construct();
        $this->dni = "";
        $this->nombre = "";
        $this->email = "";
        $this->mensajeOperacion = "";
    }

    public function setear($dni, $nombre, $email)
    {
        $this->setDni($dni);
        $this->setNombre($nombre);
        $this->setEmail($email);
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($valor)
    {
        $this->mensajeOperacion = $valor;
    }

    public function cargar()
    {
        $resp = false;
        $sql = "SELECT * FROM usuarios WHERE dni = " . $this->getDni();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $this->setear($row['dni'], $row['nombre'], $row['email']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Usuario->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $sql = "INSERT INTO usuarios (dni, nombre, email) VALUES (" . $this->getDni() . ", '" . $this->getNombre() . "', '" . $this->getEmail() . "');";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $sql = "UPDATE usuarios SET nombre='" . $this->getNombre() . "', email='" . $this->getEmail() . "' WHERE dni=" . $this->getDni();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $sql = "DELETE FROM usuarios WHERE dni=" . $this->getDni();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql) > 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $sql = "SELECT * FROM usuarios ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {
                        $obj = new Usuario();
                        $obj->setear($row['dni'], $row['nombre'], $row['email']);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setMensajeOperacion("Usuario->listar: " . $this->getError());
            }
        }
        return $arreglo;
    }
}

?>
