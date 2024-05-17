<?

$gb = isset($_REQUEST["gb"]) ? $_REQUEST["gb"] : "";
$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";
$ROOT = $_SERVER["DOCUMENT_ROOT"];
include $ROOT."/Hongik_/_Inc/db_nnoc.php";


if($code == "INT"){

	$js_layout = '<script type="text/javascript" src="/Hongik_/_Js/layoutMain.js"></script>';
	$body_bg = "";
	$body_id = "main";
	$div_slide = '
<div class="visual-slide">
  <div class="item c-01"></div>
  <div class="item c-02"></div>
  <div class="item c-03"></div>
</div>';
	$ctwrap_cls = "mcontainer";

}else{

	$js_layout = '<script type="text/javascript" src="/Hongik_/_Js/layoutSub.js"></script>';
	$body_bg = "$('body').addClass('bg-".$code."'); // 배경\n";
	$body_id = "";
	$div_slide = "";
	$ctwrap_cls = "scontainer";

}

?>

<!doctype html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1.0, minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi">
	<title>홍익대학교 디자인콘텐츠대학원</title>

<? include_once ($ROOT.'/Hongik_/_Inc/headCssinc.php');?>

<?=$js_layout?>

<style>
	@charset "utf-8";
	body.bg-<?=$code?>:after{background:url(../_Img/Sub/bg-<?=$code?>.jpg) no-repeat center center;background-size:cover; position:fixed; left:0; top:0; width:100%; height:100%; display:block; content:""; z-index:-1; background-attachment: fixed;-webkit-transition: all 0.3s ease-out;-moz-transition: all 0.3s ease-out;-o-transition: all 0.3s ease-out;transition: all 0.3s ease-out;}
</style>

<script>
	$(document).ready(function(){
		<?=$body_bg?>
		$('#<?=$code?>').addClass('over');
	});
</script>

</head>
<body id="<?=$body_id?>">
<? include_once ($ROOT.'/Hongik_/_Inc/lowEinc.php');?>

<?=$div_slide?>

<!-- s: #doc //-->
<div id="doc" class="isPage">
<? include_once ($ROOT.'/Hongik_/_Inc/skinNavi.php');?>
<!-- s: .doc-pg //-->
<div id="pg-code" class="doc-pg">
	<div class="ov ov-box">
	<? include_once ($ROOT.'/Hongik_/_Inc/headerInc.php');?>
		<!-- s: #container-wrap //-->
		<div id="container-wrap"  class="div-wrap <?=$ctwrap_cls?>" >
			<div id="container"  class="div-cont">
				<div id="contents-wrap">
					<div id="contents">


