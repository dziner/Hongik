<?php

#####################################################################################
##
##
##	변수명 규칙
##
##		+ 한영변환
##
##				웹페이지 호출시 URL?gb=변수값
##				변수값은 한글 일때는 ko, 영어일때는 en
##
##		* 메뉴코드
##
##				웹페이지 호출시 URL?code=변수값
##				변수값은 영어 세문자이고 대문자로, 학과명은 전부 한단어처리
##
##				1. 한단어일때 ex) ABOUT					->	ABO	->	$ABO
##				2. 두단어일때 ex) DCG. HONGIK		->	DHO	->	$DHO
##				3. 세단어이상 ex) PAPERS IN DCG	->	PID	->	$PID
##
##		ex) 공간디자인	->	School.php?gb=ko&code=SPA
##
##
#####################################################################################
##
##
##		INT					인트로														INTRO
##
##		DHO					대학원 안내												DCG. HONGIK
##				ABO					대학원 안내												ABOUT
##				PRE					대학원장 인사											PRESIDENT
##				APP					입학안내													APPLICATION
##				LOC					위치안내													LOCATION
##
##		SCH					학과소개													SCHOOLS
##				BNT					전체공지 게시판										NOTICE
##				FUR					가구디자인												FURNITURE
##				SPA					공간디자인												SPATIAL
##				PUB					공공디자인												PUBLIC
##				ADV					광고디자인												ADVERTISING
##				MET					금속∙액세서리디자인								METAL∙ACCESSORIES
##				CER					도예∙유리디자인										CERAMICS∙GLASS
##				BRA					브랜드패키지디자인								BRAND PACKAGE
##				SER					서비스디자인											SERVICE
##				PHO					사진디자인												PHOTOGRAPHIC
##				IND					산업디자인(제품∙운송디자인)				INDUSTRIAL
##				TEX					텍스타일디자인										TEXTILE
##				FAS					패션디자인												FASHION
##
##		NOT					공지∙이벤트												NOTICE & EVENT
##
##		ARC					자료실														ARCHIVES
##				PID					디자인콘텐츠대학원 논문목록				PAPERS IN DCG
##				PIH					홍익대학교 논문검색								PAPERS IN HONGIK UNIV
##				NDL					국가전자도서관 논문검색						NATIONAL DIGITAL LIBRARY
##				DAR					대학원 자료실 (각종 양식)					DGC ARCHIVES
##
##
#####################################################################################

