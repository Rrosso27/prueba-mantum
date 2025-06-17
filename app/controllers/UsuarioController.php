<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../validations/UsuarioValidations.php';

class UsuarioController extends Controller
{
    private  $usuario;

    public function  __construct()
    {
        $this->usuario = new Usuario();
    }

    /**
     * Obtener todos los usuarios
     * 
     * @return void
     */
    public function index()
    {
        $usuarios = $this->usuario->getAll();
        $this->response(['status' => 'success', 'data' => $usuarios]);
    }

    /**
     * Obtener un usuario por ID
     * 
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $usuario = $this->usuario->getById($id);
        if ($usuario) {
            $this->response(['status' => 'success', 'data' => $usuario], 200);
        } else {
            $this->response(['status' =>  'error', 'error' => 'Usuario no encontrado'], 404);
        }
    }


    /**
     * Crear o actualizar un usuario
     * 
     * @param array $data
     * @return void
     */
    public function createOrUpdate($data)
    {
        try {
            if ($data['id']) {
                // Si se proporciona un ID, actualizamos el usuario
                $this->update($data['id'], $data);
            } else {
                // Si no se proporciona un ID, creamos un nuevo usuario
                $this->create($data);
            }
        } catch (\Throwable $th) {
            $this->response(['status' => 'error', 'message' => 'Error al procesar la solicitud.' . $th->getMessage()], 500);
        }
    }



    /**
     * Crear un nuevo usuario
     * 
     * @return void
     */
    public function create($data)
    {
        try {
            $validationResult = $this->validate($data);

            if ($validationResult !== true) {
                $this->response(json_decode($validationResult));
            }

            $created = $this->usuario->create($data);
            if ($created) {
                $this->response(['status' => 'success', 'message' => 'Usuario creado exitosamente.'], 201);
            } else {
                $this->response(['status' => 'error', 'message' => 'Error al crear el usuario.'], status: 500);
            }
        } catch (\Throwable $th) {
            $this->response(['status' => 'error', 'message' => 'Error al procesar la solicitud.' . $th->getMessage()], 500);
        }
    }

    /**
     * Actualizar un usuario
     * 
     * @param int $id
     * @param array $data
     * @return void
     */
    public function update($id, $data)
    {
        try {
            $validationResult = $this->validate($data);
            if ($validationResult !== true) {
                $this->response(json_decode($validationResult));
            }

            $updated = $this->usuario->update($id, $data);
            if ($updated) {
                $this->response(['status' => 'success', 'message' => 'Usuario actualizado exitosamente.']);
            } else {
                $this->response(['status' => 'error', 'message' => 'Error al actualizar el usuario.'], 500);
            }
        } catch (\Throwable $th) {
            $this->response(['status' => 'error', 'error' => 'Error al procesar la solicitud.'], 500);
        }
    }

    /**
     * Eliminar un usuario
     * 
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $deleted = $this->usuario->delete($id);
            if ($deleted) {
                $this->response(['status' => 'success', 'message' => 'Usuario eliminado exitosamente.']);
            } else {
                $this->response(['status' => 'error', 'message' => 'Error al eliminar el usuario.'], 500);
            }
        } catch (\Throwable $th) {
            $this->response(['error' => 'Error al procesar la solicitud.'], 500);
        }
    }

    public function  validate($data)
    {
        $validations = new UsuarioValidations();
        $validateName = $validations->validateName($data['nombre']);
        if ($validateName !== true) {
            return json_encode(['status' => 'error', 'message' => $validateName]);
        }

        $validateCedula = $validations->validateCedula($data['cedula']);
        if ($validateCedula !== true) {
            return json_encode(['status' => 'error', 'message' => $validateCedula]);
        }
        $validateFechaNacimiento = $validations->validateFechaNacimiento($data['fecha_nacimiento']);
        if ($validateFechaNacimiento !== true) {
            return json_encode(['status' => 'error', 'message' => $validateFechaNacimiento]);
        }
        $validateSexo  = $validations->validateSexo($data['sexo']);
        if ($validateSexo !== true) {
            return json_encode(['status' => 'error', 'message' => $validateSexo]);
        }

        $exists = $this->usuario->exists($data['cedula']);
        if (!$exists) {
            return true;
        } else if ($exists && $data['id'] == null) {
            return json_encode(['status' => 'error', 'message' => 'El usuario ya existe.']);
        } else if ($exists && $data['id'] != null) {
            return $this->checkIfUserExists($data, $exists);
        }
        return true;
    }

    /**
     * Verificar si el usuario existe y es el mismo usuario que se está actualizando
     * 
     * @param array $data
     * @param array $exists
     * @return bool|string
     */
    public function checkIfUserExists($data, $exists)
    {
        if ($data['id'] == $exists['id']) {
            return true;
        } else {
            return json_encode(['status' => 'error', 'message' => 'El usuario ya existe.']);
        }
    }
}
