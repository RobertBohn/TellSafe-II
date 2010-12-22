<?php 
if (strtoupper($_SERVER[REQUEST_URI]) == "/FAQ.ASP")
{
   header("Location: faq.php");
   exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>TellSafe - Page Not Found</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="DESCRIPTION" CONTENT="TellSafe provides a totally secure service enabling Sarbanes-Oxley Act compliance. Title 3 of the Act requires that public companies provide a method for an informant or whistleblower to anonymously communicate improprieties to their Audit Committees.">
<META NAME="KEYWORDS" CONTENT="Compliant,Audit Committee,Sarbanes-Oxley,Sarbanes-Oxley Act,Sarbanes,Oxley,Whistle Blower,Whistleblower,Informant,TellSafe,Totally Secure,Sarbanes-Oxley Act Compliance,Sarbanes-Oxley Compliance">
<?php include("includes/header.inc"); ?>
<H1>Page Not Found</H1>
<p>The page you requested cannot be found. The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. 
<h1>Please try the following:</h1>
<p>If you typed the page address in the address bar, make sure that it is typed correctly.
<p>Click the Back button to try another link.
<p>Use the navigation links on the left to find the page you are looking for.
<?php include("includes/footer.inc"); ?>