<?php
require_once '../config/Conn.php';

$conn = Conn::getInstance()->getConn();
$conn->begin_transaction();

try {
    $userId = $_GET['user_id'] ?? null;
    $concertId = $_GET['concert_id'] ?? null;
    $quantity = $_GET['quantity'] ?? null;

    if ($userId && $concertId && $quantity) {
        $stmt = $conn->prepare('SELECT available_tickets FROM concerts WHERE id = ? FOR UPDATE');
        $stmt->bind_param('i', $concertId);
        $stmt->execute();
        $result = $stmt->get_result();
        $concert = $result->fetch_assoc();

        if ($concert && $concert['available_tickets'] >= $quantity) {
            $stmt = $conn->prepare('UPDATE concerts SET available_tickets = available_tickets - ? WHERE id = ?');
            $stmt->bind_param('ii', $quantity, $concertId);
            $stmt->execute();

            $stmt = $conn->prepare('INSERT INTO bookings (user_id, concert_id, quantity) VALUES (?, ?, ?)');
            $stmt->bind_param('iii', $userId, $concertId, $quantity);
            $stmt->execute();

            $bookingId = $stmt->insert_id; // Get the booking ID

            $conn->commit();
            $response = [
                'success' => true,
                'booking_id' => $bookingId
            ];
            echo json_encode($response);
        } else {
            $conn->rollback();
            $response = [
                'success' => false,
                'message' => 'Not enough available tickets.'
            ];
            echo json_encode($response);
        }
    } else {
        $conn->rollback();
        $response = [
            'success' => false,
            'message' => 'Missing parameters.'
        ];
        echo json_encode($response);
    }
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    throw $e;
}
