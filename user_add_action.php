<?
ini_set( "display_errors", 0);  

include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$admin_id = $_GET["admin"];

$userid = trim($_POST["userid"]);
if ($userid == "") $userid = 'NULL';

$password = $_POST["password"];
$admin_flag = $_POST["admin_flag"];

// the sql string
$sql = "insert into users values ('$userid', '$password', '$admin_flag')";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);
  
  die("<i> 

  <form method=\"post\" action=\"user_add?sessionid=$sessionid&admin=$admin_id\">

  <input type=\"hidden\" value = \"$userid\" name=\"userid\">
  <input type=\"hidden\" value = \"$password\" name=\"password\">
  <input type=\"hidden\" value = \"$admin_flag\" name=\"admin_flag\">
  
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

Header("Location:administrator.php?sessionid=$sessionid&admin=$admin_id");
?>