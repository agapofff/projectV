<?php

namespace app\services\lang;

use app\entities\lang\Lang;
use app\repositories\LangRepository;

class LangService
{
    public $sessiaUrl = 'https://api.sessia.com/api';

    private $langRepository;

    public function __construct(
        LangRepository $langRepository
    )
    {
        $this->langRepository = $langRepository;
    }

    public function import()
    {
        $context = stream_context_create([
            'http' => [
                'method' => "GET",
            ]
        ]);
        $params = [
            '_format' => 'json',
        ];

        $url = $this->sessiaUrl . '/language?' . http_build_query($params);

        $responseHeaders = get_headers(
            $url,
            null,
            $context
        );
        if (in_array('HTTP/1.1 200 OK', $responseHeaders)) {
            $response = file_get_contents(
                $url,
                false,
                $context
            );

            foreach (json_decode($response, true) as $content) {
                if (!$this->langRepository->get($content['id'])) {
                    $lang = Lang::create(
                        $content['id'],
                        $content['lang_short'],
                        $content['name']
                    );
                    $this->langRepository->save($lang);
                }
            }
        }
    }

    public function edit(
        $idOld,
        $id,
        $url,
        $iso,
        $name,
        $store_id,
        $currency_iso,
        $active
    )
    {
        $lang = $this->langRepository->get($idOld);
        $lang->edit(
            $id,
            $url,
            $iso,
            $name,
            $store_id,
            $currency_iso,
            $active
        );
        $this->langRepository->save($lang);
    }
}
