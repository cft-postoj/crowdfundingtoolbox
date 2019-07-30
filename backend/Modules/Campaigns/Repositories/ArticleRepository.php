<?php
/**
 * Created by IntelliJ IDEA.
 * User: notebook
 * Date: 29. 7. 2019
 * Time: 7:13
 */

namespace Modules\Campaigns\Repositories;


use Modules\Campaigns\Entities\Article;

class ArticleRepository
{

    public function getArticleByArticleId($article_id)
    {
        return Article::where('article_id', $article_id)->first();
    }

    public function createArticle($article)
    {
        return Article::create([
            'article_id' => $article['article_id'],
            'author' => $article['article_author'],
            'title' => $article['article_title'],
            'article_created_at' => $article['article_created_at']
        ]);
    }
}