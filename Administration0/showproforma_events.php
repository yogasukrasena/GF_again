<?php
session_start();
//BindEvents Method @1-FA9B7EAE
function BindEvents()
{
    global $Detil;
    $Detil->Total->CCSEvents["BeforeShow"] = "Detil_Total_BeforeShow";
    $Detil->lblAdministrasi->CCSEvents["BeforeShow"] = "Detil_lblAdministrasi_BeforeShow";
    $Detil->lblCurrency->CCSEvents["BeforeShow"] = "Detil_lblCurrency_BeforeShow";
    $Detil->DocNotes->CCSEvents["BeforeShow"] = "Detil_DocNotes_BeforeShow";
    $Detil->CCSEvents["BeforeShowRow"] = "Detil_BeforeShowRow";
    $Detil->CCSEvents["BeforeShow"] = "Detil_BeforeShow";
}
//End BindEvents Method

//Detil_Total_BeforeShow @92-ED649264
function Detil_Total_BeforeShow(& $sender)
{
    $Detil_Total_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Detil; //Compatibility
//End Detil_Total_BeforeShow

//Custom Code @152-2A29BDB7
$UPrice = $Detil->UnitPrice->GetValue();
$Qty = $Detil->Qty->GetValue();
$Detil->Total->SetValue($UPrice * $Qty);
//End Custom Code

//Close Detil_Total_BeforeShow @92-FF2D58FA
    return $Detil_Total_BeforeShow;
}
//End Close Detil_Total_BeforeShow

//Detil_lblAdministrasi_BeforeShow @146-29A1ACCA
function Detil_lblAdministrasi_BeforeShow(& $sender)
{
    $Detil_lblAdministrasi_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Detil; //Compatibility
//End Detil_lblAdministrasi_BeforeShow

//Custom Code @147-2A29BDB7
global $Header;
global $DBgayafusionall;
$Detil->lblAdministrasi->SetValue(CCDLookUp("Firstname","tblUser","id = ".$DBgayafusionall->ToSQL(($Header->DocMaker->GetValue()),ccsInteger),$DBgayafusionall));
//End Custom Code

//Close Detil_lblAdministrasi_BeforeShow @146-98ABBD6E
    return $Detil_lblAdministrasi_BeforeShow;
}
//End Close Detil_lblAdministrasi_BeforeShow

//Detil_lblCurrency_BeforeShow @150-29090376
function Detil_lblCurrency_BeforeShow(& $sender)
{
    $Detil_lblCurrency_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Detil; //Compatibility
//End Detil_lblCurrency_BeforeShow

//Custom Code @151-2A29BDB7
global $DBgayafusionall;
$proID = $Detil->Proforma_H_ID->GetValue();
$id = CCDLookUp("Currency","tblAdminist_Proforma_H","Proforma_H_ID = ".$DBgayafusionall->ToSQL($proID,ccsInteger),$DBgayafusionall);
$Detil->lblCurrency->SetValue(CCDLookUp("CurrencyCode","tbladminist_currency","CurrencyID = ".$DBgayafusionall->ToSQL($id,ccsInteger),$DBgayafusionall));
//End Custom Code

//Close Detil_lblCurrency_BeforeShow @150-A25C728D
    return $Detil_lblCurrency_BeforeShow;
}
//End Close Detil_lblCurrency_BeforeShow

//Detil_DocNotes_BeforeShow @153-9F1BD73E
function Detil_DocNotes_BeforeShow(& $sender)
{
    $Detil_DocNotes_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Detil; //Compatibility
//End Detil_DocNotes_BeforeShow

//Custom Code @154-2A29BDB7
include ("../settings.php");
$Detil->DocNotes->SetValue($cfg_DocNotes);
//End Custom Code

//Close Detil_DocNotes_BeforeShow @153-EB64B09F
    return $Detil_DocNotes_BeforeShow;
}
//End Close Detil_DocNotes_BeforeShow

//Detil_BeforeShowRow @45-36388CCD
function Detil_BeforeShowRow(& $sender)
{
    $Detil_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Detil; //Compatibility
//End Detil_BeforeShowRow

//Custom Code @134-2A29BDB7
$Component->Attributes->SetValue('LocalRowNumber', $Component->RowNumber);
//End Custom Code

//Close Detil_BeforeShowRow @45-D613C936
    return $Detil_BeforeShowRow;
}
//End Close Detil_BeforeShowRow

//Detil_BeforeShow @45-0884EB49
function Detil_BeforeShow(& $sender)
{
    $Detil_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Detil; //Compatibility
//End Detil_BeforeShow

//Custom Code @144-2A29BDB7
global $Header, $Detil;
global $DBgayafusionall;
$Proforma_H_ID = CCGetFromGet("Proforma_H_ID",0);
$company = $Header->Company->GetValue();
$Detil->Company->SetValue($company);
$Detil->PackCost->SetValue(CCDLookUp("PackagingCost","tblAdminist_Proforma_H","Proforma_H_ID = ".$DBgayafusionall->ToSQL($Proforma_H_ID, ccsInteger),$DBgayafusionall)."%");
$DBgayafusionall->query("SELECT SubTotal,Discount,Packaging,Fumigation,GrandTotal FROM ar_proforma WHERE Proforma_H_ID = ".$DBgayafusionall->ToSQL($Proforma_H_ID, ccsInteger));
$result = $DBgayafusionall->next_record();
if($result){
  $Detil->SubTotal->SetValue($DBgayafusionall->f("SubTotal"));
  $Detil->Discount->SetValue($DBgayafusionall->f("Discount"));
  $Detil->Packaging->SetValue($DBgayafusionall->f("Packaging"));
  $Detil->Fumigation->SetValue($DBgayafusionall->f("Fumigation"));
  $Detil->GrandTotal->SetValue($DBgayafusionall->f("GrandTotal"));
}
//End Custom Code

//Close Detil_BeforeShow @45-9E220C4A
    return $Detil_BeforeShow;
}
//End Close Detil_BeforeShow

?>