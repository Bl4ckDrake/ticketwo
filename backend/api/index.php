<?php
require 'auth.php';
require 'concerts.php';
require 'bookings.php';

header('Content-Type: application/json');

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch (true) {
    case preg_match('#^/register$#', $request):
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $success = register($data['name'], $data['surname'], $data['email'], $data['password']);
            echo json_encode(['success' => $success]);
        }
        break;

    case preg_match('#^/login$#', $request):
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = login($data['email'], $data['password']);
            echo json_encode($user ? ['success' => true, 'user' => $user] : ['success' => false]);
        }
        break;

    case preg_match('#^/concerts$#', $request):
        if ($method === 'GET') {
            echo json_encode(getConcerts());
        }
        break;

    case preg_match('#^/concerts/(\d+)$#', $request, $matches):
        if ($method === 'GET') {
            echo json_encode(getConcert($matches[1]));
        }
        break;

    case preg_match('#^/search$#', $request):
        if ($method === 'GET') {
            $query = $_GET['q'] ?? '';
            echo json_encode(searchConcerts($query));
        }
        break;

    case preg_match('#^/book$#', $request):
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
