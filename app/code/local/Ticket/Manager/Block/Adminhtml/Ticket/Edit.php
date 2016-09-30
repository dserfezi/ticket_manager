<?php

class Ticket_Manager_Block_Adminhtml_Ticket_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {


    public function __construct() {

        $this->_blockGroup = 'ticket_manager';
        $this->_controller = 'adminhtml_ticket';

        parent::__construct();

        $this->_updateButton('save', 'label', $this->__('Save Reply'));
        $this->_updateButton('delete', 'label', $this->__('Delete Ticket'));

        if(Mage::registry('ticket')->getActive()) {
            $this->_addButton('close', array(
                'label' => Mage::helper('ticket_manager')->__('Close Ticket'),
                'onclick' => "if(confirm('Are you sure?')){setLocation('{$this->getUrl('*/*/close/', array('id' => Mage::registry('ticket')->getEntityId()))}')}",
                'class' => 'save'
            ));
        }

    }


    /**
     * Get Header text
     * @return string
     */
    public function getHeaderText() {

        return $this->__('Ticket %s', Mage::registry('ticket')->getSupportId());

    }

}