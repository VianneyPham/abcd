<?php
/**
 * This file is part of PHPPresentation - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPPresentation is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPPresentation/contributors.
 *
 * @see        https://github.com/PHPOffice/PHPPresentation
 *
 * @copyright   2009-2015 PHPPresentation contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpPresentation\Tests\Shape\Chart\Type;

use PhpOffice\PhpPresentation\Shape\Chart\Series;
use PhpOffice\PhpPresentation\Shape\Chart\Type\Doughnut;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Doughnut element.
 *
 * @coversDefaultClass \PhpOffice\PhpPresentation\Shape\Chart\Type\Doughnut
 */
class DoughnutTest extends TestCase
{
    public function testData(): void
    {
        $object = new Doughnut();

        $this->assertIsArray($object->getSeries());
        $this->assertEmpty($object->getSeries());

        $array = [
            new Series(),
            new Series(),
        ];

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Chart\\Type\\Doughnut', $object->setSeries());
        $this->assertEmpty($object->getSeries());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Chart\\Type\\Doughnut', $object->setSeries($array));
        $this->assertCount(count($array), $object->getSeries());
    }

    public function testHoleSize(): void
    {
        $rand = mt_rand(10, 90);
        $object = new Doughnut();

        $this->assertEquals(50, $object->getHoleSize());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Chart\\Type\\Doughnut', $object->setHoleSize(9));
        $this->assertEquals(10, $object->getHoleSize());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Chart\\Type\\Doughnut', $object->setHoleSize(91));
        $this->assertEquals(90, $object->getHoleSize());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Chart\\Type\\Doughnut', $object->setHoleSize($rand));
        $this->assertEquals($rand, $object->getHoleSize());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Chart\\Type\\Doughnut', $object->setHoleSize());
        $this->assertEquals(50, $object->getHoleSize());
    }

    public function testSeries(): void
    {
        $object = new Doughnut();

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Chart\\Type\\Doughnut', $object->addSeries(new Series()));
        $this->assertCount(1, $object->getSeries());
    }

    public function testHashCode(): void
    {
        $oSeries = new Series();

        $object = new Doughnut();
        $object->addSeries($oSeries);

        $this->assertEquals(md5($oSeries->getHashCode() . get_class($object)), $object->getHashCode());
    }
}
