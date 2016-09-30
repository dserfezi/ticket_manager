<?php

class Ticket_Manager_Model_Reply extends Mage_Core_Model_Abstract {

    protected $_eventPrefix = 'ticket_manager_reply';
    protected $_eventObject = 'reply';


    protected function _construct(){

        $this->_init('ticket_manager/reply');

    }

}