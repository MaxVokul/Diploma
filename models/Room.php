<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
//
class Room {
    public static function getAllrooms() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM rooms");

        while($res = $stmt->fetch_assoc()) {
            print_r($res);
            $hotel = [
                'ID' => $res['id'],
                'TYPE' => $res['type'],
            ];
        }
    }
    public static function createRoom($number, $type, $price)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO room (number, type, price) VALUES (?, ?, ?)");
        $stmt->execute([$number, $type, $price]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}