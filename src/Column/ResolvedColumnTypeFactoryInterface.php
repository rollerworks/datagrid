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

namespace Rollerworks\Component\Datagrid\Column;

use Rollerworks\Component\Datagrid\Exception\InvalidArgumentException;

/**
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
interface ResolvedColumnTypeFactoryInterface
{
    /**
     * Resolves a column type.
     *
     * @param ColumnTypeInterface         $type
     * @param array                       $typeExtensions
     * @param ResolvedColumnTypeInterface $parent
     *
     * @throws InvalidArgumentException if the types parent can not be retrieved from any extension
     *
     * @return ResolvedColumnTypeInterface
     */
    public function createResolvedType(ColumnTypeInterface $type, array $typeExtensions, ResolvedColumnTypeInterface $parent = null): ResolvedColumnTypeInterface;
}
