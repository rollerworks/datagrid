<?php

declare(strict_types=1);

/*
 * This file is part of the RollerworksDatagrid package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Datagrid\Tests\Extension\Core\Type;

use Rollerworks\Component\Datagrid\Extension\Core\Type\NumberType;
use Symfony\Component\Intl\Util\IntlTestHelper;

class NumberTypeTest extends BaseTypeTest
{
    protected function setUp()
    {
        parent::setUp();

        // we test against "de_DE", so we need the full implementation
        IntlTestHelper::requireFullIntl($this, '58.1');

        \Locale::setDefault('de_DE');
    }

    protected function getTestedType(): string
    {
        return NumberType::class;
    }

    public function testDefaultFormatting()
    {
        $this->assertCellValueEquals('12345,679', '12345.67890');
    }

    public function testDefaultFormattingWithGrouping()
    {
        $this->assertCellValueEquals('12.345,679', '12345.67890', ['grouping' => true]);
    }

    public function testDefaultFormattingWithPrecision()
    {
        $this->assertCellValueEquals('12345,68', '12345.67890', ['precision' => 2]);
    }

    public function testDefaultFormattingWithRounding()
    {
        $this->assertCellValueEquals(
            '12346',
            '12345.54321',
            ['precision' => 0, 'rounding_mode' => \NumberFormatter::ROUND_UP]
        );
    }
}
