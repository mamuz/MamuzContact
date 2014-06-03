<?php

namespace MamuzContact\Feature;

use MamuzContact\Entity\Contact;

interface CommandInterface
{
    /**
     * @param Contact $contact
     * @return Contact
     */
    public function persist(Contact $contact);
}
