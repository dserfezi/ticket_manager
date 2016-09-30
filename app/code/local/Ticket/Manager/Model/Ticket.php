<?php

class Ticket_Manager_Model_Ticket extends Mage_Core_Model_Abstract {

    protected $_eventPrefix = 'ticket_manager_ticket';
    protected $_eventObject = 'ticket';


    protected function _construct() {

        $this->_init('ticket_manager/ticket');

    }


    /**
     * Reset all model data
     * Used in grid controller
     * @see Ticket_Manager_Adminhtml_TicketController
     *
     * @return Ticket_Manager_Model_Ticket
     */
    public function reset() {

        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;

    }

}