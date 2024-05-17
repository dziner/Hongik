
<!--s: 상세보기 레이어 -->
<div class="layer-teacher" id="teacher-ajax"></div>
<!--e: 상세보기 레이어 -->

<script type="text/javascript" language="javascript">

	$('.view-btn').click(function(){
		ajax_send($(this).attr('no'));
		$( 'html, body' ).animate( { scrollTop : 0 }, 400 );
		$('.layer-teacher').css({'z-index':9999, 'opacity':1});
		ovShow();
	});

	function ajax_send(frm){
		$.ajax({
			url:'../_Inc/teacherView_jinos.php?no=' + frm,
			type:'GET',
			success: function(data){
			  $('.layer-teacher').html(data);

				$('.slider-for').slick({
				  autoplay: true,
				  slidesToShow: 1,
				  slidesToScroll: 1,
				  arrows: false,
				  fade: true,
				  speed: 600,
				  autoplaySpeed: 3000,
				  infinite: true,
				  asNavFor: '.slider-nav'
				});

				$('.slider-nav').slick({
			    autoplay: true,
				  slidesToShow: 4,
				  slidesToScroll: 1,
				  asNavFor: '.slider-for',
				  dots: false,
				  speed: 600,
				  infinite: true,
				  autoplaySpeed: 3000,
				  //centerMode: true,
				  focusOnSelect: true
				});

				$('.work-ctrl > .prev').on('click', function() {
					$('.slider-nav').slick('slickPrev');
				});

				$('.work-ctrl > .next').on('click', function() {
					$('.slider-nav').slick('slickNext');
				});

				$('.layer-teacher').find('.layer-close').click(function(){
					$('.layer-teacher').css({'z-index': -1, 'opacity':0});
					ovHide();

				});

				$('#atscrl').height('2500');


			},error: function(xhr, status, error){
			  $('.layer-teacher').html("[" + xhr.status + "]" + error);
			}

		});
		return false;
	}

	function ovShow(){
		var $cback = $(".container-bg");
		$cback.unbind("click").bind("click",function(){ ovHide(); $('.layer-teacher').css({'z-index': -1, 'opacity':0}) }).show();
	}
	function ovHide(){
		$('#atscrl').height('10');
		$(".container-bg").hide();
	}


</script>