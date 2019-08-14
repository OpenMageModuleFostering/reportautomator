<?php
/**
 * Created by: Marco Segura.
 * Date: 8/7/15
 */

class Accorin_ReportAutomator_Block_Adminhtml_Rewrite_Accounts extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'report_customer_accounts';
        $this->_headerText = Mage::helper('reports')->__('New Accounts');
        parent::__construct();
        $this->_removeButton('add');

        $postBackUrl = $this->getUrl('reportautomator/adminhtml_report/schedule');
        $this->addButton('reportautomator_button', array(
            'label'     => Mage::helper('reports')->__('Schedule this'),
            'onclick'   => "scheduleThis('".$postBackUrl."','15')"
        ));
    }


}