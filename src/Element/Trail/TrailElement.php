<?php

namespace Donquixote\XmlTools\Element\Trail;

use Donquixote\XmlTools\Element\Attributed\AttributedElementBase;
use Donquixote\XmlTools\Element\Named\NamedElement;

class TrailElement extends AttributedElementBase implements TrailElementInterface {

  /**
   * @param $children
   *
   * @return mixed
   */
  function withChildren($children) {
    return new NamedElement($this->getParentIfKnown(), $this->getTagName(), $this->getAttributes(), $children);
  }
}
