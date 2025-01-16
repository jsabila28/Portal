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

    // Decode JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure 'image' and 'content' are set in the received data
    if (isset($data['image']) && isset($data['content'])) {

        // Properly assign values from decoded JSON
        $imageData = $data['image'] ?? null;
        $content = $data['content'] ?? null;
        $user_id = $_SESSION['user_id'];

        if ($imageData && $content) {
            // Remove the data URL prefix to get raw Base64-encoded image
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);

            // Decode the image from Base64
            $decodedImage = base64_decode($imageData);

            // Save the image as a file (in the uploads directory)
            $fileName = 'assets/announcement/post_' . uniqid() . '.png';
            file_put_contents($fileName, $decodedImage);

            try {
                // Insert the post into the database
                $stmt = $port_db->prepare('INSERT INTO tbl_announcement (ann_title, ann_content, ann_postby) VALUES (:post_desc,:file_path, :posted_by)');
                $stmt->execute([
                    ':post_desc' => $content,
                    ':file_path' => $fileName,
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
