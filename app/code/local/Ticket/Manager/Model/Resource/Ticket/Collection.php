<?php

class Ticket_Manager_Model_Resource_Ticket_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    public function _construct() {

        $this->_init('ticket_manager/ticket');

    }


    public function joinReplies() {

        $this->join('reply', 'main_table.entity_id=reply.ticket_id', array('reply'));

    }

}