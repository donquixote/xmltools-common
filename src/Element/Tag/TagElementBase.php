<?php

namespace Donquixote\XmlTools\Element\Tag;

abstract class TagElementBase implements TagElementInterface {

  /**
   * @var string
   */
  private $tagName;

  /**
   * @var string[]
   */
  private $attributes;

  /**
   * @param string $tagName
   * @param string[] $attributes
   */
  function __construct($tagName, array $attributes) {
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
