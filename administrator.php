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
// Generate the query section
echo("
  <form method=\"post\" action=\"administrator.php?sessionid=$sessionid&admin=$admin_id\">
  User ID: <input type=\"text\" size=\"10\" maxlength=\"8\" name=\"q_userid\"> 
  Password: <input type=\"text\" size=\"10\" maxlength=\"14\" name=\"q_password\"> 
  Is Admin: <input type=\"text\" size=\"5\" maxlength=\"3\" name=\"q_admin_flag\"> 
  <input type=\"submit\" value=\"Search\">
  </form>

 
  <form method=\"post\" action=\"user_add.php?sessionid=$sessionid&admin=$admin_id\">
  <input type=\"submit\" value=\"Add A New User\">
  </form>
  ");


// Interpret the query requirements
$q_userid = $_POST["q_userid"];
$q_password = $_POST["q_password"];
$q_admin_flag = $_POST["q_admin_flag"];

$whereClause = " 1=1 ";

if (isset($q_userid) and trim($q_userid)!= "") { 
  $whereClause .= " and userid like '%$q_userid%'"; 
}

if (isset($q_password) and $q_password!= "") { 
  $whereClause .= " and password like '%$q_password%'"; 
}

if (isset($q_admin_flag) and $q_admin_flag!= "") { 
  $whereClause .= " and admin_flag like '%$q_admin_flag%'"; 
}


// Form the query and execute it
$sql = "select userid, password, admin_flag from users where $whereClause order by userid";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}


// Display the query results
echo "<table border=1>";
echo "<tr> <th>User ID</th> <th>Password</th> <th>Admin</th> <th>Update</th> <th>Delete</th><th>P Reset</th></tr>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $userid = $values[0];
  $password = $values[1];
  $admin_flag = $values[2];
  echo("<tr>" . 
    "<td>$userid</td> <td>$password</td> <td>$admin_flag</td> ".
    " <td> <A HREF=\"user_update.php?sessionid=$sessionid&userid=$userid&admin=$admin_id\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?sessionid=$sessionid&userid=$userid&admin=$admin_id\">Delete</A> </td> ".
    " <td> <A HREF=\"user_reset.php?sessionid=$sessionid&userid=$userid&admin=$admin_id\">Reset</A> </td> ".
    "</tr>");
}
oci_free_statement($cursor);

echo "</table>";
echo "<br />";
echo("<A HREF = \"logout_action.php?sessionid=$sessionid\">Log Out</A>");

?>
