<?php

namespace Donquixote\XmlTools\Element\Pivot;

use Donquixote\XmlTools\Element\Tag\TagElementInterface;
use Donquixote\XmlTools\Element\Tree\TreeElement;

class PivotElement extends TreeElement implements PivotElementInterface {

  /**
   * @var \Donquixote\XmlTools\Element\Tag\TagElementInterface|null
   */
  private $parentOrNull;

  /**
   * @param \Donquixote\XmlTools\Element\Tag\TagElementInterface|null $parentOrNull
   * @param string $tagName
   * @param string[] $attributes
   * @param \Donquixote\XmlTools\Element\ElementInterface[] $children
   */
  function __construct(TagElementInterface $parentOrNull = NULL, $tagName, $attributes, $children) {
    parent::__construct($tagName, $attributes, $children);
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
