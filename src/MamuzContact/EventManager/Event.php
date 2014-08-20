<?php

namespace MamuzContact\EventManager;

interface Event
{
    const IDENTIFIER = 'mamuz-contact';

    const PRE_PERSISTENCE = 'persist.pre';

    const POST_PERSISTENCE = 'persist.post';
}
