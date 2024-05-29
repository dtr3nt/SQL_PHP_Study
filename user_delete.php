<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$admin_id =$_GET["admin"];

// Obtain input from administrator.php
$q_userid = $_GET["userid"];

// Retrieve the tuple to be deleted and display it.
$sql = "select userid, password, admin_flag from users where userid = '$q_userid'";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){ // error unlikely
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if (!($values = oci_fetch_array ($cursor))) {
  // Record already deleted by a separate session.  Go back.
  Header("Location:administrator.php?sessionid=$sessionid");
}
oci_free_statement($cursor);

$userid = $values[0];
$password = $values[1];
$admin_flag = $values[2];

// Display the tuple to be deleted
echo("
  <form method=\"post\" action=\"user_delete_action.php?sessionid=$sessionid&admin=$admin_id\">
  User ID (Read-only): <input type=\"text\" readonly value = \"$userid\" name=\"userid\"> <br /> 
  Password: <input type=\"text\" disabled value = \"$password\" name=\"password\">  <br />
  Is Admin: <input type=\"text\" disabled value = \"$admin_flag\" name=\"admin_flag\">  <br />
  <input type=\"submit\" value=\"Delete\">
  </form>

  <form method=\"post\" action=\"administrator.php?sessionid=$sessionid&admin=$admin_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");

?>
