<?php

$gb = isset($_REQUEST["gb"]) ? $_REQUEST["gb"] : "";
$no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : "";

if($no == "") exit;

## 네 종류 타입의 xml 데이타를 html 로 변환
function tagin($rawdat){

	//$rawdat = "<root>".str_replace(array("&","\"","'","<",">"), array("&amp;","&quot;","&apos;","&lt;","&gt;"), $rawdat)."</root>";
	$rawdat = "<root>".str_replace(array("&","\"","'"), array("&amp;","&quot;","&apos;"), $rawdat)."</root>";

	$xml=simplexml_load_string($rawdat);

	$node = $xml->children();
	$num = count($node);

	### IMGTXT
	if($num == 0){

		$its = explode("\n\n", trim($xml));
		return $its;

	}else{

		$i = 0;

		foreach($node as $child){

			$chi = trim($child);

			### divtxt
			if($child->getName() == "divtxt"){

				echo "			<div class=\"txt\">\n					".$chi."\n			</div>\n";

			### ulhistory
			}else if($child->getName() == "ulhistory"){

				$lis = explode("\n", $chi);
				echo "			<ul class=\"history\">\n";
				foreach($lis as $li){
					$yr = explode(" ", $li);
					$year = "<span class=\"year\">".$yr[0]."</span>";
					$dtl = " ".join(" ",array_slice($yr, 1));
					echo "				<li>".$year.$dtl."</li>\n";
				}
				echo "			</ul>\n";

			### ul
			}else if($child->getName() == "ul"){

				$lis = explode("\n", $chi);
				echo "			<ul>\n";
				foreach($lis as $li){
					echo "				<li>".$li."</li>\n";
				}
				echo "			</ul>\n";

			};

			if(++$i !== $num){
				echo "			<div class=\"u-line\"></div>\n";
		  };

		};

	};

};



## ajax가 GET방식으로 호출 -> $no 가 넘어오면 DB에 접속하여 교수정보를 배열로 저장

include $_SERVER["DOCUMENT_ROOT"]."/Hongik_/_Inc/db_nnoc.php";

$query = "select * FROM professor WHERE no='".$no."'";
$reslt = mysql_query($query, $connect);
$rows = mysql_fetch_array($reslt);

$code					=	 trim($rows["code"]);
$name_ko			=	 trim($rows["name_ko"]);
$name_en			=	 trim($rows["name_en"]);
$chief				=	 trim($rows["chief"]);
if(strlen($chief) < 3){$chief = "";};
$tel					=	 trim($rows["tel"]);
$email				=	 trim($rows["email"]);
$website			=	 trim($rows["website"]);
$sns					=	 trim($rows["sns"]);

$IMGTXT				=	 trim($rows["IMGTXT"]);
if($IMGTXT == ""){$IMGTXT_off_s = "<!--";$IMGTXT_off_e = "-->";};

$isAlive			=	 trim($rows["isAlive"]);



## 지정한 폴더에 있는 파일이름 긁어와서 배열로 만들고 처리

$skey = $code."_".$name_en;

$dir = "../_Img/Profes";
$prof = $dir."/"."if_no_profile_img.jpg";

$lst = scandir($dir);

$k = 0;

for($i=0;$i < count($lst);$i++){

	if(strpos($lst[$i], $skey) > -1){

		if(strpos($lst[$i], "profile") > -1){

			$prof = $dir."/".$lst[$i];

		}else{

			$imgs[$k] = $dir."/".$lst[$i];
			++$k;

		};

	};

};

$profile = '<img src="'.$prof.'" alt=""/>';

if(count($imgs) > 0){

	$its = tagin($IMGTXT);

	for($i=0;$i < count($imgs);$i++){

		$sliderfor .= '						<div class="item"><a href="'.$imgs[$i].'" target="_blank"><img src="'.$imgs[$i].'"/><span>'.$its[$i].'</span></a></div>'."\n";
		$slidernav .= '				<div class="item"><img src="'.$imgs[$i].'"/></div>'."\n";

	};

}else{

	$WORKSIMGS_off_s = "<!--";
	$WORKSIMGS_off_e = "-->";
	$sliderfor = "";
	$slidernav = "";

};




## $code로 school 테이블에 있는 학과 영문이름 가져오기

$query2 = "select name_en FROM school WHERE code='".$code."'";
$reslt2 = mysql_query($query2, $connect);
$rows2 = mysql_fetch_array($reslt2);

$name_en2 = trim($rows2["name_en"]);
$nar = str_split(str_replace("∙","^",$name_en2));
for($i=0;$i < count($nar);$i++){
	$name_en_i .= "<i>".str_replace("^","∙",$nar[$i])."</i>\n				";
};

?>

	<a href="#" class="layer-close"><span class="blind">레이어닫기</span></a>

	<div class="profile-top">
		<h2>
			<span class="fl">
				<?=$name_en_i?>

				<i>&nbsp;</i>
				<i>D</i>
				<i>E</i>
				<i>S</i>
				<i>I</i>
				<i>G</i>
				<i>N</i>
			</span>
		</h2>
	</div>

	<div class="profile-content">

		<div class="profile-detail">
			<p class="img"><?=$profile?></p>
			<p class="btxt"><span><?=$name_ko?></span><!--(<?=$name_en?>)--></p>
			<p class="stxt"><?=$chief?> 교수</p>
			<ul>
				<li class="num"><?=$tel?>&nbsp;</li>
				<li class="email"><?=$email?>&nbsp;</li>
				<li class="site"><?=$website?>&nbsp;</li>
			</ul>
			<a href="#works-space" class="sel-btn"><span>SELECTED WORKS</span></a>
			<a class="share-btn"><span class="blind">공유</span></a>
		</div>

<?php

$FLD = array("BIOGRAPHY","AWARDS","EXHIBITIONS","PUBLICATIONS","MAJOR","WORKS");

foreach($FLD as $VAL){

	$DAT = trim($rows[$VAL]);	

	if($DAT !== ""){

		echo '
		<div class="profile-cont">
			<h4>'.$VAL.'</h4>'."\n";

		tagin($DAT);			

		echo '		</div>';

	};

};

?>


<?=$WORKSIMGS_off_s?>
		<div class="profile-cont work">
			<h4 id="works-space"></h4>
			<div class="slider-nav ">
<?=$slidernav?>
			</div>
			<div style="height:20px">
				
			</div>
			<div class="work-slide">
					<div class="slider-for">
<?=$sliderfor?>
					</div>

			</div>

		</div>
<?=$WORKSIMGS_off_e?>

	</div>

	<div class="profile-top">
		<h2>
		</h2>
	</div>

<?php

mysql_close($connect);

?>


<!-- 이미지 슬라이드 원태그에서 제외한것들

					<div class="work-ctrl">
						<a href="#n" class="prev"><span class="blind">이전</span></a>
						<a href="#n" class="next"><span class="blind">다음</span></a>
					</div>

-->

