<?php

namespace Donquixote\XmlTools\Util;

use Donquixote\DataStream\Util\UtilBase;
use Donquixote\XmlTools\ElementStream\Provider\ElementStreamProviderInterface;

final class ElementStreamUtil extends UtilBase {

  /**
   * @param \Donquixote\XmlTools\ElementStream\Provider\ElementStreamProviderInterface $elementStreamProvider
   *
   * @return int
   */
  static function streamProviderCountElements(ElementStreamProviderInterface $elementStreamProvider) {
    if ($elementStreamProvider instanceof \Countable) {
      return $elementStreamProvider->count();
    }
    $elementStream = $elementStreamProvider->getElementStream();
    # $t0 = microtime(TRUE);
    $n = 0;
    while (FALSE !== $elementStream->getElement()) {
      # if (0 === $n % 500) {
        # $dt = (microtime(TRUE) - $t0);
        # print "<pre>n = $n: $dt seconds</pre>\n";
      # }
      ++$n;
    }
    return $n;
  }

}
