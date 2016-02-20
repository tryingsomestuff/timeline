function imageResize(img){
	var w_width=$(window).width();
	//      var w_height=$(window).height();
	/*
	   var tmp = img.attr("src").split("&");
	   img.attr("src", tmp[0] + "&size=" + Math.max(500,Math.round(w_width/3)).toString());
	 */
	img.attr("width", Math.max(500,Math.round(w_width/2)).toString());
	img.css("display","block");
}

function galleryResize(){
	var w_width=$(window).width();
	//var w_height=$(window).height();
	$(".gal_hreflightbox").each( function(){
			$(this).attr("width", Math.round(w_width*0.8).toString());
			$(this).css("display","block");
			});

	$(".gal_imgthumb").each( function(){
			$(this).attr("width", Math.max(500,Math.round(w_width/2)).toString());
			$(this).css("display","block");
			});
}

$(window).resize(function(){galleryResize();});

var stickyEl = $('#gal_sticky_icon');
var elTop = stickyEl.offset().top;
$(window).scroll(function() {
		stickyEl.toggleClass('sticky', $(window).scrollTop() > elTop);
                if ( $(window).scrollTop() < elTop )
                   stickyEl.css('top',100-$(window).scrollTop()); 
		});

jQuery(document).ready(function($) {
		var nrOfImages = $(".gal_imgthumb").length;
		var all = nrOfImages;
		$(".gal_imgthumb").load(function() {
			imageResize($(this));
			if(--nrOfImages <= 0){
   			   $("#gal_loading_icon").fadeOut(1000);
			   galleryResize();
			   $("#gal_count").fadeOut();
			}
                        console.log(nrOfImages.toString());
			$("#gal_count").text(""+ (all-nrOfImages).toString() + "/" + all.toString() + "");
			});
		});

