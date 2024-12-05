<?php
		if($test_score!=""){ ?>
			<!-- <div class="container-fluid"> -->
				<div class="panel panel-primary">
					<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#pers-res6" aria-expanded="true" style="cursor: pointer;">
						<label>VAK Result</label>
					</div>
					<div id="pers-res6" class="panel-collapse collapse" aria-expanded="true">
						<div class="panel-body">
							<div class="container-fluid">
							<?php
									foreach ($test_score as $ts_key) {
										echo "<p><b>-".$ts_key."</b><p>";
									}
							?>
							</div>
	                    </div>
					</div>
				</div>
			<!-- </div> -->
<?php	}
?>