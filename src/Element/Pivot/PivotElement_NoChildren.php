<?php

namespace Donquixote\XmlTools\Element\Pivot;

use Donquixote\XmlTools\Element\Trail\TrailElementInterface;
use Donquixote\XmlTools\Element\Tree\TreeElement_NoChildren;

class PivotElement_NoChildren extends TreeElement_NoChildren implements PivotElementInterface {

  /**
   * @var \Donquixote\XmlTools\Element\Trail\TrailElementInterface
   */
  private $parentOrNull;

  /**
   * @param \Donquixote\XmlTools\Element\Trail\TrailElementInterface $parentOrNull
   * @param string $tagName
   * @param string[] $attributes
   */
  function __construct(TrailElementInterface $parentOrNull, $tagName, array $attributes) {
    parent::__construct($tagName, $attributes);
    $this->parentOrNull = $parentOrNull;
  }

  /**
   * @return \Donquixote\XmlTools\Element\Tag\TagElementInterface|null
   *   The parent element, or NULL if parent is not known.
   */
  function getParentOrNull() {
    return $this->parentOrNull;
  }

}
