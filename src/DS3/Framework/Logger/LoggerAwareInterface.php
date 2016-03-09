<?php

namespace DS3\Framework\Logger;

/**
 * Interface that allows the injection of an optional Logger.
 *
 * @author Loïc Payol <loic.payol@gmail.com>
 */
interface LoggerAwareInterface
{
    /**
     * Injects the logger.
     *
     * @param Logger|null $logger The logger to inject
     */
    public function setLogger(Logger $logger = null);
}
