<?php

namespace MamuzContact\Mapper\Db;

use Doctrine\Common\Persistence\ObjectManager;
use MamuzContact\Entity\Contact;
use MamuzContact\EventManager\AwareTrait as EventManagerAwareTrait;
use MamuzContact\EventManager\Event;
use MamuzContact\Feature\CommandInterface;

class Command implements CommandInterface
{
    use EventManagerAwareTrait;

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
        $results = $this->trigger(Event::PRE_PERSISTENCE, array('contact' => $contact));
        if ($results->stopped()) {
            return $contact;
        }

        $this->objectManager->persist($contact);
        $this->objectManager->flush();

        $this->trigger(Event::POST_PERSISTENCE, array('contact' => $contact));

        return $contact;
    }
}
