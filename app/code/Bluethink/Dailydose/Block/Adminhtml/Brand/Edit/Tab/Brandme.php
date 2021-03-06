<?php
namespace Bluethink\Dailydose\Block\Adminhtml\Brand\Edit\Tab;
use Bluethink\Dailydose\Model\Config\Source\Brand;
class Brandme extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
    * @var \Bluethink\Trainingdiscount\Model\System\Config\Status
    */
     protected $_brand;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        Brand $brand,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        $this->_brand =$brand;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
		/* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('dailydose_brand');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Dailydose Brand')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }
        $fieldset->addField(
            'brand_name',
            'select',
            array(
                'name' => 'brand_name',
                'label' => __('brand_name'),
                'title' => __('brand_name'),
                'values'   => $this->_brand->toOptionArray(),
            )
        );
        $fieldset->addField(
            'brand_url',
            'text',
            array(
                'name' => 'brand_url',
                'label' => __('brand_url'),
                'title' => __('brand_url')
            )
        );
        $fieldset->addField(
            'image',
            'image',
            
            array(
                'name' => 'image',
                'label' => __('Brand Image'),
                'title' => __('Brand Image'),
                'required' => true
            )
            );
        
        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '2' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();   
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Dailydose Brand');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Dailydose Brand');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
