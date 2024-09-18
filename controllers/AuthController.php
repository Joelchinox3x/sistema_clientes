<?php
include_once 'dao/UserDAO.php';

class AuthController {
    private $userDAO;

    public function __construct() {
        $this->userDAO = UserDAO::getInstance(); // Usamos un Singleton para el DAO
    }

    public function login($username, $password) {
        // Intentar obtener el usuario por nombre de usuario
        $user = $this->userDAO->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            // Si la contraseña coincide, iniciar sesión
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }

    public function register($username, $password) {
        // Verificar si el usuario ya existe
        if ($this->userDAO->getUserByUsername($username)) {
            return false; // El usuario ya existe
        }
        // Cifrar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        return $this->userDAO->createUser($username, $hashedPassword);
    }
}
?>
