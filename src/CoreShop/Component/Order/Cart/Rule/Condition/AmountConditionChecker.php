<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Component\Order\Cart\Rule\Condition;

use CoreShop\Component\Order\Model\OrderInterface;
use CoreShop\Component\Order\Model\CartPriceRuleInterface;
use CoreShop\Component\Order\Model\CartPriceRuleVoucherCodeInterface;

class AmountConditionChecker extends AbstractConditionChecker
{
    public function isCartRuleValid(OrderInterface $cart, CartPriceRuleInterface $cartPriceRule, ?CartPriceRuleVoucherCodeInterface $voucher, array $configuration): bool
    {
        if ($configuration['minAmount'] > 0) {
            $minAmount = $configuration['minAmount'];

            $cartTotal = $cart->getSubtotal();

            if ($minAmount > $cartTotal) {
                return false;
            }
        }

        if ($configuration['maxAmount'] > 0) {
            $maxAmount = $configuration['maxAmount'];

            $cartTotal = $cart->getSubtotal();

            if ($maxAmount < $cartTotal) {
                return false;
            }
        }

        return true;
    }
}
