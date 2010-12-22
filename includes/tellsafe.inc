<?php

/**************************************************************************/
/*                                                                        */
/*   Application Constants                                                */
/*                                                                        */
/**************************************************************************/

define("NOTIFY_EMAIL","1");
define("NOTIFY_CONFIRM","2");
define("USR","bobbohn");
define("PSW","qwerty");

/**************************************************************************/
/*                                                                        */
/*   Static Methods                                                       */
/*                                                                        */
/**************************************************************************/

function CriticalError($msg)
{
   error_log($msg,0);
   header("Location: /err000.php");
   exit;
}

/***** Signin *****/
function Signin($user,$psw)
{
   $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
   mysql_select_db("tellsafe",$conn);
   $sql = "select id from contact where active = 'Y' and ucase(username) = ucase('$user') and ucase(password) = ucase('$psw')";
   $rows = mysql_query($sql,$conn) or CriticalError(mysql_error());
   if ($cols = mysql_fetch_array($rows))
   {
      return $cols['id'];
   }
   else
   {
      error_log("Signin Error: Username[$user] Password[$psw].",0);
      return -1;
   }
}

/***** Send Feedback *****/
function SendFeedback($name,$company,$phone,$email,$message)
{
   $to = "blewin@tellsafe.com,rbohn@tellsafe.com,isobkowski@tellsafe.com";
   $subject = "New Feedback Message Has Arrived";
   $body = "Name: $name\r\nCompany: $company\r\nPhone: $phone\r\nEmail: $email\r\nMessage: $message\r\n";
   $headers = "From: info@tellsafe.com\r\n";
   if (!mail($to,$subject,$body,$headers)) error_log("Sendmail Error: [Feedback]",0);       
   
   $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
   mysql_select_db("tellsafe",$conn);
   $sql = "insert into feedback (name,company,phone,email,message,created,confirmed,ipaddress) values ('$name','$company','$phone','$email','$message',now(),'N','$_SERVER[REMOTE_ADDR]')";
   $rc = mysql_query($sql,$conn) or CriticalError(mysql_error());
}

/***** Get Client List *****/
function Clients()
{
   $list = Array();
   $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
   mysql_select_db("tellsafe",$conn);
   $sql = "select id, name from company order by 2";
   $rows = mysql_query($sql,$conn) or CriticalError(mysql_error());      
   while ($cols = mysql_fetch_array($rows)) $list[] = new Company($cols['id']);
   return $list;
}

/***** k() Clean Strings *****/
function k($s)
{
   return htmlspecialchars(stripcslashes($s));
}

/***** Subscribe *****/
function Subscribe()
{
   $to = "blewin@tellsafe.com,rbohn@tellsafe.com,isobkowski@tellsafe.com";
   $subject = "New Client Has Subscribed";
   $body = "Company Name: $_SESSION[company]\r\nCompany Website: $_SESSION[website]\r\nCompany Phone: $_SESSION[phone]\r\n\r\nContact Name: $_SESSION[contact]\r\nContact Email: $_SESSION[email]\r\nContact Phone: $_SESSION[phone1]\r\n";
   $headers = "From: info@tellsafe.com\r\n";
   if (!mail($to,$subject,$body,$headers)) error_log("Sendmail Error: [Subscribe]",0);       

   $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
   mysql_select_db("tellsafe",$conn);

   $sql = "insert into company (name,website,phone,address,city,state,zip,billing_fname,billing_lname,billing_phone,billing_email,billing_address,billing_suite,billing_city,billing_state,billing_zip,active,created,expires) values ('$_SESSION[company]','$_SESSION[website]','$_SESSION[phone]','$_SESSION[address]','$_SESSION[city]','$_SESSION[state]','$_SESSION[zip]','$_SESSION[billing_fname]','$_SESSION[billing_lname]','$_SESSION[billing_phone]','$_SESSION[billing_email]','$_SESSION[billing_address]','$_SESSION[billing_suite]','$_SESSION[billing_city]','$_SESSION[billing_state]','$_SESSION[billing_zip]','Y',now(),date_add(now(), interval 396 day))";
   $rc = mysql_query($sql,$conn) or CriticalError(mysql_error());
   $id = mysql_insert_id();

   $sql = "insert into contact (name,email,phone1,address,city,state,zip,username,password,active,company) values ('$_SESSION[contact]','$_SESSION[email]','$_SESSION[phone1]','$_SESSION[address1]','$_SESSION[city1]','$_SESSION[state1]','$_SESSION[zip1]','$_SESSION[username]','$_SESSION[psw1]','Y',$id)";   
   $rc = mysql_query($sql,$conn) or CriticalError(mysql_error());
}

