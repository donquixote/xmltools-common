<?php

namespace Donquixote\XmlTools\ElementStream\Provider;

use Donquixote\DataStream\Stream\Provider\StreamProviderCommonInterface;

interface ElementStreamProviderInterface extends StreamProviderCommonInterface {

  /**
   * @return \Donquixote\XmlTools\ElementStream\ElementStreamInterface
   *
   * @throws \Donquixote\DataStream\Exception\StreamInitException
   */
  function getElementStream();

}
