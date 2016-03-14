<?php

namespace Donquixote\XmlTools\IdToElement;

interface IdToElementInterface {

  /**
   * @param string|int $id
   *
   * @return bool
   */
  function idExists($id);

  /**
   * @param string|int $id
   *
   * @return \Donquixote\XmlTools\Element\Named\NamedElementInterface|null
   */
  function idGetElement($id);

}
