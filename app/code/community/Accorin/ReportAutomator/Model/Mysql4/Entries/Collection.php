<?php
/**
 * Created by PhpStorm.
 * User: marcosegura
 */

class Accorin_ReportAutomator_Model_Mysql4_Entries_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('reportautomator/entries');
    }

}