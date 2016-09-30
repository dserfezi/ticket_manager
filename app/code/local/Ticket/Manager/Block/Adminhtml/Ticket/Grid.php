<?php

class Ticket_Manager_Block_Adminhtml_Ticket_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {

        parent::__construct();
        $this->setId('ticket_manager_ticket_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);

    }


    protected function _prepareCollection() {

        $collection = Mage::getResourceModel('ticket_manager/ticket_collection');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;

    }


    protected function _prepareColumns() {

        $helper = Mage::helper('ticket_manager');

        $this->addColumn('entity_id', array(
            'header'    => $helper->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
            'type'  => 'number',
        ));

        $this->addColumn('support_id', array(
            'header' => $helper->__('Support ID'),
            'width'     => '50px',
            'type'   => 'text',
            'index'  => 'support_id'
        ));

        $this->addColumn('customer_id', array(
            'header' => $helper->__('Customer ID'),
            'width'     => '50px',
            'type'   => 'number',
            'index'  => 'customer_id'
        ));

        $this->addColumn('website_id', array(
            'header' => $helper->__('Website ID'),
            'width'     => '50px',
            'type'   => 'number',
            'index'  => 'website_id'
        ));

        $this->addColumn('subject', array(
            'header'   => $helper->__('Subject'),
            'index'    => 'subject',
        ));

        $this->addColumn('message', array(
            'header'   => $helper->__('Message'),
            'type'   => 'text',
            'index'    => 'message',
            'escape' => true
        ));

        $this->addColumn('active', array(
            'header' => $helper->__('Active'),
            'width'     => '50px',
            'type'   => 'options',
            'options' => array(
                '0' => 'No',
                '1' => 'Yes'
            ),
            'index'  => 'active',
            'renderer'  => 'Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Grid_Active'
        ));

        $this->addExportType('*/*/exportTicketCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportTicketExcel', $helper->__('Excel XML'));

        return parent::_prepareColumns();

    }


    protected function _prepareMassaction() {

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('tickets');

        $this->getMassactionBlock()->addItem('close', array(
            'label'    => Mage::helper('ticket_manager')->__('Close'),
            'url'      => $this->getUrl('*/*/massClose'),
            'confirm'  => Mage::helper('ticket_manager')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('ticket_manager')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('ticket_manager')->__('Are you sure?')
        ));

        return $this;

    }


    public function getGridUrl() {

        return $this->getUrl('*/*/grid', array('_current'=>true));

    }


    public function getRowUrl($row) {

        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));

    }

}