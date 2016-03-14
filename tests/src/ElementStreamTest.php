<?php

namespace Donquixote\XmlTools\Tests;

use Donquixote\XmlTools\Element\Tree\TreeElement;
use Donquixote\XmlTools\Element\Text\TextElement;
use Donquixote\XmlTools\ElementStream\Provider\ElementStreamProvider_XmlReader;

class ElementStreamTest extends \PHPUnit_Framework_TestCase {
  
  function testElementStream() {

    $provider = new ElementStreamProvider_XmlReader(
      dirname(__DIR__) . '/fixtures/example.xml',
      array('EXAMPLE-interface', 'Response', 'ExampleDataList', 'ExampleData'));

    $stream = $provider->getElementStream();

    // Fetch 1st element.
    if (FALSE === $element = $stream->getElement()) {
      static::fail('Missing 1st element.');
      return;
    }
    static::assertSame('ExampleData', $element->getTagName());
    static::assertSame('1', $element->getAttributeValue('ID'));

    // Fetch 2nd element.
    if (FALSE === $element = $stream->getElement()) {
      static::fail('Missing 2nd element.');
      return;
    }
    static::assertSame('ExampleData', $element->getTagName());
    static::assertSame('2', $element->getAttributeValue('ID'));

    // Fetch 3nd element.
    if (FALSE === $element = $stream->getElement()) {
      static::fail('Missing 3rd element.');
      return;
    }
    static::assertSame('ExampleData', $element->getTagName());
    static::assertSame('3', $element->getAttributeValue('ID'));

    static::assertSame('ExampleDataList', $element->getParentOrNull()->getTagName());
    static::assertSame('Response', $element->getParentOrNull()->getParentOrNull()->getTagName());
    static::assertSame('EXAMPLE-interface', $element->getParentOrNull()->getParentOrNull()->getParentOrNull()->getTagName());
    static::assertNull($element->getParentOrNull()->getParentOrNull()->getParentOrNull()->getParentOrNull());

    $children = $element->getChildren();

    static::assertInstanceOf(TextElement::class, $children[0]);
    static::assertInstanceOf(TreeElement::class, $children[1]);
    static::assertInstanceOf(TextElement::class, $children[2]);
    /** @var \Donquixote\XmlTools\Element\Tree\TreeElementInterface $child */
    $child = $children[1];
    static::assertSame('Names', $child->getTagName());
    static::assertSame(array(), $child->getAttributes());

    $children = $child->getChildren();

    static::assertInstanceOf(TextElement::class, $children[0]);
    static::assertInstanceOf(TreeElement::class, $children[1]);
    static::assertInstanceOf(TextElement::class, $children[2]);
    /** @var \Donquixote\XmlTools\Element\Tree\TreeElementInterface $child */
    $child = $children[1];
    static::assertSame('Name', $child->getTagName());
    static::assertSame(array('langid' => '0'), $child->getAttributes());

    // Attempt to fetch 4th element.
    if (FALSE !== $stream->getElement()) {
      static::fail('Unexpectedly found a 4th element.');
      return;
    }
  }

}
