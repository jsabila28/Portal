<?php
require_once($sr_root . "/db/db.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $port = Database::getConnection('port');

    // Cache file path
    $cacheFile = 'cache/data.json'; // The path to store the cache file
    $cacheTime = 60 * 60; // Cache expiry time in seconds (1 hour)

    // Check if the cache file exists and is still valid
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        // Load data from cache
        $data = json_decode(file_get_contents($cacheFile), true);
    } else {
        // Fetch data from the database
        $currentYear = date("Y");
        $stmt = $port->prepare("SELECT * FROM tbl_announcement a
            LEFT JOIN tbl201_basicinfo b ON a.ann_approvedby = b.bi_empno
            WHERE a.ann_type = 'LOCAL'
            AND LEFT(a.ann_date, 4) = ?
            ORDER BY a.ann_date DESC");
        $stmt->execute([$currentYear]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Save the fetched data into the cache file as JSON
        file_put_contents($cacheFile, json_encode($data));
    }

    // Display the data as HTML
    if (!empty($data)) {
        foreach ($data as $row) {
            echo '<section class="profile-feed">';
            echo '<div class="cardbox shadow-lg bg-white">';
            echo '<div class="cardbox-heading">';
            echo '<div class="dropdown float-right">';
            echo '<button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown" aria-expanded="false">';
            echo '<em class="fa fa-ellipsis-h"></em>';
            echo '</button>';
            echo '<div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">';
            echo '<a class="dropdown-item" href="#">Hide post</a>';
            echo '<a class="dropdown-item" href="#">Stop following</a>';
            echo '<a class="dropdown-item" href="#">Report</a>';
            echo '</div>';
            echo '</div>'; // Close dropdown
            echo '<div class="media m-0">';
            echo '<div class="d-flex mr-3">';
            echo '<a href=""><img class="img-fluid rounded-circle" src="assets/image/img/'. htmlspecialchars($row['bi_empno']) .'.jpg'.'" onerror="this.onerror=null; this.src="https://i.pinimg.com/736x/6e/db/e7/6edbe770213e7d6885240b2c91e9dd86.jpg";"></a>';
            echo '</div>';
            echo '<div class="media-body">';
            echo '<p class="m-0">'. htmlspecialchars($row['bi_empfname']) . ' '. htmlspecialchars($row['bi_emplname']).'</p>';
            echo '<small><span><i class="icon ion-md-pin"></i>' . date("F j, Y", strtotime($row['ann_timestatmp'])) . '</span></small>';
            echo '<small><span><i class="icon ion-md-time"></i>' . (new DateTime($row['ann_timestatmp']))->format("h:i A") . '</span></small>';
            echo '</div>'; // Close media-body
            echo '</div>'; // Close media
            echo '</div>'; // Close cardbox-heading
            
            // Cardbox Item
            echo '<div class="cardbox-item">';
            echo '<img class="img-fluid" src="assets/img/bday.png" alt="Image">';
            // echo "".$row['ann_content']."";
            echo '</div>'; // Close cardbox-item
            
            // Cardbox Base
            echo '<div class="cardbox-base">';
            echo '<ul>';
            echo '<li><a id="react-button"><i class="ti-face-smile"></i></a></li>';
            echo '<li><a href="#"><img src="https://i.pinimg.com/564x/4a/e9/59/4ae959ce0a3f3ebdad4c64c62db42c13.jpg" class="img-fluid rounded-circle" alt="User"></a></li>';
            echo '<li><a href="#"><img src="https://i.pinimg.com/564x/f0/1b/91/f01b919c68c353f95d58b174761e5df5.jpg" class="img-fluid rounded-circle" alt="User"></a></li>';
            echo '<li><a href="#"><img src="https://i.pinimg.com/564x/dc/12/46/dc124679726a20dc2cad0aaefdfdb312.jpg" class="img-fluid rounded-circle" alt="User"></a></li>';
            echo '<li><a href="#"><img src="https://i.pinimg.com/564x/1e/b9/ab/1eb9abce88c9859c08e70330ef8495dc.jpg" class="img-fluid rounded-circle" alt="User"></a></li>';
            echo '<li><a><span>242</span></a></li>';
            echo '</ul>';
            echo '<ul class="float-right">';
            echo '<li><a><i class="fa fa-comments"></i></a></li>';
            echo '<li><a><em class="mr-5">46</em></a></li>';
            echo '</ul>';
            echo '</div>'; // Close cardbox-base
            
            // Cardbox Base Comment
            echo '<div class="cardbox-base-comment">';
            echo '<ul>';
            echo '<li><a href="#"><em class="mr-5">View more comments</em></a></li>';
            echo '</ul>';
            echo '<div class="media m-1">';
            echo '<div class="d-flex mr-1" style="margin-left: 30px;">';
            echo '<a href=""><img class="img-fluid rounded-circle" src="https://teamtngc.com/hris2/pages/empimg/045-2022-019.jpg" alt="User"></a>';
            echo '</div>';
            echo '<div class="media-body">';
            echo '<p class="m-0">Rosette Larracochea</p>';
            echo '<small><span><i class="icon ion-md-pin"></i> Happy Birthday</span></small>';
            echo '</div>'; // Close media-body
            echo '</div>'; // Close media
            echo '</div>'; // Close cardbox-base-comment
            
            echo '</div>'; // Close cardbox
            echo '</section>'; // Close profile-feed
        }
    } else {
        echo "No data available.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
