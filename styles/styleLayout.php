<?php
	require_once('../db.php');
	require_once('../functionlib.php');
	
	if(beforeRunFunctions()) { exit; }	
?>

<?php 
	include('../header.php'); 
?>

<body>
    <div id="outerHeader">Outer Header</div>
<div id="main">
    <div id="leftMargin">
     Left Margin
    </div>
    <div id="content">
        <table>
          <tr>
            <div id="banner">
                    Banner
            </div>
          </tr>
          <tr>
            <div id="topToolbar">
                    Top Toolbar
            </div>
          </tr>
          <tr>
             <div id="bodyContent">
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pretium commodo augue, at condimentum metus ultrices a. Suspendisse sed sem augue. Nam volutpat semper arcu sed ornare. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus pretium hendrerit orci vel sagittis. Sed quis pretium purus. Sed imperdiet nisi iaculis elit mollis malesuada. In interdum erat in ante congue vitae dignissim erat auctor.
</p>
<p>
Nulla auctor ligula sed arcu tempus auctor. Donec vel orci arcu. Donec placerat augue ut neque euismod convallis. Maecenas vitae ante vulputate est rhoncus luctus sed vel nulla. Duis urna magna, ultrices eget sodales quis, rhoncus eu massa. Nam mollis justo ut turpis eleifend iaculis accumsan nibh commodo. Nulla facilisi. Integer non faucibus lorem. Maecenas scelerisque feugiat bibendum.
</p>
<p>
Vivamus tempor, lacus eget eleifend pulvinar, metus dui tincidunt dui, quis commodo elit felis nec felis. Duis lacus velit, commodo sed suscipit tristique, ultricies quis magna. Donec eleifend felis in nibh ultrices a congue urna dapibus. Fusce ut libero arcu. Aliquam elementum tristique pharetra. Maecenas convallis dignissim pulvinar. Integer in lacus enim. Nulla interdum vestibulum ipsum, id cursus est ornare vel. Sed ultrices magna rhoncus enim semper malesuada. Ut quis dui elit. Sed sit amet tincidunt erat. Nunc ultrices odio aliquet risus venenatis dictum. Aenean non massa sed ipsum ultrices facilisis. Nullam ante nisi, pharetra ut tincidunt in, euismod nec dui. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
</p>
<p>
Phasellus dignissim ornare nisl in commodo. Donec id libero et est tempor molestie vitae nec sem. Nulla pulvinar leo et eros eleifend dignissim. Aliquam erat volutpat. Nullam mattis, nulla eu mattis laoreet, orci leo posuere arcu, non tempus augue ante fringilla neque. Sed in enim lectus. Suspendisse egestas pretium orci. Vestibulum laoreet lorem id tellus fringilla egestas. Nullam gravida, risus in convallis rutrum, lectus tortor convallis augue, sed commodo est tellus id risus. Aliquam nibh sem, hendrerit eu vehicula et, rutrum quis lacus. Donec ac porta ipsum. Proin eleifend lorem vitae quam posuere sit amet facilisis mauris vehicula. Aenean eget nisl eu felis condimentum vehicula nec a odio. Vestibulum ullamcorper, tellus in posuere blandit, velit ligula semper arcu, nec porttitor arcu libero vitae libero.
</p>       	
            </div>
          </tr>
          <tr>
            <div id="innerFooter">
                <?php 
                   include('../footer.php');
                ?>
            </div>
          </tr>
        </table>
    </div>
    <div id="rightMargin">
     Right Margin
    </div>
</div>
    <div id="outerFooter">Outer Footer</div>
</body>
</html>
	