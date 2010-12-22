<?php 
   include("../includes/tellsafe.inc"); 

   $c = new Company($_GET[c]);
   $msg = "";

   if (count($_POST) > 0)
   {
      foreach ($_POST as $key => $value) $c->$key = $value;
      $c->Update();
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
     <tr><td><b>Billing Information</b></td></tr>
     </table>
  </td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
  <FORM ACTION="billing.php?c=<?php print $c->id ?>&" METHOD=post>
  <TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
  <tr><td colspan=2 class=Err><?php print $msg ?></td></tr>
  <tr><td colspan=2 class=Err><?php print $msg ?></td></tr>
  <tr><td align=right style="padding-right:5">First Name:</td><td><input name=billing_fname type=text size=18 maxlength=50 value="<?php print k($c->billing_fname) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Last Name:</td><td><input name=billing_lname type=text size=18 maxlength=50 value="<?php print k($c->billing_lname) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Phone:</td><td><input name=billing_phone type=text size=11 maxlength=30 value="<?php print k($c->billing_phone) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Email:</td><td><input name=billing_email type=text size=28 maxlength=255 value="<?php print k($c->billing_email) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Address:</td><td><input type=text name=billing_address size=28 maxlength=100 value="<?php print k($c->billing_address) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Suite:</td><td><input name=billing_suite type=text size=11 maxlength=10 value="<?php print k($c->billing_suite) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">City:</td><td><input name=billing_city type=text size=11 maxlength=35 value="<?php print k($c->billing_city) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">State:</td><td><input name=billing_state type=text size=1 maxlength=2 value="<?php print k($c->billing_state) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Zip:</td><td><input name=billing_zip type=text size=11 maxlength=10 value="<?php print k($c->billing_zip) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Country:</td><td><input name=billing_country type=text size=11 maxlength=20 value="<?php print k($c->billing_country) ?>"></td></tr>
  <tr><td align=right style="padding-right:5"></td><td style="padding-top:15"><input type=submit value="Update"></td></tr>
  </table>
  </form>
</TD></TR>

</TABLE>

<?php include("adminfooter.inc"); ?>