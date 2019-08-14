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
 * Dashboard admin edit form
 *
 * @category    Share
 * @package     Share_Refund
 * @author      Ultimate Module Creator
 */
class Share_Refund_Block_Adminhtml_App_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        parent::__construct();
        $this->_blockGroup = 'share_refund';
        $this->_controller = 'adminhtml_app';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('share_refund')->__('Save Dashboard')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('share_refund')->__('Delete Dashboard')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('share_refund')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_app') && Mage::registry('current_app')->getId()) {
            return Mage::helper('share_refund')->__(
                "Edit Dashboard '%s'",
                $this->escapeHtml(Mage::registry('current_app')->getName())
            );
        } else {
            return Mage::helper('share_refund')->__('Add Dashboard');
        }
    }
}
