<?php

/**
 * Created by: Marco Segura.
 * Date: 8/14/15
 */
class Accorin_ReportAutomator_Block_Adminhtml_Report_Edit_Tab_History extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('history_grid');
        $this->_blockGroup = 'reportautomator';
        $this->_controller = 'adminhtml_history';
        $this->setDefaultSort('last_executed', 'desc');
        $this->setSaveParametersInSession(false);
        $this->setUseAjax(true);
    }

    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/history', array('_current' => true));
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('reportautomator/log')->getCollection()
            ->addFieldToFilter('entry_id', Mage::registry('entries_data')->getId());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('status_log', array(
            'header' => Mage::helper('reportautomator')->__('Status'),
            'index' => 'status_log',
            'type' => 'options',
            'options' => array(
                0 => 'Success',
                1 => "Failed"
            )
        ));

        $this->addColumn('result', array(
            'header' => Mage::helper('reportautomator')->__('Result Message'),
            'index' => 'result',
            'type' => 'text',
        ));

        $this->addColumn('last_executed', array(
            'header' => Mage::helper('reportautomator')->__('Last executed'),
            'type' => 'datetime',
            'index' => 'last_executed',
            'width' => '150px',
        ));

        return parent::_prepareColumns();
    }


}
