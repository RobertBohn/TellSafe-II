<?php 
   include("../includes/tellsafe.inc"); 
   $c = new Company();
   $msg = "";

   if (count($_POST) > 0)
   {
      $c->created = date("Y-m-d",time());
      foreach ($_POST as $key => $value) $c->$key = $value;
      if ($c->name == "") 
      {
         $msg = "Name is a required field.";
      }
      else
      {
         $c->Insert();
         header("Location: companylist.php");
         exit;
      }
   }
   else
   {
      if ($c->expires == "") $c->expires = (date("Y",time()) + 1)."-".date("m-d",time());      
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
     <tr><td><b>Create New Company</b></td></tr>
     </table>
  </td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
  <FORM ACTION="addcompany.php" METHOD=post>
  <TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
  <tr><td colspan=2 class=Err><?php print $msg ?></td></tr>
  <tr><td align=right style="padding-right:5">Name:</td><td><input name=name type=text size=28 maxlength=100 value="<?php print k($c->name) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Website:</td><td><input name=website type=text size=28 maxlength=150 value="<?php print k($c->website) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Phone:</td><td><input name=phone type=text size=11 maxlength=30 value="<?php print k($c->phone) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Employees:</td><td><input name=employees type=text size=1 maxlength=5 value="<?php print k($c->employees) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Active:</td><td><SELECT name=active><OPTION VALUE=Y<?php if ($c->active == "Y") print " SELECTED"; ?>>Yes</OPTION><OPTION VALUE=N<?php if ($c->active == "N") print " SELECTED"; ?>>No</OPTION></SELECT></td></tr>
  <tr><td align=right style="padding-right:5">Expires:</td><td><input name=expires type=text size=11 maxlength=10 value="<?php print k($c->expires) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Address:</td><td><input type=text name=address size=28 maxlength=100 value="<?php print k($c->address) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Suite:</td><td><input name=suite type=text size=11 maxlength=10 value="<?php print k($c->suite) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">City:</td><td><input name=city type=text size=11 maxlength=35 value="<?php print k($c->city) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">State:</td><td><input name=state type=text size=1 maxlength=2 value="<?php print k($c->state) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Zip:</td><td><input name=zip type=text size=11 maxlength=10 value="<?php print k($c->zip) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Country:</td><td><input name=country type=text size=11 maxlength=20 value="<?php print k($c->country) ?>"></td></tr>
  <tr><td align=right style="padding-right:5"></td><td style="padding-top:15"><input type=submit value="Create"></td></tr>
  </table>
  </form>
</TD></TR>

</TABLE>

<?php include("adminfooter.inc"); ?>