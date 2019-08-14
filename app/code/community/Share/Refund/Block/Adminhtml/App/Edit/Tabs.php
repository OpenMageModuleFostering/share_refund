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
 * Dashboard admin edit tabs
 *
 * @category    Share
 * @package     Share_Refund
 * @author      Ultimate Module Creator
 */
class Share_Refund_Block_Adminhtml_App_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('app_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('share_refund')->__('Dashboard'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Share_Refund_Block_Adminhtml_App_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_app',
            array(
                'label'   => Mage::helper('share_refund')->__('Dashboard'),
                'title'   => Mage::helper('share_refund')->__('Dashboard'),
                'content' => $this->getLayout()->createBlock(
                    'share_refund/adminhtml_app_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve dashboard entity
     *
     * @access public
     * @return Share_Refund_Model_App
     * @author Ultimate Module Creator
     */
    public function getApp()
    {
        return Mage::registry('current_app');
    }
}
