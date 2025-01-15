<?php
if (!empty($globe)) {
?>
<div class="card">
    <div class="card-header">
        <h5>GLOBE</h5>
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="multi-colum-dt" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">Company</th>
                        <th scope="col">Dept/Outlet</th>
                        <th scope="col">Custodian</th>
                        <th scope="col">ACC No</th>
                        <th scope="col">ACC Name</th>
                        <th scope="col">SIM No</th>
                        <th scope="col">SIM Serial No</th>
                        <th scope="col">SIM Type</th>
                        <th scope="col">Plan Type</th>
                        <th scope="col">Plan Features</th>
                        <th scope="col">Monthly Service Fee</th>
                        <th scope="col">Authorized By</th>
                        <th scope="col">QRPH</th>
                        <th scope="col">Merchant Desc</th>
                        <th scope="col">Model</th>
                        <th scope="col">IMEI 1</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($globe as $l) { ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?= htmlspecialchars($l['phone_custodiancompany'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_deptol'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['Custodian'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_accountno'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_accountname'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_sim'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_sim_serial'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_simtype'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_plan'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_planfeatures'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_total_msf'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_authorized'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td><?= htmlspecialchars($l['phone_model'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($l['phone_imei1'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
}
?>
