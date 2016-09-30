<?php

class Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Form_Textview
    extends Varien_Data_Form_Element_Abstract {

    protected $_element;

    public function getElementHtml() {

        $_elementValue = $this->getValue();

        $html = '<hr><div style="text-align:right;">';
        $html .= $_elementValue;
        $html .= '</div>';

        return $html;

    }

}