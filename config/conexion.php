<?php
$host = "187.191.42.170"; // IP del servidor donde está PostgreSQL $host = "172.21.37.83";
$port = "5432";
$dbname = "formacion_docente";
$user = "jerss";
$password = "admin";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("❌ Error al conectar con PostgreSQL.");
} else {
   
}
?>
