<?php

namespace Marketing\interfaces;

use Marketing\entities\User;

interface MapperInterface
{
    public function findBy(User $user);
}
