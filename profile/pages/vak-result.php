<?php
		if($test_score!=""){ ?>
			<div class="col-lg-12 col-xl-12">   
					<div class="tab-content tabs card-block" style="height: 380px; overflow:auto;">
						<div class="panel-body">
							<div class="container-fluid" style="margin-top: 20px;">
							<?php
									foreach ($test_score as $ts_key) {
										echo "<p><b>-".$ts_key."</b><p>";
									}
							?>
							</div>
	                    </div>
					</div>
			</div>
<?php	}
?>
