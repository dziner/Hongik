

					</div>
					<!-- e: #contents //-->
					<a href="#top" class="is-top"><span>TOP</span></a>
				</div>
				<!-- e: #contents-wrap //-->
			</div>
			<!-- e: #container //-->
	</div>
	<!-- e: #container-wrap //-->


	<!-- Intro 페이지 하단부분 배너 두개 + 게시글 목록 //-->
	<?php

		if($code == "INT"){

			echo '<div class="m-cont">

		<div id="btm1"><a href="/Hongik_/About/About03.php?gb=ko&code=APP"><img src="/Hongik_/_Img/banner_2018.png"></a></div>
		<div id="btm2"><a href="http://www.hongikartcenter.com/main.do" target="_new"><img src="/Hongik_/_Img/banner_ac.jpg"></a></div>
		<div id="btm3">
			<div class="introb-wrap">
				<div class="introb-con">
					<h3> RECENT NOTICES </h3>
					<ul>';

			include $_SERVER["DOCUMENT_ROOT"]."/Hongik_/Intro/index_notice.php";

			echo '
					</ul>
				</div>
			</div>
		</div>

	</div>';

		};

	?>

	</div><!-- ov close -->

<!-- s: 스크롤 늘려주는 div //-->
<div id="atscrl">
</div>
<!-- e: 스크롤 늘려주는 div //-->

<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Hongik_/_Inc/footerInc.php');?>
</div>
<!-- e: .doc-pg //-->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Hongik_/_Inc/teacherView.php');?>

</div>


<?php

if($code == "INT"){

	echo '

<script type="text/javascript" language="javascript">

	$(".is-top").hide();

	// Hsize 값만큼 높이를 줄여줌
	var Hsize = 300;

	$( document ).ready(function() {

		/*var con4 = $("#container-wrap");
		console.log( con4.height() );
		con4.height( con4.height() - Hsize )

		var con3 = $("#container");
		console.log( con3.height() );
		con3.height( con3.height() - Hsize );

		var con2 = $("#contents-wrap");
		console.log( con2.height() );
		con2.height( con2.height() - Hsize );

		var con1 = $("#contents");
		console.log( con1.height() );
		con1.height( con1.height() - Hsize );*/


	});

</script>

	';

};

?>

</body>
</html>

<?php

	mysql_close($connect);

?>