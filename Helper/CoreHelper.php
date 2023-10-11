<?php
/**
 * @author DiZed Team
 * @copyright Copyright (c) DiZed Team (https://github.com/di-zed/)
 */
namespace DiZed\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

/**
 * Helper Data.
 */
class CoreHelper extends AbstractHelper
{
    /**
     * @var Json
     */
    protected $serializer;

    /**
     * Helper constructor.
     *
     * @param Context $context
     * @param Json $serializer
     */
    public function __construct(
        Context $context,
        Json $serializer
    ) {
        parent::__construct($context);

        $this->serializer = $serializer;
    }

    /**
     * Get logger.
     *
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->_logger;
    }

    /**
     * Get values as an array from dynamic config fields.
     *
     * @param string $path
     * @param string $column
     * @return array
     */
    public function getConfigDynamicValues(string $path, string $column = ''): array
    {
        $result = [];

        try {
            $value = (string)$this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
            $decodedValue = $this->jsonDecode($value);
            foreach ($decodedValue as $item) {
                if ($column) {
                    if (!array_key_exists($column, $item)) {
                        continue;
                    }
                    $result[] = $item[$column];
                } else {
                    $result[] = $item;
                }
            }
        } catch (\Exception $e) {
            return [];
        }

        return $result;
    }

    /**
     * Get serialized data.
     *
     * @param array $data
     * @return string
     */
    public function jsonEncode(array $data): string
    {
        try {
            return (string)$this->serializer->serialize($data);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Get unserialized data.
     *
     * @param string $string
     * @return array
     */
    public function jsonDecode(string $string): array
    {
        try {
            $result = $this->serializer->unserialize($string);
            return (is_array($result) ? $result : []);
        } catch (\Exception $e) {
            return [];
        }
    }
}
