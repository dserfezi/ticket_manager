<?php

class Ticket_Manager_Model_Resource_Reply extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct() {

        $this->_init('ticket_manager/reply', 'entity_id');

    }

}