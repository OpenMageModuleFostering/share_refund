<?php
/**
 * Share_Refund extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Share
 * @package        Share_Refund
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Dashboard resource model
 *
 * @category    Share
 * @package     Share_Refund
 * @author      Ultimate Module Creator
 */
class Share_Refund_Model_Resource_App extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        $this->_init('share_refund/app', 'entity_id');
    }
}
