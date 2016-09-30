<?php

class Ticket_Manager_ReplyController extends Mage_Core_Controller_Front_Action {

    public function saveAction() {

        $ticket = Mage::getModel('ticket_manager/ticket');
        $ticket->load($this->getRequest()->getParam('ticketId'));

        // Check if this ticket belongs to logged in customer
        if(!Mage::helper('ticket_manager')->isValidTicket($ticket->getCustomerId())){
            return $this->_redirect('*/');
        }

        $reply = Mage::getModel('ticket_manager/reply');
        $reply->setData(
            array(
                'ticket_id' => $this->getRequest()->getParam('ticketId'),
                'owner' => (Mage::getSingleton('admin/session')->isLoggedIn()) ? 1 : 0,
                'reply' => $this->getRequest()->getParam('reply')
            )
        );

        try {

            $reply->save();
            //$reply_id = $reply->getId();

        } catch (Exception $e) {

            echo json_encode( array('success' => false) );
            Mage::logException($e);
            return false;

        }

        $customer = Mage::getSingleton('customer/session')->getCustomer()->getFirstname();
        $timestamp = date('Y-m-d H:i:s');
        $jsReply = nl2br($this->getRequest()->getParam('reply'));
        echo json_encode(
            array(
                'success' => true,
                'customer' => $customer,
                'timestamp' => $timestamp,
                'reply' => $jsReply
            )
        );

    }


    public function preDispatch() {

        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

    }

}