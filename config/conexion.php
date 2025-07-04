<?php
$host =   "192.168.100.28"; // 172.21.37.83 "Gio uaem" ;  // 172.21.37.84 "Ángel uaem" //Casa de Gio 192.168.100.28
$port = "5432";
$dbname = "formacion_docente2";
$user = "jerss";
$password = "admin";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("❌ Error al conectar con PostgreSQL.");
} else {
   
}
?>
