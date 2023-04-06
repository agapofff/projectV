<?php

namespace app\services\admin;

use app\entities\admin\SeoRedirect;
use app\repositories\SeoRedirectRepository;

class SeoRedirectService
{
    private $seoRedirectRepository;

    public function __construct(
        SeoRedirectRepository $seoRedirectRepository
    )
    {
        $this->seoRedirectRepository = $seoRedirectRepository;
    }

    public function create()
    {
        $seoRedirect = SeoRedirect::create();
        return $this->seoRedirectRepository->save($seoRedirect);
    }

    public function edit(
        $id,
        $type,
        $url_from,
        $url_to
    )
    {
        $seoRedirect = $this->seoRedirectRepository->get($id);
        $seoRedirect->edit(
            $type,
            $url_from,
            $url_to
        );
        $this->seoRedirectRepository->save($seoRedirect);
    }

    public function remove($id): void
    {
        $seoRedirect = $this->seoRedirectRepository->get((int)$id);
        $this->seoRedirectRepository->remove($seoRedirect);
    }
}
