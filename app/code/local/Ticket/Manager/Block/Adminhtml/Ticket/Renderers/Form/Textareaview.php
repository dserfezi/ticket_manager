<?php

class Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Form_Textareaview
    extends Varien_Data_Form_Element_Abstract {

    protected $_element;

    public function getElementHtml() {

        $_elementValue = $this->getValue();

        $html = '<span>';
        $html .= nl2br(Mage::helper('core')->quoteEscape($_elementValue));
        $html .= '</span>';

        return $html;

    }

}