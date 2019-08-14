<?php

/**
 * Created by PhpStorm.
 * User: marcosegura
 */
class Accorin_ReportAutomator_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('reportGrid');
        $this->setDefaultSort('entry_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setSubReportSize(false);
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getEntryId()));
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('reportautomator/entries')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entry_id', array(
            'header' => Mage::helper('reportautomator')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entry_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('reportautomator')->__('Name'),
            'align' => 'left',
            'sortable' => true,
            'type' => 'text',
            'default' => '--',
            'index' => 'name'
        ));

        $this->addColumn('schedule_frequency', array(
            'header' => Mage::helper('reportautomator')->__('Schedule'),
            'align' => 'left',
            'type' => 'options',
            'width' => '150px',
            'index' => 'schedule_frequency',
            'options' => array(
                '0' => Mage::helper('reportautomator')->__('Daily'),
                '1' => Mage::helper('reportautomator')->__('Weekly'),
                '2' => Mage::helper('reportautomator')->__('Monthly'),
            ),
        ));

        $this->addColumn('output_id', array(
            'header' => Mage::helper('reportautomator')->__('Output Type'),
            'align' => 'left',
            'type' => 'options',
            'width' => '120px',
            'index' => 'output_id',
            'options'   => array(
                '0' => Mage::helper('reportautomator')->__('Email'),
                '1' => Mage::helper('reportautomator')->__('FTP'),
            )
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('newsletter')->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'width' => '120px',
            'options'   => array(
                0   => Mage::helper('reportautomator')->__('Not active'),
                1   => Mage::helper('reportautomator')->__('Active'),
            )
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'index' => 'store_id',
                'header' => Mage::helper('reportautomator')->__('Store View'),
                'type' => 'options',
                'width' => '120px',
                'options' => $this->getStores(),
            ));
        }

        $this->addColumn('created', array(
            'header' => Mage::helper('reportautomator')->__('Created At'),
            'align' => 'left',
            'type' => 'date',
            'default' => '--',
            'index' => 'created',
        ));


        return parent::_prepareColumns();
    }

    protected function getStores()
    {
        $store_array = Mage::getModel('core/store')->getCollection()->toOptionHash();
        $store_array[0] = 'All Websites';
        return $store_array;
    }


}