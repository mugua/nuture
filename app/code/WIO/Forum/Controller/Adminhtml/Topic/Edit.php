<?php

/**
 * webideaonline.com.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://webideaonline.com/licensing/
 *
 */

namespace WIO\Forum\Controller\Adminhtml\Topic;

class Edit extends \WIO\Forum\Controller\Adminhtml\Index {

  public function execute() {
    // 1. Get ID and create model
    $id = $this->getRequest()->getParam('topic_id');

    $model = $this->_objectManager->create('WIO\Forum\Model\Topic');

    // 2. Initial checking
    if ($id) {
      $model->load($id);
      if (!$model->getId()) {
        $this->messageManager->addError(__('This topic no longer exists.'));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
      }
    }
    // 3. Set entered data if was error when we do save
    $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
    if (!empty($data)) {
      $model->setData($data);
    }

    // 4. Register model to use later in blocks
    $this->_coreRegistry->register('topic_model', $model);

    /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
    $resultPage = $this->resultPageFactory->create();

    // 5. Build edit form
    $this->initPageForum($resultPage)->addBreadcrumb(
            $id ? __('Edit Topic') : __('New Topic'), $id ? __('Edit Topic') : __('New Topic')
    );
    $resultPage->getConfig()->getTitle()->prepend(__('Topics'));
    $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Topic'));
    return $resultPage;
  }

}
