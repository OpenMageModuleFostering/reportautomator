<?php

/**
 * Created by: Marco Segura.
 * Date: 8/7/15
 */
class Accorin_ReportAutomator_Model_Observer extends Mage_Core_Model_Abstract
{

    protected $week = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

    public function sendReport()
    {

        $EntryCollection = Mage::getModel('reportautomator/entries')->getCollection();

        foreach ($EntryCollection as $entry) {
            if ($entry->getStatus()) {
                $schedule = $this->validateSchedule($entry);
                if ($schedule) {
                    $this->sendProtocol($entry);
                }
            }
        }
    }

    public function validateSchedule($entry)
    {
        switch ($entry->getScheduleFrequency()) {
            case 0:
                return true;
                break;
            case 1:
                $weekDay = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m"), date("d"), date("Y")), 1);
                if ($this->week[$entry->getScheduleDay()] == $weekDay)
                    return true;
                else
                    return false;
                break;
            case 2:
                if (date('j') == $entry->getScheduleDay())
                    return true;
                else
                    return false;
                break;
        }
        return false;
    }

    public function sendProtocol($entry)
    {
        $reportModel = Mage::getModel('reportautomator/report')->load($entry->getReportId());
        if ($reportModel->getId()) {
            $content = $this->getDownloadFile($entry, $reportModel->getBlock());
            if ($entry->getOutputId() == 0) {
                /*Email Protocol*/
                $this->sendMail($content['value'], $entry->getEmailArray(), $reportModel->getName(), $entry->getFileType(), $entry->getId());
            } else {
                /*FTP Protocol*/
                $this->sendFTP($entry, $content['value']);
            }
            unlink($content['value']);

        }
        return false;
    }

    public function getDownloadFile($entry, $block)
    {
        try {
            $controller = Mage::getControllerInstance('Mage_Adminhtml_Controller_Action', Mage::app()->getRequest(), Mage::app()->getResponse());
            $controller->getRequest()->setParam('website', $entry->getStoreId());
            $controller->getRequest()->setParam('store_ids', $entry->getStoreId());
            $layout = $controller->getLayout();
            if ($entry->getTemplate() == '{}') {
                $content = $layout->createBlock($block);
                if ($entry->getFileType() == 0)
                    $content = $content->getCsvFile();
                else
                    $content = $content->getExcelFile();
            } else {
                $content = $layout->createBlock($block);
                $param = json_decode($entry->getTemplate());
                $params = new Varien_Object();

                if (!is_array($content)) {
                    $content = array($content);
                }

                foreach ($param as $key => $value) {
                    if (!empty($value)) {
                        if (is_array($value))
                            $value = array(implode(",", $value));
                        if ($key == 'from' || $key == 'to')
                            $value = date("Y-m-d", strtotime($value));
                        $params->setData($key, $value);
                    }
                }

                if ($entry->getScheduleDateFlag())
                    $params = $this->setRangeDates($entry, $params);

                foreach ($content as $cont) {
                    if ($cont) {
                        $cont->setPeriodType($params->getData('period_type'));
                        $cont->setFilterData($params);
                        if ($entry->getFileType() == 0)
                            $content = $cont->getCsvFile();
                        else
                            $content = $cont->getExcelFile();
                    }
                }
            }

            return $content;
        } catch (Exception $e) {
            Mage::log($e->getMessage());
        }

    }

    public function setRangeDates($entry, $params)
    {

        switch ($entry->getScheduleFrequency()) {
            case 0:
                $params->setData('to', date('Y-m-d'));
                $params->setData('from', date('Y-m-d'));
                break;
            case 1:
                $params->setData('from', date('Y-m-d'));
                $params->setData('to', date('Y-m-d', strtotime('-7 days')));
                break;
            case 2:
                $params->setData('from', date('Y-m-d'));
                $params->setData('to', date('Y-m-d', strtotime('-30 days')));
                break;
        }
        return $params;
    }

    public function sendMail($file, $receipts, $subject, $fileType, $entryId)
    {
        $mail = new Zend_Mail('utf-8');
        $receipts = explode(',', $receipts);

        if (!empty($receipts)) {
            $mailBody = "Report Automator - Report name: " . $subject . " - Date: " . date('Y-m-d');
            $mail->setBodyHtml($mailBody)
                ->setSubject("Report Automator - Report name: " . $subject . " - Date: " . date('Y-m-d'))
                ->addTo($receipts)
                ->setFrom(Mage::getStoreConfig('trans_email/ident_general/email'), "Report Automator");

            $name = str_replace(" ", "_", $subject);
            try {
                $attachment = file_get_contents($file);
                if ($fileType == 0)
                    $name = $name . ".csv";
                else
                    $name = $name . ".xml";
                $mail->createAttachment(
                    $attachment,
                    Zend_Mime::TYPE_OCTETSTREAM,
                    Zend_Mime::DISPOSITION_ATTACHMENT,
                    Zend_Mime::ENCODING_BASE64,
                    $name
                );

                $mail->send();
                $this->saveLogs(0, $entryId, 'Report has been sent to email(s): ' . implode(',', $receipts));
            } catch (Exception $e) {
                $this->saveLogs(1, $entryId, 'Report has failed, error message: ' . $e->getMessage());
                Mage::log($e, Zend_Log::NOTICE, 'reportautomator.log');
            }
        }
    }

    public function sendFTP($entry, $file)
    {
        if ($entry->getFtpIsPassive())
            $isPassive = true;
        else
            $isPassive = false;

        try {
            $connectionId = ftp_connect($entry->getFtpHost());
            $loginResult = ftp_login($connectionId, $entry->getFtpUser(), $entry->getFtpPass());
            ftp_pasv($connectionId, $isPassive);

            // *** Check connection
            if ((!$connectionId) || (!$loginResult)) {
                Mage::log('FTP connection has failed!. Attempted to connect to ' . $entry->getFtpHost() . ' for user ' . $entry->getFtpUser(), Zend_Log::NOTICE, "reportautomator.log");
                return false;
            } else {
                // *** Upload the file
                $upload = ftp_put($connectionId, $entry->getFtpRemoteFile(), $file, FTP_ASCII);
                if (!$upload) {
                    Mage::log('FTP upload has failed!', Zend_Log::NOTICE, "reportautomator.log");
                    return false;
                } else
                    $this->saveLogs(0, $entry->getId(), 'FTP upload has sent report successfully');
            }
        } catch (Exception $e) {
            $this->saveLogs(1, $entry->getId(), 'Report has failed, error message: ' . $e->getMessage());
            Mage::log($e, Zend_Log::NOTICE, 'reportautomator.log');
        }
    }

    public function saveLogs($status, $entry_id, $result)
    {

        $model = Mage::getModel('reportautomator/log');
        $postData = array(
            'entry_id' => $entry_id,
            'status_log' => $status,
            'result' => $result
        );
        $model->setData($postData);
        $model->save();
    }
}