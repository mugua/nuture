<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Quickview
 */
namespace Amasty\Quickview\Plugin\Product;

class ProductsList
{
    /**
     * @var \Amasty\Quickview\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    public function __construct(
        \Amasty\Quickview\Helper\Data $helper,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        $this->_helper = $helper;
        $this->layoutFactory = $layoutFactory;
    }

    public function afterToHtml(
        \Magento\CatalogWidget\Block\Product\ProductsList $subject,
        $result
    ) {
        $enable = $this->_helper->getModuleConfig('general/enable');

        if ( $enable ) {
            $layout = $this->layoutFactory->create();
            $block = $layout->createBlock(
                'Amasty\Quickview\Block\Config',
                'amasty.cart.config',
                [ 'data' => [] ]
            );

            $html = $block->setPageType('widget')->toHtml();
            $result .= $html;
        }

        return  $result;
    }
}
