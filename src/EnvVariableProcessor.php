<?php
declare(strict_types=1);
namespace Lemming\EnvFallback;

use TYPO3\CMS\Core\Configuration\Processor\Placeholder\PlaceholderProcessorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EnvVariableProcessor implements PlaceholderProcessorInterface
{
    public function canProcess(string $placeholder, array $referenceArray): bool
    {
        return is_string($placeholder) && (str_contains($placeholder, '%env('));
    }

    /**
     * @param array|null $referenceArray
     * @return mixed|string
     */
    public function process(string $value, array $referenceArray)
    {
        $explode =  GeneralUtility::trimExplode(',', $value);
        $value = $explode[0];
        $env = getenv($value);
        $fallback = $explode[1] ?? null;

        if (($env === false || empty($env)) && !is_null($fallback)) {
            return $fallback;
        }
        if (!$env) {
            throw new \UnexpectedValueException('Value not found', 1581501124);
        }
        return $env;
    }
}
