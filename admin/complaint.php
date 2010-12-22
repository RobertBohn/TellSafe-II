<?php 
   include("../includes/tellsafe.inc"); 

   $m = new Complaint($_GET[m]);
   $c = new Company($m->company);

   if ($_GET[cmd] == "delete")
   {
      $m->Delete();
      header("Location: company.php?c=".$c->id."&");
      exit;         
   }
?>

<?php include("adminheader.inc"); ?>

<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=10 style="background-color=#006699; width:100%">

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 style="width:100%">
  <tr><td>
     <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
     <tr><td><a href="admin.php">Administration</a></td></tr>
     <tr><td><a href="companylist.php">View Company List</a></td></tr>
     <tr><td><a href="company.php?c=<?php print $c->id ?>&"><?php print k($c->name) ?></a></td></tr>
     <tr><td><b>Complaint #<?php print k($m->id) ?></b></td></tr>
     </table>
  </td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
  <tr><td colspan=3>Contact Log</td></tr>
  <tr><td><?php print date("n/j/Y",strtotime($m->created)) ?></td><td>&nbsp;- <?php print date("g:i A",strtotime($m->created)) ?> -&nbsp;</td><td>Complaint registered.</td></tr>
  <?php
     foreach ($m->Notifications() as $n)
     {
        $p = new Contact($n->contact);
        print "<tr><td>".(date("n/j/Y",strtotime($n->created)))."</td><td>&nbsp;- ".(date("g:i A",strtotime($n->created)))." -&nbsp;</td>";
        switch ($n->type)
        {
           case NOTIFY_EMAIL:
              print "<td>$p->name notified via email.</td></tr>";
              break;
           case NOTIFY_CONFIRM:
              print "<td>Receipt confirmed by $p->name.</td></tr>";
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
  <tr><td><?php print nl2br(k($m->message)) ?></td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;&nbsp;<input type=button value="Delete" onclick="JavaScript:if (confirm('Are you sure you want to delete this complaint?'))if (confirm('This cannot be undone. Are you really sure?')) location='complaint.php?m=<?php print $m->id ?>&cmd=delete&'"></td></tr>
  </table>
</TD></TR>

</TABLE>

<?php include("adminfooter.inc"); ?>