<?php
	require_once('db.php');
	require_once('functionlib.php');
	startSession();	
	if(isset($_SESSION["popLogin"])){
		echo '<script> popup_show(); </script>';	
	}
		
?>

<?php 
	include('header.php'); 
	if(beforeRunFunctions()) { exit; };
?>


<body>
    <div id="outerHeader">&nbsp;</div>
	<div id="main">
    <div id="leftMargin">
    	<?php showLeftBar(); ?>    
    </div>
    <?php showRightBar(); ?>
    <div id="title">
    	<?php showTitle(); ?>
    </div>
    <div id="banner">
        <?php showBanner(); ?>
    </div>
    <div id="content">
        <div id="topToolbar">
            <?php showTopToolbar(); ?>
        </div>
        <div id="bodyContent">
            <?php 
				showContent(); 
			?>
        </div>
        <div id="innerFooter">
            <?php showFooter(); ?>
        </div>
    </div>
    <div id="outerFooter"><?php showOuterFooter(); ?></div>
	<div id="test"></div>
</body>
</html>
	