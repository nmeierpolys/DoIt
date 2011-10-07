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
    <div id="outerHeader">&nbsp;</div>
	<div id="main">
    <div id="title">
    	<?php showTitle(); ?>
    </div>
    <div id="banner">
        <?php showBanner(); ?>
    </div>
    <div id="container">
    	<div id="content">
            <div id="leftMargin">
                <?php showLeftBar(); ?>    
            </div>
            <?php showRightBar(); ?>
            <div id="topToolbar" class="ajax">
                <?php showTopToolbar(); ?>
            </div>
            <div id="bodyContent" class="ajax">
                <?php showContent(); ?>
            </div>
            <div id="innerFooter">
                <?php showFooter(); ?>
            </div>
    	</div>
    </div>
    <div id="outerFooter"><?php showOuterFooter(); ?></div>
</body>
</html>
	