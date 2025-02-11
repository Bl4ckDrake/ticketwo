<?php
require_once './config/Conn.php';

function getConcerts()
{
    $conn = Conn::getInstance()->getConn();

    $query = 'SELECT c.id, c.name AS concert_name, b.name AS band_name, c.date, c.location, c.available_tickets, c.imgUrl AS image_url
              FROM concerts c
              JOIN bands b ON c.band_id = b.id
              WHERE c.available_tickets > 0';

    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getConcert($id)
{
    $conn = Conn::getInstance()->getConn();

    $stmt = $conn->prepare('SELECT c.id, c.name AS concert_name, b.name AS band_name, c.date, c.location, c.available_tickets, c.total_tickets, c.imgUrl AS image_url
                            FROM concerts c
                            JOIN bands b ON c.band_id = b.id
                            WHERE c.id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function searchConcerts($query)
{
    $conn = Conn::getInstance()->getConn();
    $search = '%' . $query . '%';

    $stmt = $conn->prepare('SELECT DISTINCT c.id, c.name AS concert_name, b.name AS band_name, c.date, c.location, c.imgUrl AS image_url
                            FROM concerts c
                            JOIN bands b ON c.band_id = b.id
                            LEFT JOIN band_artists ba ON b.id = ba.band_id
                            LEFT JOIN artists a ON ba.artist_id = a.id
                            WHERE c.name LIKE ? OR b.name LIKE ? OR a.name LIKE ? OR a.alias LIKE ?');
    $stmt->bind_param('ssss', $search, $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}
