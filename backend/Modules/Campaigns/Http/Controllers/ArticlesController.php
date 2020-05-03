<?php

namespace Modules\Campaigns\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Campaigns\Services\ArticleService;

class ArticlesController extends Controller
{

    private $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getArticles(Request $request)
    {
        return $this->articleService->getArticles($request->all(), $request['page_size']);
    }

    public function updateArticle(Request $request)
    {
        $updatedArticle = $this->articleService->updateArticleKd($request);
        Log::info('updated article: ' . $updatedArticle);
        return 'Success';
    }

    public function getArticlesData()
    {
        return $this->articleService->targetingArticlesData();
    }

}