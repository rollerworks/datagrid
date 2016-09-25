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

use Rollerworks\Component\Datagrid\Column\CellView;
use Rollerworks\Component\Datagrid\Column\CompoundColumn;
use Rollerworks\Component\Datagrid\Extension\Core\Type\CompoundColumnType;
use Rollerworks\Component\Datagrid\Extension\Core\Type\NumberType;
use Rollerworks\Component\Datagrid\Extension\Core\Type\TextType;

class CompoundColumnTypeTest extends BaseTypeTest
{
    protected function getTestedType(): string
    {
        return CompoundColumnType::class;
    }

    public function testPassLabelToView()
    {
        /** @var CompoundColumn $rootColumn */
        $rootColumn = $this->factory->createColumn('ids', $this->getTestedType(), ['label' => 'Ids']);
        $column = $this->factory->createColumn(
            'key',
            TextType::class,
            ['label' => 'My label', 'parent_column' => $rootColumn]
        );

        $rootColumn->setColumns(['id' => $column]);
        $datagrid = $this->factory->createDatagrid('grid', [$rootColumn]);

        $object = new \stdClass();
        $object->key = ' foo ';
        $datagrid->setData([1 => $object]);

        $datagridView = $datagrid->createView();
        $view = $rootColumn->createHeaderView($datagridView);

        $this->assertSame('Ids', $view->label);
    }

    public function testSubCellsToView()
    {
        /** @var CompoundColumn $column */
        $column = $this->factory->createColumn('actions', $this->getTestedType(), ['label' => 'Actions']);

        $columns = [];
        $columns['age'] = $this->factory->createColumn('age', NumberType::class, ['parent_column' => $column]);
        $columns['name'] = $this->factory->createColumn('name', TextType::class, ['parent_column' => $column]);

        $column->setColumns($columns);

        $datagrid = $this->factory->createDatagrid('grid', [$column]);

        $object = new \stdClass();
        $object->key = ' foo ';
        $object->name = ' sheldon ';
        $object->age = 42;
        $datagrid->setData([1 => $object]);

        $datagridView = $datagrid->createView();

        $view = $column->createCellView($datagridView, $object, 0);

        $this->assertDatagridCell('age', $view);
        $this->assertDatagridCell('name', $view);

        $this->assertEquals('42', $view->value['age']->value);
        $this->assertEquals(' sheldon ', $view->value['name']->value);
        $this->assertArrayNotHasKey('key', $view->value);
    }

    private function assertDatagridCell($name, CellView $view)
    {
        $this->assertInternalType('array', $view->value);
        $this->assertArrayHasKey($name, $view->value);
        $this->assertInstanceOf(CellView::class, $view->value[$name]);
    }
}
