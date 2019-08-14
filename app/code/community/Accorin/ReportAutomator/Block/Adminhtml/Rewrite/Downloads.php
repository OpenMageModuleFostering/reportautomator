<?php
/**
 * Created by: Marco Segura.
 * Date: 8/7/15
 */

class Accorin_ReportAutomator_Block_Adminhtml_Rewrite_Downloads extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'report_product_downloads';
        $this->_headerText = Mage::helper('reports')->__('Downloads');
        parent::__construct();
        $this->_removeButton('add');
        $postBackUrl = $this->getUrl('adminhtml/reportautomator_report/schedule');
        $this->addButton('reportautomator_button', array(
            'label'     => Mage::helper('reports')->__('Schedule this'),
            'onclick'   => "scheduleThis('".$postBackUrl."','14')"
        ));

    }

    protected function _prepareLayout()
    {
        $this->setChild('store_switcher',
            $this->getLayout()->createBlock('adminhtml/store_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($this->getUrl('*/*/*', array('store'=>null)))
                ->setTemplate('report/store/switcher.phtml')
        );
        return parent::_prepareLayout();
    }

    public function getStoreSwitcherHtml()
    {
        if (!Mage::app()->isSingleStoreMode()) {
            return $this->getChildHtml('store_switcher');
        }
        return '';
    }

    public function getGridHtml()
    {
        return $this->getStoreSwitcherHtml() . parent::getGridHtml();
    }
}