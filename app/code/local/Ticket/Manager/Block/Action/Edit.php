<?php

class Ticket_Manager_Block_Action_Edit extends Mage_Core_Block_Template {

    private $_ticket;


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
        }

    }


    public function getTitle() {

        if ($id = $this->getRequest()->getParam('id')) {
            $title = $this->__('Edit ticket');
        } else {
            $title = $this->__('Create ticket');
        }
        return $title;

    }


    public function getTicket() {

        return $this->_ticket;

    }

}