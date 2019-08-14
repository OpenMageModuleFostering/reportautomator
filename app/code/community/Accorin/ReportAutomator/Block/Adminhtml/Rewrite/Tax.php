<?php
/**
 * Created by: Marco Segura.
 * Date: 8/7/15
 */

class Accorin_ReportAutomator_Block_Adminhtml_Rewrite_Tax extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'report_sales_tax';
        $this->_headerText = Mage::helper('reports')->__('Order Taxes Report Grouped by Tax Rate');
        parent::__construct();
        $this->setTemplate('report/grid/container.phtml');
        $this->_removeButton('add');
        $this->addButton('filter_form_submit', array(
            'label'     => Mage::helper('reports')->__('Show Report'),
            'onclick'   => 'filterFormSubmit()'
        ));
        $postBackUrl = $this->getUrl('adminhtml/reportautomator_report/schedule');
        $this->addButton('reportautomator_button', array(
            'label'     => Mage::helper('reports')->__('Schedule this'),
            'onclick'   => "scheduleThis('".$postBackUrl."','2')"
        ));
    }

    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/tax', array('_current' => true));
    }

}