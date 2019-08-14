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
 * Dashboard admin block
 *
 * @category    Share
 * @package     Share_Refund
 * @author      Ultimate Module Creator
 */
class Share_Refund_Block_Adminhtml_App extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        $this->_controller         = 'adminhtml_app';
        $this->_blockGroup         = 'share_refund';
        parent::__construct();
        $this->_headerText         = Mage::helper('share_refund')->__('Dashboard');
        $this->_updateButton('add', 'label', Mage::helper('share_refund')->__('Add Dashboard'));

    }
}
