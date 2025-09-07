<!doctype html>
<html lang="en" class="no-js">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="description" content="Photo" />
<meta name="author" content="Vivien" />

<link rel="stylesheet" href="css/common/reset.css">
<link rel="stylesheet" href="css/template6/style.css">

<title>Photos</title>

</head>

<body>

<?php
require("php/template6/loop.php");
?>

<div class="am-container" id="am-container">
<?php
$dirs=array();
$pics=array();
getImage($dirs,$pics,true);
//dirloop($dirs);
fileloop($pics);
?>
</div>


<script src="js/common/jquery-1.11.0.min.js"></script>
<script src="js/jquery.montage.min.js"></script>

<script type="text/javascript">
$(function() {
    var $container = $('#am-container'),
            $imgs = $container.find('img').hide(),
            totalImgs = $imgs.length,
            cnt = 0;

    $imgs.each(function(i) {
        var $img	= $(this);
        $('<img/>').load(function() {
            ++cnt;
            if( cnt === totalImgs ) {
                $imgs.show();
                $container.montage({
                    minsize	: false,
                    margin 	: 2,
                    fillLastRow	: false,
                    alternateHeight	: true,
                    alternateHeightRange : {
                    min	: 200,
                    max	: 600
                }
                });
            }
        }).attr('src',$img.attr('src'));
    });
});
</script>

</body>
</html>
