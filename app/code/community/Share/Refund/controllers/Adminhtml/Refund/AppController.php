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
 * Dashboard admin controller
 *
 * @category    Share
 * @package     Share_Refund
 * @author      Ultimate Module Creator
 */
class Share_Refund_Adminhtml_Refund_AppController extends Share_Refund_Controller_Adminhtml_Refund
{
    /**
     * init the dashboard
     *
     * @access protected
     * @return Share_Refund_Model_App
     */
    protected function _initApp()
    {
        $appId  = (int) $this->getRequest()->getParam('id');
        $app    = Mage::getModel('share_refund/app');
        if ($appId) {
            $app->load($appId);
        }
        Mage::register('current_app', $app);
        return $app;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('share_refund')->__('Share a Refund'));
        $this->renderLayout();
    }

    /**
     * help action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function helpAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('share_refund')->__('Help'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit dashboard - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $appId    = $this->getRequest()->getParam('id');
        $app      = $this->_initApp();
        if ($appId && !$app->getId()) {
            $this->_getSession()->addError(
                Mage::helper('share_refund')->__('This dashboard no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getAppData(true);
        if (!empty($data)) {
            $app->setData($data);
        }
        Mage::register('app_data', $app);
        $this->loadLayout();
        $this->_title(Mage::helper('share_refund')->__('Share a Refund'))
             ->_title(Mage::helper('share_refund')->__('Dashboard'));
        if ($app->getId()) {
            $this->_title($app->getName());
        } else {
            $this->_title(Mage::helper('share_refund')->__('Add dashboard'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new dashboard action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save dashboard - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('app')) {
            try {
                $app = $this->_initApp();
                $app->addData($data);
                $app->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('share_refund')->__('Dashboard was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $app->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setAppData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('share_refund')->__('There was a problem saving the dashboard.')
                );
                Mage::getSingleton('adminhtml/session')->setAppData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('share_refund')->__('Unable to find dashboard to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete dashboard - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $app = Mage::getModel('share_refund/app');
                $app->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('share_refund')->__('Dashboard was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('share_refund')->__('There was an error deleting dashboard.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('share_refund')->__('Could not find dashboard to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete dashboard - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $appIds = $this->getRequest()->getParam('app');
        if (!is_array($appIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('share_refund')->__('Please select dashboard to delete.')
            );
        } else {
            try {
                foreach ($appIds as $appId) {
                    $app = Mage::getModel('share_refund/app');
                    $app->setId($appId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('share_refund')->__('Total of %d dashboard were successfully deleted.', count($appIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('share_refund')->__('There was an error deleting dashboard.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $appIds = $this->getRequest()->getParam('app');
        if (!is_array($appIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('share_refund')->__('Please select dashboard.')
            );
        } else {
            try {
                foreach ($appIds as $appId) {
                $app = Mage::getSingleton('share_refund/app')->load($appId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d dashboard were successfully updated.', count($appIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('share_refund')->__('There was an error updating dashboard.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'app.csv';
        $content    = $this->getLayout()->createBlock('share_refund/adminhtml_app_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'app.xls';
        $content    = $this->getLayout()->createBlock('share_refund/adminhtml_app_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'app.xml';
        $content    = $this->getLayout()->createBlock('share_refund/adminhtml_app_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('share_refund/app');
    }
}
