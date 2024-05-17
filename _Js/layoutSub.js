var _thisSite = {};	
var _thisPage = {};
var _isMobile_ = false;
var _isLowBr_ = false;
function initPageLayout(){
	if(_thisPage.initAction!=undefined && _thisPage.initAction.length>0){$(_thisPage.initAction).each(function(i,func){try{func();}catch(e){ alert(e);}});}
}
function setPageLayout(){
	nHeight();
	if(_thisPage.initAction!=undefined && _thisPage.initAction.length>0){$(_thisPage.initAction).each(function(i,func){try{func();}catch(e){ alert(e);}});}
	try{ thisPageResizeAction(); }catch(e){}
	if($(".container-bg").length<1) $("<div class='container-bg'/>").appendTo($("#doc")).hide();

	
}
function resetPageLayout(){
	mainNavi._reset();
	nHeight();
	if(_thisPage.resizeAction!=undefined && _thisPage.resizeAction.length>0){$(_thisPage.resizeAction).each(function(i,func){try{func();}catch(e){ alert(e);}});}
	try{ thisPageResizeAction(); }catch(e){}
	if($(".container-bg").length<1) $("<div class='container-bg'/>").appendTo($("#doc")).hide();
}
function resizePageLayoutHeight(){
}
function nHeight(){
	/*var navH_ =  $('#mainNavi-wrap').outerHeight() ;
	var contH_ = $('#container').outerHeight();
	if(wsize.win.w>1000){
		if( navH_ + 250 > contH_){
			$('#container').css({'height' : navH_  + 250 })
		}
	}
	
	$('.topmenu').find('a.mn_a1, .tgl-btn').click(function(){
		 var vssMenu2 = $(this).parent('li').find('.depth2').outerHeight();
		 var vssCont = $('#contents-wrap').outerHeight();
		 if(wsize.win.w > 1000 && navH_ + 150 > contH_){
			 $('#container').stop().animate({'height': vssCont + vssMenu2 - 100},300);
		 }
		 if(wsize.win.w > 1000 && navH_ + 150 < contH_){
			 $('#container').stop().animate({'height': vssCont + vssMenu2 - 100},300);
		 }
	});*/

}
function setScrollEndLayout(){
	var scrTop = $(window).scrollTop();	
	var chkH = $("#header-wrap").height();
	var cnaviTop = $("#contents-wrap").offset().top - $("#cont-navi-wrap").outerHeight();
	if(_thisPage.scrollAction!=undefined && _thisPage.scrollAction.length>0){		$(_thisPage.scrollAction).each(function(i,func){			try{func();}catch(e){ alert(e);}		});	}
}
function setScrollAfertLayout(){
}
function setWindowRotation(){
	if(typeof(thisPageRotation)=="function" && thisPageRotation!=undefined){  thisPageRotation(); }
	else {
	}
}
if('onorientationchange' in window){	window.addEventListener('onorientationchange', setWindowRotation, false);}

$(document).ready(function(){
	try{initPageCssFiles();}catch(e){}
	try{initPageJavascript();}catch(e){}
	try{getWindowSize();}catch(e){ alert(e);}
	try{getPageSize();}catch(e){}
	try{setLowBrowser();}catch(e){	}
	try{initPageLayout();}catch(e){	}
	try{setMediaObjectFunc();}catch(e){	}
	try{_thisLayout_style = getPageStyle(); }catch(e){}
	docLoading(function(){
	});
});
$(window).load(function(){
	try{initImgSizeInfo();}catch(e){	}

	setPageLayout();	
});
$(window).resize(function(e){
	var resizeTimeGap = 10;
	if(_isLowBr_) resizeTimeGap=100;
	clearTimeout(window.resizeEvt);
	window.resizeEvt = setTimeout(function()
	{
		getWindowSize();getPageSize();
		try{
		if(old_wsize.win== undefined ||  wsize.win.w!=old_wsize.win.w){
			resetPageLayout();
		}else{
			resizePageLayoutHeight();
		}
		}catch(e){
			resetPageLayout();
		}
		try{$(msgPopArr).each(function(k,pp){ pp._resize();});}catch(e){}
	}, resizeTimeGap);
});

$(window).scroll(function(){
	var scrTimeGap = 10;
	if(_isLowBr_) scrTimeGap=200;
	clearTimeout(window.scrollEvt);
	window.scrollEvt = setTimeout(function()
	{
		try{ setScrollEndLayout();}catch(e){}
		
	}, scrTimeGap);
	
	clearTimeout(window.scrollAfterEvt);
	window.scrollAfterEvt = setTimeout(function()
	{
		try{ setScrollAfertLayout();}catch(e){}
	}, 5000);

});
