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

namespace CoreShop\Bundle\CoreBundle\Fixtures\Data\Demo;

use CoreShop\Bundle\FixtureBundle\Fixture\VersionedFixtureInterface;
use CoreShop\Component\Taxation\Model\TaxRuleGroupInterface;
use CoreShop\Component\Core\Model\TaxRuleInterface;
use CoreShop\Component\Taxation\Calculator\TaxCalculatorInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TaxRuleGroupFixture extends AbstractFixture implements ContainerAwareInterface, VersionedFixtureInterface, DependentFixtureInterface
{
    private ?ContainerInterface $container;

    public function getVersion(): string
    {
        return '2.0';
    }

    public function setContainer(ContainerInterface $container = null): void
    {
        $this->container = $container;
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            TaxRateFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        if (!count($this->container->get('coreshop.repository.tax_rule_group')->findAll())) {
            /**
             * @var TaxRuleGroupInterface $taxRuleGroup
             */
            $taxRuleGroup = $this->container->get('coreshop.factory.tax_rule_group')->createNew();
            $taxRuleGroup->setName('AT');
            $taxRuleGroup->setActive(true);

            /**
             * @var TaxRuleInterface $taxRule
             */
            $taxRule = $this->container->get('coreshop.factory.tax_rule')->createNew();
            $taxRule->setCountry($this->container->get('coreshop.repository.country')->findByCode('AT'));
            $taxRule->setTaxRate($this->getReference('taxRate'));
            $taxRule->setTaxRuleGroup($taxRuleGroup);
            $taxRule->setBehavior(TaxCalculatorInterface::DISABLE_METHOD);

            $manager->persist($taxRuleGroup);
            $manager->persist($taxRule);
            $manager->flush();

            $this->setReference('taxRule', $taxRuleGroup);
        }
    }
}
