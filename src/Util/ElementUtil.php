<?php

namespace Donquixote\XmlTools\Util;

use Donquixote\XmlTools\Element\Named\NamedElementInterface;
use Donquixote\XmlTools\Element\Other\OtherElementInterface;
use Donquixote\XmlTools\Element\Text\TextElementInterface;

final class ElementUtil {

  /**
   * Private constructor to prevent instantiation.
   */
  private function __construct() {}

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string $tagName
   * @param string $kk
   * @param string $vk
   *
   * @return string[]
   *   Format: $[$key] = '..'
   */
  static function elementChildrenAsKeyValue(NamedElementInterface $element, $tagName, $kk, $vk) {
    $values = array();
    foreach ($element->getChildrenWithName($tagName) as $child) {
      if (1
        and NULL !== $key = $child->getAttributeValue($kk)
        and NULL !== $value = $child->getAttributeValue($vk)
      ) {
        $values[$key] = $value;
      }
    }
    return $values;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string $tagName
   * @param string $vk
   *
   * @return string[]
   *   Format: $[] = $value
   */
  static function elementChildrenAsAttributeValue(NamedElementInterface $element, $tagName, $vk) {
    $values = array();
    foreach ($element->getNamedChildren() as $child) {
      if ($tagName === $child->getTagName()) {
        if (NULL !== $value = $child->getAttributeValue($vk)) {
          $values[] = $value;
        }
      }
    }
    return $values;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[][]
   *   Format: $[$childElement->getTagName()][] = $childElement
   */
  static function elementChildrenByTagName(NamedElementInterface $element) {
    $children = array();
    foreach ($element->getNamedChildren() as $child) {
      $children[$child->getTagName()][] = $child;
    }
    return $children;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   *
   * @return string
   */
  static function elementGetText(NamedElementInterface $element) {
    $text = '';
    foreach ($element->getChildren() as $child) {
      if ($child instanceof TextElementInterface) {
        $text .= $child->getText();
      }
      elseif ($child instanceof NamedElementInterface) {
        $text .= self::elementGetText($child);
      }
    }
    return $text;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface[] $elements
   *
   * @return mixed[][]
   */
  static function simplifyElements(array $elements) {
    $result = array();
    foreach ($elements as $i => $element) {
      $result['+ ' . $element->getTagName() . ' #' . $i] = self::simplifyElement($element);
    }
    return $result;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   *
   * @return mixed[]
   */
  static function simplifyElement(NamedElementInterface $element) {
    $simplified = array();
    foreach ($element->getAttributes() as $k => $v) {
      $simplified['# ' . $k] = $v;
    }
    $simplified += self::simplifyElements($element->getChildren());
    return $simplified;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface[] $elements
   *
   * @return string[]
   */
  static function pathifyKeyedElements(array $elements) {
    $pathified = array();
    foreach ($elements as $prefix => $child) {
      foreach (self::pathifyElement($child) as $k => $v) {
        $pathified[$prefix . $k] = $v;
      }
    }
    return $pathified;
  }

  /**
   * @param \Donquixote\XmlTools\Element\ElementInterface[] $elements
   *
   * @return string[]
   */
  static function pathifyElements(array $elements) {
    $pathified = array();
    $keyCount = array();
    foreach ($elements as $i => $element) {
      if ($element instanceof TextElementInterface) {
        if ('' === trim($element->getText())) {
          continue;
        }
        $prefix = '/#text';
        $vv = array('' => $element->getText());
      }
      elseif ($element instanceof NamedElementInterface) {
        $prefix = '/' . $element->getTagName();
        $vv = self::pathifyElement($element);
      }
      elseif ($element instanceof OtherElementInterface) {
        $prefix = '/#xml';
        $vv = array('' => $element->getXml());
      }
      else {
        continue;
      }
      if (!array_key_exists($prefix, $keyCount)) {
        $keyCount[$prefix] = 0;
      }
      else {
        ++$keyCount[$prefix];
        $prefix .= '(' . $keyCount[$prefix] . ')';
      }
      foreach ($vv as $k => $v) {
        $pathified[$prefix . $k] = $v;
      }
    }
    return $pathified;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   *
   * @return string[]
   */
  static function pathifyElement(NamedElementInterface $element) {
    $pathified = array();
    foreach ($element->getAttributes() as $prefix => $v) {
      $pathified['[' . $prefix . ']'] = $v;
    }
    $pathified += self::pathifyElements($element->getChildren());
    return $pathified;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string $xpath
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  static function elementDescendantsWithXPath(NamedElementInterface $element, $xpath) {
    if ('' === $xpath) {
      return array('' => $element);
    }
    if ('/' === $xpath[0]) {
      throw new \InvalidArgumentException('$xpath may not begin with a slash.');
    }
    $trail = explode('/', $xpath);
    if (in_array('', $trail, TRUE)) {
      throw new \InvalidArgumentException('$xpath may not contain empty fragments.');
    }
    return self::elementDescendantsWithTrail($element, $trail);
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string[] $trail
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  static function elementDescendantsWithTrail(NamedElementInterface $element, array $trail) {
    $tagName = array_shift($trail);
    if (array() === $trail) {
      return $element->getChildrenWithName($tagName);
    }
    $descendants = array();
    foreach ($element->getChildrenWithName($tagName) as $i => $child) {
      foreach (self::elementDescendantsWithTrail($child, $trail) as $suffix => $leafElement) {
        if (!$leafElement instanceof NamedElementInterface) {
          throw new \RuntimeException('Expected to find named element.');
        }
        $descendants[$i . '/' . $suffix] = $leafElement;
      }
    }
    return $descendants;
  }

  /**
   * @param object $object
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string[] $keys
   */
  static function objectPropertiesFromAttributes($object, NamedElementInterface $element, array $keys) {
    foreach (self::elementGetAttributeValues($element, $keys) as $k => $v) {
      $object->$k = $v;
    }
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string[] $keys
   *
   * @return string[]
   */
  static function elementGetAttributeValues(NamedElementInterface $element, array $keys) {
    $result = array();
    $attributes = $element->getAttributes();
    foreach ($keys as $k) {
      $result[$k] = array_key_exists($k, $attributes)
        ? $attributes[$k]
        : NULL;
    }
    return $result;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string $xpath
   * @param string $valueAttrName
   * @param string $conditionAttrName
   * @param string $conditionValue
   *
   * @return null|string
   */
  static function elementPickDescendantValue(NamedElementInterface $element, $xpath, $valueAttrName, $conditionAttrName, $conditionValue) {
    foreach (self::elementDescendantsWithXPath($element, $xpath) as $child) {
      if ($conditionValue === $child->getAttributeValue($conditionAttrName)) {
        return $child->getAttributeValue($valueAttrName);
      }
    }
    return NULL;
  }

  /**
   * @param \Donquixote\XmlTools\Element\Named\NamedElementInterface $element
   * @param string $xpath
   * @param string $conditionAttrName
   * @param string $conditionValue
   *
   * @return null|string
   */
  static function elementPickDescendentText(NamedElementInterface $element, $xpath, $conditionAttrName, $conditionValue) {
    foreach (self::elementDescendantsWithXPath($element, $xpath) as $child) {
      if ($conditionValue === $child->getAttributeValue($conditionAttrName)) {
        return self::elementGetText($child);
      }
    }
    return NULL;
  }

}
