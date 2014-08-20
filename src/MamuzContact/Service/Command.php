<?php

namespace MamuzContact\Service;

use MamuzContact\Entity\Contact;
use MamuzContact\Feature\CommandInterface;

class Command implements CommandInterface
{
    /** @var CommandInterface */
    private $mapper;

    /**
     * @param CommandInterface $mapper
     */
    public function __construct(CommandInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function persist(Contact $contact)
    {
        $this->mapper->persist($contact);

        return $contact;
    }
}
