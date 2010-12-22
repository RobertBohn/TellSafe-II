<?php
   ob_start();
   include("../includes/tellsafe.inc");
   session_start();
   if (!isset($_SESSION[user]))
   {
      error_log("Attempting to access complaint page without signing in.",0);
      header("Location: signin.php");
      exit;
   }

   $u = new Contact($_SESSION[user]);
   $c = new Complaint($_GET[c]);
   if ($u->company != $c->company)
   {
      CriticalError("Invalid Complaint: User[$_SESSION[user]] Complaint[$_GET[c]]");
   }

   if (isset($_POST[confirm]))
   {
      if ($u->name != "Guest Account") $c->ConfirmReceipt($u->id);
      header("Location: members.php");
      exit;
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>TellSafe - Review Complaint</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<?php include("../includes/header.inc"); ?>

<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=10 style="background-color=#006699; width:100%">

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 style="width:100%">
  <tr><td><b>Complaint #<?php print $c->id ?></b></td>
  <td align=right><input type=button value="Signout" align=right onClick="JavaScript:location='signout.php';"></td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
  <tr><td colspan=3><b>Contact Log</b></td></tr>
  <tr><td><?php print date("n/j/Y",strtotime($c->created)) ?></td><td>&nbsp;- <?php print date("g:i A",strtotime($c->created)) ?>&nbsp;</td><td>-&nbsp; Complaint registered.</td></tr>
  <?php
     foreach ($c->Notifications() as $n)
     {
        $p = new Contact($n->contact);
        print "<tr><td>".(date("n/j/Y",strtotime($n->created)))."</td><td>&nbsp;- ".(date("g:i A",strtotime($n->created)))."&nbsp;</td>";
        switch ($n->type)
        {
           case NOTIFY_EMAIL:
              print "<td>-&nbsp; $p->name notified via email.</td></tr>";
              break;
           case NOTIFY_CONFIRM:
              print "<td>-&nbsp; Receipt confirmed by $p->name.</td></tr>";
              break;
           default:
              print "<td></td></tr>";
              break;
        }
     }
  ?>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
  <tr><td><b>Full text of the complaint</b> &nbsp; (<A HREF="JavaScript:window.print();">click here to print</A>)</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td><?php print nl2br(k($c->message)) ?></td></tr>
  <tr><td>&nbsp;</td></tr>

  <?php if ($c->confirmed == "N") { ?>
     <tr><td align=center><FORM ACTION="complaint.php?c=<?php print $c->id ?>&" METHOD=post><input type=submit value="Confirm Receipt"><input name=confirm type=hidden></form></td></tr>
  <?php } else { ?>
     <tr><td align=center><input type=button value="Back" onClick="JavaScript:location='members.php';"></td></tr>
  <?php } ?>

  </table>
</TD></TR>

</TABLE>

<?php include("../includes/footer.inc"); ?>
