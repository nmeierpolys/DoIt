<?php

require_once('includes.php');
startSession();		
?>

<?php 

include('header.php'); 
if(beforeRunFunctions()) { exit; };
if(isset($_GET)){
	$_SESSION['GET'] = $_GET;
}
?>


<body>
	<div id="results"></div>
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
				//showContent(); 
			?>
        </div>
        <div id="innerFooter">
            <?php showFooter(); ?>
        </div>
    </div>
    <div id="outerFooter"><?php showOuterFooter(); ?></div>
</body>
</html>
	