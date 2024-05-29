<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$admin_id =$_GET["admin"];

// Obtain the inputs from user_add_action.php
$userid= $_POST["dnumber"];
$dname = $_POST["dname"];
$location = $_POST["location"];

// display the insertion form.
echo("
  <form method=\"post\" action=\"user_add_action.php?sessionid=$sessionid&admin=$admin_id\">
  UserID (Required): <input type=\"text\" value = \"$userid\" size=\"8\" maxlength=\"8\" name=\"userid\"> <br /> 
  Password: <input type=\"text\" value = \"$password\" size=\"14\" maxlength=\"14\" name=\"password\">  <br />
  Is Admin: <input type=\"text\" value = \"$admin_flag\" size=\"3\" maxlength=\"3\" name=\"admin_flag\">  <br />
  <input type=\"submit\" value=\"Add\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>

  <form method=\"post\" action=\"administrator.php?sessionid=$sessionid&admin=$admin_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");

?>