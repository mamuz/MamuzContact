<?php

namespace MamuzContact\Mapper\Db;

use Doctrine\Common\Persistence\ObjectManager;
use MamuzContact\Entity\Contact;
use MamuzContact\Feature\CommandInterface;

class Command implements CommandInterface
{
    /** @var ObjectManager */
    private $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function persist(Contact $contact)
    {
        $this->objectManager->persist($contact);
        $this->objectManager->flush();
        return $contact;
    }
}
