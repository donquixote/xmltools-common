<?php

namespace Donquixote\XmlTools\Element\Tree;

use Donquixote\XmlTools\Element\Tag\TagElementInterface;
use Donquixote\XmlTools\Element\ChildrenAware\ChildrenAwareElementInterface;

/**
 * @todo Rename to ParentElementInterface?
 */
interface TreeElementInterface extends TagElementInterface, ChildrenAwareElementInterface {

}
