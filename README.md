   <?php 
try {
    $host = "ep-dark-boat-a5upd43k.us-east-2.aws.neon.tech";
    $dbname = "dbphp";
    $username = "dbphp_owner";
    $password = "sJjPoUiI18rT";
    $endpoint = "ep-dark-boat-a5upd43k";

    $dsn = "pgsql:host=$host;dbname=$dbname;options=endpoint=$endpoint;sslmode=require";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?> 
