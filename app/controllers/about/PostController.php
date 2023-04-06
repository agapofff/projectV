<?php

namespace app\controllers\about;

use app\forms\about\PostForm;
use app\services\admin\SeoMetadataService;
use app\services\about\PostService;
use app\repositories\PostRepository;
use app\services\main\SiteService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Post controller
 */
class PostController extends Controller
{
    public $layout = 'front';

    private $postRepository;
    private $postService;
    private $seoMetadataService;

    public function __construct(
        $id,
        $module,
        PostRepository $postRepository,
        PostService $postService,
        SeoMetadataService $seoMetadataService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->postRepository = $postRepository;
        $this->postService = $postService;
        $this->seoMetadataService = $seoMetadataService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'load'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['add', 'form', 'delete', 'error', 'image-upload', 'images-get', 'image-delete'],
                        'allow' => true,
                        'roles' => ['post', 'seo'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        $id = $_GET['id'] ?? '';

        $url = '/storage/post/' . $id . '/imgs/';  // Directory URL address, where files are stored.
        $path = '@webroot/storage/post/' . $id . '/imgs/';  // Or absolute path to directory where files are stored.

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => $url,
                'path' => $path,
                'replace' => true,
                'translit' => true,
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => $url,
                'path' => $path,
            ],
            'image-delete' => [
                'class' => 'vova07\imperavi\actions\DeleteFileAction',
                'url' => $url,
                'path' => $path,
            ],
        ];
    }

    ####################################################################################################

    public function actionIndex($type = '')
    {
        $menu = SiteService::getMenu();

        $seoMedatada = $this->seoMetadataService->get([
            'title' => $menu['about']['items'][$type]['label'],
            'breadcrumbs' => [
                $menu['about']['items'][$type],
            ],
        ]);

        $models = $this->postRepository->getAllAfterDate($type, Yii::$app->language, '2999-01-01 00:00:00', 24);
        $lastModel = $this->postRepository->getLastByTypeAndLang($type, Yii::$app->language);

        return $this->render('index', [
            'seoMedatada' => $seoMedatada,
            'type' => $type,
            'models' => $models,
            'lastModel' => $lastModel,
        ]);
    }

    public function actionLoad($type)
    {
        if (Yii::$app->request->isAjax) {
            $post = $this->postRepository->get((int)Yii::$app->request->post('id'));
            $models = $this->postRepository->getAllAfterDate($type, Yii::$app->language, $post->created_at, 12);
            $lastModel = $this->postRepository->getLastByTypeAndLang($type, Yii::$app->language);

            return $this->renderFile('@app/views/about/post/_row.php', [
                'models' => $models,
                'lastModel' => $lastModel,
            ]);
        }

        return $this->redirect(['/about/post/index', 'type' => $type]);
    }

    public function actionView($type, $id, $url = '')
    {
        try {
            $post = $this->postRepository->get($id);
        } catch (\Exception $ex) {
            throw new NotFoundHttpException($ex->getMessage());
        }

        if ($post->type !== $type || ($post->url !== $url && !empty($post->title))) {
            $this->redirect($post->getUrl(), 301);
        }

        $menu = SiteService::getMenu();

        $seoMedatada = $this->seoMetadataService->get([
            'title' => $post->metadata_title,
            'description' => $post->metadata_description,
            'h1' => $post->title,
            'breadcrumbs' => [
                $menu['about']['items'][$type],
                [
                    'url' => $post->getUrl(),
                    'label' => $post->title,
                ],
            ],
            'image' => $post->getUrlCover(),
        ]);

        return $this->render('view', [
            'model' => $post,
            'seoMedatada' => $seoMedatada,
        ]);
    }

    ####################################################################################################

    public function actionAdd($type)
    {
        $id = $this->postService->create($type);
        $this->redirect(['/about/post/form', 'id' => $id]);
    }

    public function actionForm($id)
    {
        $this->layout = 'admin';

        $post = $this->postRepository->get($id);
        $currentCover = $post->cover;
        $currentImg = $post->img;

        $form = new PostForm($post);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->postService->edit($form->id, $currentCover, $currentImg, $form);
            $this->redirect($post->getUrl());
        }

        return $this->render('form', [
            'model' => $form,
            'post' => $post,
        ]);
    }

    public function actionDelete($id)
    {
        $type = $this->postService->remove($id);
        $this->redirect(['/about/post/index', 'type' => $type]);
    }
}
