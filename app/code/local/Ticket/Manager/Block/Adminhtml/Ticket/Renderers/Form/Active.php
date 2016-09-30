<?php

class Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Form_Active
    extends Varien_Data_Form_Element_Abstract {


    public function getElementHtml() {

        return Mage::registry('ticket')->getActive() ? 'Yes' : 'No';

    }

}