<?php
require_once($sr_root . "/db/db.php");
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $port = Database::getConnection('port');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $postedBy = $_POST['postedBy'];
        $postDesc = strip_tags($_POST['postDesc']);
        $audience = $_POST['audience'];
        $filePath = null;

        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $targetDir = "assets/announcement/";
            $fileName = basename($_FILES["file"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $filePath = 'assets/announcement/post_' . $fileName;
            } else {
                echo json_encode(["error" => "Error uploading file."]);
                exit;
            }
        }

        // Save post (INSERT only once)
        $sql = "INSERT INTO tbl_announcement (ann_title, ann_content, ann_receiver, ann_approvedby) 
                VALUES (:ann_title, :ann_content, :ann_receiver, :ann_approvedby)";
        $stmt = $port->prepare($sql);
        $stmt->bindParam(':ann_title', $postDesc);
        $stmt->bindParam(':ann_content', $filePath);
        $stmt->bindParam(':ann_receiver', $audience);
        $stmt->bindParam(':ann_approvedby', $postedBy);

        if (!$stmt->execute()) {
            echo json_encode(["error" => "Error saving post."]);
            exit;
        }

        $announcementId = $port->lastInsertId(); // Get inserted post ID

        // Detect mentions in postDesc (Capture full names)
        preg_match_all('/@([\w\s]+)/', $postDesc, $matches);
        $mentionedUsernames = array_unique(array_map('trim', $matches[1])); // Remove duplicates and trim spaces

        if (!empty($mentionedUsernames)) {
            // Fetch corresponding user IDs from database
            $placeholders = implode(',', array_fill(0, count($mentionedUsernames), '?'));
            $stmtUser = $port->prepare("
                SELECT bi_empno, CONCAT(bi_empfname, ' ', bi_emplname) AS fullname
                FROM tbl201_basicinfo 
                WHERE CONCAT(bi_empfname, ' ', bi_emplname) IN ($placeholders)
            ");
            $stmtUser->execute($mentionedUsernames);
            $mentionedUsers = $stmtUser->fetchAll(PDO::FETCH_ASSOC);

            // Insert each mention with user ID
            $stmtMention = $port->prepare("
                INSERT INTO tbl_mention (content_id, type, mentioned_userid, mentionby_user) 
                VALUES (?, 'post', ?, ?)
            ");

            foreach ($mentionedUsers as $user) {
                $stmtMention->execute([$announcementId, $user['bi_empno'], $postedBy]);
            }
        }

        echo json_encode(["success" => "Post and mentions saved successfully."]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
