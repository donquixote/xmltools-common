<?php

namespace Donquixote\XmlTools\Element\Tree;

use Donquixote\XmlTools\Element\Tag\TagElementBase;

class TreeElement_NoChildren extends TagElementBase implements TreeElementInterface {

  /**
   * @return \Donquixote\XmlTools\Element\ElementInterface[]
   */
  function getChildren() {
    return array();
  }

  /**
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[]
   */
  function getNamedChildren() {
    return array();
  }

  /**
   * @param string $name
   *
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[]
   */
  function getChildrenWithName($name) {
    return array();
  }

  /**
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  function getNamedChildrenByTagName() {
    return array();
  }
}
