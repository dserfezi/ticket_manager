<?php

class Ticket_Manager_Adminhtml_TicketController extends Mage_Adminhtml_Controller_Action {


    protected function _initTicket($idFieldName = 'id') {

        $this->_title($this->__('Tickets'))->_title($this->__('Manage Tickets'));

        $ticketId = (int) $this->getRequest()->getParam($idFieldName);
        $ticket = Mage::getModel('ticket_manager/ticket');

        if ($ticketId) {
            $ticket->load($ticketId);
        }

        Mage::register('current_ticket', $ticket);
        return $this;

    }


    public function indexAction() {

        $this->_title($this->__('Tickets'))->_title($this->__('Ticket Manager'));
        $this->loadLayout();
        $this->_setActiveMenu('customer/customer');
        $this->_addContent($this->getLayout()->createBlock('ticket_manager/adminhtml_ticket'));
        $this->renderLayout();

    }


    public function gridAction() {

        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('ticket_manager/adminhtml_ticket_grid')->toHtml()
        );

    }


    public function editAction() {

        $this->loadLayout()
            ->_setActiveMenu('customer/ticket_manager_ticket')
            ->_title($this->__('Customer'))->_title($this->__('Ticket Support'))
            ->_addBreadcrumb($this->__('Customer'), $this->__('Customer'))
            ->_addBreadcrumb($this->__('Ticket Support'), $this->__('Ticket Support'));

        $id  = $this->getRequest()->getParam('id');

        if ($id) {
            $ticket = Mage::getModel('ticket_manager/ticket');
            $ticket->load($id);
            if (!$ticket->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This ticket no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
            $this->_title($ticket->getSupportId() ? $ticket->getSupportId() : $this->__('View Ticket'));

            $replies = Mage::getModel('ticket_manager/reply')->getCollection();
            $replies->addFieldToFilter('ticket_id', array('eq' => $id));

            Mage::register('ticket', $ticket);
            Mage::register('replies', $replies);
        }

        $this->_addBreadcrumb($this->__('Edit Ticket'), $this->__('Edit Ticket'))
            ->_addContent($this->getLayout()->createBlock('ticket_manager/adminhtml_ticket_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();

    }


    public function saveAction() {

        if ($postData = $this->getRequest()->getPost()) {
            $reply = Mage::getSingleton('ticket_manager/reply');
            $postData['owner'] = 1;
            $reply->setData($postData);

            try {
                $reply->save();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The ticket has been saved.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving the ticket.'));
            }

            $this->_redirectReferer();
        }

    }


    public function closeAction() {

        if ($id = $this->getRequest()->getParam('id')) {

            $ticket = Mage::getSingleton('ticket_manager/ticket')->load($id);
            $ticket->setData(
                array(
                    'entity_id' => $id,
                    'active' => 0
                )
            );

            try {
                $ticket->save();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The ticket has been closed.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while closing the ticket.'));
            }

            $this->_redirectReferer();

        }

    }


    public function deleteAction() {

        if ($id = $this->getRequest()->getParam('id')) {
            $ticket = Mage::getSingleton('ticket_manager/ticket');

            try {
                $ticket->load($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The ticket has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while deleting the ticket.'));
            }

            $this->_redirectReferer();
        }

    }


    public function exportTicketCsvAction() {

        $fileName = 'ticket_manager.csv';
        $grid = $this->getLayout()->createBlock('ticket_manager/adminhtml_ticket_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());

    }


    public function exportTicketExcelAction() {

        $fileName = 'ticket_manager.xml';
        $grid = $this->getLayout()->createBlock('ticket_manager/adminhtml_ticket_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));

    }


    public function massCloseAction() {

        $ticketsIds = $this->getRequest()->getParam('tickets');
        if(!is_array($ticketsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select ticket(s).'));
        } else {
            try {
                $ticket = Mage::getModel('ticket_manager/ticket');
                foreach ($ticketsIds as $ticketId) {
                    $ticket->reset()->load($ticketId);
                    $ticket->setData('active', 0);
                    $ticket->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were marked as resolved.', count($ticketsIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');

    }


    public function massDeleteAction() {

        $ticketsIds = $this->getRequest()->getParam('tickets');
        if(!is_array($ticketsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select ticket(s).'));
        } else {
            try {
                $ticket = Mage::getModel('ticket_manager/ticket');
                foreach ($ticketsIds as $ticketId) {
                    $ticket->reset()
                        ->load($ticketId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($ticketsIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');

    }







    public function messageAction()
    {
        $data = Mage::getModel('ticket_manager/ticket')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }


    /**
     * Check currently called action by permissions for current user
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('customer/ticket_manager_ticket');
    }

}