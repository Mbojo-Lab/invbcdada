<?php
require_once "../models/abspath.php";
require_once "pdocon.php";
require_once "function.php";

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 25;
$offset = ($page-1)*$rows;
$result = array();

$q = "SELECT *,CONCAT(LEFT(h.CAR,3),'.',RIGHT(h.CAR,3)) AS FCAR,CONCAT(LEFT(NoDaf,3),'.',RIGHT(NoDaf,3)) AS FNoDaf,DATE_FORMAT(TgDaf,'%d/%m/%Y') AS tgl_daf
	  FROM header h 
	  INNER JOIN jenis_dok jd ON jd.KdJnsDok=h.DokKdBc 
	  WHERE (h.DokKdBc IN ('1','8','5') OR (h.DokKdBc = '6' AND h.ket = 'in')) AND NoDaf = '' ";

$q .= "ORDER BY h.DokKdBc";

$runtot=$pdo->query($q);
$rstot=$runtot->fetchAll(PDO::FETCH_ASSOC);

$q .= " LIMIT $offset,$rows";
$run=$pdo->query($q);
$rs=$run->fetchAll(PDO::FETCH_ASSOC);

$result["total"] = count($rstot);
$result["rows"] = $rs;

echo json_encode($result);
?>