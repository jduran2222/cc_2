<HTML>
<HEAD>
<TITLE>Using DHTML to Create Sliding Menus (From JavaScript For Dummies, 4th Edition)</TITLE>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
<!-- Hide from older browsers

function displayMenu(currentPosition,nextPosition) {

    // Get the menu object located at the currentPosition on the screen
    var whichMenu = document.getElementById(currentPosition).style;

    if (displayMenu.arguments.length == 1) {
        // Only one argument was sent in, so we need to
        // figure out the value for "nextPosition"

        if (parseInt(whichMenu.top) == -5) {
            // Only two values are possible: one for mouseover
            // (-5) and one for mouseout (-90). So we want
            // to toggle from the existing position to the
            // other position: i.e., if the position is -5,
            // set nextPosition to -90...
            nextPosition = -90;
        }
        else {
            // Otherwise, set nextPosition to -5
            nextPosition = -5;
        }
    }

    // Redisplay the menu using the value of "nextPosition"
    whichMenu.top = nextPosition + "px";
}

// End hiding-->
</SCRIPT>

<STYLE TYPE="text/css">
<!--

.menu {position:absolute; font:10px arial, helvetica, sans-serif; background-color:#ffffcc; layer-background-color:#ffffcc; top:-90px}
#resMenu {right:10px; width:-130px}
A {text-decoration:none; color:#000000}
A:hover {background-color:pink; color:blue}

 -->

</STYLE>

</HEAD>

<BODY BGCOLOR="white">

<div id="resMenu" class="menu" onmouseover="displayMenu('resMenu',-5)" onmouseout="displayMenu('resMenu',-90)"><br />
<a href="#"> Alert:</a><br>
<a href="#"> </a><br>
<a href="#"> You pushed that button again... Didn't yeah? </a><br>
<a href="#"> </a><br>
<a href="#"> </a><br>
<a href="#"> </a><br>
</div>
ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
<input type="button" value="Wake that alert up" onclick="displayMenu('resMenu',-5)">
</BODY>
</HTML>