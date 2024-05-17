var _thisLayout_style = {};
var _orgLayout_style = {};
var _thisPage_cfg  = {};
function checkPageStyle(){
	_orgLayout_style =  $.extend({},_thisLayout_style);  _thisLayout_style = getPageStyle();
}
function getPageStyle(){
	var pg_type = {};
	var chkW = $("body").width();
	if(_isLowBr_ && chkW >999) chkW = wsize.win.w;
	return pg_type;

}
function _getLayoutHeaderHeight(){
	return	$("#header-wrap").height();
}
function _getLayoutFooterHeight(){
	return	$("#footer-wrap").height();
}


function viewFolingListItem(idx){
	var obj = $(".foldings-list #foldings-data"+idx);
	var obj_other = $(".foldings-list li").not("#foldings-data"+idx);
	
	$(".foldings-in-cont",$(obj_other)).slideUp("fast");
	$(obj_other).removeClass("over");			

	if(obj.hasClass("over")){
		
		$(".foldings-in-cont",$(obj)).slideUp("fast");
		$(obj).removeClass("over");
	}else{

		$(".foldings-in-cont",$(obj)).slideDown("fast");
		$(obj).addClass("over");
	}

}
function viewSiteAllMenu(){
	if(mainNavi.mnType=="H"){
		mainNavi_H.toggleMenu();
		return false;
	}else{
		return true;
	}

}
