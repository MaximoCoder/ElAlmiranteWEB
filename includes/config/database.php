<?php

// LLAVE PARA ENCRIPTAR
define("KEY", "MAX");
define("COD", "AES-128-ECB"); // metodo de encriptacion (NO CAMBIAR)

#FUNCION DE CONEXION A LA BASE DE DATOS Y ENCRIPTACION 
function connectDB() {
    $host = 'localhost';
    $db = 'almirante';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function encryptData($data) {
    return openssl_encrypt($data, COD, KEY);
}

function decryptData($data) {
    return openssl_decrypt($data, COD, KEY);
}