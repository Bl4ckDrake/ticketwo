<?php
require_once './config/Conn.php';

function getUserBookings($userId)
{
    $conn = Conn::getInstance()->getConn();

    // Retrieve user bookings
    $sql = "
        SELECT 
            bookings.id AS booking_id, 
            concerts.name AS concert_name, 
            concerts.date, 
            concerts.location, 
            bookings.quantity, 
            concerts.imgUrl
        FROM bookings
        JOIN concerts ON bookings.concert_id = concerts.id
        WHERE bookings.user_id = $userId
        ORDER BY concerts.date DESC";

    $result = $conn->query($sql);

    return $result; // Return the query result directly
}

function getBookingById($bookingId)
{
    $conn = Conn::getInstance()->getConn();

    // Retrieve booking by id
    $sql = "
        SELECT 
            bookings.id AS booking_id, 
            concerts.name AS concert_name, 
            concerts.date, 
            concerts.location, 
            bookings.quantity, 
            concerts.imgUrl
        FROM bookings
        JOIN concerts ON bookings.concert_id = concerts.id
        WHERE bookings.id = $bookingId";

    $result = $conn->query($sql);

    return $result; // Return the first row of the query result
}
