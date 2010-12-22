<?php
   ob_start();
   include("../includes/tellsafe.inc");
   session_start();

   if (!isset($_SESSION[user]))
   {      
      error_log("Attempting to access members page without signing in.",0);
      header("Location: signin.php");
      exit;
   }

   $u = new Contact($_SESSION[user]);
   $c = new Company($u->company);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>TellSafe - Member Area</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<?php include("../includes/header.inc"); ?>

<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=10 style="background-color=#006699; width:100%">

<!-- Company Information -->
<TR style="background-color=#f5f5f5"><TD>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 style="width:100%">
    <tr><td>
      <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
      <tr><td><b>Company</b></td></tr>
      <tr><td><?php print $c->name ?></td></tr>
      <tr><td><?php print $c->address ?></td></tr>
      <tr><td><?php print ($c->city).", ".($c->state)." ".($c->zip) ?></td></tr>
      </table>
    </td>
    <td valign=top align=right><input type=button value="Signout" align=right onClick="JavaScript:location='signout.php';"></td></tr>
    </table>
</TD></TR>

<!-- Subscription Information -->
<TR style="background-color=#f5f5f5"><TD>
    <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
    <tr><td><b>Subscription</b></td></tr>
    <tr><td>Your TellSafe subscription expires on <?php print date("n/j/Y",strtotime($c->expires)) ?>.</td></tr>
    </table>
</TD></TR>

<!-- Contact List -->
<TR style="background-color=#f5f5f5"><TD>
    <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
    <tr><td><b>Contacts</b></td><td></td><td>Phone</td><td></td><td>Email Address</td></tr>
    <?php foreach ($c->Contacts() as $p) if ($p->active == "Y") print "<tr><td>".($p->name)."</td><td>&nbsp;&nbsp;</td><td>".($p->phone1)."</td><td>&nbsp;&nbsp;</td><td>".($p->email)."</td></tr>"; ?>
    </table>
</TD></TR>

<!-- Message List -->
<TR style="background-color=#f5f5f5"><TD>
    <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
    <tr><td><b>Complaints</b></td></tr>
    <?php
       $list = $c->Complaints();
       if (count($list) == 0)
          print "<tr><td>No complaints have been registered in the past 180 days.</td></tr>";
       else
          foreach ($list as $m) print "<tr><td><a href=\"complaint.php?c=".($m->id)."&\">#".($m->id)."</a> registered on ".(date("n/j/Y",strtotime($m->created))).(($m->confirmed == "N") ? "&nbsp;&nbsp;<b>&lt;not confirmed&gt;</b>" : "&nbsp;")."</td></tr>";
    ?>
    </table>
</TD></TR>

</TABLE>

<?php include("../includes/footer.inc"); ?>
