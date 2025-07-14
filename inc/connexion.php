<?php
function dbconnect() {
    static $connect = null;

    if ($connect === null) {
       $connect = mysqli_connect("localhost", "root", "", "s2_final");

        if (!$connect) {
            die('Erreur de connexion à la base : ' . mysqli_connect_error());
        }

        mysqli_set_charset($connect, 'utf8mb4');
    }

    return $connect;
}