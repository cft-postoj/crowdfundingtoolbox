<?php

namespace Modules\Campaigns\Services;


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
        $result = $this->getArticleByArticleId($article['article_id']);
        if ($result != null) {
            return $result;
        } else {
            return $this->createArticle($article);
        }

    }

    private function getArticleByArticleId($article_id)
    {
        return $this->articleRepository->getArticleByArticleId($article_id);
    }

    private function createArticle($article)
    {
        return $this->articleRepository->createArticle($article);
    }

}