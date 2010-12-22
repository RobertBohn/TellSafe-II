<?php 
include("../includes/tellsafe.inc"); 
?>

<?php
   $c = new Company($_GET[c]);
?>

<?php include("adminheader.inc"); ?>

<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=10 style="background-color=#006699; width:100%">

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 style="width:100%">
  <tr><td>
     <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
     <tr><td><a href="admin.php">Administration</a></td></tr>
     <tr><td><a href="companylist.php">View Company List</a></td></tr>
     <tr><td><b><?php print $c->name; ?></b></td></tr>
     </table>
  </td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
  <tr><td align=right style="padding-right:5">Website:</td><td style="padding-right:25"><?php print $c->website; ?></td><td><a href="companyinfo.php?c=<?php print $c->id; ?>&">Edit Company Information</a></td></tr>
  <tr><td align=right style="padding-right:5">Phone:</td><td style="padding-right:25"><?php print $c->phone; ?></td><td><a href="billing.php?c=<?php print $c->id; ?>&">Edit Billing Information</a></td></tr>
  <tr><td align=right style="padding-right:5">Active:</td><td style="padding-right:25"><?php print (($c->active =="Y") ? "Yes" : "No") ?></td><td></td></tr>
  <tr><td align=right style="padding-right:5">Expires:</td><td style="padding-right:25"><?php print date("n/j/Y",strtotime($c->expires)); ?></td><td></td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
    <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
    <tr>
        <td><b>Contacts</b></td>
        <td>&nbsp;&nbsp;</td>
        <td align=center>Active</td>
        <td>&nbsp;&nbsp;</td>
        <td>Phone</td>
        <td>&nbsp;&nbsp;</td>
        <td>Email</td>
    </tr>

    <?php 
       foreach ($c->Contacts() as $p) 
       {
          print "<tr>";
          print "<td><a href=\"contact.php?c=".$p->id."&\">".$p->name."</a></td>";
          print "<td>&nbsp;&nbsp;</td><td align=center>".(($p->active == "Y") ? "Yes" : "No")."</td>";
          print "<td>&nbsp;&nbsp;</td><td>".$p->phone1."</td>";
          print "<td>&nbsp;&nbsp;</td><td>".$p->email."</td>";
          print "</tr>";
       }
    ?>

    <tr>
        <td><a href="addcontact.php?c=<?php print $c->id; ?>&">Create New Contact</a></td>
        <td colspan=6></td>
    </tr>
    </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
    <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
    <tr>
        <td><b>Complaints</b></td>
        <td>&nbsp;&nbsp;</td>
        <td align=center>Registered</td>
        <td>&nbsp;&nbsp;</td>
        <td>Status</td>
    </tr>

    <?php 
       foreach ($c->Complaints() as $m) 
       {
          print "<tr>";
          print "<td><a href=\"complaint.php?m=".$m->id."&\">#".$m->id."</a></td>";
          print "<td>&nbsp;&nbsp;</td><td align=center>".date("n/j/Y",strtotime($m->created))."</td>";
          print "<td>&nbsp;&nbsp;</td><td>".(  ($m->confirmed == "Y") ? "Closed" : "<b>Open</b>")."</td>";
          print "</tr>";
       }
    ?>
    </table>
</TD></TR>

</TABLE>

<?php include("adminfooter.inc"); ?>