<?php 
   include("../includes/tellsafe.inc"); 

   $p = new Contact($_GET[c]);
   $c = new Company($p->company);
   $msg = "";

   if (count($_POST) > 0)
   {
      foreach ($_POST as $key => $value) $p->$key = $value;
      $p->Update();
      header("Location: company.php?c=".$c->id."&");
      exit;         
   }
   else
   {
      if ($_GET[cmd] == "delete")
      {
         $p->Delete();
         header("Location: company.php?c=".$c->id."&");
         exit;         
      }
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
     <tr><td><b><?php print k($p->name) ?></b></td></tr>
     </table>
  </td></tr>
  </table>
</TD></TR>

<TR style="background-color=#f5f5f5"><TD>
  <FORM ACTION="contact.php?c=<?php print $p->id ?>&" METHOD=post>
  <TABLE BORDER=0 CELLSPACING=3 CELLPADDING=0>
  <tr><td colspan=2 class=Err><?php print $msg ?></td></tr>
  <tr><td align=right style="padding-right:5">Contact's Name:</td><td><input name=name type=text size=28 maxlength=50 value="<?php print k($p->name) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Contact's Title:</td><td><input name=title type=text size=28 maxlength=100 value="<?php print k($p->title) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Active:</td><td><SELECT name=active><OPTION VALUE=Y<?php if ($p->active == "Y") print " SELECTED"; ?>>Yes</OPTION><OPTION VALUE=N<?php if ($p->active == "N") print " SELECTED"; ?>>No</OPTION></SELECT></td></tr>
  <tr><td align=right style="padding-right:5">Email:</td><td><input name=email type=text size=28 maxlength=255 value="<?php print k($p->email) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Primary Phone:</td><td><input name=phone1 type=text size=11 maxlength=30 value="<?php print k($p->phone1) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Secondary Phone:</td><td><input name=phone2 type=text size=11 maxlength=30 value="<?php print k($p->phone2) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Address:</td><td><input type=text name=address size=28 maxlength=100 value="<?php print k($p->address) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Suite:</td><td><input name=suite type=text size=11 maxlength=10 value="<?php print k($p->suite) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">City:</td><td><input name=city type=text size=11 maxlength=35 value="<?php print k($p->city) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">State:</td><td><input name=state type=text size=1 maxlength=2 value="<?php print k($p->state) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Zip:</td><td><input name=zip type=text size=11 maxlength=10 value="<?php print k($p->zip) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Country:</td><td><input name=country type=text size=11 maxlength=20 value="<?php print k($p->country) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Username:</td><td><input name=username type=text size=11 maxlength=16 value="<?php print k($p->username) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Password:</td><td><input name=password type=text size=11 maxlength=16 value="<?php print k($p->password) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Security Question:</td><td><input name=question type=text size=28 maxlength=255 value="<?php print k($p->question) ?>"></td></tr>
  <tr><td align=right style="padding-right:5">Security Answer:</td><td><input name=answer type=text size=28 maxlength=255 value="<?php print k($p->answer) ?>"></td></tr>
  <tr><td align=right style="padding-right:5"></td><td style="padding-top:15"><input type=button value="Delete" onclick="JavaScript:if (confirm('Are you sure you want to delete this contact?')) if (confirm('This cannot be undone. Are you really sure?')) location='contact.php?c=<?php print $p->id ?>&cmd=delete&'"> &nbsp; <input type=submit value="Update"></td></tr>
  </table>
  </form>
</TD></TR>

</TABLE>

<?php include("adminfooter.inc"); ?>