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

namespace Rollerworks\Component\Datagrid\Tests;

use PHPUnit\Framework\TestCase;
use Rollerworks\Component\Datagrid\Exception\InvalidArgumentException;
use Rollerworks\Component\Datagrid\Extension\Core\Type\DateTimeType;
use Rollerworks\Component\Datagrid\PreloadedExtension;
use Rollerworks\Component\Datagrid\Tests\Fixtures\Extension\BarType;
use Rollerworks\Component\Datagrid\Tests\Fixtures\Extension\DateTypeExtension;
use Rollerworks\Component\Datagrid\Tests\Fixtures\Extension\FooType;

final class PreloadedExtensionTest extends TestCase
{
    /**
     * @var PreloadedExtension
     */
    private $extension;

    /** @before */
    public function setExtension()
    {
        $this->extension = new PreloadedExtension(
            [
                'foo' => new FooType(),
                'bar' => new BarType(),
            ],
            [
                DateTimeType::class => [new DateTypeExtension()],
            ]
        );
    }

    /** @test */
    public function it_provides_types()
    {
        self::assertTrue($this->extension->hasType('foo'));
        self::assertTrue($this->extension->hasType('bar'));
        self::assertFalse($this->extension->hasType('bla'));

        self::assertInstanceOf(FooType::class, $this->extension->getType('foo'));
        self::assertInstanceOf(BarType::class, $this->extension->getType('bar'));
    }

    /** @test */
    public function it_provides_types_extensions()
    {
        self::assertTrue($this->extension->hasTypeExtensions(DateTimeType::class));
        self::assertFalse($this->extension->hasTypeExtensions('bla'));

        self::assertEquals([new DateTypeExtension()], $this->extension->getTypeExtensions(DateTimeType::class));
        self::assertEquals([], $this->extension->getTypeExtensions('bar'));
    }

    /** @test */
    public function it_throws_an_exception_when_type_not_is_found()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The column-type "bla" can not be loaded by this extension');

        $this->extension->getType('bla');
    }
}
