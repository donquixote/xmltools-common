<?php

namespace Donquixote\XmlTools\Element\Attributed;

use Donquixote\XmlTools\Element\ElementInterface;

/**
 * @todo Rename to NamedElementInterface?
 */
interface AttributedElementInterface extends ElementInterface {

  /**
   * @return string
   */
  function getTagName();

  /**
   * @return string[]
   *   Format: $[$attributeName] = $attributeValue
   */
  function getAttributes();

  /**
   * @param string $name
   *
   * @return string|null
   */
  function getAttributeValue($name);

}
