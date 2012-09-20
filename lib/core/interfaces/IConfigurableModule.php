<?php

namespace pff;

/**
 *
 * @author paolo.fagni<at>gmail.com
 */
interface IConfigurableModule {

    /**
     * @abstract
     * @param array $parsedConfig
     * @return mixed
     */
    public function loadConfig($parsedConfig);
}
