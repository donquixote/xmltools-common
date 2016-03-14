<?php

namespace Donquixote\XmlTools\Element\Attributed;

use Donquixote\XmlTools\Element\ElementBase;

class AttributedElementBase extends ElementBase implements AttributedElementInterface {

  /**
   * @var string
   */
  private $tagName;

  /**
   * @var string[]
   */
  private $attributes;

  /**
   * @param \Donquixote\XmlTools\Element\Attributed\AttributedElementInterface $parentIfKnown
   * @param string $tagName
   * @param string[] $attributes
   */
  function __construct(AttributedElementInterface $parentIfKnown = NULL, $tagName, array $attributes) {
    parent::__construct($parentIfKnown);
    $this->tagName = $tagName;
    $this->attributes = $attributes;
  }

  /**
   * @return string
   */
  function getTagName() {
    return $this->tagName;
  }

  /**
   * @return string[]
   *   Format: $[$attributeName] = $attributeValue
   */
  function getAttributes() {
    return $this->attributes;
  }

  /**
   * @param string $name
   *
   * @return string|null
   */
  function getAttributeValue($name) {
    return array_key_exists($name, $this->attributes)
      ? $this->attributes[$name]
      : NULL;
  }

}
