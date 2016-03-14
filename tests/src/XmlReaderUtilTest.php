<?php

namespace Donquixote\XmlTools\Tests;

use Donquixote\XmlTools\Element\Named\NamedElement;
use Donquixote\XmlTools\Element\Text\TextElement;
use Donquixote\XmlTools\Util\XmlReaderUtil;

class XmlReaderUtilTest extends \PHPUnit_Framework_TestCase {

  function testReadAttributes() {

    $file = dirname(__DIR__) . '/fixtures/example.xml';
    if (NULL === $xmlReader = XmlReaderUtil::openFile($file)) {
      static::fail('Unable to open example.xml file.');
      return;
    }

    $xmlReader->read();
    static::assertSame('EXAMPLE-interface', $xmlReader->name);
    static::assertSame(\XMLReader::DOC_TYPE, $xmlReader->nodeType);
    $xmlReader->read();
    static::assertSame('#comment', $xmlReader->name);
    $xmlReader->read();
    static::assertSame('EXAMPLE-interface', $xmlReader->name);
    $xmlReader->read();
    static::assertSame('#text', $xmlReader->name);
    $xmlReader->read();
    static::assertSame('Response', $xmlReader->name);

    $attributes = XmlReaderUtil::readElementAttributes($xmlReader);
    static::assertSame(
      array (
        'Date' => 'Tue Feb 16 23:00:01 2016',
        'ID' => '0',
        'Request_ID' => '12345',
        'Status' => '1',
      ),
      $attributes);

    // $xmlReader is on the last attribute node.
    static::assertSame('Status', $xmlReader->name);

    $xmlReader->read();
    static::assertSame('#text', $xmlReader->name);
    $xmlReader->read();
    static::assertSame('ExampleDataList', $xmlReader->name);

    $attributes = XmlReaderUtil::readElementAttributes($xmlReader);
    static::assertSame(
      array(),
      $attributes);

    $xmlReader->read();
    static::assertSame('#text', $xmlReader->name);
    $xmlReader->read();
    static::assertSame('ExampleData', $xmlReader->name);

    $attributes = XmlReaderUtil::readElementAttributes($xmlReader);
    static::assertSame(
      array(
        'ID' => '1',
        'type' => 'numeric',
        'Updated' => '2015-12-08 11:38:14',
        'measure_id' => '24',
      ),
      $attributes);

    $children = XmlReaderUtil::readChildren($xmlReader);

    static::assertInstanceOf(TextElement::class, $children[0]);
    static::assertInstanceOf(NamedElement::class, $children[1]);
    static::assertInstanceOf(TextElement::class, $children[2]);
    
    $child = $children[1];
    if (!$child instanceof NamedElement) {
      static::fail('Unexpected element class.');
      return;
    }
    static::assertSame('Names', $child->getTagName());
  }

  function testReadUntilTrail() {

    $file = dirname(__DIR__) . '/fixtures/example.xml';
    if (NULL === $xmlReader = XmlReaderUtil::openFile($file)) {
      static::fail('Unable to open example.xml file.');
      return;
    }
    static::assertSame(0, $xmlReader->depth);

    $expectedTrail = array('EXAMPLE-interface', 'Response', 'ExampleDataList', 'ExampleData');
    if (FALSE === $trailElement = XmlReaderUtil::readUntilTrail($xmlReader, $expectedTrail)) {
      static::fail('Unable to read first trail element in example.xml file');
      return;
    }

    // Check $trailElement
    static::assertSame('ExampleData', $trailElement->getTagName());
    static::assertSame('ExampleDataList', $trailElement->getParentIfKnown()->getTagName());
    static::assertSame('Response', $trailElement->getParentIfKnown()->getParentIfKnown()->getTagName());
    static::assertSame('EXAMPLE-interface', $trailElement->getParentIfKnown()->getParentIfKnown()->getParentIfKnown()->getTagName());
    static::assertNull($trailElement->getParentIfKnown()->getParentIfKnown()->getParentIfKnown()->getParentIfKnown());
    static::assertSame(
      array(
        'ID' => '1',
        'type' => 'numeric',
        'Updated' => '2015-12-08 11:38:14',
        'measure_id' => '24',
      ),
      $trailElement->getAttributes());

    // Check status of $xmlReader
    static::assertSame('ExampleData', $xmlReader->name);
    static::assertSame(\XMLReader::END_ELEMENT, $xmlReader->nodeType);
    static::assertSame(3, $xmlReader->depth);

    if (FALSE === $trailElement = XmlReaderUtil::readUntilTrail($xmlReader, $expectedTrail, $trailElement)) {
      static::fail('Unable to read second trail element in example.xml file');
      return;
    }

    static::assertSame('ExampleData', $trailElement->getTagName());
    static::assertSame('ExampleDataList', $trailElement->getParentIfKnown()->getTagName());
    static::assertSame('Response', $trailElement->getParentIfKnown()->getParentIfKnown()->getTagName());
    static::assertSame('EXAMPLE-interface', $trailElement->getParentIfKnown()->getParentIfKnown()->getParentIfKnown()->getTagName());
    static::assertNull($trailElement->getParentIfKnown()->getParentIfKnown()->getParentIfKnown()->getParentIfKnown());
    static::assertSame(
      array(
        'ID' => '2',
        'type' => 'numeric',
        'Updated' => '2015-12-08 11:38:17',
        'measure_id' => '24',
      ),
      $trailElement->getAttributes());
  }

}
