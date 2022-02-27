<?php

namespace App\Infrastructure\Symfony\Messenger;

use App\Domain\Query\QueryBusInterface;
use App\Domain\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBusHandler implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function handle(QueryInterface $query)
    {
        return $this->handleQuery($query);
    }
}