/**************************************************************************/
/*                                                                        */
/*   Abstract Table Class                                                 */
/*                                                                        */
/**************************************************************************/

class Table
{
   /***** Populate Variables From Database *****/
   function Populate($who,$which)
   {
      $this->me = $which;
      $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
      mysql_select_db("tellsafe",$conn);
      $sql = "select * from $this->me where id = $who";
      $rows = mysql_query($sql,$conn) or CriticalError(mysql_error());
      if ($cols = mysql_fetch_array($rows)) foreach ($cols as $key => $value) $this->$key = $value;
   }

   /***** Get Children List *****/
   function Children($type,$sql)
   {
      $list = Array();
      $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
      mysql_select_db("tellsafe",$conn);
      $rows = mysql_query($sql,$conn) or CriticalError(mysql_error());      
      while ($cols = mysql_fetch_array($rows)) $list[] = new $type($cols['id']);
      return $list;
   }

   /***** Delete *****/
   function Delete()
   {
      $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
      mysql_select_db("tellsafe",$conn);
      $sql = "delete from $this->me where id = $this->id";
      $rc = mysql_query($sql,$conn) or CriticalError(mysql_error()); 
   }

   /***** Update *****/
   function Update()
   {
      $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
      mysql_select_db("tellsafe",$conn);

      $sql = "update $this->me set ";
      $flds = mysql_list_fields("tellsafe", $this->me, $conn);
      $cols = mysql_num_fields($flds);
      for ($i=0; $i<$cols;$i++) 
      {
         $name = mysql_field_name($flds,$i);
         $type = mysql_field_type($flds,$i);

         if ($i > 0) $sql .= ",";
         $sql .= $name." = ";

         if ($type == "int")
         {
            if ($this->$name == "")
               $sql .= "NULL";
            else
               $sql .= $this->$name;
         }
         else
         {
             $sql .= "'". $this->$name."'";
         }
      }
      $sql .= " where id = $this->id";
      $rc = mysql_query($sql,$conn) or CriticalError(mysql_error()); 
   }

   /***** Insert *****/
   function Insert()
   {
      $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
      mysql_select_db("tellsafe",$conn);   

      $sql = "insert into $this->me (";
      $values = "";

      $flds = mysql_list_fields("tellsafe", $this->me, $conn);
      $cols = mysql_num_fields($flds);
      for ($i=0; $i<$cols;$i++) 
      {
         $name = mysql_field_name($flds,$i);
         $type = mysql_field_type($flds,$i);

         if ($name == "id" or $this->$name == "") continue;

         if ($values == "")
         {
            $values = ") values (";
         }
         else
         {
            $sql .= ",";
            $values .= ",";
         }         

         $sql .= $name;

         if ($type == "int")
            $values .= $this->$name;
         else
             $values .= "'". $this->$name."'";
      }
      $sql .= $values.")";
      $rc = mysql_query($sql,$conn) or CriticalError(mysql_error()); 
      $this->id = mysql_insert_id();
   }
}

/**************************************************************************/
/*                                                                        */
/*   Company Class                                                        */
/*                                                                        */
/**************************************************************************/

