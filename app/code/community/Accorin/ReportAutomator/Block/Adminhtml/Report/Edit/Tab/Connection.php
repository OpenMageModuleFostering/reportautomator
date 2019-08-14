<?php

/**
 * Created by: Marco Segura.
 * Date: 8/6/15
 */
class Accorin_ReportAutomator_Block_Adminhtml_Report_Edit_Tab_Connection extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('reportautomator_connection_form', array('legend' => Mage::helper('reportautomator')->__('Report connection')));

        $fieldset->addField('output_id', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Output type option'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'output_id',
            'after_element_html' => '<small>Select the outbound type</small>',
            'options' => array(
                '0' => Mage::helper('reportautomator')->__('Email'),
                '1' => Mage::helper('reportautomator')->__('FTP'),
            ),
        ));

        $fieldset->addField('email_array', 'textarea', array(
            'label' => Mage::helper('reportautomator')->__('Collection of emails'),
            'title' => Mage::helper('reportautomator')->__('Collection of emails'),
            'name' => 'email_array',
            'class' => 'required-entry',
            'required' => true,
            'after_element_html' => '<small>Separate the emails by comma ","</small>',
        ));

        $fieldset->addField('ftp_host', 'text', array(
            'label' => Mage::helper('reportautomator')->__('Host'),
            'title' => Mage::helper('reportautomator')->__('Host'),
            'name' => 'ftp_host',
            'required' => true,
            'after_element_html' => '<small>FTP server host</small>',
        ));

        $fieldset->addField('ftp_user', 'text', array(
            'label' => Mage::helper('reportautomator')->__('Username'),
            'title' => Mage::helper('reportautomator')->__('Username'),
            'name' => 'ftp_user',
            'class' => 'required-entry',
            'required' => true,
            'after_element_html' => '<small>FTP server username</small>',
        ));

        $fieldset->addField('ftp_pass', 'password', array(
            'label' => Mage::helper('reportautomator')->__('Password'),
            'title' => Mage::helper('reportautomator')->__('Password'),
            'name' => 'ftp_pass',
            'class' => 'required-entry',
            'required' => true,
            'after_element_html' => '<small>FTP server password</small>',
        ));

        $fieldset->addField('ftp_remote_file', 'text', array(
            'label' => Mage::helper('reportautomator')->__('Remote file'),
            'title' => Mage::helper('reportautomator')->__('Remote file'),
            'class' => 'required-entry',
            'name' => 'ftp_remote_file',
            'required' => true,
            'after_element_html' => '<small>The remote file to be generated.</small>',
        ));

        $fieldset->addField('ftp_is_passive', 'select', array(
            'label' => Mage::helper('reportautomator')->__('Passive mode'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'ftp_is_passive',
            'options' => array(
                '0' => Mage::helper('reportautomator')->__('False'),
                '1' => Mage::helper('reportautomator')->__('True'),
            ),
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
            ->addFieldMap('output_id', 'output_id')
            ->addFieldMap('email_array', 'email_array')
            ->addFieldMap('ftp_host', 'ftp_host')
            ->addFieldMap('ftp_user', 'ftp_user')
            ->addFieldMap('ftp_pass', 'ftp_pass')
            ->addFieldMap('ftp_remote_file', 'ftp_remote_file')
            ->addFieldMap('ftp_is_passive', 'ftp_is_passive')
            ->addFieldDependence('email_array', 'output_id', '0')
            ->addFieldDependence('ftp_host', 'output_id', '1')
            ->addFieldDependence('ftp_user', 'output_id', '1')
            ->addFieldDependence('ftp_pass', 'output_id', '1')
            ->addFieldDependence('ftp_remote_file', 'output_id', '1')
            ->addFieldDependence('ftp_is_passive', 'output_id', '1')
        ;

        return parent::_toHtml() . $dependency_block->toHtml();
    }

}




