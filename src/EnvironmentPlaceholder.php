<?php
declare(strict_types=1);
namespace Lemming\EnvFallback;

use Helhum\ConfigLoader\Processor\Placeholder\PhpExportablePlaceholderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Friendly modified copy of EnvironmentPlaceholder from helhum/config-loader
 */
class EnvironmentPlaceholder implements PhpExportablePlaceholderInterface
{
    public function supportedTypes(): array
    {
        return ['env'];
    }

    public function supports(string $type): bool
    {
        return $type === 'env';
    }

    public function canReplace(string $accessor, array $referenceConfig = []): bool
    {
        return getenv($accessor) !== false || str_contains($accessor, ',');
    }

    public function representsValue(string $accessor, array $referenceConfig = [])
    {
        $explode =  GeneralUtility::trimExplode(',', $accessor);
        $accessor = $explode[0];
        $env = getenv($accessor);
        $fallback = $explode[1] ?? null;

        if (($env === false || empty($env)) && !is_null($fallback)) {
            return $fallback;
        }
        return $env;
    }

    public function representsPhpCode(string $accessor, array $referenceConfig = []): string
    {
        return 'getenv(\'' . addcslashes($accessor, '\\\'') . '\')';
    }
}
