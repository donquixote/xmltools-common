<?php

namespace Donquixote\XmlTools\ElementStream\Provider;

use Donquixote\XmlTools\ElementStream\ElementStream_XmlReader;
use Donquixote\XmlTools\Util\XmlReaderUtil;

class ElementStreamProvider_XmlReader implements ElementStreamProviderInterface, \Countable {

  /**
   * @var string
   */
  private $file;

  /**
   * @var string[]
   */
  private $xtrail;

  /**
   * @param string $file
   * @param string[] $xtrail
   */
  function __construct($file, array $xtrail) {
    $this->file = $file;
    $this->xtrail = $xtrail;
  }

  /**
   * @return \Donquixote\XmlTools\ElementStream\ElementStreamInterface
   */
  function getElementStream() {
    return ElementStream_XmlReader::startWithFile($this->file, $this->xtrail);
  }

  /**
   * Count elements of an object
   * @link http://php.net/manual/en/countable.count.php
   * @return int The custom count as an integer.
   * </p>
   * <p>
   * The return value is cast to an integer.
   * @since 5.1.0
   */
  public function count() {
    return XmlReaderUtil::fileCountElements($this->file, $this->xtrail);
  }
}
