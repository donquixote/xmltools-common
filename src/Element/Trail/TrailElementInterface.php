<?php

namespace Donquixote\XmlTools\Element\Trail;

use Donquixote\XmlTools\Element\Tag\TagElementInterface;

interface TrailElementInterface extends TagElementInterface {

  /**
   * @return \Donquixote\XmlTools\Element\Trail\TrailElementInterface|null
   *   The parent element, or NULL if parent is not known.
   */
  function getParentOrNull();

}
