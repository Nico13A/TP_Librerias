<?php

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class ABMAuto {
    // Espera como parámetro un arreglo asociativo donde las claves 
    // coinciden con los nombres de las variables instancias del objeto.
    public function abm($datos) {
        $resultado = [
            'exito' => false,
            'errores' => []
        ];

        // Dependiendo de la acción en los datos, llama a los métodos correspondientes.
        if ($datos['accion'] == 'editar') {
            $resultado = $this->modificacion($datos);
        }
    
        if ($datos['accion'] == 'nuevo') {
            $resultado = $this->alta($datos);
        } 

        if ($datos['accion'] == 'borrar') {
            $resultado = $this->baja($datos);
        }

        return $resultado;
    }


    /**
     * Carga un objeto Auto desde un arreglo asociativo.
     * @param array $param
     * @return Auto
     */
    private function cargarObjeto($param) {
        $obj = null;
        // Verifica que todos los campos necesarios estén presentes en los datos
        if (array_key_exists('patente', $param) && array_key_exists('marca', $param) && array_key_exists('modelo', $param) && array_key_exists('anio', $param) && array_key_exists('dni_usuario', $param)) {
            $obj = new Auto();
            $objUsuario = new Usuario();
            $objUsuario->setDni($param['dni_usuario']);
            $objUsuario->cargar();
            $obj->setear($param['patente'], $param['marca'], $param['modelo'], $param['anio'], $objUsuario);
        }
        return $obj;
    }

    /**
     * Carga un objeto Auto con clave.
     * @param array $param
     * @return Auto
     */
    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['patente'])) {
            $obj = new Auto();
            $obj->setear($param['patente'], null, null, null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo están seteados los campos claves.
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['patente'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Permite dar de alta un objeto.
     * @param array $param
     * @return array
     */
    public function alta($param) {
        $resultado = [
            'exito' => false,
            'errores' => []
        ];
        // Validar los datos del formulario.
        $errores = $this->validarFormulario($param['dni_usuario'], $param['patente'], $param['modelo'], $param['marca'], $param['anio']);
        if (empty($errores)) {
            // Si no hay errores, proceder con la inserción.
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null && $elObjtTabla->insertar()) {
                $resultado['exito'] = true;
            }
        } else {
            // Si hay errores, agregar los errores al arreglo de resultado.
            $resultado['errores'] = $errores;
        }
        return $resultado;
    }

    /**
     * Permite eliminar un objeto. 
     * @param array $param
     * @return array
     */
    public function baja($param) {
        $resultado = [
            'exito' => false,
            'errores' => []
        ];
        // Verifica si los campos clave están seteados en el arreglo $param.
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null && $elObjtTabla->eliminar()) {
                $resultado['exito'] = true;
            } 
        }
        return $resultado;
    }


    /**
     * Permite modificar un objeto.
     * @param array $param
     * @return array
     */
    public function modificacion($param) {
        $resultado = [
            'exito' => false,
            'errores' => []
        ];

        if ($this->seteadosCamposClaves($param)) {
            // Validar los datos del formulario
            $errores = $this->validarFormulario($param['dni_usuario'], $param['patente'], $param['modelo'], $param['marca'], $param['anio']);
        
            if (empty($errores)) {
                // Si no hay errores, proceder con la modificación.
                $elObjtTabla = $this->cargarObjeto($param);
                if ($elObjtTabla != null && $elObjtTabla->modificar()) {
                    $resultado['exito'] = true;
                }
            } else {
                // Si hay errores, agregar los errores al arreglo de resultado.
                $resultado['errores'] = $errores;
            }
        } 
        return $resultado;
    }


    /**
     * Permite buscar un objeto.
     * @param array $param
     * @return array
     */
    public function buscar($param) {
        $where = " true ";
        if ($param != null) {
            if (isset($param['patente'])) {
                $where .= " and patente = '" . $param['patente'] . "'";
            }
            if (isset($param['marca'])) {
                $where .= " and marca = '" . $param['marca'] . "'";
            }
            if (isset($param['modelo'])) {
                $where .= " and modelo = '" . $param['modelo'] . "'";
            }
            if (isset($param['anio'])) {
                $where .= " and anio = " . $param['anio'];
            }
            if (isset($param['dni_usuario'])) {
                $where .= " and dni_usuario = " . $param['dni_usuario'];
            }
        }
        $obj = new Auto();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    public function mostrarDatos() {
        $lista = convert_array($this->buscar(null));
        $resultado = [];
        foreach ($lista as $objAuto) {
            if (!empty($objAuto)) {
                $resultado[] = [
                    'patente' => isset($objAuto['patente']) ? $objAuto['patente'] : '',
                    'marca' => isset($objAuto['marca']) ? $objAuto['marca'] : '',
                    'modelo' => isset($objAuto['modelo']) ? $objAuto['modelo'] : '',
                    'anio' => isset($objAuto['anio']) ? $objAuto['anio'] : '',
                    'dni_usuario' => isset($objAuto['objUsuario']) && $objAuto['objUsuario'] instanceof Usuario ? $objAuto['objUsuario']->getDni() : ''
                ];
            }
        }
        return $resultado;
    }

    // FUNCIONES VALIDACIÓN

    /**
     * Valida una patente de auto.
     * @param string $patente
     * @return array 
     */
    private function validarPatente($patente) {
        $resultados = [];
        $patenteValidador = v::regex('/^[A-Z]{3}\s\d{3}$/');
        try {
            // Intenta validar la patente usando el validador definido.
            // Si la validación falla, se lanzará una excepción.
            $patenteValidador->assert($patente);
        } catch (NestedValidationException $exception) {
            // Si ocurre una excepción de validación, captura los mensajes de error.
            $resultados = $exception->getMessages([
                'regex' => '{{name}} debe seguir el formato AAA 123',
            ]);
        }
        return $resultados;
    }

    /**
     * Valida el modelo de un auto.
     * @param string $modelo 
     * @return array 
     */
    private function validarModelo($modelo) {
        $resultados = [];
        // El modelo no debe estar vacío, debe contener solo caracteres alfanuméricos 
        // y espacios, y debe tener entre 3 y 30 caracteres.
        $modeloValidador = v::notEmpty()->alnum(' ')->length(3, 30);
        try {
            $modeloValidador->assert($modelo);
        } catch (NestedValidationException $exception) {
            $resultados = $exception->getMessages([
                'notEmpty' => '{{name}} no debe estar vacío.',
                'alnum' => '{{name}} debe contener solo letras (a-z), dígitos (0-9) y espacios.',
                'length' => '{{name}} debe tener entre 3 y 30 caracteres.'
            ]);
        }
        return $resultados;
    }

    /**
     * Valida la marca de un auto.
     * @param string $marca 
     * @return array
     */
    private function validarMarca($marca) {
        $resultados = [];
        $marcaValidador = v::notEmpty()->alpha(' ')->length(3, 30);
        try {
            $marcaValidador->assert($marca);
        } catch (NestedValidationException $exception) {
            $resultados = $exception->getMessages([
                'notEmpty' => '{{name}} no debe estar vacío.',
                'alpha' => '{{name}} debe contener solo letras (a-z) y espacios.',
                'length' => '{{name}} debe tener entre 3 y 30 caracteres.'
            ]);
        }
        return $resultados;
    }

    /**
     * Valida el año de un auto.
     * @param int $year 
     * @return array 
     */
    private function validarAnio($year)
    {
        $resultados = [];

        $fecha_actual = getdate();
        $anioActual = (int)$fecha_actual['year'];
    
        $yearValidator = v::date('Y')->between(2000, $anioActual);
        try {
            $yearValidator->assert($year);
        } catch (NestedValidationException $exception) {
            $resultados = $exception->getMessages([
                'date' => '{{name}} debe ser numérico.',
                'between' => '{{name}} debe estar entre el año 2000 y el ' . $anioActual
            ]);
        }
    
        return $resultados;
    }

    /**
     * Valida el DNI de un usuario.
     * @param int $dni 
     * @return array 
     */
    private function validarDni($dni) {
        $resultados = [];
        // Define el validador para el DNI
        $dniValidador = v::numericVal()->noWhitespace()->length(8, 8);
        try {
            // Intenta validar el DNI
            $dniValidador->assert($dni);
        } catch (NestedValidationException $exception) {
            // Captura de mensajes de error personalizados
            $resultados = $exception->getMessages([
                'numericVal' => '{{name}} debe contener solo números.',
                'noWhitespace' => '{{name}} no debe contener espacios.',
                'length' => '{{name}} debe tener exactamente 8 caracteres.'
            ]);
        }
        // Si no se pasa la validación, retorna el arreglo de errores
        return $resultados;
    }

    /**
     * Valida todos los campos del formulario de un auto.
     * @param string $dni
     * @param string $patente 
     * @param string $modelo 
     * @param string $marca 
     * @param int $anio 
     * @return array 
     */
    private function validarFormulario($dni, $patente, $modelo, $marca, $anio) {
        $errores = [];
    
        // Validar DNI
        $erroresDni = $this->validarDni($dni);
        if (!empty($erroresDni)) {
            $errores['dni_usuario'] = $erroresDni;
        }

        // Validar Patente
        $erroresPatente = $this->validarPatente($patente);
        if (!empty($erroresPatente)) {
            $errores['patente'] = $erroresPatente;
        }

        // Validar Modelo
        $erroresModelo = $this->validarModelo($modelo);
        if (!empty($erroresModelo)) {
            $errores['modelo'] = $erroresModelo;
        }

        // Validar Marca
        $erroresMarca = $this->validarMarca($marca);
        if (!empty($erroresMarca)) {
            $errores['marca'] = $erroresMarca;
        }

        // Validar Año
        $erroresAnio = $this->validarAnio($anio);
        if (!empty($erroresAnio)) {
            $errores['anio'] = $erroresAnio;
        }

        // Retorna el arreglo con los errores de validación.
        return $errores;
    }
    
}


?>