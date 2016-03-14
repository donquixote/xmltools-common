<?php

namespace Donquixote\XmlTools\Element\Named;

use Donquixote\XmlTools\Element\Attributed\AttributedElementBase;

class NamedElement_NoChildren extends AttributedElementBase implements NamedElementInterface {

  /**
   * @return \Donquixote\XmlTools\Element\ElementInterface[]
   */
  function getChildren() {
    return array();
  }

  /**
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  function getNamedChildren() {
    return array();
  }

  /**
   * @param string $name
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  function getChildrenWithName($name) {
    return array();
  }

  /**
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  function getNamedChildrenByTagName() {
    return array();
  }
}
