<?php

class Ticket_Manager_Block_Dashboard_List extends Mage_Core_Block_Template {


    public function __construct() {

        parent::__construct();

        $tickets = Mage::getModel('ticket_manager/ticket')->getCollection();
        $tickets->addFieldToSelect('entity_id');
        $tickets->addFieldToSelect('support_id');
        $tickets->addFieldToSelect('subject');
        $tickets->addFieldToSelect('active');
        // Get only currently logged in customer's tickets
        $tickets->addFieldToFilter('customer_id', array('eq' => Mage::getSingleton('customer/session')->getCustomerId()));

        $this->setTickets($tickets);

    }


    protected function _prepareLayout() {

        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'dashboard.list.pager')
            ->setCollection($this->getTickets());
        $this->setChild('pager', $pager);
        $this->getTickets()->load();
        return $this;

    }


    public function getPagerHtml() {

        return $this->getChildHtml('pager');

    }

}