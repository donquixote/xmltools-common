<?php

namespace Donquixote\XmlTools\Util;

use Donquixote\XmlTools\Element\Tree\TreeElement;
use Donquixote\XmlTools\Element\Tree\TreeElement_NoChildren;
use Donquixote\XmlTools\Element\Other\OtherElement;
use Donquixote\XmlTools\Element\Pivot\PivotElement;
use Donquixote\XmlTools\Element\Pivot\PivotElement_NoChildren;
use Donquixote\XmlTools\Element\Text\TextElement;
use Donquixote\XmlTools\Element\Trail\TrailElement;
use Donquixote\XmlTools\Element\Trail\TrailElementInterface;

final class XmlReaderUtil {

  private function __construct() {}

  /**
   * @param string $file
   * @param string[] $expectedTrail
   *
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface|null
   */
  static function fileReadElement($file, array $expectedTrail) {
    if (NULL === $xmlReader = self::openFile($file)) {
      return NULL;
    }
    if (FALSE === $trailElement = self::readUntilTrail($xmlReader, $expectedTrail)) {
      return NULL;
    }
    return $trailElement;
  }

  /**
   * @param string $file
   *
   * @return \XMLReader|null
   */
  static function openFile($file) {
    if (!is_file($file)) {
      return NULL;
    }
    $xmlReader = new \XMLReader();
    $success = $xmlReader->open($file, NULL, LIBXML_NOWARNING | LIBXML_NOERROR);
    if (!$success) {
      return NULL;
    }
    return $xmlReader;
  }

  /**
   * @param \XMLReader $xmlReader
   *   XML reader, starting at the beginning of the file, or at $trailElement.
   * @param string[] $expectedTrail
   * @param \Donquixote\XmlTools\Element\Trail\TrailElementInterface|null $trailElement
   *   The previous trail element, or
   *   NULL, if at the beginning of the file.
   *
   * @return \Donquixote\XmlTools\Element\Pivot\PivotElementInterface|false
   *   The element with the specified trail, in case of success. Or
   *   FALSE, if $xmlReader has run to EOF without success.
   */
  static function readUntilTrail(\XMLReader $xmlReader, array $expectedTrail, TrailElementInterface $trailElement = NULL) {
    $trailTagNames = array();
    if (NULL !== $trailElement) {
      $trailTagNames = $expectedTrail;
    }
    # $trailElements = array();
    /** @var \Donquixote\XmlTools\Element\Trail\TrailElementInterface|null $trailElement */
    while ($xmlReader->read()) {
      while (count($trailTagNames) > $xmlReader->depth) {
        array_pop($trailTagNames);
        # array_pop($trailElements);
        if (NULL === $trailElement) {
          throw new \RuntimeException('Reached root element, cannot go further.');
        }
        $trailElement = $trailElement->getParentOrNull();
      }
      if (\XMLReader::END_ELEMENT === $xmlReader->nodeType) {
        continue;
      }
      if ('#text' === $xmlReader->name) {
        // We are not interested in text nodes on this level.
        continue;
      }
      $trailTagNames[] = $xmlReader->name;
      $tagName = $xmlReader->name;
      $isEmpty = $xmlReader->isEmptyElement;
      $attributes = self::readElementAttributes($xmlReader);
      if ($expectedTrail === $trailTagNames) {
        if ($isEmpty) {
          $trailElement = new PivotElement_NoChildren($trailElement, $tagName, $attributes);
        }
        else {
          $children = self::readChildren($xmlReader);
          $trailElement = new PivotElement($trailElement, $tagName, $attributes, $children);
        }
        return $trailElement;
      }
      else {
        $trailElement = new TrailElement($trailElement, $tagName, $attributes);
      }
    }
    return FALSE;
  }

  /**
   * @param \XMLReader $xmlReader
   *
   * @return \Donquixote\XmlTools\Element\ElementInterface[]
   */
  static function readChildren(\XMLReader $xmlReader) {
    /** @var \Donquixote\XmlTools\Element\ElementInterface[] $elements */
    $elements = array();
    while ($xmlReader->read()) {
      if (\XMLReader::END_ELEMENT === $xmlReader->nodeType) {
        break;
      }
      if ('#text' === $xmlReader->name) {
        $elements[] = new TextElement($xmlReader->readString());
      }
      elseif (\XMLReader::ELEMENT === $xmlReader->nodeType) {
        $tagName = $xmlReader->name;
        $attributes = self::readElementAttributes($xmlReader);
        if ($xmlReader->isEmptyElement) {
          $elements[] = new TreeElement_NoChildren($tagName, $attributes);
        }
        else {
          $children = self::readChildren($xmlReader);
          $elements[] = new TreeElement($tagName, $attributes, $children);
        }
      }
      else {
        // Remember the node type, because it might change on readOuterXml().
        $nodeType = $xmlReader->nodeType;
        $elements[] = new OtherElement($xmlReader->readOuterXml(), $nodeType);
      }
    }
    return $elements;
  }

  /**
   * @param \XMLReader $xmlReader
   *   Start position should be on the opening tag.
   *   Final position will be on the last attribute, if any.
   *
   * @return string[]
   */
  static function readElementAttributes(\XMLReader $xmlReader) {
    if (!$xmlReader->moveToFirstAttribute()) {
      return array();
    }

    $attributes = array();
    do {
      $attributes[$xmlReader->name] = $xmlReader->value;
    } while ($xmlReader->moveToNextAttribute());

    return $attributes;
  }

  /**
   * @param string $file
   * @param string[] $expectedTrail
   *
   * @return int
   *
   * @throws \Exception
   */
  static function fileCountElements($file, array $expectedTrail) {
    $uri = '.gz' === substr($file, -3)
      ? 'compress.zlib://' . $file
      : $file;
    $xmlReader = new \XMLReader();
    $success = $xmlReader->open($uri);
    if (!$success) {
      throw new \RuntimeException("Failed to open '$uri'.");
    }

    # $t0 = microtime(TRUE);
    $n = 0;
    $trail = array();
    while ($xmlReader->read()) {
      while (count($trail) > $xmlReader->depth) {
        array_pop($trail);
      }
      if (\XMLReader::END_ELEMENT === $xmlReader->nodeType) {
        continue;
      }
      if ('#text' === $xmlReader->name) {
        // We are not interested in text nodes on this level.
        continue;
      }
      $trail[] = $xmlReader->name;
      if ($expectedTrail === $trail) {
        # if (0 === $n % 500) {
          # $tsince = (microtime(TRUE) - $t0);
          # print "<pre>n = $n: $tsince seconds (XmlReaderUtil)</pre>\n";
        # }
        ++$n;
      }
    }

    return $n;
  }

}
