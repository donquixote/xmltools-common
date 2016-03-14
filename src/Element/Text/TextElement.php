<?php

namespace Donquixote\XmlTools\Element\Text;

class TextElement implements TextElementInterface {

  /**
   * @var string
   */
  private $text;

  /**
   * @param string $text
   */
  function __construct($text) {
    $this->text = $text;
  }

  /**
   * @return string
   */
  function getText() {
    return $this->text;
  }
}
