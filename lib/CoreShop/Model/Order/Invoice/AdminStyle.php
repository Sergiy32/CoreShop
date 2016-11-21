<?php
/**
 * CoreShop.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2016 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Model\Order\Invoice;

use CoreShop\Model\Order\Invoice;

/**
 * Class AdminStyle
 * @package CoreShop\Model\Order\Invoice\Item
 */
class AdminStyle extends \Pimcore\Model\Element\AdminStyle
{
    /**
     * AdminStyle constructor.
     *
     * @param $element
     */
    public function __construct($element)
    {
        parent::__construct($element);

        if ($element instanceof Invoice) {
            $this->elementIconClass = 'coreshop_icon_orders_invoice';
        }
    }
}
