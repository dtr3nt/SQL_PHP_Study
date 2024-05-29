<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
$admin_id =$_GET["admin"];
verify_session($sessionid);


echo("<P ALIGN = center ><FONT color = brown size = 20><STRONG>STUDENT ENROLLMENT INFORMATION SHEET<STRONG></FONT></P> ");
echo "<br />";
echo("Hello, $admin_id");
echo "<br />";
echo("<A HREF=\"password_change.php?sessionid=$sessionid&userid=$admin_id\">Change Password</A> </td> ");
echo "<br />";
echo "<br />";
echo("<P><FONT color = brown size = 10><STRONG>PROJECT PART 2 IMPLEMENTATION GOES HERE SHEET<STRONG></FONT></P> ");
echo "<br />";
echo "<br />";
echo("<A HREF = \"logout_action.php?sessionid=$sessionid\">Log Out</A>");

?>
