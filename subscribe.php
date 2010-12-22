<?php
include("includes/tellsafe.inc");
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>TellSafe - Subscribe</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="DESCRIPTION" CONTENT="Subscribe to TellSafe. Download the TellSafe Subscriber's Agreement. TellSafe is an online service designed to help audit committees comply with Section 301 of the Sarbanes-Oxley Act. Employees of subscribing companies can register anonymous complaints on our secure website or by calling our 24-hour toll-free hotline.">
<META NAME="KEYWORDS" CONTENT="subscribe tellsafe subscriber's agreement sarbanes oxley act section 301 anonymous hotline complaint audit committee compliance confidential comply">
<?php include("includes/header.inc"); ?>

<?php
/**************************************************/
/*  Part I - Figure Out Which Section to Display  */
/**************************************************/

$page = 0;
$err = "";

if (count($_POST)==0)
{ 
   $page = 1;
}
elseif (isset($_POST[company]))
{
   if (!$_POST[company])
   {
      $err = "Company name is a required field.";
      $page = 1;
   }
   else
   {
      foreach ($_POST as $key => $value) $_SESSION[$key] = $value;
      $page = 2;
   }
}
elseif (isset($_POST[billing_fname]))
{
   if (!$_POST[billing_fname] || !$_POST[billing_lname] || !$_POST[billing_phone] || !$_POST[billing_email])
   {
      $err = "First name, last name, phone and email are required fields.";
      $page = 2;
   }
   else
   {
      foreach ($_POST as $key => $value) $_SESSION[$key] = $value;
      $page = 3;
   }
}
elseif (isset($_POST[username]))
{
   if (!$_POST[contact] || !$_POST[email] || !$_POST[phone1] || !$_POST[username] || !$_POST[psw1] || !$_POST[psw2])
   {
      $err = "Contact name, email, phone, username and passwords are required fields.";
      $page = 3;
   }
   else
   {
      if ($_POST[psw1] != $_POST[psw2])
      {
         $err = "Password entries must match.";
         $page = 3;
      }
      else
      {
         foreach ($_POST as $key => $value) $_SESSION[$key] = $value;
         $page = 4;
      }
   }
}
?>


<?php
/**************************************************/
/*  Part II - Write Subscription Info to mySql    */
/**************************************************/

if ($page == 4)
{
   Subscribe(); 
   session_destroy();
}

/**************************************************/
/*  Part III - Display the Appropriate Section    */
/**************************************************/
?>


