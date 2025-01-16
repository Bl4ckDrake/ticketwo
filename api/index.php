<?php
//echo password_hash("Test123@", PASSWORD_DEFAULT);
require 'auth.php';
require 'concerts.php';
require 'bookings.php';

header('Content-Type: application/json');

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch (true) {
    case preg_match('#^/api/login$#', $request):
        if ($method === 'POST') {
            $conn = Conn::getInstance()->getConn();

            $data = json_decode(file_get_contents('php://input'), true);

            $email = $conn->real_escape_string($data['email']);
            $password = $data['password'];

            $sql = "SELECT id, password FROM users WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    // Generate a token
                    $token = bin2hex(random_bytes(32));

                    // Optional: Store the token in the database
                    $userId = $user['id'];
                    $conn->query("UPDATE users SET auth_token = '$token' WHERE id = $userId");

                    // Set the token in a secure, HttpOnly cookie
                    setcookie("auth_token", $token, [
                        'expires' => time() + 3600, // 1 hour
                        'path' => '/',
                        'domain' => '', // Set your domain
                        'secure' => true, // Use HTTPS
                        'httponly' => true,
                        'samesite' => 'Strict'
                    ]);

                    echo json_encode(["success" => true, "message" => "Login successful"]);
                    exit;
                }
            }

            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Invalid email or password"]);
        }
        break;

    case preg_match('#^/api/register$#', $request):
        if ($method === 'POST') {
            $conn = Conn::getInstance()->getConn();

            $data = json_decode(file_get_contents('php://input'), true);

            $name = $conn->real_escape_string($data['name']);
            $surname = $conn->real_escape_string($data['surname']);
            $email = $conn->real_escape_string($data['email']);
            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            // Check if email already exists
            $result = $conn->query("SELECT id FROM users WHERE email = '$email'");
            if ($result->num_rows > 0) {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "Email already registered"]);
                exit;
            }

            // Insert new user
            $sql = "INSERT INTO users (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";
            if ($conn->query($sql)) {
                // Generate a token
                $token = bin2hex(random_bytes(32));

                // Optional: Store the token in the database
                $userId = $conn->insert_id;
                $conn->query("UPDATE users SET auth_token = '$token' WHERE id = $userId");

                // Set the token in a secure, HttpOnly cookie
                setcookie("auth_token", $token, [
                    'expires' => time() + 3600, // 1 hour
                    'path' => '/',
                    'domain' => '', // Set your domain
                    'secure' => true, // Use HTTPS
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);

                echo json_encode(["success" => true, "message" => "Registration successful"]);
                exit;
            }

            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Registration failed"]);
        }
        break;

    case preg_match('#^/api/concerts$#', $request):
        if ($method === 'GET') {
            echo json_encode(getConcerts());
        }
        break;

    case preg_match('#^/api/concerts/(\d+)$#', $request, $matches):
        if ($method === 'GET') {
            echo json_encode(getConcert($matches[1]));
        }
        break;

    case preg_match('#^/api/search$#', $request):
        if ($method === 'GET') {
            $query = $_GET['q'] ?? '';
            echo json_encode(searchConcerts($query));
        }
        break;

    case preg_match('#^/api/book$#', $request):
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $success = bookConcert($data['user_id'], $data['concert_id']);
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
