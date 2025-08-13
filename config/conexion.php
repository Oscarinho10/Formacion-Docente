<?php
$host = "148.218.78.37"; // 172.21.37.83 "Gio uaem" ;  // 172.21.37.84 "Ángel uaem" //Casa de Gio 192.168.100.28
$port = "5432";
$dbname = "formacion_docente2";
$user = "jerss";
$password = "root";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

pg_query($conn, "SET TIME ZONE 'America/Mexico_City'");


if (!$conn) {
    die("❌ Error al conectar con PostgreSQL.");
} else {
   
}

//licenciatura maestria y doctorado

//Licenciatura, Ingenieria, Maestria, Doctorado
