<?php
ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>TellSafe - Feedback</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="DESCRIPTION" CONTENT="Send feedback to TellSafe. Tell us how you feel about our website, company and services. Your opinions and ideas are very valuable to us. TellSafe is an online service designed to help audit committees comply with Section 301 of the Sarbanes-Oxley Act.">
<META NAME="KEYWORDS" CONTENT="feedback sarbanes oxley act section 301 anonymous hotline complaint audit committee compliance tellsafe confidential comply">
<?php include("includes/header.inc"); ?>

<?php if (isset($_POST[message])) { ?>

<?php
   include("includes/tellsafe.inc");
   SendFeedback($_POST[name],$_POST[company],$_POST[phone],$_POST[email],$_POST[message]);
?> 

<h1>Your Feedback Has Been Received</h1> 
<p>Your feedback helps us improve the quality of our services. 
<p>Thank you for taking the time to share your comments with us. 

<?php } else { ?>

<FORM ACTION="feedback.php" METHOD=post>
<h1>Feedback</h1>
<p>Tell us what you think about our website, company and services. Your opinions and ideas are very valuable to us.
<p>Please enter your comments here:
<br><TEXTAREA NAME=message ROWS=5 COLS=44></TEXTAREA>
<p>Please enter your contact information here:<br>
<TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
<tr><td align=right style="PADDING-RIGHT:5px">Name:</td><td><input name=name type=text size=29 maxlength=100></td></tr>
<tr><td align=right style="PADDING-RIGHT:5px">Company:</td><td><input name=company type=text size=29 maxlength=100></td></tr>
<tr><td align=right style="PADDING-RIGHT:5px">Phone:</td><td><input name=phone type=text size=29 maxlength=20></td></tr>
<tr><td align=right style="PADDING-RIGHT:5px">Email:</td><td><input name=email type=text size=29 maxlength=255></td></tr>
<tr><td align=right style="PADDING-RIGHT:5px"></td><td style="PADDING-TOP:15"><input type=submit value=Submit></td></tr>
</table>
</FORM>

<?php } ?>

<?php include("includes/footer.inc"); ?>
