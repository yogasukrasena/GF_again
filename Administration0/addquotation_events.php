<?php
//BindEvents Method @1-4771EFC2
function BindEvents()
{
    global $AddNewHeader;
    global $AddNewDetail;
    global $CCSEvents;
    $AddNewHeader->Attn->CCSEvents["BeforeShow"] = "AddNewHeader_Attn_BeforeShow";
    $AddNewHeader->CCSEvents["BeforeShow"] = "AddNewHeader_BeforeShow";
    $AddNewHeader->CCSEvents["AfterInsert"] = "AddNewHeader_AfterInsert";
    $AddNewHeader->CCSEvents["BeforeDelete"] = "AddNewHeader_BeforeDelete";
    $AddNewDetail->CCSEvents["BeforeShowRow"] = "AddNewDetail_BeforeShowRow";
    $AddNewDetail->ds->CCSEvents["BeforeBuildInsert"] = "AddNewDetail_ds_BeforeBuildInsert";
    $AddNewDetail->CCSEvents["BeforeShow"] = "AddNewDetail_BeforeShow";
}
//End BindEvents Method

//DEL  // -------------------------
//DEL      global $AddNewDetail;
//DEL  	global $RowNumber;
//DEL    
//DEL    	$RowNumber++;
//DEL    	$AddNewDetail->RowIDAttribute->SetValue($RowNumber);
//DEL  
//DEL    	if( ($RowNumber <= $AddNewDetail->ds->RecordsCount) && ($RowNumber <= $AddNewDetail->PageSize) ){
//DEL      	
//DEL  		$AddNewDetail->RowNameAttribute->SetValue("FillRow");
//DEL  
//DEL    	}else{ 
//DEL  
//DEL  		$AddNewDetail->RowNameAttribute->SetValue("EmptyRow");
//DEL      	$AddNewDetail->RowStyleAttribute->SetValue("style='display:none;'");
//DEL       	
//DEL  		if($AddNewDetail->EditMode){
//DEL  
//DEL  		    if($AddNewDetail->ErrorMessages[$RowNumber]) $AddNewDetail->RowStyleAttribute->SetValue("");
//DEL          }
//DEL  	 }
//DEL  // -------------------------

//DEL  // -------------------------
//DEL     global $AddNewDetail;
//DEL  	$Quotation_H_ID = intval(CCGetFromGet("Quotation_H_ID",0));
//DEL  	if($Quotation_H_ID > 0){
//DEL  		$AddNewDetail->ds->Quotation_H_ID->SetValue($Quotation_H_ID);
//DEL    	}
//DEL  // -------------------------

//DEL  	$QuotationHID = CCGetFromGet("Quotation_H_ID",0);
//DEL  	if($QuotationHID > 0){
//DEL  		$db = new clsDBgayafusionall;
//DEL  		$sqlquery = "SELECT * FROM tblAdminist_Quotation_D WHERE Quotation_H_ID = ".$QuotationHID;
//DEL  		$db->query($sqlquery);
//DEL  		$result = $db->next_record();
//DEL  		if ($result){
//DEL  			$filefoto = $db->f("Photo");
//DEL  			$filefoto = "../upload/".$filefoto;
//DEL  		}
//DEL  		$db->close;
//DEL  		//show the image still wrong and not give any result
//DEL  		$AddNewDetail->Photo->SetValue($filefoto);
//DEL  	}
//DEL  

//AddNewHeader_Attn_BeforeShow @13-C0B4F923
function AddNewHeader_Attn_BeforeShow(& $sender)
{
    $AddNewHeader_Attn_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddNewHeader; //Compatibility
//End AddNewHeader_Attn_BeforeShow

//Close AddNewHeader_Attn_BeforeShow @13-674E9276
    return $AddNewHeader_Attn_BeforeShow;
}
//End Close AddNewHeader_Attn_BeforeShow

