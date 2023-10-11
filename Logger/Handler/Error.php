<?php
/**
 * @author DiZed Team
 * @copyright Copyright (c) DiZed Team (https://github.com/di-zed/)
 */
namespace DiZed\Core\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Custom logger handler for error mode.
 */
class Error extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/dized/error.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::ERROR;
}
