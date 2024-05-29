<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$admin_id=$_GET["admin"];

// Verify how we reach here
if (!isset($_POST["update_fail"])) { // from welceomepage.php
  // Get the dnumber, fetch the record to be updated from the database
  $userid = $_GET["userid"];

  // the sql string
  $sql = "select userid, password, admin_flag from users where userid = '$userid'";
  //echo($sql);

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }

  $values = oci_fetch_array ($cursor);
  oci_free_statement($cursor);

  $userid = $values[0];
  $password = $values[1];
  $admin_flag = $values[2];
}
else { // from update_action.php
  // Get the values of the record to be updated directly
  $userid = $_POST["userid"];
  $password = $_POST["password"];
  $admin_flag = $_POST["admin_flag"];
}

// display the record to be updated.
echo("
  <form method=\"post\" action=\"user_update_action.php?sessionid=$sessionid&admin=$admin_id\">
  User ID (Read-only): <input type=\"text\" readonly value = \"$userid\" size=\"8\" maxlength=\"8\" name=\"userid\"> <br />
  Password (Required): <input type=\"text\" value = \"$password\" size=\"15\" maxlength=\"14\" name=\"password\">  <br />
  Is Admin: <input type=\"text\" value = \"$admin_flag\" size=\"5\" maxlength=\"3\" name=\"admin_flag\">  <br />
  <input type=\"submit\" value=\"Update\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>

  <form method=\"post\" action=\"administrator.php?sessionid=$sessionid&admin=$admin_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>

