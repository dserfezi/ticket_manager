<?php

class Ticket_Manager_Block_Adminhtml_Ticket extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {

        $this->_blockGroup = 'ticket_manager';
        $this->_controller = 'adminhtml_ticket';
        $this->_headerText = Mage::helper('ticket_manager')->__('Ticket Support');

        parent::__construct();
        $this->_removeButton('add');

    }
}