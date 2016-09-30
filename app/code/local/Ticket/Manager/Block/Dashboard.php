<?php

class Ticket_Manager_Block_Dashboard extends Mage_Core_Block_Template {

    public function getCustomer()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }


    public function getNewTicketUrl()
    {
        return $this->getUrl('ticket_manager/ticket/new', array('_secure'=>true));
    }

}