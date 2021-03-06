<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */


namespace Magecomp\Gstcharge\Block\Sales\Totals;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magecomp\Gstcharge\Helper\Data as GstHelper;
use Magento\Framework\DataObject;

class ShippingCgstInvoiceTotal extends Template
{
    /**
     * @var \Magecomp\Gstcharge\Helper\Data
     */
    protected $_dataHelper;

    /**
     * @var Order
     */
    protected $_order;

    /**
     * @var \Magento\Framework\DataObject
     */
    protected $_source;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        GstHelper $dataHelper,
        array $data = []
    )
    {
        $this->_dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }

    /**
     * Check if we nedd display full tax total info
     *
     * @return bool
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * Get data (totals) source model
     *
     * @return \Magento\Framework\DataObject
     */
    public function getSource()
    {
        return $this->_source;
    }

    public function getStore()
    {
        return $this->_order->getStore();
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * @return array
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * @return array
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->_order = $parent->getOrder();
        $this->_source = $parent->getSource();
		if(!$this->_source->getShippingCgstCharge() || $this->_source->getShippingCgstCharge() <=0) {
            return $this;
        }
		
		$shippingfee = new DataObject(
            [
                'code' => 'shipping',
                'value' => $this->_source->getShippingAmount(),
                'base_value' => $this->_source->getBaseShippingAmount(),
                'label' => __('Shipping & Handling'),
            ]
        );
	  	$parent->addTotal($shippingfee, 'shipping');
        $fee = new DataObject(
            [
                'code' => 'shipping_cgst_charge',
                'strong' => false,
                'value' => $this->_source->getShippingCgstCharge(),
                'label' => 'Shipping CGST',
            ]
        );

        $parent->addTotal($fee, 'shipping_cgst_charge');

        return $this;
    }

}
