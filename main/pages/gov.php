<div id="memo"> 
    <span><a href="#"><h6>Government</h6></a></span>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="m_widget4_tab1_content">
                    <div class="m-widget4 m-widget4--progress">
                        <?php
                             if (!empty($ongoingleave)) {
                                  foreach ($ongoingleave as $ol) {
                        ?>
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--pic">
                                <img src="assets/image/img/<?=$ol['la_empno'].'.jpg'?>" alt="">
                            </div>
                            <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    <strong ><?=$ol['bi_empfname'].' '.$ol['bi_emplname']?></strong>
                                </span>
                                <br>
                                <span class="m-widget4__sub">
                                    <strong class="text-muted"><?=$ol['jrec_department']?></strong>
                                </span>
                            </div>
                            <div class="m-widget4__progress">
                                <div class="m-widget4__progress-wrapper">
                                    <span class="m-widget17__progress-number">
                                       <strong>start: <?= date("F j, Y", strtotime($ol['la_start'])) ?></strong>
                                    </span><br>
                                    <span class="m-widget17__progress-label">
                                       <strong>return: <?= date("F j, Y", strtotime($ol['la_return'])) ?></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="m-widget4__ext">
                                <label class="label label-inverse-danger"><?=$ol['la_type']?></label>
                            </div>
                        </div>
                        <?php }} ?>
                        <?php
                             if (!empty($leave)) {
                                  foreach ($leave as $lv) {
                        ?>
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--pic">
                                <img src="assets/image/img/<?=$lv['la_empno'].'.jpg'?>" alt="">
                            </div>
                            <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    <strong ><?=$lv['bi_empfname'].' '.$lv['bi_emplname']?></strong>
                                </span>
                                <br>
                                <span class="m-widget4__sub">
                                    <strong class="text-muted"><?=$lv['jrec_department']?></strong>
                                </span>
                            </div>
                            <div class="m-widget4__progress">
                                <div class="m-widget4__progress-wrapper">
                                    <span class="m-widget17__progress-number">
                                       <strong>start: <?= date("F j, Y", strtotime($lv['la_start'])) ?></strong>
                                    </span><br>
                                    <span class="m-widget17__progress-label">
                                       <strong>return: <?= date("F j, Y", strtotime($lv['la_return'])) ?></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="m-widget4__ext">
                                <label class="label label-inverse-danger"><?=$lv['la_type']?></label>
                            </div>
                        </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
</div>