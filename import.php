<?php
$pdo = new PDO("mysql:host=mysql.railway.internal;dbname=railway", "root", "ILLyyTqUMQOAqhJFNZpomvwBkOHVPbQV");
$sql = file_get_contents("/app/axis_seed.sql");
$statements = explode(";", $sql);
foreach ($statements as $statement) {
    $statement = trim($statement);
    if (!empty($statement)) {
        try {
            $pdo->exec($statement);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
echo "Import complete!\n";
