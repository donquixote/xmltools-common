<?php

namespace Donquixote\XmlTools\Element\Trail;

use Donquixote\XmlTools\Element\Tag\TagElementBase;

class TrailElement extends TagElementBase implements TrailElementInterface {

  /**
   * @var \Donquixote\XmlTools\Element\Trail\TrailElementInterface
   */
  private $parentOrNull;

  /**
   * @param \Donquixote\XmlTools\Element\Trail\TrailElementInterface|NULL $parentOrNull
   * @param string $tagName
   * @param string[] $attributes
   */
  function __construct(TrailElementInterface $parentOrNull = NULL, $tagName, $attributes) {
    parent::__construct($tagName, $attributes);
    $this->parentOrNull = $parentOrNull;
  }

  /**
   * @return \Donquixote\XmlTools\Element\Trail\TrailElementInterface|null
   *   The parent element, or NULL if parent is not known.
   */
  function getParentOrNull() {
    return $this->parentOrNull;
  }
}