//AddNewHeader_BeforeShow @2-F3C590C7
function AddNewHeader_BeforeShow(& $sender)
{
    $AddNewHeader_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddNewHeader; //Compatibility
//End AddNewHeader_BeforeShow

//Custom Code @48-2A29BDB7
// -------------------------
	global $AddNewHeader,$AddNewDetail;
	global $QuotationNo;//3 below to make an increment quo number
	global $AddQuotation;
	global $NoTrans;
	global $ContactID;//this is to get the contact id
	
	$Prefik = "QUO".date(Ym);
	$NewConnection = new clsDBgayafusionall();

   	if(!$AddNewHeader->EditMode){ 
		$AddNewDetail->Visible = false;
		$AddNewHeader->Revis->Visible = false;
		$AddNewHeader->LinkRev->Visible = false;

		$sqlquery = "SELECT * FROM tblAdminist_Quotation_H WHERE QuotationNo LIKE '".$Prefik."%'";
		$jumlah = mysql_num_rows(mysql_query($sqlquery));
		if ($jumlah > 0){
			$sqlquery = "SELECT MAX(QuotationNo) FROM tblAdminist_Quotation_H";
			$NoTrans = mysql_fetch_array(mysql_query($sqlquery));
			$NoTrans = $Prefik.substr("0".strval(intval(substr($NoTrans[0],-2)+1)),-2);
		}
		else{
			$NoTrans = $Prefik."01";
		}
		$AddNewHeader->QuotationNo->SetValue($NoTrans);
	}
	//to handle the revision
	$QuotationHID = CCGetFromGet("Quotation_H_ID",0);
	if($QuotationHID > 0){
		$sqlquery = "SELECT Rev FROM tblAdminist_Qutation_H WHERE Quotation_H_ID = ".$QuotationHID;
		$NewConnection->query($sqlquery);
		$Result = $NewConnection->next_record();
		if($Result){
			$RevNotEmpty = 1;
			$rev = $NewConnection->f("Rev");
		}else{
			$RevNotEmpty = 0;
		}
		if ($RevNotEmpty == 1){
			$AddNewHeader->Revis->Visible = true;
			$AddNewHeader->Revis->SetValue($rev);
		}else{
			$AddNewHeader->Revis->Visible = false;
		}
	}

	//to handle the address-attn
	$ContactID = CCGetFromGet("ContactID",0);
	if($ContactID > 0){
		$AddNewHeader->AddressID->Visible = false;
		$AddNewHeader->Attn->Visible = false;
		$AddNewHeader->lblAddress->Visible = true;
		$AddNewHeader->lblAttn->Visible = true;
		$AddNewHeader->LinkChange->Visible = true;
		$addquery = "SELECT tblAdminist_AddressBook_Contact.*, tblAdminist_AddressBook.* FROM tblAdminist_AddressBook_Contact INNER JOIN tblAdminist_AddressBook ON tblAdminist_AddressBook_Contact.AddressID = tblAdminist_AddressBook.AddressID WHERE ContactID = ".$ContactID;
		$NewConnection->query($addquery);
		$Result = $NewConnection->next_record();
		if($Result){
			$company = $NewConnection->f("Company");
			$contactname = $NewConnection->f("ContactName");
			$email = $NewConnection->f("Email");
			$address = $NewConnection->f("Address");
			$phone = $NewConnection->f("Phone");
			$fax = $NewConnection->f("Fax");
		}
		$NewConnection->close;
		//show the value
		$AddNewHeader->lblAddress->SetValue($company);
		$AddNewHeader->Attn->SetValue($ContactID);
		$AddNewHeader->lblAttn->SetValue($contactname);
		$AddNewHeader->Email->SetValue($email);
		$AddNewHeader->Address->SetValue($address);
		$AddNewHeader->Phone->SetValue($phone);
		$AddNewHeader->Fax->SetValue($fax);
	}
	else{
		$AddNewHeader->AddressID->Visible = true;
		$AddNewHeader->Attn->Visible = true;
		$AddNewHeader->lblAddress->Visible = false;
		$AddNewHeader->lblAttn->Visible = false;
		$AddNewHeader->LinkChange->Visible = false;
	}

// -------------------------
//End Custom Code

//Close AddNewHeader_BeforeShow @2-57E968BE
    return $AddNewHeader_BeforeShow;
}
//End Close AddNewHeader_BeforeShow

//AddNewHeader_AfterInsert @2-A55E4721
function AddNewHeader_AfterInsert(& $sender)
{
    $AddNewHeader_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddNewHeader; //Compatibility
//End AddNewHeader_AfterInsert

//Custom Code @49-2A29BDB7
// -------------------------
     global $DBgayafusionall;	
  	global $Redirect,$FileName;
  
    	$Redirect = $FileName."?Quotation_H_ID=".CCDLookUp("max(Quotation_H_ID)","tblAdminist_Quotation_H","", $DBgayafusionall);
  // -------------------------
//End Custom Code

//Close AddNewHeader_AfterInsert @2-55234D2C
    return $AddNewHeader_AfterInsert;
}
//End Close AddNewHeader_AfterInsert

