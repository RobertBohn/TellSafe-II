<?php 
include("../includes/tellsafe.inc"); 
?>

<?php include("adminheader.inc"); ?>

<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=10 style="background-color=#006699; width:100%">

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 style="width:100%">
  <tr><td>
     <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
     <tr><td><a href="admin.php">Administration</a></td></tr>
     <tr><td><b>View Company List</b></td></tr>
     </table>
  </td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
    <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
    <tr>
        <td><b>Companies</b></td>
        <td></td>
        <td align=center>Active</td>
        <td></td>
        <td align=center>Created</td>
        <td></td>
        <td align=center>Expires</td>
        <td></td>
        <td align=center>Msgs</td>
    </tr>

    <?php 
       foreach (Clients() as $c)
       {
          print "<tr>";
          print "<td><a href=\"company.php?c=".$c->id."&\">".$c->name."</a></td>";
          print "<td>&nbsp;&nbsp;</td><td align=center>".(($c->active =="Y") ? "Yes" : "No")."</td>";
          print "<td>&nbsp;&nbsp;</td><td align=center>".date("n/j/Y",strtotime($c->created))."</td>";

          // Days till expiration
          $exp = (integer)((strtotime($c->expires) - time()) / (24*60*60));
          if ($exp <= 0)
             print "<td>&nbsp;&nbsp;</td><td align=right><b>Expired</b></td>";
          else
             print "<td>&nbsp;&nbsp;</td><td align=right>".$exp." days</td>";

          // Number of open complaints
          $open = 0;
          $msgs = 0;
          foreach ($c->Complaints() as $m)
          {
             $msgs++;
             if ($m->confirmed == "N") $open++; 
          }

          if ($open == 0)
             print "<td>&nbsp;&nbsp;</td><td align=center>".$msgs."</td>";
          else
             print "<td>&nbsp;&nbsp;</td><td align=center><b>".$msgs."</b></td>";

          print "</tr>";
       } 
    ?>

    <tr>
        <td><a href="addcompany.php">Create New Company</a></td>
        <td colspan=8></td>
    </tr>
    </table>
</TD></TR>

</TABLE>

<?php include("adminfooter.inc"); ?>