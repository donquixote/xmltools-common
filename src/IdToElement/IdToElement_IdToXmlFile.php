<?php

namespace Donquixote\XmlTools\IdToElement;

use Donquixote\XmlTools\Util\XmlReaderUtil;

class IdToElement_IdToXmlFile implements  IdToElementInterface {

  /**
   * @var callable
   */
  private $idToFile;

  /**
   * @var string[]
   */
  private $trail;

  /**
   * @param string $prefix
   * @param string $suffix
   * @param string[] $trail
   *
   * @return \Donquixote\XmlTools\IdToElement\IdToElement_IdToXmlFile
   */
  static function createWithPrefixIntSuffix($prefix, $suffix, array $trail) {
    return new self(
      function($id) use ($prefix, $suffix) {
        if ((string)(int)$id !== (string)$id) {
          return NULL;
        }
        return $prefix . $id . $suffix;
      },
      $trail);
  }

  /**
   * @param callable $idToFile
   * @param string[] $trail
   */
  function __construct(callable $idToFile, array $trail) {
    $this->idToFile = $idToFile;
    $this->trail = $trail;
  }

  /**
   * @param string|int $id
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface|null
   */
  function idGetElement($id) {
    if (NULL === $file = call_user_func($this->idToFile, $id)) {
      return NULL;
    }
    return XmlReaderUtil::fileReadElement($file, $this->trail);
  }

  /**
   * @param string|int $id
   *
   * @return bool
   */
  function idExists($id) {
    return NULL !== call_user_func($this->idToFile, $id);
  }
}
