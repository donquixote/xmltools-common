<?php

namespace Donquixote\XmlTools\Element\Text;

use Donquixote\XmlTools\Element\ElementInterface;

interface TextElementInterface extends ElementInterface {

  /**
   * @return string
   */
  function getText();

}
