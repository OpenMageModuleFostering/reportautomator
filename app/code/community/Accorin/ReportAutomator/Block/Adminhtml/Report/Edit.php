<?php

/**
 * Created by PhpStorm.
 * User: marcosegura
 */
class Accorin_ReportAutomator_Block_Adminhtml_Report_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'reportautomator';
        $this->_controller = 'adminhtml_report';
        $this->_headerText = Mage::helper('reportautomator')->__('Report Automators');
        /*$this->_updateButton('delete', 'label', Mage::helper('confattr')->__('Delete Configurable Attribute'));
        $this->_removeButton('save');
        $this->_removeButton('reset');*/
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('entries_data') && Mage::registry('entries_data')->getId()) {
            return Mage::helper('reportautomator')->__("%s - Report Automator", $this->htmlEscape(Mage::registry('entries_data')->getName()));
        } else {
            return Mage::helper('reportautomator')->__('Report Configuration');
        }
    }
}