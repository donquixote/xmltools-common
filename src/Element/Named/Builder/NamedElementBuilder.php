<?php

namespace Donquixote\XmlTools\Element\Named\Builder;

use Donquixote\XmlTools\Element\Attributed\AttributedElementInterface;
use Donquixote\XmlTools\Element\ElementInterface;
use Donquixote\XmlTools\Element\Named\NamedElement;

class NamedElementBuilder {

  /**
   * @var string
   */
  private $tagName;

  /**
   * @var string[]
   */
  private $attributes = array();

  /**
   * @var \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  private $children = array();

  /**
   * @param string $tagName
   */
  function __construct($tagName) {
    $this->tagName = $tagName;
  }

  /**
   * @param string $key
   * @param string $value
   */
  function setAttribute($key, $value) {
    $this->attributes[$key] = $value;
  }

  /**
   * @param \Donquixote\XmlTools\Element\ElementInterface $element
   */
  function addChild(ElementInterface $element) {
    $this->children[] = $element;
  }

  /**
   * @return \Donquixote\XmlTools\Element\Named\NamedElement
   */
  function createElement() {
    return new NamedElement(NULL, $this->tagName, $this->attributes, $this->children);
  }

  /**
   * @param \Donquixote\XmlTools\Element\Attributed\AttributedElementInterface $parentElement
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElement
   */
  function createWithKnownParent(AttributedElementInterface $parentElement) {
    return new NamedElement($parentElement, $this->tagName, $this->attributes, $this->children);
  }

}
