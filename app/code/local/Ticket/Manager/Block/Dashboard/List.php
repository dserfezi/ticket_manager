<?php

class Ticket_Manager_Block_Dashboard_List extends Mage_Core_Block_Template {

    private $tickets = array();


    public function __construct() {

        parent::__construct();
        $this->getTicketCollection();

    }


    private function getTicketCollection(){

        $tickets = Mage::getModel('ticket_manager/ticket')->getCollection();
        $tickets->addFieldToSelect('entity_id');
        $tickets->addFieldToSelect('support_id');
        $tickets->addFieldToSelect('subject');
        $tickets->addFieldToSelect('active');
        // Get only currently logged in customer tickets
        $tickets->addFieldToFilter('customer_id', array('eq' => Mage::getSingleton('customer/session')->getCustomerId()));

        $rowCount = 1;
        foreach ($tickets as $ticket) {

            $ticketData = array();
            $ticketData['trClass'] = ($rowCount%2==0) ? 'even' : 'odd';
            $ticketData['rowCount'] = $rowCount;
            $ticketData['url'] = Mage::getUrl('*/ticket/view/id/'.$ticket->getData('entity_id'));
            $ticketData['support_id'] = $ticket->getData('support_id');
            $ticketData['subject'] = $ticket->getSubject();
            $ticketData['active'] = $ticket->getActive();
            $ticketData['close'] = Mage::getUrl('*/ticket/close/', array('id' => $ticket->getData('entity_id')));
            $ticketData['delete'] = Mage::getUrl('*/ticket/delete/', array('id' => $ticket->getData('entity_id')));

            $rowCount++;
            $this->tickets[] = $ticketData;

        }

    }


    public function getTickets(){

        return $this->tickets;

    }

}