<?php

namespace App\Http\Clients;


use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class BitrixClient
{
    protected $client;
    private $token;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('BITRIX_API_URL')
        ]);

        $this->token = env('BITRIX_API_TOKEN');
    }

    public function getDeal($id) 
    {
        $response = $this->client
                ->get("/rest/3/{$this->token}/crm.deal.get", [
                    'query' => [
                        "id" => $id,
                    ]
                ])
                ->getBody()
                ->getContents();
        $result = json_decode($response, true);

        return $result['result'];
    }

    public function getLead($id) 
    {
        $response = $this->client
                ->get("/rest/3/{$this->token}/crm.lead.get", [
                    'query' => [
                        "id" => $id,
                    ]
                ])
                ->getBody()
                ->getContents();
        $result = json_decode($response, true);
        
        return $result['result'];
    }

    public function getManagerName($id)
    {
        $managerName = '-';
        $response = $this->client
            ->get("/rest/3/{$this->token}/user.search", [
                'query' => [
                     'ID' => $id
                ]
            ])
            ->getBody()
            ->getContents();

            $result = json_decode($response, true);
            if($result['result']){
                $manager = reset($result['result']);
                $managerName = "{$manager['LAST_NAME']}  {$manager['NAME']}  {$manager['SECOND_NAME']}";
            }

            return $managerName;
    }

    public function getContact($id)
    {
        $response = $this->client
            ->get("/rest/3/{$this->token}/crm.contact.get", [
                'query' => [
                    "id" => $id,
                ]
            ])
            ->getBody()
            ->getContents();

            $result = json_decode($response, true);
        
            return $result['result'];
    }

    public function getCompanyContacts($id)
    {
        $response = $this->client
            ->get("/rest/3/{$this->token}/crm.company.contact.items.get", [
                'query' => [
                    "id" => '1667',
                ]
            ])
            ->getBody()
            ->getContents();

        $result = json_decode($response, true);

        return $result['result'];
    }

    public function getCompany($id)
    {
        $response = $this->client
            ->get("/rest/3/{$this->token}/crm.company.get", [
                'query' => [
                    "id" => '1667',
                ]
            ])
            ->getBody()
            ->getContents();

            $result = json_decode($response, true);

            return $result['result'];
    }

}