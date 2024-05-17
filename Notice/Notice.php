<?php 

include_once ($_SERVER["DOCUMENT_ROOT"].'/Hongik_/_Inc/subHead.php');

$meta = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';

if($gb !== "ko" && $gb !== "en"){
	echo $meta.'<center><br><br><br><br><hr><br><b>!한영 변수설정이 잘못되었습니다.</b> <br><br><hr><br><br><br>한국어는 <a href="?gb=ko&code=NOT">URL?gb=ko&code=NOT</a> <br><br>영문은 <a href="?gb=en&code=NOT">URL?gb=en&code=NOT</a>';
	exit;
};

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





?>

<!--// page start -->

<script type="text/javascript">

	function select_togo(sel){
		if(sel != ""){
			window.open('Notice_pop.php?data=' + sel,'board','width=800,height=900,scrollbars=yes,resizable=yes');
		};
	};

</script>

	<div class="notice-top">
		<h2><span class="c-01">NEWS</span> <span class="c-02">&</span> <span class="c-03">EVENT</span></h2>
	</div>
	<!--div class="notice-banner">
		<ul>
			<li>
				<a>
					<img src="../_Img/Content/banner-01.png" alt=""/>
					<span class="btxt">International <br/>Art Fair</span>
					<span class="stxt">3-8 Aug 2017</span>
				</a>
			</li>
			<li>
				<a>
					<img src="../_Img/Content/banner-02.png" alt=""/>
					<span class="btxt">International <br/>Art Fair</span>
					<span class="stxt">3-8 Aug 2017</span>
				</a>
			</li>
		</ul>
	</div-->
	<!-- s : notice-wrap -->
	<div class="notice-wrap">
		<div class="notice-search">
			<h3>NOTICES</h3>
			<div class="search">

				<?php
				echo "				<a href=\"#n\" onclick=\"window.open('Notice_pop.php?data=".urlencode($gb."|".$bname[0]."|".$base.$bdid[0])."','board','width=800,height=900,scrollbars=yes,resizable=yes')\" class=\"all-btn\"><span>전체공지</span></a>\n";
				?>

				<p class="select-box">

<!-- 풀다운 게시판 목록 start -->

					<select onchange="javascript:select_togo(this.options[this.selectedIndex].value)">
						<option value="">전공별 게시판</option>
						<option value=""></option>
						<?php
						foreach($bname as $key=>$onse){

							if($key > 0){
								$value = urlencode($gb."|".$onse."|".$base.$bdid[$key]);
								echo '						<option value="'.$value.'">'.$onse.'</option>'."\n";
							};

						};
						?>
					</select>

<!-- 풀다운 게시판 목록 end -->

				</p>
			</div>
		</div>
		<div class="notice-con">
			<ul>

<!-- 뽑아온 글 목록 html 태깅 start -->

				<?php

				## $range = 한번에 보여줄 목록 수
				$range = 10;

				for($i=0;$i< $range;$i++){

					$tit = str_replace("/viewcount.do?", "http://www.hongik.ac.kr/viewcount.do?", $fl[$i][1]);
					$hre = explode("\"", $tit);

					$data = urlencode($gb."|".$bname[$fl[$i][2]]."|".$hre[1]);

					$time = substr($fl[$i][3],0,4).".".substr($fl[$i][3],4,2).".".substr($fl[$i][3],6,2);
					$major = $bname[$fl[$i][2]];

					echo "
				<li>					
					<a href=\"#n\" onclick=\"window.open('Notice_pop.php?data=".$data."','board','width=800,height=900,scrollbars=yes,resizable=yes')\">
						<span class=\"tit\">".strip_tags($tit)."</span>
						<span class=\"date\">".$time."</span>
					</a>
				</li>";

				};

				?>

<!-- 뽑아온 글 목록 html 태깅 end -->

			</ul>
		</div>
	</div>
	<!-- e : notice-wrap -->
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Hongik_/_Inc/subTail.php');?>