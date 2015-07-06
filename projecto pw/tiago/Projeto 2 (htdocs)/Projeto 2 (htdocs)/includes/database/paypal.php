<?php

	// #### PAYPAL ###
	function paypalGet($id)
	{
		$t = getTable("paypal", "id = " . dbInteger($id), "");
		return foreachRow($t);
	}
	
	function paypalGetAll()
	{
		return getTable("paypal", "", "");
	}
	
	function paypalInsert($fields)
	{
		unset($fields['id']);
		$fields['id'] = insertRecord('paypallogs', $fields, true);
	}

?>