?>
<div id="logo"><a href="/Hongik_/Intro/index.php?gb=<?=$gb?>&code=INT"><img src="/Hongik_/_Img/logo.png" alt=""/></a></div>
<header class="div-wrap header-wrap-abs">
	<!-- s : header-wrap -->
	<div id="header-wrap" class="div-wrap header-wrap">
		<span class="mn-bar"></span>
		<div id="header" class="div-cont header">
			<a href="#"  class="bt-mnall" id="mn-ctrs-btns"><span class="blind">사이트맵</span></a>
			<!--s: mainNavi-wrap -->

			<div id="mainNavi-wrap" >
				<div class="header-bg">
					<div id="mainNavi">
						<div class="tmn-tit">
							<h2 class="m-logo"><a href="/Hongik_/Intro/index.php?gb=ko&code=INT"><span class="blind spacerlogo"><img src="/Hongik_/_Img/spacer.png"></span></a></h2>
							<button type="button" class="bt-mnclose"><span class="blind">메뉴닫기</span></button>
						</div>

						<?php // 루트메뉴 열림상태 유지

							$SELF = $_SERVER['PHP_SELF'];
							if(strpos($SELF,'About')) {
								$DHO="over";
							}elseif(strpos($SELF,'School')) {
								$SCH="over";
							}elseif(strpos($SELF,'Notice')) {
								$NOT="over";
							}elseif(strpos($SELF,'Archives')) {
								$ARC="over";
							};

						?>

						<ul class="topmenu">
							<li id="DHO" class="mn_l1 mn_type <?=$DHO?>">
								<a href="#n" class="mn_a1"><span class="btxt">DCG. HONGIK</span><span class="stxt">대학원 안내</span></a>
								<div class="depth2-wrap">
									<ul class="depth2">
										<li id="ABO" class="mn_l2"><a href="/Hongik_/About/About01.php?gb=<?=$gb?>&code=ABO" class="mn_a2" target="_self"><span class="btxt">ABOUT</span><span class="stxt">대학원 안내</span></a></li>
										<li id="PRE" class="mn_l2"><a href="/Hongik_/About/About02.php?gb=<?=$gb?>&code=PRE" class="mn_a2" target="_self"><span class="btxt">DEAN'S GREETING</span><span class="stxt">대학원장 인사</span></a></li>
										<li id="APP" class="mn_l2"><a href="/Hongik_/About/About03.php?gb=<?=$gb?>&code=APP" class="mn_a2" target="_self"><span class="btxt">APPLICATION</span><span class="stxt">입학안내</span></a></li>
										<li id="LOC" class="mn_l2"><a href="/Hongik_/About/About04.php?gb=<?=$gb?>&code=LOC" class="mn_a2" target="_self"><span class="btxt">LOCATION</span><span class="stxt">위치안내</span></a></li>
									</ul>
								</div>
							</li>
							<li id="SCH" class="mn_l1 mn_type <?=$SCH?>">
								<a href="#n" class="mn_a1"><span class="btxt">SCHOOLS</span><span class="stxt">전공소개</span></a>
								<div class="depth2-wrap">
									<ul class="depth2">

										<?php // 메뉴 > 학과소개 > 서브메뉴, DB에서 받아오기
										$query = "select code, name_ko, name_en FROM school ORDER BY no ASC";
										$reslt = mysql_query($query, $connect);
										while($rows = mysql_fetch_array($reslt)) {
											echo '<li id="'.$rows["code"].'" class="mn_l2"><a href="/Hongik_/School/School.php?gb='.$gb.'&code='.$rows["code"].'" class="mn_a2" target="_self"><span class="btxt">'.$rows["name_en"].'</span><span class="stxt">'.$rows["name_ko"].'</span></a></li>'."\n										";
										};
										?>

									</ul>
								</div>
							</li>
							<li id="NOT" class="mn_l1 mn_type <?=$NOT?>"><a href="/Hongik_/Notice/Notice.php?gb=<?=$gb?>&code=NOT" class="mn_a1"><span class="btxt">NOTICE &amp; EVENT</span><span class="stxt">공지∙이벤트</span></a></li>
							<li id="ARC" class="mn_l1 mn_type <?=$ARC?>">
								<a href="#n" class="mn_a1"><span class="btxt">ARCHIVES</span><span class="stxt">자료실</span></a>
								<div class="depth2-wrap">
									<ul class="depth2">
										<li id="PID" class="mn_l2"><a href="/Hongik_/Archives/Archives01.php?gb=<?=$gb?>&code=PID" class="mn_a2" target="_self" ><span class="btxt">PAPERS IN DCG</span><span class="stxt">디자인콘텐츠대학원 논문목록</span></a></li>
										<li id="PIH" class="mn_l2"><a href="http://honors.hongik.ac.kr/local/html/thesis" class="mn_a2" target="_new"><span class="btxt">PAPERS IN HONGIK UNIV</span><span class="stxt">홍익대학교 논문검색</span></a></li>
										<li id="NDL" class="mn_l2"><a href="http://www.dlibrary.go.kr/JavaClient/jsp/ndli/index.jsp?LOGSTATUS=notok&NLSSOTOKEN=" class="mn_a2" target="_new"><span class="btxt">NATIONAL DIGITAL LIBRARY</span><span class="stxt">국가전자도서관 논문검색</span></a></li>
										<li id="DAR" class="mn_l2"><a href="http://classnet.hongik.ac.kr/~home/hbbs/list.php?table_id=230" class="mn_a2" target="new"><span class="btxt">DGC ARCHIVES</span><span class="stxt">대학원 자료실 (각종 양식)</span></a></li>
									</ul>
								</div>
							</li>
						</ul>
						<script type="text/javascript">initNavigation(0,0)</script>
					</div>

					<div class="sns-wrap">
						<ul>
							<li><a href="#" class="sns-01"><span class="blind">페이스북</span></a></li>
							<li><a href="#" class="sns-02"><span class="blind">인스타그램</span></a></li>
							<li><a href="#" class="sns-03"><span class="blind">트위터</span></a></li>
						</ul>
					</div>
				</div>

				<?php	// 인트로 페이지일때 메뉴아래 배너 안나오게
				if($code !== "INT"){
					echo '
				<div class="left-banner">
					<a href="/Hongik_/About/About03.php?gb=ko&code=APP"><img src="../_Img/Layout/left-banner.jpg" alt=""/></a>
				</div>';
				};
				?>

			</div>
			<!--e: mainNavi-wrap -->

		</div>
		<div class="mn-bg"></div>
	</div>
	<!-- e : header-wrap -->
</header>
