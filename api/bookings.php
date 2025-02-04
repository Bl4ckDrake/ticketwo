<?php
require_once '../config/Conn.php';

function bookConcert($userId, $concertId, $quantity)
{
    $conn = Conn::getInstance()->getConn();
    $conn->begin_transaction();

    try {
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

            $conn->commit();
            return true;
        }

        $conn->rollback();
        return false;
    } catch (mysqli_sql_exception $e) {
        $conn->rollback();
        throw $e;
    }
}
