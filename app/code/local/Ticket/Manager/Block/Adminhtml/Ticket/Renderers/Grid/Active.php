<?php

class Ticket_Manager_Block_Adminhtml_Ticket_Renderers_Grid_Active
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {


    /**
     * @param Varien_Object $row
     * @return $value string
     */
    public function render(Varien_Object $row) {

        $active = $row->getData($this->getColumn()->getIndex());

        if($active) {
            $value = 'Yes';
        } else {
            $value = 'No';
        }

        return $value;

    }

}