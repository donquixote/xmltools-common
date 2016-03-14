<?php

namespace Donquixote\XmlTools\Element\Named;

use Donquixote\XmlTools\Element\Attributed\AttributedElementBase;
use Donquixote\XmlTools\Element\Attributed\AttributedElementInterface;

class NamedElement extends AttributedElementBase implements NamedElementInterface {

  /**
   * @var \Donquixote\XmlTools\Element\ElementInterface[]
   */
  private $children;

  /**
   * @var \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   *   Format: $[] = $childElement
   */
  private $namedChildren = array();

  /**
   * @var \Donquixote\XmlTools\Element\Named\NamedElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  private $namedChildrenByName = array();

  /**
   * @param \Donquixote\XmlTools\Element\Attributed\AttributedElementInterface $parentIfKnown
   * @param string $tagName
   * @param string[] $attributes
   * @param \Donquixote\XmlTools\Element\ElementInterface[] $children
   */
  function __construct(AttributedElementInterface $parentIfKnown = NULL, $tagName, array $attributes, array $children) {
    parent::__construct($parentIfKnown, $tagName, $attributes);
    $this->children = $children;
    foreach ($children as $child) {
      if ($child instanceof NamedElementInterface) {
        $this->namedChildren[] = $child;
        $this->namedChildrenByName[$child->getTagName()][] = $child;
      }
    }
  }

  /**
   * @return NamedElementInterface[]
   *   Format: $[] = $childNode
   */
  function getChildren() {
    return $this->children;
  }

  /**
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  function getNamedChildren() {
    return $this->namedChildren;
  }

  /**
   * @param string $name
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  function getChildrenWithName($name) {
    return array_key_exists($name, $this->namedChildrenByName)
      ? $this->namedChildrenByName[$name]
      : array();
  }

  /**
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  function getNamedChildrenByTagName() {
    return $this->namedChildrenByName;
  }
}
