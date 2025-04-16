<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
	<div class="page-body">
		<div class="row" style="display: flex;">
			<div class="col-md-2 my-div">
				<?php if (!empty($hotside)) include_once($hotside); ?>
				<div style="height: 50px;padding: 10px;">
					<span>TNGC | 2025</span>
				</div>
			</div>
			<?php
			require_once($pcf_root."/actions/get_pcf.php");

			$date = date("Y-m-d");
			$Year = date("Y");
			$Month = date("m");
			$Day = date("d");
			$yearMonth = date("Y-m");
			$repl_list = PCF::GetReplenishList($user_id,$outlet);
			$coh = PCF::GetCashOnHand($user_id,$outlet);
            $pcfacc = PCF::GetPCFAcc($user_id);
            $cashcount = PCF::GetCashCount($user_id,$outlet);
			?>
			<div id="right-sided" style="width: 76%; background-color: white;padding: 20px;height: 87vh;margin-top: 5px;margin-bottom: 5px;overflow: auto;">
					<div class="card-block">
            <div class="card">
                <div class="card-header" style="display: flex;justify-content: space-between;">
                    <h5>Count your Cash today!</h5>
                    <div class="col-sm-3">
                       <form method="GET">
                          <select class="form-control" id="unit" name="unit" onchange="this.form.submit()"> 
                            <?php
                              if (!empty($pcfacc)) {
                                foreach ($pcfacc as $pa) {
                                  $selected = ($_GET['unit'] ?? '') == $pa['outlet_dept'] ? 'selected' : '';
                                  echo '<option value="' . $pa['outlet_dept'] . '" ' . $selected . '>' . $pa['outlet_dept'] . '</option>';
                                }
                              }
                            ?>
                          </select>
                        </form>

                    </div>
                    <div class="col-sm-3">
                       	<input type="date" id="dateInput" name="" class="form-control form-control-normal date-input" value="">
                    </div>
                </div>
                <div class="card-block">
                    <form style="padding: 20px;">

                        <?php if (!empty($coh)) { foreach ($coh as $c) { ?>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">Cash on Hand</label>
                        	<div class="col-sm-3">
                        			<input type="text" id="cashonhand" name="_coh" class="form-control form-control-rtl coh-cash" value="<?= number_format($c['repl_cash_on_hand'],2) ?>" readonly>
                        	</div>
                        	<label class="col-sm-2 col-form-label">End PCF Balance</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="endpcf" name="pcf_bal" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">1,000</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_1000" name="_1000num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label">Subtotal</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_1000total" name="_1000sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">500</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_500" name="_500num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_500total" name="_500sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">200</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_200" name="_200num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_200total" name="_200sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">100</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_100" name="_100num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_100total" name="_100sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">50</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_50" name="_50num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_50total" name="_50sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">20</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_20" name="_20num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_20total" name="_20sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">10</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_10" name="_10num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_10total" name="_10sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">5</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_5" name="_5num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_5total" name="_5sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">1</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_1" name="_1num" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="_1total" name="_1sum" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-form-label">loose coins</label>
                        	<div class="col-sm-3">
                        		<input type="text" id="lcoin" name="loosecoin" class="form-control" value="">
                        	</div>
                        	<label class="col-sm-2 col-form-label"></label>
                        	<div class="col-sm-3">
                        		<input type="text" id="lcoinTotal" name="Totalcoin" readonly class="form-control form-control-rtl" value="">
                        	</div>
                        </div>
                        <?php } }?>
                    </form>
                    <div style="display: flex;float: right;flex-wrap: wrap;gap: 10px;">
                    	<!-- <button type="button" class="btn btn-default waves-effect btn-mini" data-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-mini" id="saveCount">Save</button>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		let today = new Date().toISOString().split("T")[0];
		let dateinput = document.getElementById("dateInput");

		document.querySelectorAll(".date-input").forEach(function (input) {
			input.setAttribute("max", today);
		});

		dateinput.value = today;
		dateinput.min = today;
		dateinput.max = today;
	});
	const denominations = [1000, 500, 200, 100, 50, 20, 10, 5, 1];

	function calculateTotal() {
		let grandTotal = 0;

		denominations.forEach(denom => {
			const input = document.getElementById(`_${denom}`);
			const total = document.getElementById(`_${denom}total`);
			const quantity = parseInt(input.value) || 0;
			const subTotal = quantity * denom;
			total.value = subTotal.toLocaleString();
			grandTotal += subTotal;
		});

		const looseInput = document.getElementById('lcoin');
		const looseTotal = document.getElementById('lcoinTotal');
		const looseVal = parseFloat(looseInput.value) || 0;
		looseTotal.value = looseVal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

		grandTotal += looseVal;

		const endpcf = document.getElementById('endpcf');
		endpcf.value = grandTotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    // Compare with cash on hand
    const cohInput = document.getElementById('cashonhand');
    if (cohInput) {
    	const cohVal = parseFloat(cohInput.value.replace(/,/g, '')) || 0;
    	const endpcfVal = parseFloat(endpcf.value.replace(/,/g, '')) || 0;

    	if (cohVal === endpcfVal) {
    		endpcf.style.border = '2px solid green';
    	} else {
    		endpcf.style.border = '2px solid red';
    	}
    }
}

  // Attach input event listeners
  denominations.forEach(denom => {
  	document.getElementById(`_${denom}`).addEventListener('input', calculateTotal);
  });

  document.getElementById('lcoin').addEventListener('input', calculateTotal);
</script>