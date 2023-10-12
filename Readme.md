# TYPO3: Fallback for enviroment variables in YAML files

This package provides an extended `EnvVariableProcessor` for TYPO3 with the ability to define a fallback value.

Instead `%env(DB_HOST)%` you now can use `%env(DB_HOST, localhost)%` where `localhost` is the fallback value.

It also works with `helhum/typo3-config-handling`.

## Installation

```shell
composer req christophlehmann/yaml-env-fallback
```

## Configuration

Not needed.