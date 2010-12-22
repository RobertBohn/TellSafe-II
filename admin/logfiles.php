<?php include("adminheader.inc"); ?>

<?php
if (count($_POST) > 0)
{   
   switch ($_POST[which]) 
   {
      case "Access":
         $arrFiles=Array("tellsafe_log"=>"/var/log/httpd/tellsafe_log");
         mail_attach($_POST[email],"rbohn@tellsafe.com","TellSafe Access Log","Access Log",$arrFiles);
         break;

      case "Error":
         $arrFiles=Array("error_log"=>"/var/log/httpd/error_log");
         mail_attach($_POST[email],"rbohn@tellsafe.com","TellSafe Error Log","Error Log",$arrFiles);
         break;
   }
}
?>

<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=10 style="background-color=#006699; width:100%">

<TR style="background-color=#f5f5f5"><TD>
  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 style="width:100%">
  <tr><td>
     <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
     <tr><td><a href="admin.php">Administration</a></td></tr>
     <tr><td><b>Email Log Files</b></td></tr>
     </table>
  </td></tr>
  </table>
</TD></TR>

<SCRIPT TYPE="text/javascript">
<!--
function process(w)
{
  if (document.forms[0].email.value == "") { alert("Email Address is Required."); return; }
  document.forms[0].which.value = w;
  document.forms[0].submit();
}
-->
</SCRIPT>

<TR style="background-color=#f5f5f5"><TD>
    <FORM ACTION="logfiles.php" METHOD=post>     
    <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0>
    <tr>
        <td>Email Address&nbsp;</td>
        <td>
            <input name=email type=text size=30 maxlength=255 value="<?php if (count($_POST) > 0) print $_POST[email]; else print "robertbohn@hotmail.com"; ?>">
            <input name=which type=hidden value="Access">
        </td>
    </tr>
    <tr>
        <td>Access Log File&nbsp;</td>
        <td><input type=button value="Send" onClick="JavaScript:process('Access');"><?php if ($_POST[which]=="Access") print "&nbsp;<B>Email Successfully Sent</B>"; ?></td>
    </tr>
    <tr>
        <td>Error Log File&nbsp;</td>
        <td><input type=button value="Send" onClick="JavaScript:process('Error');"><?php if ($_POST[which]=="Error") print "&nbsp;<B>Email Successfully Sent</B>"; ?></td>
    </tr>
    </table>
    </form>
</TD></TR>

</TABLE>

<?php
function mail_attach($to, $from, $subject, $message, $files,$lb="\n") {
 // $to Recipient
 // $from Sender (like "email@domain.com" or "Name <email@domain.com>")
 // $subject Subject
 // $message Content
 // $files hash-array of files to attach
 // $lb is linebreak characters... some mailers need \r\n, others need \n
 $mime_boundary = "<<<:" . md5(uniqid(mt_rand(), 1));
 $header = "From: ".$from.$lb;
 $header.= "MIME-Version: 1.0".$lb;
 $header.= "Content-Type: multipart/mixed;".$lb;
 $header.= " boundary=\"".$mime_boundary."\"".$lb;
 $content = "This is a multi-part message in MIME format.".$lb.$lb;
 $content.= "--".$mime_boundary.$lb;
 $content.= "Content-Type: text/plain; charset=\"iso-8859-1\"".$lb;
 $content.= "Content-Transfer-Encoding: 7bit".$lb.$lb;
 $content.= $message.$lb;
 $content.= "--".$mime_boundary.$lb;
 if(is_array($files)) {
 foreach($files as $filename=>$filelocation) {
  if(is_readable($filelocation)) {
     $data = chunk_split(base64_encode(implode(file($filelocation))));
       $content.= "Content-Disposition: attachment;".$lb;
       $content.= "Content-Type: Application/Octet-Stream;";
       $content.= " name=\"".$filename."\"".$lb;
       $content.= "Content-Transfer-Encoding: base64".$lb.$lb;
       $content.= $data.$lb;
       $content.= "--".$mime_boundary.$lb;
   }
  }
 }
 if(mail($to, $subject, $content, $header)) {
  return TRUE;
 }
 return FALSE;
}
?> 

<?php include("adminfooter.inc"); ?>
