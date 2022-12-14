<?php
//BindEvents Method @1-8819F865
function BindEvents()
{
    global $Payment;
    $Payment->lblCurrency->CCSEvents["BeforeShow"] = "Payment_lblCurrency_BeforeShow";
    $Payment->CCSEvents["BeforeShow"] = "Payment_BeforeShow";
    $Payment->CCSEvents["BeforeInsert"] = "Payment_BeforeInsert";
}
//End BindEvents Method

//Payment_lblCurrency_BeforeShow @16-E73B2E0E
function Payment_lblCurrency_BeforeShow(& $sender)
{
    $Payment_lblCurrency_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Payment; //Compatibility
//End Payment_lblCurrency_BeforeShow

//Custom Code @22-2A29BDB7
global $DBgayafusionall;
$CurrencyID = $Payment->currency_id->GetValue();
$Payment->lblCurrency->SetValue(CCDLookUp("Currency","tblAdminist_Currency","CurrencyID=".$DBgayafusionall->ToSQL($CurrencyID,ccsInteger),$DBgayafusionall));
//End Custom Code

//Close Payment_lblCurrency_BeforeShow @16-06DCEB8C
    return $Payment_lblCurrency_BeforeShow;
}
//End Close Payment_lblCurrency_BeforeShow

//Payment_BeforeShow @2-2FC4E308
function Payment_BeforeShow(& $sender)
{
    $Payment_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Payment; //Compatibility
//End Payment_BeforeShow

//Custom Code @20-2A29BDB7
if(!$Payment->EditMode){
  global $DBgayafusionall;
  $ar_proforma_id = CCGetFromGet("ar_proforma_id",0);
  $CurrencyID = CCDLookUp("Currency","ar_proforma","ar_proforma_id=".$DBgayafusionall->ToSQL($ar_proforma_id,ccsInteger),$DBgayafusionall);
  $Payment->currency_id->SetValue($CurrencyID);
  $Payment->lblCurrency->SetValue(CCDLookUp("Currency","tblAdminist_Currency","CurrencyID=".$DBgayafusionall->ToSQL($CurrencyID,ccsInteger),$DBgayafusionall));
  $Payment->Rate->SetValue(CCDLookUp("Rate","tblAdminist_Currency","CurrencyID=".$DBgayafusionall->ToSQL($CurrencyID,ccsInteger),$DBgayafusionall));
  $Payment->amount_paid->SetValue(CCDLookUp("GrandTotal","ar_proforma","ar_proforma_id=".$DBgayafusionall->ToSQL($ar_proforma_id,ccsInteger),$DBgayafusionall));
}
//End Custom Code

//Close Payment_BeforeShow @2-9F021A37
    return $Payment_BeforeShow;
}
//End Close Payment_BeforeShow

//Payment_BeforeInsert @2-20C4E354
function Payment_BeforeInsert(& $sender)
{
    $Payment_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Payment; //Compatibility
//End Payment_BeforeInsert

//Custom Code @21-2A29BDB7
global $DBgayafusionall;
$ar_proforma_id = CCGetFromGet("ar_proforma_id",0);
$DBgayafusionall->query("UPDATE ar_proforma SET PAID=1 WHERE ar_proforma_id = ".$DBgayafusionall->ToSQL($ar_proforma_id,ccsInteger));
//End Custom Code

//Close Payment_BeforeInsert @2-37E804E9
    return $Payment_BeforeInsert;
}
//End Close Payment_BeforeInsert
?>
