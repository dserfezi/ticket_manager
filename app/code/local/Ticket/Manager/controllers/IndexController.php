<?php

class Ticket_Manager_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Support'));
        $this->renderLayout();

    }


    public function preDispatch() {

        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

    }

}