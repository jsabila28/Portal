<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');

    $cacheFile = 'cache/postfeeddata.json';
    $cacheTime = 30 * 30; 

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {

        $data = json_decode(file_get_contents($cacheFile), true);
    } else { 
        $currentYear = date('Y');
        $stmt = $port_db->prepare("SELECT * FROM tbl_announcement a
            LEFT JOIN tbl201_basicinfo b ON a.ann_postby = b.bi_empno
            WHERE a.ann_type = 'LOCAL'
            AND DATE_FORMAT(a.ann_timestatmp, '%Y') = ?
            ORDER BY ann_timestatmp DESC");
        $stmt->execute([$currentYear]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);    

        file_put_contents($cacheFile, json_encode($data));
    }

    if (!empty($data)) {
        foreach ($data as $row) {

            $stmt = $port_db->prepare("
                SELECT COUNT(*) as reaction_count 
                FROM tbl_reaction 
                WHERE post_id = ?
                GROUP BY post_id
            ");
            $stmt->execute([$row['ann_id']]);
            $reaction = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $port_db->prepare("
                SELECT com_post_id,COUNT(*) as comment_count 
                FROM tbl_post_comment 
                WHERE com_post_id = ?
                GROUP BY com_post_id
            ");
            $stmt->execute([$row['ann_id']]);
            $cm = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<section class="profile-feed">';
            echo '<div class="cardbox shadow-lg bg-white">';
            echo '<div class="cardbox-heading">';
            echo '<div class="dropdown float-right">';
            echo '<button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown" aria-expanded="false">';
            echo '<em class="fa fa-ellipsis-h"></em>';
            echo '</button>';
            echo '<div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">';
            echo '<a class="dropdown-item" href="#"><i class="fas fa-eye-slash"></i> Hide post</a>';
            // echo '<a class="dropdown-item" href="#">Stop following</a>';
            echo '<a class="dropdown-item" href="#"><i class="fas fa-exclamation-circle"></i> Report</a>';
            echo '</div>';
            echo '</div>'; // Close dropdown
            echo '<div class="media m-0">';
            echo '<div class="d-flex mr-3">';
            echo '<a href=""><img class="img-fluid rounded-circle" src="assets/image/img/'. htmlspecialchars($row['bi_empno']) .'.jpg'.'" onerror="this.onerror=null; this.src="https://i.pinimg.com/736x/6e/db/e7/6edbe770213e7d6885240b2c91e9dd86.jpg";"></a>';
            echo '</div>';
            echo '<div class="media-body">';
            echo '<p class="m-0" style="font-weight: 500px;">'. htmlspecialchars($row['bi_empfname']) . ' '. htmlspecialchars($row['bi_emplname']).'</p>';
            echo '<small><span><i class="icon ion-md-pin"></i>' . date("F j, Y", strtotime($row['ann_timestatmp'])) . '</span></small>';
            echo '<small><span><i class="icon ion-md-time"></i>' . (new DateTime($row['ann_timestatmp']))->format("h:i A") . '</span></small>';
            echo '</div>'; // Close media-body
            echo '</div>'; // Close media

            echo '<div class="media m-0">';
            echo '<div class="media-body">';
            echo '<p><span><i class="icon ion-md-time"></i>' . htmlspecialchars($row['ann_title']). '</span></p>';
            echo '</div>'; // Close media-body
            echo '</div>'; // Close media

            echo '</div>'; // Close cardbox-heading
            
            // Cardbox Item
            echo '<div class="cardbox-item">';
            if(strpos($row['ann_content'], '<figure') !== false){

                $imagePattern = '/<img\s+[^>]*src=["\']([^"\']+)["\']/i';

                // Match image sources
                preg_match_all($imagePattern, $row['ann_content'], $imageMatches);
                $sources = $imageMatches[1];

                foreach ($sources as $imgv) {
                    echo '<img class="img-fluid" style="max-height: 500px !important;cursor: pointer;" src="assets/announcement/' . htmlspecialchars($imgv) . '">';
                }

            }else if(strpos($row['ann_content'], '<figure') !== false){
                echo str_replace('../announcement', 'https://teamtngc.com/hris2/pages/announcement', $row['ann_content']);
            }else{
                echo '<img class="img-fluid" style="max-height: 500px !important;cursor: pointer;" src="https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($row['ann_content']) . '">';
            }
            // echo "".$row['ann_content']."";
            echo '</div>'; // Close cardbox-item
            
            // Cardbox Base
            echo '<div class="cardbox-base">';
            echo '<ul>';
            echo '<li>';
            echo '<div class="reaction-container">';
            $stmt = $port_db->prepare("
                SELECT reaction_type FROM tbl_reaction 
                WHERE reaction_by = '045-2022-013'
                AND post_id = ?
            ");
            $stmt->execute([$row['ann_id']]);
            $ireact = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if the reaction type is 'heart'
            if ($ireact && $ireact['reaction_type'] == 'heart') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/564x/f0/1b/91/f01b919c68c353f95d58b174761e5df5.jpg" class="img-fluid rounded-circle">
                      </a>';
            }elseif ($ireact && $ireact['reaction_type'] == 'like') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/564x/dc/12/46/dc124679726a20dc2cad0aaefdfdb312.jpg" class="img-fluid rounded-circle">
                      </a>';
            }elseif ($ireact && $ireact['reaction_type'] == 'love') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/564x/1e/b9/ab/1eb9abce88c9859c08e70330ef8495dc.jpg" class="img-fluid rounded-circle">
                      </a>';
            }elseif ($ireact && $ireact['reaction_type'] == 'eey') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/564x/cc/12/e0/cc12e02e7eed4491de74e05ea8a019a5.jpg" class="img-fluid rounded-circle">
                      </a>';
            }elseif ($ireact && $ireact['reaction_type'] == 'cry') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/736x/7f/3f/f7/7f3ff7ab44c80e30adefdf6b16c3910d.jpg" class="img-fluid rounded-circle">
                      </a>';
            }elseif ($ireact && $ireact['reaction_type'] == 'haha') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/564x/d5/8a/76/d58a766054d451198a197c3c6f127b2e.jpg" class="img-fluid rounded-circle">
                      </a>';
            }elseif ($ireact && $ireact['reaction_type'] == 'money') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/564x/ee/c6/a1/eec6a14275d6dd51f0592276d74fc35b.jpg" class="img-fluid rounded-circle">
                      </a>';
            }elseif ($ireact && $ireact['reaction_type'] == 'angry') {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <img src="https://i.pinimg.com/564x/0e/b2/75/0eb275a0b969571ca235168b176949ed.jpg class="img-fluid rounded-circle">
                      </a>';
            } else {
                echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                        <i class="ti-face-smile"></i>
                      </a>';
            }

             echo '<input type="hidden" name="post-id" value="' .htmlspecialchars($row['ann_id']). '" />
            <div class="reaction-options">
                <div name="reaction" class="reaction" data-reaction="like"><img width="50" height="50" src="https://i.pinimg.com/originals/fb/0e/29/fb0e291a63c613670dafb8bd2f75cc70.gif"></div>
                <div name="reaction" class="reaction" data-reaction="eey"><img width="50" height="60" src="https://i.pinimg.com/originals/58/91/52/58915204d17860c24d4c02be7425a830.gif"></div>
                <div name="reaction" class="reaction" data-reaction="heart"><img width="50" height="50" src="https://i.pinimg.com/originals/9c/97/2b/9c972b76ac2edb9baccb38292b9a3d11.gif"></div>
                <div name="reaction" class="reaction" data-reaction="love"><img class="img" width="50" height="50" src="https://media1.tenor.com/m/63nE7vC84pIAAAAd/care-discord.gif"></div>
                <div name="reaction" class="reaction" data-reaction="cry"><img width="50" height="50" src="https://i.pinimg.com/originals/d9/98/d1/d998d123da2480eb9fa1baded88830e1.gif"></div>
                <div name="reaction" class="reaction" data-reaction="haha"><img width="50" height="50" src="https://i.pinimg.com/originals/cd/96/83/cd9683d1984b3d7fbc210417d41d0f3c.gif"></div>
                <div name="reaction" class="reaction" data-reaction="money"><img width="50" height="50" src="https://i.pinimg.com/originals/18/08/0c/18080c89cbecb7ac434bfcd201e5ae5a.gif"></div>
                <div name="reaction" class="reaction" data-reaction="angry"><img width="50" height="50" src="https://i.pinimg.com/originals/61/50/bd/6150bd0fd8198bd2bc50d87f36a7148a.gif"></div>
            </div>
            </div>
            </li>';
            $stmt = $port_db->prepare("
                SELECT reaction_type 
                FROM tbl_reaction 
                WHERE post_id = ?
                AND reaction_by <> '045-2022-013'
                GROUP BY reaction_type
            ");
            $stmt->execute([$row['ann_id']]);
            $reactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($reactions as $react) {
                if ($react['reaction_type'] == 'like') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/564x/dc/12/46/dc124679726a20dc2cad0aaefdfdb312.jpg" class="img-fluid rounded-circle"></a></li>';
                }
                if ($react['reaction_type'] == 'heart') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/564x/f0/1b/91/f01b919c68c353f95d58b174761e5df5.jpg" class="img-fluid rounded-circle"></a></li>';
                }
                if ($react['reaction_type'] == 'eey') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/564x/cc/12/e0/cc12e02e7eed4491de74e05ea8a019a5.jpg" class="img-fluid rounded-circle"></a></li>';
                }
                if ($react['reaction_type'] == 'love') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/564x/1e/b9/ab/1eb9abce88c9859c08e70330ef8495dc.jpg" class="img-fluid rounded-circle"></a></li>';
                }
                if ($react['reaction_type'] == 'cry') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/736x/7f/3f/f7/7f3ff7ab44c80e30adefdf6b16c3910d.jpg" class="img-fluid rounded-circle"></a></li>';
                }
                if ($react['reaction_type'] == 'haha') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/564x/d5/8a/76/d58a766054d451198a197c3c6f127b2e.jpg" class="img-fluid rounded-circle"></a></li>';
                }
                if ($react['reaction_type'] == 'money') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/564x/ee/c6/a1/eec6a14275d6dd51f0592276d74fc35b.jpg" class="img-fluid rounded-circle"></a></li>';
                }
                if ($react['reaction_type'] == 'angry') {
                    echo '<li><a href="#"><img src="https://i.pinimg.com/564x/0e/b2/75/0eb275a0b969571ca235168b176949ed.jpg" class="img-fluid rounded-circle"></a></li>';
                }
            }


            if ($reaction !== false && isset($reaction['reaction_count'])) {
                echo '<li><a><span>' . htmlspecialchars($reaction['reaction_count']) . '</span></a></li>';
            } else {
                echo '<li><a><span></span></a></li>';
            }
            echo '</ul>';
            echo '<ul class="float-right">';
            
            if ($cm !== false && isset($cm['comment_count'])) {
                echo '<li><a style="cursor: pointer;" data-toggle="modal" data-target="#comment-Modal' . htmlspecialchars($cm['com_post_id']) . '"><span>' . htmlspecialchars($cm['comment_count']) . ' <i class="ti-comment"></i></span></a></li>';
            } else {
                echo '<li><a><span></span></a></li>';
            }
             echo '</ul>';
            echo '</div>';
            
           $stmt = $port_db->prepare("
                SELECT 
                  *
                FROM
                  tbl_post_comment a
                LEFT JOIN tbl201_basicinfo b
                ON b.`bi_empno` = a.`com_post_by`
                WHERE a.`com_post_by` = ?
                AND a.`com_post_id` = ?");
            $stmt->execute([$user_id, $row['ann_id']]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Loop through comments if available
            if (!empty($comments)) {
                foreach ($comments as $c) {
                    // Existing comment display code...
                    echo '<div class="cardbox-base-comment">';
                    echo '<div class="media m-1">';
                    echo '<div class="d-flex mr-1" style="margin-left: 20px;">';
                    echo '<a href=""><img class="img-fluid rounded-circle" src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/' . htmlspecialchars($c['bi_empno']) . '.JPG" alt="User"></a>';
                    echo '</div>';
                    echo '<div class="media-body">';
                    echo '<p class="m-0">' . htmlspecialchars($c['bi_empfname']) . ' ' . htmlspecialchars($c['bi_emplname']) . '</p>';
                    echo '<small><span><i class="icon ion-md-pin"></i> ' . htmlspecialchars($c['com_content']) . '</span></small>';
                    echo '<div class="comment-reply"><small><a>12m </a></small> <small><a style="cursor: pointer;">Reply</a></small></div>';
                    echo '</div>'; // Close media-body
                    echo '</div>'; // Close media
                    echo '</div>'; // Close cardbox-base-comment
                }
            }

            // Add new comment input section
            echo '<div class="cardbox-base-comment">';
            echo '<div class="media m-1">';
            echo '<div class="d-flex mr-1" style="margin-left: 20px;">';
            echo '<a href=""><img class="img-fluid rounded-circle" src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/' . $user_id . '.JPG" alt="User"></a>';
            echo '</div>';
            echo '<div class="media-body" id="comment">';
            echo '<div class="textarea-wrapper">';
            echo '<input type="text" placeholder="Write a comment..." id="input-default" class="emojiable-option"></input>';
            echo '<i class="ti-face-smile icon emoji-icon"></i>';
            echo '</div>'; // Close textarea-wrapper
            echo '<img src="assets/img/send_icon.png" height="30" width="30"/>';
            echo '</div>'; // Close media-body
            echo '</div>'; // Close media
            echo '</div>'; // Close cardbox-base-comment
            // Add new comment input section
            echo '</div>'; // Close cardbox
            echo '</section>'; // Close profile-feed

            echo '<div class="modal fade" id="comment-Modal' . htmlspecialchars($row['ann_id']) . '" tabindex="-1" role="dialog" style="height:100vh;overflow:hidden;">
                    <div class="modal-dialog modal-lg" role="document"style="margin-top:0px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="margin-left: 300px !important;color:black;">'. htmlspecialchars($row['bi_empfname']) . ' '. htmlspecialchars($row['bi_emplname']).' Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times-circle"style="font-size:24px;"></i></span>
                                </button>
                            </div>
                            <div class="modal-body" id="post-modalbody" style="height:480px;overflow:auto;">';
                                // Cardbox Item
                                echo '<div class="cardbox-item">';
                                if(strpos($row['ann_content'], '<figure') !== false){

                                    $imagePattern = '/<img\s+[^>]*src=["\']([^"\']+)["\']/i';

                                    // Match image sources
                                    preg_match_all($imagePattern, $row['ann_content'], $imageMatches);
                                    $sources = $imageMatches[1];

                                    foreach ($sources as $imgv) {
                                        echo '<img class="img-fluid" style="max-height: 500px !important;cursor: pointer;" src="assets/announcement/' . htmlspecialchars($imgv) . '">';
                                    }

                                }else if(strpos($row['ann_content'], '<figure') !== false){
                                    echo str_replace('../announcement', 'https://teamtngc.com/hris2/pages/announcement', $row['ann_content']);
                                }else{
                                    echo '<img class="img-fluid" style="max-height: 500px !important;cursor: pointer;" src="https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($row['ann_content']) . '">';
                                }
                                // echo "".$row['ann_content']."";
                                echo '</div>'; // Close cardbox-item
                                // Cardbox Base
                                echo '<div class="cardbox-base">';
                                echo '<ul>';
                                echo '<li>';
                                echo '<div class="reaction-container">';
                                $stmt = $port_db->prepare("
                                    SELECT reaction_type FROM tbl_reaction 
                                    WHERE reaction_by = '045-2022-013'
                                    AND post_id = ?
                                ");
                                $stmt->execute([$row['ann_id']]);
                                $ireact = $stmt->fetch(PDO::FETCH_ASSOC);
                                
                                // Check if the reaction type is 'heart'
                                if ($ireact && $ireact['reaction_type'] == 'heart') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/564x/f0/1b/91/f01b919c68c353f95d58b174761e5df5.jpg" class="img-fluid rounded-circle">
                                          </a>';
                                }elseif ($ireact && $ireact['reaction_type'] == 'like') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/564x/dc/12/46/dc124679726a20dc2cad0aaefdfdb312.jpg" class="img-fluid rounded-circle">
                                          </a>';
                                }elseif ($ireact && $ireact['reaction_type'] == 'love') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/564x/1e/b9/ab/1eb9abce88c9859c08e70330ef8495dc.jpg" class="img-fluid rounded-circle">
                                          </a>';
                                }elseif ($ireact && $ireact['reaction_type'] == 'eey') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/564x/cc/12/e0/cc12e02e7eed4491de74e05ea8a019a5.jpg" class="img-fluid rounded-circle">
                                          </a>';
                                }elseif ($ireact && $ireact['reaction_type'] == 'cry') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/736x/7f/3f/f7/7f3ff7ab44c80e30adefdf6b16c3910d.jpg" class="img-fluid rounded-circle">
                                          </a>';
                                }elseif ($ireact && $ireact['reaction_type'] == 'haha') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/564x/d5/8a/76/d58a766054d451198a197c3c6f127b2e.jpg" class="img-fluid rounded-circle">
                                          </a>';
                                }elseif ($ireact && $ireact['reaction_type'] == 'money') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/564x/ee/c6/a1/eec6a14275d6dd51f0592276d74fc35b.jpg" class="img-fluid rounded-circle">
                                          </a>';
                                }elseif ($ireact && $ireact['reaction_type'] == 'angry') {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <img src="https://i.pinimg.com/564x/0e/b2/75/0eb275a0b969571ca235168b176949ed.jpg class="img-fluid rounded-circle">
                                          </a>';
                                } else {
                                    echo '<a id="react-button-' . htmlspecialchars($row['ann_id']) . '" class="reaction-trigger">
                                            <i class="ti-face-smile"></i>
                                          </a>';
                                }

                                 echo '<input type="hidden" name="post-id" value="' .htmlspecialchars($row['ann_id']). '" />
                                <div class="reaction-options">
                                    <div name="reaction" class="reaction" data-reaction="like"><img width="50" height="50" src="https://i.pinimg.com/originals/fb/0e/29/fb0e291a63c613670dafb8bd2f75cc70.gif"></div>
                                    <div name="reaction" class="reaction" data-reaction="eey"><img width="50" height="60" src="https://i.pinimg.com/originals/58/91/52/58915204d17860c24d4c02be7425a830.gif"></div>
                                    <div name="reaction" class="reaction" data-reaction="heart"><img width="50" height="50" src="https://i.pinimg.com/originals/9c/97/2b/9c972b76ac2edb9baccb38292b9a3d11.gif"></div>
                                    <div name="reaction" class="reaction" data-reaction="love"><img class="img" width="50" height="50" src="https://media1.tenor.com/m/63nE7vC84pIAAAAd/care-discord.gif"></div>
                                    <div name="reaction" class="reaction" data-reaction="cry"><img width="50" height="50" src="https://i.pinimg.com/originals/d9/98/d1/d998d123da2480eb9fa1baded88830e1.gif"></div>
                                    <div name="reaction" class="reaction" data-reaction="haha"><img width="50" height="50" src="https://i.pinimg.com/originals/cd/96/83/cd9683d1984b3d7fbc210417d41d0f3c.gif"></div>
                                    <div name="reaction" class="reaction" data-reaction="money"><img width="50" height="50" src="https://i.pinimg.com/originals/18/08/0c/18080c89cbecb7ac434bfcd201e5ae5a.gif"></div>
                                    <div name="reaction" class="reaction" data-reaction="angry"><img width="50" height="50" src="https://i.pinimg.com/originals/61/50/bd/6150bd0fd8198bd2bc50d87f36a7148a.gif"></div>
                                </div>
                                </div>
                                </li>';
                                $stmt = $port_db->prepare("
                                    SELECT reaction_type 
                                    FROM tbl_reaction 
                                    WHERE post_id = ?
                                    AND reaction_by <> '045-2022-013'
                                    GROUP BY reaction_type
                                ");
                                $stmt->execute([$row['ann_id']]);
                                $reactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($reactions as $react) {
                                    if ($react['reaction_type'] == 'like') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/564x/dc/12/46/dc124679726a20dc2cad0aaefdfdb312.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                    if ($react['reaction_type'] == 'heart') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/564x/f0/1b/91/f01b919c68c353f95d58b174761e5df5.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                    if ($react['reaction_type'] == 'eey') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/564x/cc/12/e0/cc12e02e7eed4491de74e05ea8a019a5.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                    if ($react['reaction_type'] == 'love') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/564x/1e/b9/ab/1eb9abce88c9859c08e70330ef8495dc.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                    if ($react['reaction_type'] == 'cry') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/736x/7f/3f/f7/7f3ff7ab44c80e30adefdf6b16c3910d.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                    if ($react['reaction_type'] == 'haha') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/564x/d5/8a/76/d58a766054d451198a197c3c6f127b2e.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                    if ($react['reaction_type'] == 'money') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/564x/ee/c6/a1/eec6a14275d6dd51f0592276d74fc35b.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                    if ($react['reaction_type'] == 'angry') {
                                        echo '<li><a href="#"><img src="https://i.pinimg.com/564x/0e/b2/75/0eb275a0b969571ca235168b176949ed.jpg" class="img-fluid rounded-circle"></a></li>';
                                    }
                                }


                                if ($reaction !== false && isset($reaction['reaction_count'])) {
                                    echo '<li><a><span>' . htmlspecialchars($reaction['reaction_count']) . '</span></a></li>';
                                } else {
                                    echo '<li><a><span></span></a></li>';
                                }
                                echo '</ul>';
                                echo '<ul class="float-right">';
                                
                                if ($cm !== false && isset($cm['comment_count'])) {
                                    echo '<li><a style="cursor: pointer;" data-toggle="modal" data-target="#comment-Modal' . htmlspecialchars($cm['com_post_id']) . '"><span>' . htmlspecialchars($cm['comment_count']) . ' <i class="ti-comment"></i></span></a></li>';
                                } else {
                                    echo '<li><a><span></span></a></li>';
                                }
                                 echo '</ul>';
                                echo '</div>';
                                
                               $stmt = $port_db->prepare("
                                    SELECT 
                                      *
                                    FROM
                                      tbl_post_comment a
                                    LEFT JOIN tbl201_basicinfo b
                                    ON b.`bi_empno` = a.`com_post_by`
                                    WHERE a.`com_post_by` = ?
                                    AND a.`com_post_id` = ?");
                                $stmt->execute([$user_id, $row['ann_id']]);
                                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                // Loop through comments if available
                                if (!empty($comments)) {
                                    foreach ($comments as $c) {
                                        // Existing comment display code...
                                        echo '<div class="cardbox-base-comment">';
                                        echo '<div class="media m-1">';
                                        echo '<div class="d-flex mr-1" style="margin-left: 20px;">';
                                        echo '<a href=""><img class="img-fluid rounded-circle" src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/' . htmlspecialchars($c['bi_empno']) . '.JPG" alt="User"></a>';
                                        echo '</div>';
                                        echo '<div class="media-body">';
                                        echo '<p class="m-0">' . htmlspecialchars($c['bi_empfname']) . ' ' . htmlspecialchars($c['bi_emplname']) . '</p>';
                                        echo '<small><span><i class="icon ion-md-pin"></i> ' . htmlspecialchars($c['com_content']) . '</span></small>';
                                        echo '<div class="comment-reply"><small><a>12m </a></small> <small><a style="cursor: pointer;">Reply</a></small></div>';
                                        echo '</div>'; // Close media-body
                                        echo '</div>'; // Close media
                                        echo '</div>'; // Close cardbox-base-comment
                                    }
                                }

                         echo '</div>';
                         echo '<div class="modal-footer">';
                                // Add new comment input section
                                echo '<div class="cardbox-base-comment" style="width:100%;">';
                                echo '<div class="media m-1">';
                                echo '<div class="d-flex mr-1" style="margin-left: 20px;">';
                                echo '<a href=""><img class="img-fluid rounded-circle" src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/' . $user_id . '.JPG" alt="User"></a>';
                                echo '</div>';
                                echo '<div class="media-body" id="comment">';
                                echo '<div class="textarea-wrapper">';
                                echo '<input type="text" placeholder="Write a comment..." id="input-default" class="emojiable-option"></input>';
                                echo '<i class="ti-face-smile icon emoji-icon"></i>';
                                echo '</div>'; // Close textarea-wrapper
                                echo '<img src="assets/img/send_icon.png" height="30" width="30"/>';
                                echo '</div>'; // Close media-body
                                echo '</div>'; // Close media
                                echo '</div>'; // Close cardbox-base-comment
                                // Add new comment input section
                        echo '</div>';
                     echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No data available.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
