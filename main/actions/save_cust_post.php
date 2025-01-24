<?php
require_once($sr_root . "/db/db.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['image']) && isset($data['content'])) {

        $imageData = $data['image'] ?? null;
        $content = $data['content'] ?? null;
        // $content = '';
        $audience = $data['audience'] ?? null;
        $user_id = $_SESSION['user_id'];

        if ($imageData && $content) {
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);

            $decodedImage = base64_decode($imageData);

            $fileName = 'assets/announcement/post_' . uniqid() . '.png';
            file_put_contents($fileName, $decodedImage);

            try {
                $stmt = $port_db->prepare('INSERT INTO tbl_announcement (ann_content, ann_receiver, ann_approvedby) VALUES (:file_path, :audience, :posted_by)');
                $stmt->execute([
                    // ':post_desc' => $content,
                    ':file_path' => $fileName,
                    ':audience' => $audience,
                    ':posted_by' => $user_id
                ]);

                echo json_encode(['success' => true]);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid input']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
