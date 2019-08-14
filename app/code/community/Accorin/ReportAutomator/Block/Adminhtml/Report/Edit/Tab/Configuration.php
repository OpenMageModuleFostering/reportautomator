<?php
/**
 * Created by: Marco Segura.
 * Date: 8/6/15
 */

class Accorin_ReportAutomator_Block_Adminhtml_Report_Edit_Tab_Configuration extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('reportautomator_configuration_form', array('legend' => Mage::helper('reportautomator')->__('Report Configuration')));

        $fieldset->addField('template', 'jsoneditor', array(
            'label' => Mage::helper('reportautomator')->__('Report configuration'),
            'index' => 'templatecontrol',
            'name' => 'templatecontrol',
            'style' => 'width: 600px; height:400px',
            'after_element_html' => '<small>JSON structure to handle the report configuration</small>'
        ));

        $fieldset->addField('template_hidden', 'hidden', array(

            'name' => 'template',
        ));

        if (Mage::getSingleton('adminhtml/session')->getEntriesData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getEntriesData());
            Mage::getSingleton('adminhtml/session')->setEntriesData(null);
        } elseif (Mage::registry('entries_data')) {
            $form->setValues(Mage::registry('entries_data')->getData());
        }
        return parent::_prepareForm();
    }
}
