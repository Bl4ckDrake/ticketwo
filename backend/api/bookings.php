<?php
require_once '../config/Conn.php';

function bookConcert($userId, $concertId)
{
    $conn = Conn::getInstance()->getConn();
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare('SELECT available_tickets FROM concerts WHERE id = ? FOR UPDATE');
        $stmt->bind_param('i', $concertId);
        $stmt->execute();
        $result = $stmt->get_result();
        $concert = $result->fetch_assoc();

        if ($concert && $concert['available_tickets'] > 0) {
            $stmt = $conn->prepare('UPDATE concerts SET available_tickets = available_tickets - 1 WHERE id = ?');
            $stmt->bind_param('i', $concertId);
            $stmt->execute();

            $stmt = $conn->prepare('INSERT INTO bookings (user_id, concert_id) VALUES (?, ?)');
            $stmt->bind_param('ii', $userId, $concertId);
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
