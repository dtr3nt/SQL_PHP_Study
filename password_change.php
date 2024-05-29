<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$client_id =$_GET["userid"];

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
  <form method=\"post\" action=\"password_change_action.php?sessionid=$sessionid&adminflag=$admin_flag\">
  userid: <input type=\"text\" readonly value = \"$userid\" size=\"8\" maxlength=\"8\" name=\"userid\"> <br />
  New Password: <input type=\"text\" size=\"15\" maxlength=\"14\" name=\"password\">  <br /> <br />
  <input type=\"submit\" value=\"Change Password\">
  </form>
 ");

  if ($admin_flag == yes) {
  echo("<form method=\"post\" action=\"administrator.php?sessionid=$sessionid&admin=$client_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form> ");
  }
	else {
echo(" <form method=\"post\" action=\"student.php?sessionid=$sessionid&admin=$client_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
  }

 
?>

