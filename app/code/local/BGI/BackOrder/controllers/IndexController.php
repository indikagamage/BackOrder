<?php
class BGI_BackOrder_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{		//echo "ssssssssss";exit;
		Mage::helper('backorder')->sendAuctionEmails();
	}
}