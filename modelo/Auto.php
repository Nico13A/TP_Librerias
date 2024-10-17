<?php

class Auto extends BaseDatos {
    private $patente;
    private $marca;
    private $modelo;
    private $anio;
    private $objUsuario;
    private $mensajeOperacion;

    public function __construct() {
        parent::__construct();
        $this->patente = "";
        $this->marca = "";
        $this->modelo = "";
        $this->anio = "";
        $this->objUsuario = null;
        $this->mensajeOperacion = "";
    }

    public function setear($patente, $marca, $modelo, $anio, $objUsuario) {
        $this->setPatente($patente);
        $this->setMarca($marca);
        $this->setModelo($modelo);
        $this->setAnio($anio);
        $this->setObjUsuario($objUsuario);
    }

    public function getPatente() {
        return $this->patente;
    }

    public function setPatente($patente) {
        $this->patente = $patente;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }

    public function getObjUsuario() {
        return $this->objUsuario;
    }

    public function setObjUsuario($objUsuario) {
        $this->objUsuario = $objUsuario;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($valor) {
        $this->mensajeOperacion = $valor;
    }

    public function cargar() {
        $resp = false;
        $sql = "SELECT * FROM autos WHERE patente = '" . $this->getPatente() . "'";
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $objUsuario = new Usuario();
                    $objUsuario->setDni($row['dni_usuario']);
                    $objUsuario->cargar();

                    $this->setear($row['patente'], $row['marca'], $row['modelo'], $row['anio'], $objUsuario);
                    $resp = true;
                }
            }
        } else {
                $this->setMensajeOperacion("Auto->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $sql = "INSERT INTO autos (patente, marca, modelo, anio, dni_usuario) VALUES ('" . $this->getPatente() . "', '" . $this->getMarca() . "', '" . $this->getModelo() . "', " . $this->getAnio() . ", " . $this->getObjUsuario()->getDni() . ")";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Auto->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Auto->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $sql = "UPDATE autos SET marca='" . $this->getMarca() . "', modelo='" . $this->getModelo() . "', anio=" . $this->getAnio() . ", dni_usuario=" . $this->getObjUsuario()->getDni() . " WHERE patente='" . $this->getPatente() . "'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Auto->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Auto->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $sql = "DELETE FROM autos WHERE patente='" . $this->getPatente() . "'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql) > 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Auto->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Auto->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "") {
        $arreglo = array();
        $sql = "SELECT * FROM autos ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {
                        $obj = new Auto();
                        $objUsuario = new Usuario();
                        $objUsuario->setDni($row['dni_usuario']);
                        $objUsuario->cargar();
                        
                        $obj->setear($row['patente'], $row['marca'], $row['modelo'], $row['anio'], $objUsuario);
                        array_push($arreglo, $obj);

                    }
                }
            } else {
                $this->setMensajeOperacion("Auto->listar: " . $this->getError());
            }
        }
        return $arreglo;
    }
}
?>
