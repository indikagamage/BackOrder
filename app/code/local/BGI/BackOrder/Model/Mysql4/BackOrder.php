<?php
class BGI_BackOrder_Model_Mysql4_BackOrder extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('backorder/backorder', 'backorder_id');
	}
}