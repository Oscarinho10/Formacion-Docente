<?php
$host = "localhost";
$port = "5432";
$dbname = "formacion_docente";
$user = "jerss";
$password = "admin";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("❌ Error al conectar con PostgreSQL.");
}
?>
