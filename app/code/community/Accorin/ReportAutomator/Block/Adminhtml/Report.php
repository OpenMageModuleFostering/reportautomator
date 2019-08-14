<?php
/**
 * Created by PhpStorm.
 * User: marcosegura
 */

class Accorin_ReportAutomator_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'reportautomator';
        $this->_controller = 'adminhtml_report';
        $this->_headerText = Mage::helper('reportautomator')->__('Report Automator');
        parent::__construct();
        $this->_removeButton('add');
    }

}