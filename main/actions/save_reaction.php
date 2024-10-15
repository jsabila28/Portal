<?php
$host = 'localhost';
$db = 'portal_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $postId = $_POST['post_id'];
        $reaction = $_POST['reaction'];
        // $postBy = $_POST['posted-by'];

        $stmt = $pdo->prepare("INSERT INTO tbl_reaction (post_id, reaction_type, reaction_by) 
                       VALUES (:post_id, :reaction_type, :reaction_by)
                       ON DUPLICATE KEY UPDATE reaction_type = :reaction_type_update");
        $stmt->execute([
            'post_id' => $postId, 
            'reaction_type' => $reaction,
            'reaction_by' => $postBy,
            'reaction_type_update' => $reaction
        ]);


        echo json_encode(['success' => true]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
