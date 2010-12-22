<?php
ob_start();
include("../includes/tellsafe.inc");

$msg = "";
if (isset($_POST[user]))
{
   $result = Signin($_POST[user],$_POST[psw]);
   if ($result > 0)
   {
      session_start();
      $_SESSION[user] = $result;
      header("Location: members.php");
      exit;
   }
   $msg = "Incorrect username or password.<br>";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>TellSafe - Member Signin</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="DESCRIPTION" CONTENT="TellSafe Member Signin. TellSafe is an online service designed to help audit committees comply with Section 301 of the Sarbanes-Oxley Act. Employees of subscribing companies can register anonymous complaints on our secure website or by calling our 24-hour toll-free hotline.">
<META NAME="KEYWORDS" CONTENT="member signin sarbanes oxley act section 301 anonymous hotline complaint audit committee compliance tellsafe confidential comply">
<?php include("../includes/header.inc"); ?>

<FORM ACTION="signin.php" METHOD=post>
<h1>Member Signin</h1>
<p>Please enter your username and password:
<p>
<TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
<tr><td align=right style="padding-right:5px">Username:</td><td><input name=user type=text size=15 maxlength=16 value="<?php if (isset($_POST[user])) print htmlspecialchars(stripcslashes($_POST[user])); ?>"></td></tr>
<tr><td align=right style="padding-right:5px">Password:</td><td><input name=psw type=password size=15 maxlength=16></td></tr>
<tr><td align=right style="padding-right:5px"></td><td style="padding-top:15px"><input type=submit value="Signin"></td></tr>
</table>
<p><span class="Err"><?php print $msg; ?></span><br>To view sample pages of our member area, you may signin using <i>Guest</i> as your username and password.
</FORM>

<SCRIPT TYPE="text/javascript">
<!--
document.forms[0].user.focus();
-->
</SCRIPT>

<?php include("../includes/footer.inc"); ?>
