<?php
/**
 * Created by PhpStorm.
 * User: marcosegura
 */

class Accorin_ReportAutomator_Model_Mysql4_Report extends Mage_Core_Model_Mysql4_Abstract
{

    protected function _construct()
    {
        $this->_init('reportautomator/report', 'report_id');
    }

}