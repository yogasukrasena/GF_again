<?php	
session_start();
include ("../settings.php");
include("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'RnD',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}
?>

<html>
<head>
<meta name="GENERATOR" content="CodeCharge Studio 2.3.2.24">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>Gaya Design - Work Plan</title>
<link rel="stylesheet" type="text/css" href="../Includes/Graphite.css">
</head>
<body link="#000000" vlink="#000000" alink="#0000ff" bgcolor="#ffffff" text="#000000" class="GraphitePageBODY">
<?php
error_reporting(0);
$id=$_GET['id'];
//$sid=10;
//$query=;
$result = mysql_query("SELECT tblDesMaterial.*, tblSupplier.*, tblUnit.UnitValue FROM tblDesMaterial INNER JOIN tblSupplier ON tblDesMaterial.DmSupplier = tblSupplier.SupCode INNER JOIN tblUnit ON tblDesMaterial.DmUnit = tblUnit.UnitID WHERE tblDesMaterial.DmID = $id");
$alldata = mysql_fetch_array($result);
?>
<!-- BEGIN Record c_codification -->
  <font class="GraphiteFormHeaderFont">Work Plan Gaya&nbsp;Design </font> 
  <table class="GraphiteFormTABLE" cellspacing="1" cellpadding="3">
    <!-- BEGIN Error -->
    <tr>
      <td class="GraphiteColumnTD" colspan="2" align="center">
	  	<table width="100%" border="0" cellspacing="0" cellpadding="3">
        	<tr>
       		  <td height="50" align="center" valign="middle"><h2>DESIGN MATERIAL </h2></td>
				<td height="50"><img src="../images/logo GAYA/logo GAYA C n D transp kcl.jpg" width="300" height="50"></td> 
        	</tr>
      	</table>	  </td> 
    </tr>
    <!-- END Error -->
    <tr>
      <td class="GraphiteDataTD" nowrap colspan="2" align="right">&nbsp;</td> 
    </tr>
    <tr>
      <td width="97" align="center" nowrap class="GraphiteFieldCaptionTD">Code</td> 
      <td width="512" align="center" class="GraphiteFieldCaptionTD">Description</td> 
    </tr>
 
    <tr>
      <td class="GraphiteDataTD" nowrap="nowrap"><?php echo $alldata['DmCode'] ?>&nbsp;</td> 
      <td class="GraphiteDataTD"><?php echo $alldata['DmDescription'] ?>&nbsp;</td> 
    </tr>
 	<tr>
      <td class="GraphiteDataTD" nowrap colspan="2" align="right">&nbsp;</td> 
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Supplier</td> 
	  <td class="GraphiteDataTD"><?php echo "$alldata[DmSupplier]"." - "."$alldata[SupCompany]" ?>&nbsp;</td>
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Contact Person</td> 
	  <td class="GraphiteDataTD"><?php echo $alldata['SupContact'] ?>&nbsp;</td> <!-- supcontact disini ambil dr tblsupp -->
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Address</td> 
	  <td class="GraphiteDataTD"><?php echo $alldata['SupAddress'] ?>&nbsp;</td> <!-- ini jg ambil dr tblsup -->
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Telephone</td> 
	  <td class="GraphiteDataTD"><?php echo $alldata['SupHP'] ?>&nbsp;</td>
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Fax</td> 
	  <td class="GraphiteDataTD"><?php echo $alldata['SupFax'] ?>&nbsp;</td>
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">E-mail</td> 
	  <td class="GraphiteDataTD"><?php echo $alldata['SupEmail'] ?>&nbsp;</td>
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Other Info</td> 
	  <td class="GraphiteDataTD"><?php echo $alldata['SupOtherInfo'] ?>&nbsp;</td>
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Unit</td> 
	  <td class="GraphiteDataTD"><?php echo "$alldata[UnitValue]" ?>&nbsp;</td>
    </tr>
	<tr>
      <td class="GraphiteDataTD" nowrapalign="right">Unit Price</td> 
	  <td class="GraphiteDataTD"><?php echo $alldata['DmUnitPrice'] ?>&nbsp;</td>
    </tr>
    <tr>
      <td class="GraphiteFieldCaptionTD" colspan="2" nowrap>Notes</td> 
    </tr>
 
    <tr>
      <td class="GraphiteDataTD" colspan="2" nowrap></td> 
    </tr>
 
    <tr>
      <td class="GraphiteDataTD" nowrap colspan="2">
	  	<table border="1" cellpadding="3" cellspacing="0" width="100%">
			<tr>
				<td height="300" valign="top"><?php echo $alldata['DmNotes'] ?></td>
			</tr>
		</table>	
	  </td> 
    </tr>
	<tr>
      <td class="GraphiteDataTD" colspan="2" nowrap>&nbsp;</td> 
    </tr>
 	<tr>
      <td class="GraphiteFieldCaptionTD" valign="middle" nowrap align="center" colspan="2">&nbsp;Photo</td> 
    </tr>
	<tr>
	  <td colspan="2">
	  	<table width="100%" cellpadding="3" cellspacing="0" border="0">
			<tr>
	  			<td class="GraphiteDataTD" align="center"><?php echo "<img class=\"GraphiteInput\" width=\"150\" src=\"../UploadImg/$alldata[DmPhoto1]\" >" ?> </td> 
      			<td class="GraphiteDataTD" align="center"><?php echo "<img class=\"GraphiteInput\" width=\"150\" src=\"../UploadImg/$alldata[DmPhoto2]\" >" ?></td> 
      			<td class="GraphiteDataTD" align="center"><?php echo "<img class=\"GraphiteInput\" width=\"150\" src=\"../UploadImg/$alldata[DmPhoto3]\" >" ?></td>
				<td class="GraphiteDataTD" align="center"><?php echo "<img class=\"GraphiteInput\" width=\"150\" src=\"../UploadImg/$alldata[DmPhoto4]\" >" ?></td> 
			</tr>
		</table>
	  </td>
    <tr>
      <td class="GraphiteFieldCaptionTD" valign="middle" nowrap align="center" colspan="2">&nbsp;Technical
        Drawing</td> 
    </tr>
 
    <tr>
      <td class="GraphiteDataTD" nowrap colspan="2" align="center" valign="middle">
        <p><?php echo "<img class=\"GraphiteInput\" height=\"750\" width=\"600\" src=\"../UploadImg/$alldata[DmTechDraw]\" >" ?></p> </td> 
    </tr>
</table>
<!-- END Grid c_color_c_design_c_textur --></p>
</body>
</html>