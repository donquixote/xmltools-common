<?php

namespace Donquixote\XmlTools\Element\Trail;

trait TrailElementTrait {

  /**
   * @var \Donquixote\XmlTools\Element\Tag\TagElementInterface|null
   */
  private $parentOrNull;

  /**
   * @return \Donquixote\XmlTools\Element\Tag\TagElementInterface|null
   *   The parent element, or NULL if parent is not known.
   */
  function getParentOrNull() {
    return $this->parentOrNull;
  }

  function withParentElement(TrailElementInterface $parentElement) {
    $clone = clone $this;
    $clone->parentOrNull = $parentElement;
    return $clone;
  }

}
