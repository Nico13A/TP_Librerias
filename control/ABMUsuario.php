<?php

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class ABMUsuario {
    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancia del objeto
     * @param array $datos
     * @return array
     */
    public function abm($datos) {
        $resultado = [
            'exito' => false,
            'errores' => []
        ];

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
     * Carga un objeto Usuario desde un arreglo asociativo
     * @param array $param
     * @return Usuario|null
     */
    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('dni', $param) && array_key_exists('nombre', $param) && array_key_exists('email', $param)) {
            $obj = new Usuario();
            $obj->setear($param['dni'], $param['nombre'], $param['email']);
        }
        return $obj;
    }

    /**
     * Carga un objeto Usuario con clave
     * @param array $param
     * @return Usuario|null
     */
    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['dni'])) {
            $obj = new Usuario();
            $obj->setear($param['dni'], null, null);
        }
        return $obj;
    }

    /**
     * Verifica si los campos claves están seteados
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param) {
        return isset($param['dni']);
    }

    /**
     * Permite insertar un nuevo usuario
     * @param array $param
     * @return array
     */
    public function alta($param) {
        $resultado = [
            'exito' => false,
            'errores' => []
        ];
        
        // Validar los datos del formulario
        $errores = $this->validarFormulario($param['dni'], $param['nombre'], $param['email']);
        
        if (empty($errores)) {
            // Si no hay errores, proceder con la inserción
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null && $elObjtTabla->insertar()) {
                $resultado['exito'] = true;
            }
        } else {
            // Si hay errores, agregar los errores al arreglo de resultado
            $resultado['errores'] = $errores;
        }
        
        return $resultado;
    }
    

    /**
     * Permite eliminar un usuario
     * @param array $param
     * @return array
     */
    public function baja($param) {
        $resultado = [
            'exito' => false,
            'errores' => []
        ];

        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null && $elObjtTabla->eliminar()) {
                $resultado['exito'] = true;
            } 
        }

        return $resultado;
    }

    /**
     * Permite modificar un usuario
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
            $errores = $this->validarFormulario($param['dni'], $param['nombre'], $param['email']);
        
            if (empty($errores)) {
                // Si no hay errores, proceder con la modificación
                $elObjtTabla = $this->cargarObjeto($param);
                if ($elObjtTabla != null && $elObjtTabla->modificar()) {
                    $resultado['exito'] = true;
                }
            } else {
                // Si hay errores, agregar los errores al arreglo de resultado
                $resultado['errores'] = $errores;
            }
        } 
        return $resultado;
    }

    /**
     * Permite buscar usuarios
     * @param array $param
     * @return array
     */
    public function buscar($param) {
        $where = " true ";
        if ($param != null) {
            if (isset($param['dni'])) {
                $where .= " and dni =" . $param['dni'];
            }
            if (isset($param['nombre'])) {
                $where .= " and nombre ='" . $param['nombre'] . "'";
            }
            if (isset($param['email'])) {
                $where .= " and email ='" . $param['email'] . "'";
            }
        }
        $obj = new Usuario();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    // FUNCIONES DE VALIDACIÓN

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

    private function validarNombre($nombre) {
        $resultados = [];
    
        // Define el validador para el nombre
        $nombreValidador = v::alpha(' ')     // Permite solo letras y espacios.
                            ->length(5, 50)  // Asegura que la longitud esté entre 1 y 50 caracteres.
                            ->not(v::regex('/\s{2,}/'))  // No permite más de un espacio consecutivo.
                            ->notEmpty();  // Asegura que no esté vacío.
    
        try {
            // Intenta validar el nombre
            $nombreValidador->assert($nombre);
        } catch (NestedValidationException $exception) {
            // Captura de mensajes de error personalizados
            $resultados = $exception->getMessages([
                'alpha' => '{{name}} debe contener solo letras y espacios.',
                'length' => '{{name}} debe tener entre 5 y 50 caracteres.',
                'regex' => '{{name}} no debe contener más de un espacio consecutivo.',
                'notEmpty' => '{{name}} no debe estar vacío.'
            ]);
        }
        // Si no se pasa la validación, retorna el arreglo de errores
        return $resultados;
    }

    private function validarEmail($email) {
        $resultados = [];
    
        // Define el validador para el email
        $emailValidador = v::email();
    
        try {
            // Intenta validar el email
            $emailValidador->assert($email);
        } catch (NestedValidationException $exception) {
            // Captura de mensajes de error personalizados
            $resultados = $exception->getMessages([
                'email' => '{{name}} debe ser una dirección de correo electrónico válida.'
            ]);
        }
        // Si no se pasa la validación, retorna el arreglo de errores
        return $resultados;
    }
    
    private function validarFormulario($dni, $nombre, $email) {
        $errores = [];
    
        // Validar DNI
        $erroresDni = $this->validarDni($dni);
        if (!empty($erroresDni)) {
            $errores['dni'] = $erroresDni;
        }
    
        // Validar Nombre
        $erroresNombre = $this->validarNombre($nombre);
        if (!empty($erroresNombre)) {
            $errores['nombre'] = $erroresNombre;
        }
    
        // Validar Email
        $erroresEmail = $this->validarEmail($email);
        if (!empty($erroresEmail)) {
            $errores['email'] = $erroresEmail;
        }
    
        return $errores;
    }

}



?>