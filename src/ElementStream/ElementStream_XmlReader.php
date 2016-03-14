<?php

namespace Donquixote\XmlTools\ElementStream;

use Donquixote\XmlTools\Util\XmlReaderUtil;

class ElementStream_XmlReader implements ElementStreamInterface {

  /**
   * @var \XMLReader
   */
  private $xmlReader;

  /**
   * @var string[]
   */
  private $expectedTrail;

  /**
   * @var \Donquixote\XmlTools\Element\Tree\TreeElementInterface|null|false
   *   The last element that was returned with getElement(), or
   *   NULL, if getElement() was not called yet, or
   *   FALSE, for eof.
   *   
   */
  private $element;

  /**
   * @param string $file
   * @param string[] $expectedTrail
   *
   * @return \Donquixote\XmlTools\ElementStream\ElementStreamInterface
   */
  static function startWithFile($file, array $expectedTrail) {
    $uri = '.gz' === substr($file, -3)
      ? 'compress.zlib://' . $file
      : $file;
    return self::start($uri, $expectedTrail);
  }

  /**
   * @param string $uri
   * @param string[] $expectedTrail
   *
   * @return \Donquixote\XmlTools\ElementStream\ElementStreamInterface
   */
  static function start($uri, array $expectedTrail) {
    $xmlReader = new \XMLReader();
    $success = $xmlReader->open($uri);
    if (!$success) {
      throw new \RuntimeException("Failed to open '$uri'.");
    }
    return new self($xmlReader, $expectedTrail);
  }

  /**
   * @param \XMLReader $xmlReader
   * @param string[] $expectedTrail
   */
  private function __construct(\XMLReader $xmlReader, array $expectedTrail) {
    $this->xmlReader = $xmlReader;
    $this->expectedTrail = $expectedTrail;
  }

  /**
   * Gets the next element, or false on eof.
   *
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface|false
   *
   * @throws \Donquixote\DataStream\Exception\StreamFetchException
   */
  function getElement() {

    if (FALSE === $this->element) {
      return FALSE;
    }

    // Read the current element/node.
    return $this->element = XmlReaderUtil::readUntilTrail($this->xmlReader, $this->expectedTrail, $this->element);
  }
}
