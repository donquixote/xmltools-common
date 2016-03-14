<?php

namespace Donquixote\XmlTools\ElementStream;

class ElementStream_Empty implements ElementStreamInterface {

  /**
   * Gets the next element, or false on eof.
   *
   * @return \Donquixote\XmlTools\Element\Tree\TreeElementInterface|false
   */
  function getElement() {
    return FALSE;
  }
}
