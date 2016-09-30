<?php

class Ticket_Manager_TicketController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Support'));
        $this->renderLayout();

    }


    public function viewAction() {

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Support'));
        $navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');
        if ($navigationBlock) {
            $navigationBlock->setActive('ticket_manager');
        }
        $this->renderLayout();

    }


    public function newAction() {

        $this->_forward('form');

    }


    public function editAction() {

        $this->_forward('form');

    }


    /**
     * Set navigation URL as active and title
     */
    public function formAction() {

        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Support'));
        $navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');
        if ($navigationBlock) {
            $navigationBlock->setActive('ticket_manager');
        }
        $this->renderLayout();

    }


    /**
     * Save ticket in database
     */
    public function saveAction() {

        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/');
        }

        $ticket = Mage::getModel('ticket_manager/ticket');

        $isEdit = false;
        if($ticketId = $this->getRequest()->getParam('id')){
            $ticket->load($ticketId);
            $isEdit = true;
        }

        if(!$isEdit) {
            $ticket->setData(
                array(
                    'support_id' => Mage::helper('ticket_manager')->generateSupportId(),
                    'customer_id' => Mage::getSingleton('customer/session')->getCustomer()->getId(),
                    'website_id' => Mage::app()->getWebsite()->getId(),
                    'subject' => $this->getRequest()->getParam('subject'),
                    'message' => $this->getRequest()->getParam('message'),
                    'active' => true
                )
            );
        } else {
            // Check if this ticket belongs to logged in customer
            if(!Mage::helper('ticket_manager')->isValidTicket($ticket->getCustomerId())){
                return $this->_redirect('*/');
            }

            $ticket->setData(
                array(
                    'entity_id' => $this->getRequest()->getParam('id'),
                    'subject' => $this->getRequest()->getParam('subject'),
                    'message' => $this->getRequest()->getParam('message')
                )
            );
        }

        try {

            $ticket->save();

        } catch (Exception $e) {

            echo $e->getMessage();
            Mage::logException($e);
            Mage::getSingleton('core/session')->addError('Save error');
            if($isEdit) {
                $this->_redirect('*/ticket/edit/', array('id' => $this->getRequest()->getParam('id')));
            } else {
                $this->_redirect('*/ticket/new/');
            }

        }

        Mage::getSingleton('core/session')->addSuccess('Ticket saved successfully.');
        $this->_redirect('*/');

    }


    public function closeAction() {

        $ticket = Mage::getModel('ticket_manager/ticket');
        $ticket->load($this->getRequest()->getParam('id'));

        // Check if this ticket belongs to logged in customer
        if(!Mage::helper('ticket_manager')->isValidTicket($ticket->getCustomerId())){
            return $this->_redirect('*/');
        }

        $ticket->setData(
            array(
                'entity_id' => $this->getRequest()->getParam('id'),
                'active' => false
            )
        );

        try {

            $ticket->save();

        } catch (Exception $e) {

            echo json_encode( array('success' => false) );
            Mage::logException($e);
            return false;

        }

        echo json_encode(array('success' => true));

    }


    public function deleteAction() {

        $ticket = Mage::getModel('ticket_manager/ticket');
        $ticket->load($this->getRequest()->getParam('id'));

        // Check if this ticket belongs to logged in customer
        if(!Mage::helper('ticket_manager')->isValidTicket($ticket->getCustomerId())){
            return $this->_redirect('*/');
        }

        try {

            $ticket->delete();

        } catch (Exception $e) {

            echo json_encode( array('success' => false) );
            Mage::logException($e);
            return false;

        }

        echo json_encode(array('success' => true));

    }


    public function preDispatch() {

        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

    }

}