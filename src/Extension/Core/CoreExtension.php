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

namespace Rollerworks\Component\Datagrid\Extension\Core;

use Rollerworks\Component\Datagrid\AbstractDatagridExtension;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
class CoreExtension extends AbstractDatagridExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypes(): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return [
            new Type\ColumnType($propertyAccessor),
            new Type\CompoundColumnType(),

            new Type\ActionType(),
            new Type\BatchType(),
            new Type\BooleanType(),
            new Type\DateTimeType(),
            new Type\MoneyType(),
            new Type\NumberType(),
            new Type\TextType(),
        ];
    }
}
