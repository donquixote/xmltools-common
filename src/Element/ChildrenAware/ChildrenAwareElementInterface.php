<?php

namespace Donquixote\XmlTools\Element\ChildrenAware;

interface ChildrenAwareElementInterface {

  /**
   * @return \Donquixote\XmlTools\Element\ElementInterface[]
   */
  function getChildren();

  /**
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  function getNamedChildren();

  /**
   * @param string $name
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[]
   */
  function getChildrenWithName($name);

  /**
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface[][]
   *   Format: $[$tagName][] = $childElement
   */
  function getNamedChildrenByTagName();

}
