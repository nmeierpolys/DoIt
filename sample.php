<head>
<link rel="stylesheet" type="text/css" href="styles/sample.css" />
<script type="text/javascript" src="scripts/popup-window.js"></script>
</head>


<!-- ***** Form ************************************************************ -->

<form action="" onsubmit="return false;">
	<input type="button" value="Center" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'screen-center',         0,   0);" />
</form>


<!-- ***** Popup Window **************************************************** -->

<div class="sample_popup"     id="popup" style="display: none;">

<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="styles/form_exit.png" alt="" />
&nbsp;&nbsp;&nbsp;Login
</div>

<div class="menu_form_body">
<form action="sample.php" method="post">
<table>
  <tr><th>Username:</th><td><input class="field" type="text"     onfocus="select();" name="username" /></td></tr>
  <tr><th>Password:</th><td><input class="field" type="password" onfocus="select();" name="password" /></td></tr>
  <tr><th>         </th><td><input class="btn"   type="submit"   value="Submit" /></td></tr>
</table>
</form>
</div>
</div>
