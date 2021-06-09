<?php

$awal = $_POST['tglawal'];
$tgl_awal= date('Y-m-d', strtotime($awal));

$mindate_tglakhir = date('Y-m-d', strtotime('+1 days', strtotime($tgl_awal)));

echo $mindate_tglakhir;

?>