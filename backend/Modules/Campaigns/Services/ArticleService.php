<?php

namespace Modules\Campaigns\Services;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Campaigns\Entities\Article;
use Modules\Campaigns\Repositories\ArticleRepository;

class ArticleService
{

    private $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function createArticleIfDontExist($article)
    {
        $result = $this->getArticleByArticleId($article['id']);
        if ($result != null) {
            return $result;
        } else {
            return $this->createArticle($article);
        }
    }

    public function updateArticle($articleRequest, $article_id)
    {
        return $this->articleRepository->updateArticle($articleRequest, $article_id);
    }

    public function updateArticleKd($articleRequest)
    {
        return $this->articleRepository->updateArticleKd($articleRequest);
    }

    public function createMass($mass)
    {
        return $this->articleRepository->createMass($mass);
    }

    public function getAll()
    {
        return $this->articleRepository->getAll();
    }

    public function getNumberOfArticlesPortalUser($portalUserId)
    {
        return $this->articleRepository->getNumberOfArticlesPortalUser($portalUserId);
    }

    public function getNumberOfArticlesUserCookie($userCookie)
    {
        return $this->articleRepository->getNumberOfArticlesUserCookie($userCookie);
    }


    public function getArticleByArticleId($article_id)
    {
        return $this->articleRepository->getArticleByArticleId($article_id);
    }

    private function createArticle($article)
    {
        return $this->articleRepository->createArticle($article);
    }

    public function getArticles(array $filters, $page_size)
    {
        return $this->articleRepository->getArticles($filters, $page_size);
    }

    public function targetingArticlesData()
    {
        $articles = DB::table('articles')->distinct()->where('category', '!=', 'Blog')->select('author', 'category')->get();
        $authors = array();
        $categories = array();
        foreach ($articles as $article) {
            (!in_array($article->author, $authors)) ? array_push($authors, $article->author) : null;
            (!in_array($article->category, $categories)) ? array_push($categories, $article->category) : null;
        }

        return response()->json([
            'authors' => $authors,
            'categories' => $categories
        ], Response::HTTP_OK);
    }

}