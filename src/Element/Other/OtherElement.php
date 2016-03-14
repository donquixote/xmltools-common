<?php

namespace Donquixote\XmlTools\Element\Other;

class OtherElement implements OtherElementInterface {

  /**
   * @var string
   */
  private $xml;

  /**
   * @var int
   */
  private $nodeType;

  /**
   * @param string $xml
   * @param int $nodeType
   */
  function __construct($xml, $nodeType) {
    $this->xml = $xml;
    $this->nodeType = $nodeType;
  }

  /**
   * @return string
   */
  function getXml() {
    return $this->xml;
  }

  /**
   * @return int
   */
  function getNodeType() {
    return $this->nodeType;
  }
}
