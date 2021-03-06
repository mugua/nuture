<?php
/**
 * Webinse
 *
 * PHP Version 5.6.23
 *
 * @category    Webinse
 * @package     Webinse_Barcode
 * @author      Webinse Team <info@webinse.com>
 * @copyright   2017 Webinse Ltd. (https://www.webinse.com)
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0
 */
/**
 * Delete action for the List of generated barcodes.
 *
 * @category    Webinse
 * @package     Webinse_Barcode
 * @author      Webinse Team <info@webinse.com>
 * @copyright   2017 Webinse Ltd. (https://www.webinse.com)
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0
 */

namespace Webinse\Barcode\Controller\Adminhtml\Generator;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Webinse\Barcode\Model\Generator;

class Delete extends Action
{
    /** @var $_modelGenerator */
    protected $_modelGenerator;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param Generator $modelGenerator
     */
    public function __construct(Action\Context $context, Generator $modelGenerator)
    {
        parent::__construct($context);
        $this->_modelGenerator = $modelGenerator;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_modelGenerator;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The barcode has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a barcode to delete.'));
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webinse_Barcode::delete');
    }
}