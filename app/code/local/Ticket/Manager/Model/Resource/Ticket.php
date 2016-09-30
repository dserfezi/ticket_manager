<?php

class Ticket_Manager_Model_Resource_Ticket extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct() {

        $this->_init('ticket_manager/ticket', 'entity_id');

    }

}