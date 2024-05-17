<?php

$data = isset($_REQUEST["data"]) ? $_REQUEST["data"] : "";

if($data !== ""){

	$sel = explode("|", trim(urldecode($data)));
	$url = $sel[2];
	$board = $sel[1];
	$gb = $sel[0];

}else{

	exit;

};

$base = "http://www.hongik.ac.kr/front/boardlist.do?siteGubun=1&menuGubun=1&bbsConfigFK=";

include $_SERVER["DOCUMENT_ROOT"]."/Hongik_/_Inc/db_nnoc.php";

$query = "select no, board_ID, name_".$gb.", code FROM school ORDER BY no ASC";
$reslt = mysql_query($query, $connect);

$nos[0] = 0;
$bdid[0] = 121;
if($gb == "ko"){$bname[0] = "전체공지";}else if($gb == "en"){$bname[0] = "NOTICE";};
$codes[0] = "BNT";

$k = 1;
while($rows = mysql_fetch_array($reslt)) {

	$nos[$k] = $rows["no"];
	$bdid[$k] = $rows["board_ID"];
	$bname[$k] = $rows["name_".$gb];
	$codes[$k] = $rows["code"];
	++$k;

};

mysql_close($connect);

?>

<!DOCTYPE HTML>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<script type="text/javascript" src="http://www.hongik.ac.kr/js/resize.js"></script>
<style>
	html,body,table,tr,td, a, select {font-family:"Noto Sans KR","Malgun Gothic", "NanumGothic", "Nanum Gothic", 'Montserrat'; }
	a, font, td { font-size : 10pt; }
	a:link { color :  #585858; text-decoration : none; }
	a:hover { color : #585858; font-weight : bold; }
	a:active { color : #585858; text-decoration : underline; }
	a:visited { color : #585858; text-decoration : none; }
	select {
		color : #fff;
		background : #000000;
		border: 1px solid #ccc;
		font-size: 16px;
		height: 30px;
		width: 180px;
	}
</style>
<script>

	function select_togo(bdid){

		var ids = [];

<?php
for($i=0;$i < count($bdid);$i++){
	echo '		ids["'.$bdid[$i].'"] = "'.$bname[$i].'"'.";\n";
};
?>

		if(bdid != ""){
			var urlbase = "<?=$base?>";
			document.getElementById("mainFrm").src = urlbase + bdid;
			document.getElementById("btitle").innerHTML = ids[bdid];
		};
	};

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">

<table width="750" align=center border=0 cellspacing=0 cellpadding=0>
	<tr height=90>
		<td>
			<font id="btitle" style="font-size:18pt;font-weight:bold"><?=$board?></font>
		</td>
		<td align=right>
			<select onchange="javascript:select_togo(this.options[this.selectedIndex].value)" id="more">
				<option value="">전공별 게시판</option>
				<option value=""></option>
				<?php
				foreach($bname as $key=>$onse){
					echo '
				<option value="'.$bdid[$key].'">'.$onse.'</option>';
				};
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<iframe width="750" id="mainFrm" src="<?=$url?>" frameborder="0" scrolling="no" topmargin="0" leftmargin="0"></iframe>
		</td>
	</tr>
</table>

</body>
</html>
