<?php

namespace app\services\store;

use app\entities\store\Client;
use app\repositories\ClientRepository;

class ClientService
{
    private $clientRepository;

    public function __construct(
        ClientRepository $clientRepository
    )
    {
        $this->clientRepository = $clientRepository;
    }

    public function create(): Client
    {
        $client = Client::create();
        return $this->clientRepository->save($client);
    }

    public function edit(
        int $id,
        string $first_name,
        string $last_name,
        string $email
    ): void
    {
        $client = $this->clientRepository->get($id);
        $client->edit(
            $first_name,
            $last_name,
            $email
        );
        $this->clientRepository->save($client);
    }
}
