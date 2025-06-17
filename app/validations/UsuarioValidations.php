<?php

require_once __DIR__ . '/../messages/MessageHandler.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioValidations
{
    /**
     * Validar nombre.
     *
     * @param array $data
     * @return bool|string
     */
    public function validateName($name)
    {
        // Validar que el nombre no esté vacío y tenga una longitud válida
        try {

            $name = trim($name);
            if (empty($name)) {
                return MessageHandler::get('user_nombre_required');
            }
            if (strlen($name) < 3 || strlen($name) > 50) {
                return  MessageHandler::get('user_invalid_data');;
            }
            if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
                return  MessageHandler::get('user_invalid_data');
            }
            return true;
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

    /**
     * Validar Documento de Identidad (Cédula).
     *
     * @param string $fechaNacimiento
     * @return bool|string
     */
    public function validateCedula($cedula)
    {
        try {
            $cedula = trim($cedula);
            if (empty($cedula)) {
                return   MessageHandler::get('user_cedula_required');
            }
            if (!preg_match('/^\d+$/', $cedula)) {
                return   MessageHandler::get('user_invalid_cedula');
            }
            return true;
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

    /**
     * Validar Fecha de Nacimiento.
     *
     * @param string $fechaNacimiento
     * @return bool
     */
    public function validateFechaNacimiento($fechaNacimiento)
    {
        $fechaNacimiento = trim($fechaNacimiento);
        if (empty($fechaNacimiento)) {

            return   MessageHandler::get('user_fecha_nacimiento_required');
        }
        $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        if (!$fecha || $fecha->format('Y-m-d') !== $fechaNacimiento) {

            return MessageHandler::get('user_invalid_fecha_nacimiento');
        }

        return true;
    }

    /**
     * Validar Sexo.
     *
     * @param string $sexo
     * @return bool|string
     */
    public function validateSexo($sexo)
    {
        try {
            $sexo = trim($sexo);
            if (empty($sexo)) {
                return MessageHandler::get('user_sexo_required');
            }
            if (!in_array($sexo, ['M', 'F'])) {
                return MessageHandler::get('user_invalid_sexo');
            }
            return true;
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }
}
