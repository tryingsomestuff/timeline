<!doctype html>
<html lang="en" class="no-js">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="description" content="Photo" />
<meta name="author" content="Vivien" />

<link rel="stylesheet" href="css/common/reset.css">
<link rel="stylesheet" href="css/template7/style.css">

<script src="js/common/jquery-1.11.0.min.js"></script>
<script src="js/jquery.collagePlus.min.js"></script>
<script src="js/jquery.removeWhitespace.min.js"></script>
<script src="js/jquery.collageCaption.min.js"></script>

<title>Photos</title>

</head>

<body>

<?php
require("php/template7/loop.php");
?>

<div class="Collage">
<?php
$dirs=array();
$pics=array();
getImage($dirs,$pics,true);
//dirloop($dirs);
fileloop($pics);
?>
</div>

    <script>

    $(window).load(function () {
        $(document).ready(function(){
            collage();
            $('.Collage').collageCaption();
        });
    });

    function collage() {
        $('.Collage').removeWhitespace().collagePlus(
            {
                'fadeSpeed'     : 2000,
                'targetHeight'  : 255
            }
        );
    };

    var resizeTimer = null;
    $(window).bind('resize', function() {
        $('.Collage .Image_Wrapper').css("opacity", 0);
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(collage, 200);
    });

    </script>

</body>
</html>
