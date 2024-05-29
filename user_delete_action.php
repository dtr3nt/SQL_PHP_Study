<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$admin_id =$_GET["admin"];

// suppress php auto warning.
ini_set( "display_errors", 0);  

// obtain input from user_delete.php
$userid = $_POST["userid"];

// Form the sql string and execute it.
$sql = "delete from users where userid = '$userid'";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){ 
  // Error occured.  Display error-handling interface.
  echo "<B>Deletion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  <form method=\"post\" action=\"administrator.php?sessionid=$sessionid\">
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record deleted.  Go back automatically.
Header("Location:administrator.php?sessionid=$sessionid&admin=$admin_id");
?>