class Company extends Table
{
   /***** New Company *****/
   function Company($who = 0) 
   {
      $this->Populate($who,"company");
   }

   /***** Get Contacts List *****/
   function Contacts()
   {
      return $this->Children("Contact","select id from contact where company = $this->id");
   }

   /***** Get Complaints List *****/
   function Complaints()
   {
      return $this->Children("Complaint","select id from complaint where company = $this->id order by 1 desc");
   }

   /***** Register Complaint *****/
   function RegisterComplaint($what)
   {       
      $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
      mysql_select_db("tellsafe",$conn);

      $sql = "insert into complaint (company,confirmed,created,message) values ($this->id,'N',now(),'$what')";
      $rc = mysql_query($sql,$conn) or CriticalError(mysql_error());      
      $msg = mysql_insert_id();

      $to = "";
      foreach ($this->Contacts() as $p)
      {
         if ($p->active == "Y")
         {
            if ($to != "") $to .= ",";
            $to .= $p->email;
            $sql = "insert into notification (complaint, contact, type, created) values ($msg,$p->id,".NOTIFY_EMAIL.",now())";
            $rc = mysql_query($sql,$conn) or CriticalError(mysql_error());
         }
      }

      $subject = "TellSafe Complaint #$msg";
      $body = "TellSafe has received an anonymous complaint directed to your Audit Committee.\r\n\r\nPlease visit http://www.tellsafe.com/ to review this submission.";
      $headers = "From: info@tellsafe.com\r\nBcc: rbohn@tellsafe.com\r\n";
      if (!mail($to,$subject,$body,$headers))
      {
         error_log("Sendmail Error: Complaint[$msg]",0);       
      }

      return $msg;
   }

   /***** Delete *****/
   function Delete()
   {
      foreach ($this->Complaints() as $c) $c->Delete();
      foreach ($this->Contacts() as $p) $p->Delete();
      Table::Delete();      
   }
}

/**************************************************************************/
/*                                                                        */
/*   Contact Class                                                        */
/*                                                                        */
/**************************************************************************/

class Contact extends Table
{
   /***** New Contact *****/
   function Contact($who = 0) 
   {
      $this->Populate($who,"contact");
   } 

   /***** Delete *****/
   function Delete()
   {
      $list = $this->Children("Notification","select id from notification where contact = $this->id");
      foreach ($list as $n) $n->Delete();
      Table::Delete();      
   }
}

/**************************************************************************/
/*                                                                        */
/*   Complaint Class                                                      */
/*                                                                        */
/**************************************************************************/

class Complaint extends Table
{
   /***** New Complaint *****/
   function Complaint($who = 0) 
   {
      $this->Populate($who,"complaint");
   }

   /***** Get Notifications List *****/
   function Notifications()
   {
      return $this->Children("Notification","select id from notification where complaint = $this->id order by 1");
   }

   /***** Confirm Receipt *****/
   function ConfirmReceipt($who)
   {       
      $conn = mysql_connect("localhost",USR,PSW) or CriticalError(mysql_error());
      mysql_select_db("tellsafe",$conn);

      $sql = "update complaint set confirmed = 'Y' where id = $this->id";
      $rc = mysql_query($sql,$conn) or CriticalError(mysql_error());      

      $sql = "insert into notification (complaint, contact, type, created) values ($this->id,$who,".NOTIFY_CONFIRM.",now())";
      $rc = mysql_query($sql,$conn) or CriticalError(mysql_error());
   }

   /***** Delete *****/
   function Delete()
   {
      foreach ($this->Notifications() as $n) $n->Delete();
      Table::Delete();      
   }
}

/**************************************************************************/
/*                                                                        */
/*   Notification Class                                                   */
/*                                                                        */
/**************************************************************************/

class Notification extends Table
{
   /***** New Notification *****/
   function Notification($who = 0) 
   {
      $this->Populate($who,"notification");
   }
}

?>
