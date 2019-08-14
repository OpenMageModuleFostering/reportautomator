<?php
/**
 * Created by: Marco Segura.
 * Date: 8/6/15
 */

class Accorin_ReportAutomator_Block_Adminhtml_Report_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('report_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('reportautomator')->__('Report Configuration'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_details_tab', array(
            'label' => Mage::helper('reportautomator')->__('Details'),
            'title' => Mage::helper('reportautomator')->__('Details'),
            'content' => $this->getLayout()->createBlock('reportautomator/adminhtml_report_edit_tab_details')->toHtml(),
        ));

        $this->addTab('form_connection_tab', array(
            'label' => Mage::helper('reportautomator')->__('Connection'),
            'title' => Mage::helper('reportautomator')->__('Connection'),
            'content' => $this->getLayout()->createBlock('reportautomator/adminhtml_report_edit_tab_connection')->toHtml(),
        ));

        $this->addTab('form_configuration_tab', array(
            'label' => Mage::helper('reportautomator')->__('Configuration'),
            'title' => Mage::helper('reportautomator')->__('Configuration'),
            'content' => $this->getLayout()->createBlock('reportautomator/adminhtml_report_edit_tab_configuration')->toHtml(),
        ));

        $this->addTab('form_history_log', array(
            'label' => Mage::helper('reportautomator')->__('History Logs'),
            'title' => Mage::helper('reportautomator')->__('History Logs'),
            'content' => $this->getLayout()->createBlock('reportautomator/adminhtml_report_edit_tab_history')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}