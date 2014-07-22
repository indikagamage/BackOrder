<?php
class BGI_BackOrder_Helper_Data extends Mage_Core_Helper_Abstract {

	function sendAuctionEmails() {
		/* Format our dates */
		$time = time();
		$toDate = date('Y-m-d H:i:s', $time);
		$lastTime = $time - (2592000*2); // 60*60*24*30*2
		$fromDate = date('Y-m-d H:i:s', $lastTime);

        /* Get the collection */
        $orders = Mage::getModel('sales/order')->getCollection()
            ->addAttributeToSelect('customer_id')
            ->addAttributeToFilter ('created_at', array (
                'from' => $fromDate,
                'to' => $toDate
            ) )
            ->addAttributeToFilter ( 'status', array (
                'eq' => Mage_Sales_Model_Order::STATE_COMPLETE
            ) );

           $cusstomers=$this->getAllCusstomersIds();

		foreach ($orders as $order) {
			if(($key = array_search($order->getCustomerId(), $cusstomers)) !== false) {
				unset($cusstomers[$key]);
			}
		}

		$sendcusstomers = Mage::getModel('backorder/backorder')
		->getCollection()
		->addFieldToFilter ('send_time', array (
				'from' => $fromDate,
				'to' => $toDate
		) )
		->addFieldToSelect('customer_id');

		foreach ($sendcusstomers as $sendcusstomer) {
			if(($key = array_search($sendcusstomer->getCustomerId(), $cusstomers)) !== false) {
				unset($cusstomers[$key]);
			}
		}

		$sender = Mage::getModel('core/email_template');
		foreach($cusstomers as $custId) {
			$customer_data = Mage::getModel('customer/customer')->load($custId);
			$email = $customer_data->getSubscriberEmail();
			$name = $customer_data->getSubscriberFullName();

			$backorderModel = Mage::getModel('backorder/backorder');

			$backorderModel
			->setCustomerId($custId)
			->save();

			$sender->emulateDesign($customer_data->getStoreId());
			$successSend = $sender->send($email, $name, array('subject'=>'We havent heard from you for a while','customer' => $customer_data));
			$sender->revertDesign();
		}


	}

	function getAllCusstomersIds(){
		$collection = Mage::getModel('customer/customer')
		->getCollection()
		->addAttributeToSelect('*');
		$result = array();
		foreach ($collection as $customer) {
			$result[] = $customer->getId();
		}
		return $result;

	}
}
