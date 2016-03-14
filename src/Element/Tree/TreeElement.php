<?php

namespace Donquixote\XmlTools\Element\Tree;

use Donquixote\XmlTools\Element\Tag\TagElementBase;

class TreeElement extends TagElementBase implements TreeElementInterface {

  /**
   * @var \Donquixote\XmlTools\Element\ElementInterface[]
   */
  private $children;

  /**
   * @var \Donquixote\XmlTools\Element\Tree\TreeElementInterface[]
   *   Format: $[] = $childElement
   */
  private $namedChildren = array();

  /**
   * @var \Donquixote\XmlTools\Element\Tree\TreeElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  private $namedChildrenByName = array();

  /**
   * @param string $tagName
   * @param string[] $attributes
   * @param \Donquixote\XmlTools\Element\ElementInterface[] $children
   */
  function __construct($tagName, array $attributes, array $children) {
    parent::__construct($tagName, $attributes);
    $this->children = $children;
    foreach ($children as $child) {
      if ($child instanceof TreeElementInterface) {
        $this->namedChildren[] = $child;
        $this->namedChildrenByName[$child->getTagName()][] = $child;
      }
    }
  }

  /**
   * @return TreeElementInterface[]
   *   Format: $[] = $childNode
   */
  function getChildren() {
    return $this->children;
  }

  /**
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[]
   */
  function getNamedChildren() {
    return $this->namedChildren;
  }

  /**
   * @param string $name
   *
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[]
   */
  function getChildrenWithName($name) {
    return array_key_exists($name, $this->namedChildrenByName)
      ? $this->namedChildrenByName[$name]
      : array();
  }

  /**
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  function getNamedChildrenByTagName() {
    return $this->namedChildrenByName;
  }
}
