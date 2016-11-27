////////////////////
// LOADING
////////////////////
jQuery(document).ready(function($) {
    var nrOfImagesPic = $(".gal_imgthumb").length;
    var nrOfImagesDir = $(".gal_dirthumb").length;

    var all = nrOfImagesPic + nrOfImagesDir;
    var nrOfImages = all;
    $(".gal_dirthumb").load(function() {
        if(--nrOfImages <= 0){
            $("#gal_loading_icon").fadeOut(1000);
            $("#gal_count").fadeOut();
        }
        console.log(nrOfImages.toString());
        $("#gal_count").text(""+ (all-nrOfImages).toString() + "/" + all.toString() + "");
    });
    $(".gal_imgthumb").load(function() {
        if(--nrOfImages <= 0){
            $("#gal_loading_icon").fadeOut(1000);
            $("#gal_count").fadeOut();
        }
        console.log(nrOfImages.toString());
        $("#gal_count").text(""+ (all-nrOfImages).toString() + "/" + all.toString() + "");
    });
});

