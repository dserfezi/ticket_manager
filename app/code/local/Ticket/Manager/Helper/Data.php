<?php

class Ticket_Manager_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Generate unique ticket name
     * @return string
     */
    public function generateSupportId() {

        $sid = 'TM';
        for ($i=0; $i<10; $i++){
            $sid .= mt_rand(0, 9);
        }
        return $sid;

    }


    /**
     * Check if ticket belongs to logged in customer
     * @param int $ticketCustomerId
     * @return bool
     */
    public function isValidTicket($ticketCustomerId) {

        if($ticketCustomerId != Mage::getSingleton('customer/session')->getCustomerId()){
            return false;
        }
        return true;

    }

}