<?php

namespace app\widgets\linkpagepost;

use yii\widgets\LinkPager;

class LinkPagerPost extends LinkPager
{
    public $title;
    public $text;

    public function run()
    {
        $pageCount = $this->pagination->getPageCount();
        /*if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }*/

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // prev/next page
        echo $this->renderPrevNextPages($buttons, $currentPage, $pageCount);

        // internal pages
        echo $this->renderInternalPages($buttons, $currentPage);
    }

    public function renderPrevNextPages($buttons, $currentPage, $pageCount)
    {
        // prev page
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }
        $buttons['prev'] = [
            'label' => $this->prevPageLabel,
            'page' => $page,
            'url' => $this->pagination->createUrl($page),
        ];

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }
        $buttons['next'] = [
            'label' => $this->nextPageLabel,
            'page' => $page,
            'url' => $this->pagination->createUrl($page),
        ];

        return $this->render('@app/widgets/linkpagepost/view/prev-next-pages.php', [
            'buttons' => $buttons,
            'currentPage' => $currentPage,
            'title' => $this->title,
            'text' => $this->text,
        ]);
    }

    public function renderInternalPages($buttons, $currentPage)
    {
        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[$i] = [
                'label' => $i + 1,
                'page' => $i,
                'url' => $this->pagination->createUrl($i),
            ];
        }

        return $this->render('@app/widgets/linkpagepost/view/internal-pages.php', [
            'buttons' => $buttons,
            'currentPage' => $currentPage,
        ]);
    }
}
