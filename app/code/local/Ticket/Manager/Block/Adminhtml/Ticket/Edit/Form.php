<?php
class Ticket_Manager_Block_Adminhtml_Ticket_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {


    public function __construct() {

        parent::__construct();

        $this->setId('ticket_manager_ticket_form');
        $this->setTitle($this->__('Ticket Information'));

    }

    /**
     * Setup form fields for inserts/updates
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $ticket = Mage::registry('ticket');
        $replies = Mage::registry('replies');

        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));


        /**
         * Ticket fields
         */
        $fieldset = $form->addFieldset('ticket_fieldset', array(
            'legend'    => Mage::helper('ticket_manager')->__('Ticket Information'),
            'class'     => 'fieldset-wide',
        ));

        if ($ticket->getId()) {
            $fieldset->addField('entity_id', 'hidden', array(
                'name'  => 'ticket_id',
                'value' => $ticket->getEntityId(),
            ));
        }

        $fieldset->addField('support_id', 'text', array(
            'name'      => 'support_id',
            'value'     => $ticket->getSupportId(),
            'label'     => Mage::helper('ticket_manager')->__('Support ID'),
            'title'     => Mage::helper('ticket_manager')->__('Support ID'),
            'required'  => true,
            'disabled'  => 'disabled'
        ));

        $fieldset->addField('customer_id', 'text', array(
            'name'      => 'customer_id',
            'value'     => $ticket->getCustomerId(),
            'label'     => Mage::helper('ticket_manager')->__('Customer ID'),
            'title'     => Mage::helper('ticket_manager')->__('Customer ID'),
            'required'  => true,
            'disabled'  => 'disabled'
        ));

        $fieldset->addField('website_id', 'text', array(
            'name'      => 'website_id',
            'value'     => $ticket->getWebsiteId(),
            'label'     => Mage::helper('ticket_manager')->__('Website ID'),
            'title'     => Mage::helper('ticket_manager')->__('Website ID'),
            'required'  => true,
            'disabled'  => 'disabled'
        ));

        $fieldset->addType('type_active', 'Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Form_Active');
        $fieldset->addField('active', 'type_active', array(
            'name'      => 'active',
            'value'     => $ticket->getActive(),
            'label'     => Mage::helper('ticket_manager')->__('Active'),
            'title'     => Mage::helper('ticket_manager')->__('Active'),
            'required'  => true,
            'disabled'  => 'disabled'
        ));

        /**
         * Replies fields
         */
        $fieldset = $form->addFieldset('replies_fieldset', array(
            'legend'    => Mage::helper('ticket_manager')->__('Replies'),
            'class'     => 'fieldset-wide',
        ));

        $fieldset->addType('text_view', 'Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Form_Textview');
        $fieldset->addType('textarea_view', 'Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Form_Textareaview');


        $replyIncrement = 1;
        foreach ($replies as $replyKey => $reply) {

            $fieldset->addField('owner_and_time'.$replyKey, 'text_view', array(
                'name'      => 'owner_and_time'.$replyKey,
                'value'     => (($reply->getOwner()) ? 'Admin' : 'Customer') . ' ' . $reply->getCreatedAt(),
                'label'     => Mage::helper('ticket_manager')->__('Reply #%s', $replyIncrement),
                'title'     => Mage::helper('ticket_manager')->__('Reply #%s', $replyIncrement)
            ));

            $fieldset->addField('reply'.$replyIncrement, 'textarea_view', array(
                'name'      => 'reply'.$replyIncrement,
                'value'     => $reply->getReply()
            ));

            $replyIncrement++;

        } // end foreach $replies

        $fieldset->addField('new_reply', 'textarea', array(
            'name'      => 'reply',
            'label'     => Mage::helper('ticket_manager')->__('New Reply'),
            'title'     => Mage::helper('ticket_manager')->__('New Reply'),
            'required'  => true
        ));

        //$form->setValues($ticket->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}