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
 * Dashboard edit form tab
 *
 * @category    Share
 * @package     Share_Refund
 * @author      Ultimate Module Creator
 */
class Share_Refund_Block_Adminhtml_App_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Share_Refund_Block_Adminhtml_App_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('app_');
        $form->setFieldNameSuffix('app');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'app_form',
            array('legend' => Mage::helper('share_refund')->__('Dashboard'))
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('share_refund')->__('Name'),
                'name'  => 'name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('share_refund')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('share_refund')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('share_refund')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_app')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getAppData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getAppData());
            Mage::getSingleton('adminhtml/session')->setAppData(null);
        } elseif (Mage::registry('current_app')) {
            $formValues = array_merge($formValues, Mage::registry('current_app')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
