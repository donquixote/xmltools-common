<?php

namespace Donquixote\XmlTools\ElementStream\Provider;

interface ElementStreamProviderInterface {

  /**
   * @return \Donquixote\XmlTools\ElementStream\ElementStreamInterface
   *
   * @throws \Donquixote\DataStream\Exception\StreamInitException
   */
  function getElementStream();

}
