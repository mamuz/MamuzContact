<?php

namespace MamuzContact\DomainManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getContactDomainConfig();
}
