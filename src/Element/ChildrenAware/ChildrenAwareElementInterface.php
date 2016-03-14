<?php

namespace Donquixote\XmlTools\Element\ChildrenAware;

interface ChildrenAwareElementInterface {

  /**
   * @return \Donquixote\XmlTools\Element\ElementInterface[]
   */
  function getChildren();

  /**
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[]
   */
  function getNamedChildren();

  /**
   * @param string $name
   *
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[]
   */
  function getChildrenWithName($name);

  /**
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  function getNamedChildrenByTagName();

}
