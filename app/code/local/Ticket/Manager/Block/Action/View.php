<?php

class Ticket_Manager_Block_Action_View extends Mage_Core_Block_Template {

    private $_ticket;
    private $_replies;


    public function __construct()
    {

        parent::__construct();

        if ($ticketId = $this->getRequest()->getParam('id')) {

            $ticket = Mage::getModel('ticket_manager/ticket');
            $ticket->load($ticketId);
            // Check if this ticket belongs to logged in customer
            if(!Mage::helper('ticket_manager')->isValidTicket($ticket->getCustomerId())){
                return;
            }
            $this->_ticket = $ticket;

            $replies = Mage::getModel('ticket_manager/reply')->getCollection();
            $replies->addFieldToFilter('ticket_id', array('eq' => $ticketId));
            $this->_replies = $replies;

        }

    }


    public function getTicket() {

        return $this->_ticket;

    }


    public function getReplies() {

        return $this->_replies;

    }

}