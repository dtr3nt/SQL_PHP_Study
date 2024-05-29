<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$admin_flag =$_GET["adminflag"];
// Suppress PHP auto warning.
ini_set( "display_errors", 0);

// Get input from password_change.php and update the record.
$userid = $_POST["userid"];
$password = $_POST["password"];

// the sql string
$sql = "update users set password = '$password' where userid = '$userid'";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Update Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i>

  <form method=\"post\" action=\"password_change?sessionid=$sessionid\">

  <input type=\"hidden\" value = \"$userid\" name=\"userid\">
  <input type=\"hidden\" value = \"$password\" name=\"password\">
  <input type=\"hidden\" value = \"$admin_flag\" name=\"admin_flag\">
  <input type=\"hidden\" value = \"1\" name=\"update_fail\">

  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
  }
if ($admin_flag == yes) {
// Record updated.  Go back.
Header("Location:administrator.php?sessionid=$sessionid&admin=$userid");
}
else {
Header("Location:student.php?sessionid=$sessionid&admin=$userid");
}

?>