<?php if ($page == 1) { ?>
<SCRIPT TYPE="text/javascript">
<!--
function process()
{
  if (document.forms[0].company.value == "") { alert("Please enter your Company's Name."); return; }
  if (document.forms[0].agree.checked == false) { alert("Please download and read the terms of the subscription before proceeding."); return; }
  document.forms[0].submit();
}
-->
</SCRIPT>
<FORM ACTION="subscribe.php" METHOD=post>
<h1>Subscribe to TellSafe - Step 1 of 3</h1>
<p>Please enter your company information here:
<p><TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
<tr><td align=right style="PADDING-RIGHT:5">Company:</td><td><input name=company type=text size=28 maxlength=100 value="<?php print k($_POST[company]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Website:</td><td><input name=website type=text size=28 maxlength=150 value="<?php print k($_POST[website]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Phone:</td><td><input name=phone type=text size=10 maxlength=30 value="<?php print k($_POST[phone]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Address:</td><td><input name=address type=text size=28 maxlength=100 value="<?php print k($_POST[address]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">City:</td><td><input name=city type=text size=10 maxlength=35 value="<?php print k($_POST[city]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">State:</td><td><input name=state type=text size=2 maxlength=2 value="<?php print k($_POST[state]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Zip:</td><td><input name=zip type=text size=10 maxlength=10 value="<?php print k($_POST[zip]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">&nbsp;</td><td></td></tr>
<tr><td align=right style="PADDING-RIGHT:5"><INPUT TYPE=checkbox NAME=agree CHECKED></td><td>I agree to the terms of TellSafe's Subscriber Agreement.</td></tr>
<tr><td align=right style="PADDING-RIGHT:5"></td><td style="PADDING-TOP:15"><input type=button value=Submit onClick="JavaScript:process();"></td></tr>
</table>
<?php if ($err != "") print "<p><span class=\"Err\">".$err."</span>"; ?>
<p><a href="/resources/SubscriberAgreement.pdf">Download TellSafe's Subscriber Agreement</a>. 
</FORM>
<?php } ?>


<?php if ($page == 2) { ?>
<SCRIPT TYPE="text/javascript">
<!--
function process()
{
  if (document.forms[0].billing_fname.value == "") { alert("Please Enter First Name."); return; }
  if (document.forms[0].billing_lname.value == "") { alert("Please Enter Last Name."); return; }
  if (document.forms[0].billing_phone.value == "") { alert("Please Enter Phone Number."); return; }
  if (document.forms[0].billing_email.value == "") { alert("Please Enter Email Address."); return; }
  document.forms[0].submit();
}
-->
</SCRIPT>
<FORM ACTION="subscribe.php" METHOD=post>
<h1>Subscribe to TellSafe - Step 2 of 3</h1>
<p>Please enter the information for the person who will be billed for your subscription.
<p>
<TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
<tr><td align=right style="padding-right:5">First Name:</td><td><input name=billing_fname type=text size=18 maxlength=50" value="<?php print k($_POST[billing_fname]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="padding-right:5">Last Name:</td><td><input name=billing_lname type=text size=18 maxlength=50 value="<?php print k($_POST[billing_lname]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="padding-right:5">Phone:</td><td><input name=billing_phone type=text size=11 maxlength=30 value="<?php print k($_POST[billing_phone]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="padding-right:5">Email:</td><td><input name=billing_email type=text size=28 maxlength=255 value="<?php print k($_POST[billing_email]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="padding-right:5">Address:</td><td><input type=text name=billing_address size=28 maxlength=100 value="<?php print k($_POST[billing_address]) ?>"></td></tr>
<tr><td align=right style="padding-right:5">Suite:</td><td><input name=billing_suite type=text size=11 maxlength=10 value="<?php print k($_POST[billing_suite]) ?>"></td></tr>
<tr><td align=right style="padding-right:5">City:</td><td><input name=billing_city type=text size=11 maxlength=35 value="<?php print k($_POST[billing_city]) ?>"></td></tr>
<tr><td align=right style="padding-right:5">State:</td><td><input name=billing_state type=text size=1 maxlength=2 value="<?php print k($_POST[billing_state]) ?>"></td></tr>
<tr><td align=right style="padding-right:5">Zip:</td><td><input name=billing_zip type=text size=11 maxlength=10 value="<?php print k($_POST[billing_zip]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5"></td><td style="PADDING-TOP:15"><input type=button value="Submit" onClick="JavaScript:process();"></td></tr>
</table>
<?php if ($err != "") print "<p><span class=\"Err\">".$err."</span>"; ?>
</FORM>
<?php } ?>


<?php if ($page == 3) { ?>
<SCRIPT TYPE="text/javascript">
<!--
function process()
{
  if (document.forms[0].contact.value == "") { alert("Please enter your Contact's Name."); return; }
  if (document.forms[0].email.value == "") { alert("Please enter your Contact's Email Address."); return; }
  if (document.forms[0].phone1.value == "") { alert("Please enter your Contact's Phone Number."); return; }
  if (document.forms[0].username.value == "") { alert("Please enter your Contact's Username."); return; }
  if (document.forms[0].psw1.value == "") { alert("Please enter your Contact's Password."); return; }
  if (document.forms[0].psw1.value != document.forms[0].psw2.value) { alert("The Password values you entered do not match."); return; }
  document.forms[0].submit();
}
-->
</SCRIPT>
<FORM ACTION="subscribe.php" METHOD=post>
<h1>Subscribe to TellSafe - Step 3 of 3</h1>
<p>Enter information about your company's primary contact. This person will be notified whenever an anonymous complaint is registered about your company.
<p>
<TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
<tr><td align=right style="PADDING-RIGHT:5">Name:</td><td><input name=contact type=text size=28 maxlength=50 value="<?php print k($_POST[contact]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Email:</td><td><input name=email type=text size=28 maxlength=255 value="<?php print k($_POST[email]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Phone:</td><td><input name=phone1 type=text size=12 maxlength=30 value="<?php print k($_POST[phone1]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Address:</td><td><input name=address1 type=text size=28 maxlength=100 value="<?php print k($_POST[address1]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">City:</td><td><input name=city1 type=text size=10 maxlength=35 value="<?php print k($_POST[city1]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">State:</td><td><input name=state1 type=text size=2 maxlength=2 value="<?php print k($_POST[state1]) ?>"></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Zip:</td><td><input name=zip1 type=text size=10 maxlength=10 value="<?php print k($_POST[zip1]) ?>"></td></tr>
</table>
<p>Create an online account. Your primary contact will enter this username and password to signin and review registered complaints.
<p>
<p><TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
<tr><td align=right style="PADDING-RIGHT:5">Username:</td><td><input name=username type=text size=15 maxlength=16 value="<?php print k($_POST[username]) ?>"> <i>* required</i></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Password:</td><td><input name=psw1 type=password size=15 maxlength=16> <i>* required</i></td></tr>
<tr><td align=right style="PADDING-RIGHT:5">Password:</td><td><input name=psw2 type=password size=15 maxlength=16> <i>* re-enter password</i></td></tr>
<tr><td align=right style="PADDING-RIGHT:5"></td><td style="PADDING-TOP:15"><input type=button value="Submit" onClick="JavaScript:process();"></td></tr>
</table>
<?php if ($err != "") print "<p><span class=\"Err\">".$err."</span>"; ?>
</FORM>
<?php } ?>


<?php if ($page == 4) { ?>
<h1>Thank You</h1>
<p>Thank you for subscribing to TellSafe. We know that you will be pleased with our services.
<p>A TellSafe officer will contact you shortly with more information.
<?php } ?>


<?php include("includes/footer.inc"); ?>
