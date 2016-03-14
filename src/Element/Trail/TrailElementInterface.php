<?php

namespace Donquixote\XmlTools\Element\Trail;

use Donquixote\XmlTools\Element\Attributed\AttributedElementInterface;

interface TrailElementInterface extends AttributedElementInterface {

  /**
   * @return \Donquixote\XmlTools\Element\Trail\TrailElementInterface|null
   *   The parent element, or NULL if parent is not known.
   */
  function getParentIfKnown();

}
