<?php
class BGI_BackOrder_Model_Mysql4_BackOrder_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		//parent::__construct();
		$this->_init('backorder/backorder');
	}
}