<?php
require_once './config/Conn.php';

function register($name, $surname, $email, $password)
{
    $conn = Conn::getInstance()->getConn();
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare('INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $name, $surname, $email, $hash);

    return $stmt->execute();
}

function login($email, $password)
{
    $conn = Conn::getInstance()->getConn();

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        return $user['id'];
    }

    return null;
}
