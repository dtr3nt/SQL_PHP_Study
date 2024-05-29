<?
include "utility_functions.php";

// Get the client id and password and verify them
$clientid = $_POST["clientid"];
$password = $_POST["password"];

$sql = "select userid,password,admin_flag " .
       "from users " .
       "where userid='$clientid'
         and password ='$password'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($values = oci_fetch_array ($cursor)){
  oci_free_statement($cursor);
  // found the client
  $clientid = $values[0];
  $password = $values[1];
  $admin_flag = $values[2];
 
 
  // create a new session for this client
  $sessionid = md5(uniqid(rand()));

  // store the link between the sessionid and the clientid
  // and when the session started in the session table

  $sql = "insert into userssession " .
    "(sessionid, userid, sessiondate) " .
    "values ('$sessionid', '$clientid', sysdate)";

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Failed to create a new session");
  }
  elseif ($admin_flag == yes) {
    // insert OK - we have created a new session
    header("Location:administrator.php?sessionid=$sessionid&admin=$clientid");
  }
  else {
    // insert OK - we have created a new session
    header("Location:student.php?sessionid=$sessionid&admin=$clientid");
  }
}
else { 
  // client username not found
  die ('Login failed.  Click <A href="login.html">here</A> to go back to the login page.');
} 
?>