//AddNewHeader_BeforeDelete @2-5BB1DF18
function AddNewHeader_BeforeDelete(& $sender)
{
    $AddNewHeader_BeforeDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddNewHeader; //Compatibility
//End AddNewHeader_BeforeDelete

//Custom Code @50-2A29BDB7
// -------------------------
  		$Quotation_H_ID = CCGetFromGet("Quotation_H_ID",0);	
   
    	if(intval($Quotation_H_ID) >0){
 		//Create a new database connection object
      	$NewConnection = new clsDBgayafusionall();
      	$NewConnection->query("DELETE FROM tblAdminist_Quotation_D WHERE Quotation_H_ID=".$NewConnection->ToSQL($Quotation_H_ID,ccsInteger));
  		}
      	//Close and destroy the database connection object
      	$NewConnection->close();
// -------------------------
//End Custom Code

//Close AddNewHeader_BeforeDelete @2-30AF98EE
    return $AddNewHeader_BeforeDelete;
}
//End Close AddNewHeader_BeforeDelete

//AddNewDetail_BeforeShowRow @24-E5384DC1
function AddNewDetail_BeforeShowRow(& $sender)
{
    $AddNewDetail_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddNewDetail; //Compatibility
//End AddNewDetail_BeforeShowRow

//Custom Code @51-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close AddNewDetail_BeforeShowRow @24-3351FC09
    return $AddNewDetail_BeforeShowRow;
}
//End Close AddNewDetail_BeforeShowRow

//AddNewDetail_ds_BeforeBuildInsert @24-537ADC74
function AddNewDetail_ds_BeforeBuildInsert(& $sender)
{
    $AddNewDetail_ds_BeforeBuildInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddNewDetail; //Compatibility
//End AddNewDetail_ds_BeforeBuildInsert

//Custom Code @52-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close AddNewDetail_ds_BeforeBuildInsert @24-88ED8B8D
    return $AddNewDetail_ds_BeforeBuildInsert;
}
//End Close AddNewDetail_ds_BeforeBuildInsert

//AddNewDetail_BeforeShow @24-41B7439C
function AddNewDetail_BeforeShow(& $sender)
{
    $AddNewDetail_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddNewDetail; //Compatibility
//End AddNewDetail_BeforeShow

//Custom Code @136-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close AddNewDetail_BeforeShow @24-C65A1036
    return $AddNewDetail_BeforeShow;
}
//End Close AddNewDetail_BeforeShow

//Page_BeforeInitialize @1-D7B72985
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $AddQuotation; //Compatibility
//End Page_BeforeInitialize

//PTAutoFill1 Initialization @152-8A3F6187
    if ('AddNewHeaderAttnPTAutoFill1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End PTAutoFill1 Initialization

//PTAutoFill1 DataSource @152-3D3BDCAD
        $Service->DataSource = new clsDBgayafusionall();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM tbladminist_addressbook_contact {SQL_Where} {SQL_OrderBy}";
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutoFill1 DataSource

//PTAutoFill1 DataFields @152-22D517C6
        $Service->AddDataSourceField('Email',ccsText,"");
        $Service->AddDataSourceField('Address',ccsText,"");
        $Service->AddDataSourceField('Phone',ccsText,"");
        $Service->AddDataSourceField('Fax',ccsText,"");
//End PTAutoFill1 DataFields

//PTAutoFill1 Execution @152-028A6C4C
        echo $Service->Execute();
//End PTAutoFill1 Execution

//PTAutoFill1 Loading @152-27890EF8
        exit;
    }
//End PTAutoFill1 Loading

//PTAutoFill1 Initialization @198-3C4AA766
    if ('AddNewDetailRndCodePTAutoFill1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End PTAutoFill1 Initialization

//PTAutoFill1 DataSource @198-DB8FA9F1
        $Service->DataSource = new clsDBgayafusionall();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM sampleceramic {SQL_Where} {SQL_OrderBy}";
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutoFill1 DataSource

//PTAutoFill1 DataFields @198-D71179B3
        $Service->AddDataSourceField('SampleCode',ccsText,"");
        $Service->AddDataSourceField('SampleDescription',ccsText,"");
        $Service->AddDataSourceField('Diameter',ccsFloat,"");
        $Service->AddDataSourceField('Height',ccsFloat,"");
        $Service->AddDataSourceField('Width',ccsFloat,"");
        $Service->AddDataSourceField('Length',ccsFloat,"");
        $Service->AddDataSourceField('RealSellingPrice',ccsFloat,"");
//End PTAutoFill1 DataFields

//PTAutoFill1 Execution @198-028A6C4C
        echo $Service->Execute();
//End PTAutoFill1 Execution

//PTAutoFill1 Loading @198-27890EF8
        exit;
    }
//End PTAutoFill1 Loading

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
