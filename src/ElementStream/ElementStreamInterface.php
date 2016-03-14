<?php

namespace Donquixote\XmlTools\ElementStream;

interface ElementStreamInterface {

  /**
   * Gets the next element, or false on eof.
   *
   * @return \Donquixote\XmlTools\Element\Pivot\PivotElementInterface|false
   *
   * @throws \Donquixote\DataStream\Exception\StreamFetchException
   */
  function getElement();

}
