<?php

/*
 * This file is part of the Symfony Azri Breadcrumb Bundle.
 *
 * @author Bilel Azri    <azri.bilel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 * Azri Breadcrumb Bundle (c) 2023.
 */

declare(strict_types=1);

namespace Azri\BreadcrumbBundle\Tests\Model;

use Azri\BreadcrumbBundle\Model\Breadcrumb;
use Azri\BreadcrumbBundle\Model\BreadcrumbCollection;
use PHPUnit\Framework\TestCase;

/**
 * BreadcrumbCollectionTest.
 *
 * Test array logic of collection
 */
class BreadcrumbCollectionTest extends TestCase
{
    /**
     * Test normal adding of breadcrumbs.
     */
    public function testAddBreadcrumb(): void
    {
        $breadcrumbA = new Breadcrumb('foo', 'bar');
        $breadcrumbB = new Breadcrumb('bar', 'baz');

        $expected = [$breadcrumbA, $breadcrumbB];

        $collection = new BreadcrumbCollection();
        $collection->addBreadcrumb($breadcrumbA)->addBreadcrumb($breadcrumbB);

        $this->assertEquals($expected, $collection->getAll());
    }

    /**
     * Test adding of breadcrumb before another known one.
     */
    public function testAddBeforeCrumb(): void
    {
        $breadcrumbA = new Breadcrumb('foo', 'bar');
        $breadcrumbB = new Breadcrumb('bar', 'baz');
        $breadcrumbC = new Breadcrumb('baz', 'qux');

        $expected = [$breadcrumbA, $breadcrumbB, $breadcrumbC];

        $collection = new BreadcrumbCollection();
        $collection->addBreadcrumb($breadcrumbA)->addBreadcrumb($breadcrumbC);

        $collection->addBreadcrumbBeforeCrumb($breadcrumbB, $breadcrumbC);

        $this->assertEquals($expected, $collection->getAll());
    }

    /**
     * Test adding of breadcrumb after another known one.
     */
    public function testAddAfterCrumb(): void
    {
        $breadcrumbA = new Breadcrumb('foo', 'bar');
        $breadcrumbB = new Breadcrumb('bar', 'baz');
        $breadcrumbC = new Breadcrumb('baz', 'qux');

        $expected = [$breadcrumbA, $breadcrumbC, $breadcrumbB];

        $collection = new BreadcrumbCollection();
        $collection->addBreadcrumb($breadcrumbA)->addBreadcrumb($breadcrumbC);

        $collection->addBreadcrumbAfterCrumb($breadcrumbB, $breadcrumbC);

        $this->assertEquals($expected, $collection->getAll());
    }

    /**
     * Test adding of breadcrumb to the very start.
     */
    public function testAddBreadcrumbToStart(): void
    {
        $breadcrumbA = new Breadcrumb('foo', 'bar');
        $breadcrumbB = new Breadcrumb('bar', 'baz');
        $breadcrumbC = new Breadcrumb('baz', 'qux');

        $expected = [$breadcrumbC, $breadcrumbA, $breadcrumbB];

        $collection = new BreadcrumbCollection();
        $collection->addBreadcrumb($breadcrumbA)->addBreadcrumb($breadcrumbB);

        $collection->addBreadcrumbToStart($breadcrumbC);

        $this->assertEquals($expected, $collection->getAll());
    }

    /**
     * Test getting a breadcrumb by a known route.
     */
    public function testGetBreadcrumbByRoute(): void
    {
        $breadcrumbA = new Breadcrumb('foo', 'bar');
        $breadcrumbB = new Breadcrumb('bar', 'baz');
        $breadcrumbC = new Breadcrumb('baz', 'qux');

        $collection = new BreadcrumbCollection();
        $collection->addBreadcrumb($breadcrumbA)->addBreadcrumb($breadcrumbB)->addBreadcrumb($breadcrumbC);

        $this->assertEquals($breadcrumbB, $collection->getBreadcrumbByRoute('baz'));
        $this->assertEquals($breadcrumbA, $collection->getBreadcrumbByRoute('bar'));
    }

    /**
     * Test throwing of exception if a breadcrumb doesn't exist.
     */
    public function testAddAfterBreadcrumbExceptionException(): void
    {
        $breadcrumbA = new Breadcrumb('foo', 'bar');
        $breadcrumbB = new Breadcrumb('bar', 'baz');

        $collection = new BreadcrumbCollection();

        $this->expectException('\InvalidArgumentException');

        $collection->addBreadcrumbAfterCrumb($breadcrumbA, $breadcrumbB);
    }
}
