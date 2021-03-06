/**
 * Plumrocket Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket Product Filter v3.x.x
 * @copyright   Copyright (c) 2016 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */

define([
    'jquery',
    "Plumrocket_ProductFilter/js/model/drag",
    "Plumrocket_ProductFilter/js/model/jsonGenerator",
    "domReady!"
], function($,drag, jsonGenerator){
    "use strict";


    $.widget('productfilter.filteroptions', {

        _create: function() {
            jsonGenerator.init(this.options);
            drag.init(this.options);
        }
    });

    return $.productfilter.filteroptions;
});
