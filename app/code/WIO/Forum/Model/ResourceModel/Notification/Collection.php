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

namespace WIO\Forum\Model\ResourceModel\Notification;

use \WIO\Forum\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection {

  /**
   * @var string
   */
  protected $_idFieldName = 'notify_id';

  /**
   * Define resource model
   *
   * @return void
   */
  protected function _construct() {
    $this->_init('WIO\Forum\Model\Notification', 'WIO\Forum\Model\ResourceModel\Notification');
    /* $this->_map['fields']['store'] = 'store_table.store_id'; */
  }

  public function loadByCustomerTopic($topicId, $customerId) {
    $select = $this->getSelect();
    $select->where('system_user_id=?', $customerId);
    $select->where('topic_id=?', $topicId);
    return $this;
  }
  
  public function getNotifyCustomers($topicId, $customerId) {
    $select = $this->getSelect();
    $select->where('system_user_id != ?', $customerId);
    $select->where('topic_id = ?', $topicId);
    return $this;
  }
}
