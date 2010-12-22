<?php
ob_start();
include("../includes/tellsafe.inc"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>TellSafe - Register Complaint</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="DESCRIPTION" CONTENT="Register Your Complaint Online. This secure form is provided for you to register complaints about your company's accounting or auditing practices. TellSafe is an online service designed to help audit committees comply with Section 301 of the Sarbanes-Oxley Act.">
<META NAME="KEYWORDS" CONTENT="register complaint online secure submission sarbanes oxley act section 301 anonymous hotline audit committee compliance tellsafe confidential comply">
<?php include("../includes/header.inc"); ?>

<?php if (isset($_POST[who])) { ?>

<h1>Your Complaint Has Been Registered</h1> 
<p>Your company's authorized representatives will receive email notification of this anonymous complaint.
<p>If you need to refer to your complaint in a future submission, please use the following confirmation number:

<?php
   $c = new Company($_POST[who]);
   print "<p>Confirmation #".$c->RegisterComplaint($_POST[what]);
?>

<?php } else { ?>

<SCRIPT TYPE="text/javascript">
<!--
function process()
{
  if (document.forms[0].who.value == "0") { alert("Please select your company from the list."); return; }
  if (document.forms[0].what.value == "") { alert("Please enter your message in the text area below."); return; }
  if (document.forms[0].what.value.length > 32000) { alert("Your text exceeds our maximum length of 32,000 characters.\n\nYou can either shorten your text or you can divide it into smaller portions and then submit them in multiple messages."); return; }
  document.forms[0].submit();
}
-->
</SCRIPT>

<FORM ACTION="submissions.php" METHOD=post>
<h1>Register Your Complaint Online</h1>
<p>This secure form is provided for you to register complaints about your company's accounting or auditing practices.
<p>Please be as specific as you can. Include dates and times whenever possible. In order to remain anonymous, do not include any personal information.
<p>Please select your company:
<br><SELECT NAME=who style="width:260;"><OPTION VALUE="0" SELECTED></OPTION>
<?php foreach (Clients() as $c) if ($c->active == "Y") print "<OPTION VALUE=\"$c->id\">$c->name</OPTION>"; ?>
</SELECT>

<p>Please enter your complaint here:
<br><TEXTAREA NAME=what ROWS=5 COLS=44></TEXTAREA>
<p><input type=button value=Submit onClick="JavaScript:process();">
</FORM>

<?php } ?>

<?php include("../includes/footer.inc"); ?>
