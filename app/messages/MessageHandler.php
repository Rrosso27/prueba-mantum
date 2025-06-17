<?php

class MessageHandler
{
    private static $messages = [
        'user_created' => 'Usuario creado exitosamente.',
        'user_updated' => 'Usuario actualizado exitosamente.',
        'user_deleted' => 'Usuario eliminado exitosamente.',
        'user_not_found' => 'Usuario no encontrado.',
        'user_exists' => 'El usuario ya existe.',
        'user_nombre_required' => 'El nombre del usuario es obligatorio.',
        'user_cedula_required' => 'La cedula del usuario es obligatoria.',
        'user_fecha_nacimiento_required' => 'La fecha de nacimiento del usuario es obligatoria.',
        'user_sexo_required' => 'El sexo del usuario es obligatorio.',
        'user_invalid_cedula' => 'La cedula proporcionada no es valida.',
        'user_invalid_fecha_nacimiento' => 'La fecha de nacimiento proporcionada no es valida.',
        'user_invalid_sexo' => 'El sexo proporcionado no es valido. Debe ser "M" o "F".',
        'user_invalid_data' => 'Datos del usuario invalidos proporcionados.',
        'invalid_data' => 'Datos invalidos proporcionados.',
        'server_error' => 'Error del servidor, por favor intente mas tarde.'
    ];


    /**
     * Recibir un mensaje por clave.
     *
     * @param string $key
     * @return string|null
     */
    public static function get($key)
    {
        return self::$messages[$key] ?? null;
    }
}
