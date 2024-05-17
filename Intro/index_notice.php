<?php

$gb = isset($_REQUEST["gb"]) ? $_REQUEST["gb"] : "";
$meta = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';

if($gb !== "ko" && $gb !== "en"){
	echo $meta.'<center><br><br><br><br><hr><br><b>!한영 변수설정이 잘못되었습니다.</b> <br><br><hr><br><br><br>한국어는 <a href="?gb=ko">URL?gb=ko</a> <br><br>영문은 <a href="?gb=en">URL?gb=en</a>';
	exit;
};

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

$base = "http://www.hongik.ac.kr/front/boardlist.do?siteGubun=1&menuGubun=1&bbsConfigFK=";

$fl = [];

for($a=0; $a< count($bdid);$a++){

	$url = $base.$bdid[$a];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot/2.1 (+http://www.google.com/bot.html)");
	curl_setopt($ch, CURLOPT_REFERER, "http://crawl-66-249-73-".rand(2,254).".googlebot.com");
	$result = curl_exec($ch);
	curl_close($ch);

	$s = strpos($result, "<!-- List 시작 -->");
	$e = strpos($result, "<!-- List 끝 -->");
	$l = $e - $s;

	$lst = trim(substr($result, $s, $l+20));

	$dom = new DOMDocument;
	$dom->loadHTML($meta.$lst);
	$trs = $dom->getElementsByTagName("tr");

	$arr[$a] = [];
	foreach($trs as $key=>$tr){
		$tds = $tr->getElementsByTagName("td");
		$ct = $tds->length;

		if($ct == "6"){$dat = 4;}else{$dat = 3;};	// 글목록에 첨부파일 필드가 있는 게시판과 없는 게시판 구별

		$arr[$a][$key] = [
			trim(str_replace("&#xD;", "", strip_tags($tds->item(0)->c14n()))),	// 글번호
			trim(str_replace("&#xD;", "", strip_tags($tds->item(1)->c14n(), "<a>"))),	// a 링크걸린 제목
			$nos[$a],	// DB school 테이블의 no
			trim(str_replace(array("&#xD;","."), "", strip_tags($tds->item($dat)->c14n())))	// 날짜
		];

	};

	$fl = array_merge($fl, $arr[$a]);

};

foreach ($fl as $key => $row) {
	$date[$key] = $row[3]; // 날짜순
	$bdmn[$key] = $row[2]; // 메뉴에 나오는 순서 (DB school 테이블에 no 값 낮은 순)
	$bdno[$key] = $row[0]; // 글번호
}

## 최신글 정렬 순서 = 게시날짜 최신 순 > 게시판 메뉴순 > 글 번호 높은 순

array_multisort($date, SORT_DESC, $bdmn, SORT_ASC, $bdno, SORT_DESC, $fl);





## Intro 페이지 게시글 목록 html 태깅 시작

		## $range = 한번에 보여줄 목록 수
		$range = 3;

		for($i=0;$i< $range;$i++){

			$tit = str_replace("/viewcount.do?", "http://www.hongik.ac.kr/viewcount.do?", $fl[$i][1]);
			$hre = explode("\"", $tit);

			$data = urlencode($gb."|".$bname[$fl[$i][2]]."|".$hre[1]);
			$title = "<a href=\"#n\" onclick=\"window.open('../Notice/Notice_pop.php?data=".$data."','board','width=800,height=900,scrollbars=yes,resizable=yes')\"><span class=\"itit\">".strip_tags($tit)."</span></a>";

			$major = $bname[$fl[$i][2]];
			$time = substr($fl[$i][3],0,4).".".substr($fl[$i][3],4,2).".".substr($fl[$i][3],6,2);


			echo '
						<li>
							'.$title.'
						</li>';

		};


?>
