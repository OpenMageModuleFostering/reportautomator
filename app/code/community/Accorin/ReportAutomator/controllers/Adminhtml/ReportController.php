<?php

/**
 * Created by PhpStorm.
 * User: marcosegura
 */
class Accorin_ReportAutomator_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
        //Zend_Debug::dump($this->getLayout()->getUpdate()->getHandles());
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('system/reportautomator')
            ->_addBreadcrumb(Mage::helper('reportautomator')->__('Report Automators'), Mage::helper('reportautomator')->__('Report Automators'));
        return $this;
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('accorin_reportautomator_adminhtml/report_grid')->toHtml());
        $this->renderLayout();
    }

    public function editAction()
    {
        $EntryId = $this->getRequest()->getParam('id');
        $ReportId = $this->getRequest()->getParam('report_id');
        $template = $this->getRequest()->getParam('template');
        $store_id = $this->getRequest()->getParam('website');
        $entryModel = Mage::getModel('reportautomator/entries')->load($EntryId);

        if ($ReportId) {
            $entryCollection = Mage::getModel('reportautomator/entries')->getCollection();
            foreach ($entryCollection as $entries) {
                if ($ReportId == $entries->getReportId() AND $store_id == $entries->getStoreId())
                    $entryModel = $entries;
            }

            if (empty($entryModel->getData())) {
                $entryModel->setData("report_id", $ReportId);
                $reportModel = Mage::getModel('reportautomator/report')->load($ReportId);
                $entryModel->setData("name", $reportModel->getName());
                if ($template)
                    $entryModel->setData("template", $template);
            }
        }

        if ($entryModel->getId() || $EntryId == 0) {
            $entryModel->setData('schedule_day_week', $entryModel->getData('schedule_day'));
            if ($store_id) {
                $nameStore = Mage::getModel('core/store')->load($store_id)->getName();
                $entryModel->setData('store_id', $store_id);
            } else
                $nameStore = Mage::getModel('core/store')->load($entryModel->getData('store_id'))->getName();

            if (!$nameStore)
                $nameStore = "All Websites";

            $entryModel->setData('store_name', $nameStore);

            Mage::register('entries_data', $entryModel);

            $this->loadLayout();
            $this->_setActiveMenu('system/reportautomator');

            $this->_addBreadcrumb(Mage::helper('reportautomator')->__('Report Automators'), Mage::helper('reportautomator')->__('Report Automators'));
            $this->_addBreadcrumb(Mage::helper('reportautomator')->__('Report Automators'), Mage::helper('reportautomator')->__('Report Automators'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('reportautomator/adminhtml_report_edit'))
                ->_addLeft($this->getLayout()->createBlock('reportautomator/adminhtml_report_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('reportautomator')->__('Report entry does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function scheduleAction()
    {
        $this->_forward('edit');
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function historyAction()
    {
        $logId = $this->getRequest()->getParam('id');
        $logModel = Mage::getModel('reportautomator/log')->load($logId);


        Mage::register('entries_data', $logModel);

        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('reportautomator/adminhtml_report_edit_tab_history')->toHtml()
        );
    }


    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $EntryModel = Mage::getModel('reportautomator/entries');
                $EntryModel->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Report Automator was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }


    public function saveAction()
    {
        if ($this->getRequest()->getPost()) {
            try {
                $postData = $this->getRequest()->getPost();
                $entryModel = Mage::getModel('reportautomator/entries');

                $id = $this->getRequest()->getParam('id');
                if (empty($postData['entry_id']))
                    unset($postData['entry_id']);

                $entryModel->setData($postData);

                if ($id)
                    $entryModel->setEntryId($id);
                try {
                    $entryModel->save();
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Report entry was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setEntryData(false);
                } catch (Exception $ex) {
                    $this->_redirect('*/*/');
                    return;
                }

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFlowData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }


}