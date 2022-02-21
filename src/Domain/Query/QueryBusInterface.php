<?php

namespace App\Domain\Query;

interface QueryBusInterface
{
    /** @return mixed */
    public function handle(QueryInterface $query);
}
