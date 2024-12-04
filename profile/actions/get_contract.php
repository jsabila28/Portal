<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

    $stmt = $hr_db->prepare("
        SELECT ci_empno,
        ci_startdate,
        ci_enddate,
        ci_file,
        jd_company, 
        jd_title,
        es_name 
        FROM tbl201_contractinfo
        LEFT JOIN tbl_jobdescription ON jd_code = ci_position
        LEFT JOIN tbl_empstatus ON es_code = ci_jobstatus 
        WHERE ci_empno = ? 
        -- GROUP BY psl_paydate
        ORDER BY ci_startdate ASC
    ");
    $stmt->execute([$user_id]);
    $contract = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($contract)) {
        echo '<div class="card-block" id="prof-card">'; // prof-card start
        echo '<div id="specialSkills" class="contact" style="margin-bottom:10px;">';
        foreach ($contract as $k) {
            echo '<div class="skill">';
            echo '<div class="desc-skill">';
            // echo '
            //     <div class="skill-title">
            //         <p id="title">' . htmlspecialchars($k['empl_position'] ?: 'None') . '</p>
            //     </div>
            // ';
            echo '<div class="skill-types">';
            echo '<p id="type"><i class="icofont icofont-man-in-glasses"></i> ' . htmlspecialchars($k['ci_empno'] ?: 'None') . '</p>';
            echo '<p id="type"><i class="icofont icofont-man-in-glasses"></i> ' . htmlspecialchars($k['jd_title'] ?: 'None') . '</p>';
            echo '<p id="type"><i class="icofont icofont-man-in-glasses"></i> ' . htmlspecialchars($k['es_name'] ?: 'None') . '</p>';
            echo '<p id="type"><i class="icofont icofont-calendar"></i> ';
            echo isset($k['ci_startdate']) && !empty($k['ci_startdate']) ? htmlspecialchars((new DateTime($k['ci_startdate']))->format('F j, Y')) : 'Invalid date';
            echo '</p>';
            echo '<p id="type"><i class="icofont icofont-calendar"></i> ';
            echo isset($k['ci_enddate']) && !empty($k['ci_enddate']) ? htmlspecialchars((new DateTime($k['ci_enddate']))->format('F j, Y')) : 'Invalid date';
            echo '</p>';
            echo '<p id="type"><i class="icofont icofont-man-in-glasses"></i> ' . htmlspecialchars($k['jd_company'] ?: 'None') . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>No contract found.</p>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
