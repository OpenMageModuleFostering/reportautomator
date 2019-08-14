<?php

/**
 * Created by: Marco Segura.
 * Date: 8/6/15
 */
class Accorin_ReportAutomator_Block_Adminhtml_Report_Edit_Tab_Details extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $mainFieldset = $form->addFieldset('reportautomator_details_form', array('legend' => Mage::helper('reportautomator')->__('Report Settings')));

        $mainFieldset->addField('name', 'text', array(
            'label' => Mage::helper('reportautomator')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
            'after_element_html' => '<small>Name of the report.</small>'
        ));

        $mainFieldset->addField('report_id', 'hidden', array(
            'name' => 'report_id',
        ));

        $mainFieldset->addField('entry_id', 'hidden', array(
            'name' => 'entry_id',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $mainFieldset->addField('store_id', 'hidden', array(
                'name' => 'store_id',
            ));
        }

        $mainFieldset->addField('status', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Status'),
            'title' => Mage::helper('reportautomator')->__('Status'),
            'name' => 'status',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('reportautomator')->__('Active'),
                '0' => Mage::helper('reportautomator')->__('Not active'),
            ),
        ));

        $mainFieldset->addField('file_type', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Export to:'),
            'title' => Mage::helper('reportautomator')->__('Export to:'),
            'name' => 'file_type',
            'required' => true,
            'options' => array(
                '0' => Mage::helper('reportautomator')->__('CSV'),
                '1' => Mage::helper('reportautomator')->__('Excel XML'),
            ),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $mainFieldset->addField('store_name', 'label', array(
                'label' => Mage::helper('reportautomator')->__('Store Name'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'store_name',
            ));
        }

        $fieldset = $form->addFieldset('reportautomator_schedule_form', array('legend' => Mage::helper('reportautomator')->__('Schedule Settings')));

        $fieldset->addField('schedule_frequency', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Cron Schedule - Frequency'),
            'title' => Mage::helper('reportautomator')->__('Cron Schedule - Frequency'),
            'required' => false,
            'name' => 'schedule_frequency',
            'options' => array(
                '0' => Mage::helper('reportautomator')->__('Daily'),
                '1' => Mage::helper('reportautomator')->__('Weekly'),
                '2' => Mage::helper('reportautomator')->__('Monthly'),
            ),
            'after_element_html' => '<small>Frequency of the report.</small>',
        ));

        $fieldset->addField('schedule_day', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Cron Schedule - Start date'),
            'title' => Mage::helper('reportautomator')->__('Cron Schedule - Start date'),
            'required' => false,
            'name' => 'schedule_day',
            'options' => array(
                '1' => Mage::helper('reportautomator')->__('1'),
                '2' => Mage::helper('reportautomator')->__('2'),
                '3' => Mage::helper('reportautomator')->__('3'),
                '4' => Mage::helper('reportautomator')->__('4'),
                '5' => Mage::helper('reportautomator')->__('5'),
                '6' => Mage::helper('reportautomator')->__('6'),
                '7' => Mage::helper('reportautomator')->__('7'),
                '8' => Mage::helper('reportautomator')->__('8'),
                '9' => Mage::helper('reportautomator')->__('9'),
                '10' => Mage::helper('reportautomator')->__('10'),
                '11' => Mage::helper('reportautomator')->__('11'),
                '12' => Mage::helper('reportautomator')->__('12'),
                '13' => Mage::helper('reportautomator')->__('13'),
                '14' => Mage::helper('reportautomator')->__('14'),
                '15' => Mage::helper('reportautomator')->__('15'),
                '16' => Mage::helper('reportautomator')->__('16'),
                '17' => Mage::helper('reportautomator')->__('17'),
                '18' => Mage::helper('reportautomator')->__('18'),
                '19' => Mage::helper('reportautomator')->__('19'),
                '20' => Mage::helper('reportautomator')->__('20'),
                '21' => Mage::helper('reportautomator')->__('21'),
                '22' => Mage::helper('reportautomator')->__('22'),
                '23' => Mage::helper('reportautomator')->__('23'),
                '24' => Mage::helper('reportautomator')->__('24'),
                '25' => Mage::helper('reportautomator')->__('25'),
                '26' => Mage::helper('reportautomator')->__('26'),
                '27' => Mage::helper('reportautomator')->__('27'),
                '28' => Mage::helper('reportautomator')->__('28'),
                '29' => Mage::helper('reportautomator')->__('29'),
                '30' => Mage::helper('reportautomator')->__('30'),
            ),
        ));

        $fieldset->addField('schedule_day_week', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Cron Schedule - Week Day'),
            'title' => Mage::helper('reportautomator')->__('Cron Schedule - Week Day'),
            'required' => false,
            'name' => 'schedule_day',
            'options' => array(
                '0' => Mage::helper('reportautomator')->__('Sunday'),
                '1' => Mage::helper('reportautomator')->__('Monday'),
                '2' => Mage::helper('reportautomator')->__('Tuesday'),
                '3' => Mage::helper('reportautomator')->__('Wednesday'),
                '4' => Mage::helper('reportautomator')->__('Thursday'),
                '5' => Mage::helper('reportautomator')->__('Friday'),
                '6' => Mage::helper('reportautomator')->__('Saturday'),
            ),
        ));

        $fieldset->addField('schedule_date_flag', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Active Period time'),
            'title' => Mage::helper('reportautomator')->__('Active Period time'),
            'name' => 'schedule_date_flag',
            'options' => array(
                '0' => Mage::helper('reportautomator')->__('No'),
                '1' => Mage::helper('reportautomator')->__('Yes'),
            ),
            'after_element_html' => '<small class="schedule_date_flag" style="display:block">Set start and end date to the date the report is being run.</small>'
        ));


        if (Mage::getSingleton('adminhtml/session')->getEntriesData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getEntriesData());
            Mage::getSingleton('adminhtml/session')->setEntriesData(null);
        } elseif (Mage::registry('entries_data')) {
            $form->setValues(Mage::registry('entries_data')->getData());
        }
        return parent::_prepareForm();
    }

    protected function _toHtml()
    {
        $dependency_block = $this->getLayout()
            ->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap('schedule_frequency', 'schedule_frequency')
            ->addFieldMap('schedule_day', 'schedule_day')
            ->addFieldMap('schedule_day_week', 'schedule_day_week')
            ->addFieldDependence('schedule_day', 'schedule_frequency', '2')
            ->addFieldDependence('schedule_day_week', 'schedule_frequency', '1');

        return parent::_toHtml() . $dependency_block->toHtml();
    }


}




