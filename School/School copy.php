<?php

include_once ($_SERVER["DOCUMENT_ROOT"].'/Hongik_/_Inc/subHead.php');


/* school 테이블에서 뽑아오기 */
$query = "select * FROM school where code='".$code."'";
$reslt = mysql_query($query, $connect);
$rows = mysql_fetch_array($reslt);


$name_en = trim($rows["name_en"]);
$nar = str_split(str_replace("∙","^",$name_en));
for($i=0;$i < count($nar);$i++){
	$name_en_i .= "<i>".str_replace("^","∙",$nar[$i])."</i>\n			";
};

$name_ko = trim($rows["name_ko"]);

$info = str_replace("\n", "<br>", trim($rows["info_".$gb]));

$curri = trim($rows["curri_".$gb]);
if($curri == ""){$curri_off_s = "<!--";$curri_off_e = "-->";};

?>

<!--// page start -->
<div class="teacher-top">
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
	<p><?=$name_ko?>전공</p>
</div>
<div class="teacher-con">
  <div class="info">
    <h3>SCHOOL INFO<span>학과정보</span></h3>
		<p><?=$info?></p>
 </div>
  <div class="faculties">
	 <h3>FACULTIES<span>교수진</span></h3>
	 <ul>
<?php

/* professor 테이블에서 뽑아오기 */

##############################################
##
##	chief 필드 규칙(DB 입력시)
##
##		현재 전공주임으로 되어있는 부분은
##		명칭이 바뀌어도 
##		최소 한글 두 글자 이상이어야 함.
##		(영문일경우 3글자이상)
##
##
##		일반 교수는 서열을 문자타입으로 기록함
##		89보다 9가 더 높음.
##		앞 첫자가 높기때문
##
##		숫자가 높을수록 서열이 높기때문에
##		그 범위는 99부터 10까지이며,
##
##		이 범위를 꼭 지킬것.
##
##############################################


$query = "select no, name_ko, name_en, chief, isAlive FROM professor WHERE code='".$code."' ORDER BY chief DESC, name_ko ASC";
$reslt = mysql_query($query, $connect);


$dir = "../_Img/Profes";
$lst = scandir($dir);


while($rows = mysql_fetch_array($reslt)) {

	if(trim($rows["isAlive"]) == ""){
		
		$chief = trim($rows["chief"]);
		if(strlen($chief) < 3){$chief = "교수";}else{$chief = $chief." 교수";};
		$prof = $code."_".trim($rows["name_en"])."_profile.jpg";
		if(!array_search($prof,$lst)){$prof = "if_no_profile_img.jpg";};

		echo '
		<li>
			<a href="#n" class="view-btn" no='.$rows["no"].'>
				<span class="img"><img src="../_Img/Profes/'.$prof.'" alt=""/></span>
				<span class="btxt"><i>'.$rows["name_ko"].'</i> '.$chief.'<i class="rtxt"></i></span>
				<span class="stxt">'.$rows["name_en"].'</span>
			</a>
		</li>'."\n";

	};

};

?>

	 </ul>
	 <a href="#top" class="top-btn"><span class="blind">상단으로</span></a>
  </div>

  <?=$curri_off_s?>

  <div class="curri">
	 <h3>CURRICULUMS<span>커리큘럼</span></h3>

		<?=$curri?>

	 <a href="#top" class="top-btn"><span class="blind">상단으로</span></a>
  </div>
  <?=$curri_off_e?>


</div>


<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Hongik_/_Inc/subTail.php');?>



