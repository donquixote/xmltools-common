<?php

namespace Donquixote\XmlTools\Element\Other;

use Donquixote\XmlTools\Element\ElementInterface;

interface OtherElementInterface extends ElementInterface {

  /**
   * @return string
   */
  function getXml();

  /**
   * @return int
   */
  function getNodeType();

}
