<?php
		$test_definition=['','<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- LINGUISTIC</b></span></span></h1>',
		'<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- LOGICAL/MATHEMATICAL</b></span></span></h1>',
		'<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- VISUAL/SPATIAL</b></span></span></h1>',
		'<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- BODY KINESTHETIC</b></span></span></h1>',
		'<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- MUSICAL/ARTISTIC</b></span></span></h1>',
		'<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- INTERPERSONAL</b></span></span></h1>',
		'<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- INTRAPERSONAL</b></span></span></h1>',
		'<h1><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><b>- NATURALIST</b></span></span></h1>'];
		if($test_score!=""){ ?>
			<!-- <div class="container-fluid"> -->
				<div class="panel panel-primary">
					<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#pers-res4" aria-expanded="true" style="cursor: pointer;">
						<label>MULTIPLE INTELLIGENCE QUOTIENT Result</label>
					</div>
					<div id="pers-res4" class="panel-collapse collapse" aria-expanded="true">
						<div class="panel-body">
							<div class="container-fluid">
							<?php
									foreach ($test_score as $ts_key) {
										echo $test_definition[$ts_key];
									}
							?>
							</div>
	                    </div>
					</div>
				</div>
			<!-- </div> -->
<?php	}
?>