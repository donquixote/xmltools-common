<?php

namespace Donquixote\XmlTools\Element;

use Donquixote\XmlTools\Element\Attributed\AttributedElementInterface;

abstract class ElementBase implements ElementInterface {

  /**
   * @var \Donquixote\XmlTools\Element\Attributed\AttributedElementInterface|null
   */
  private $parentIfKnown;

  /**
   * @param \Donquixote\XmlTools\Element\Attributed\AttributedElementInterface $parentIfKnown
   */
  function __construct(AttributedElementInterface $parentIfKnown = NULL) {
    $this->parentIfKnown = $parentIfKnown;
  }

  /**
   * @return \Donquixote\XmlTools\Element\Attributed\AttributedElementInterface|null
   *   The parent element, or NULL if parent is not known.
   */
  function getParentIfKnown() {
    return $this->parentIfKnown;
  }
}
