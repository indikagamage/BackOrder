<?php

class BGI_BackOrder_Model_Event {

 public function sendEmails(){

        Mage::helper('backorder')->sendAuctionEmails();
    }
}
