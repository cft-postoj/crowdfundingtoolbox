<?php
/**
 * Created by IntelliJ IDEA.
 * User: notebook
 * Date: 29. 7. 2019
 * Time: 7:13
 */

namespace Modules\Campaigns\Repositories;


use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Campaigns\Entities\Article;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Entities\TrackingVisit;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserCookieCouple;

class ArticleRepository
{

    public function getArticleByArticleId($article_id)
    {
        return Article::where('article_id', $article_id)->first();
    }

    public function createMass($mass)
    {
        return Article::create($mass);
    }

    public function createArticle($article)
    {
        return Article::create([
            'article_id' => $article['id'],
            'title' => $article['title'],
            'url' => '/' . $article['id'] . '/' . $article['slug'],
            'thumbnail_url' => ($article['image'] !== null) ? $article['image'] : '/assets/frontend/build/img/placeholder/placeholder.jpg',
            'author' => $article['author'],
            'author_url' => ($article['author_slug'] !== null) ? '/autor/' . $article['author_slug'] : '/',
            'author_profile_image' => ($article['author_image_id'] !== null) ? '/uploads/' . $article['author_image_id'] . '/conversions/square.jpg' : 'https://via.placeholder.com/50',
            'category' => $article['category_title'],
            'description' => mb_substr(trim($article['description']), 0, 120) . '...',
            'category_url' => '/' . $article['category_slug'],
            'article_created_at' => $article['article_created_at']
        ]);
    }

    public function updateArticle($article, $id)
    {
        return Article::where('id', $id)
            ->update($article);

    }

    public function updateArticleKd($article)
    {
        Log::info('updating article: '.$article['id']);
        return Article::query()
            ->updateOrCreate([
                'article_id' => $article['id']
            ],[
                'article_id' =>  $article['id'],
                'title' => $article['title'],
                'url' => '/' . $article['id'] . '/' . $article['slug'],
                'thumbnail_url' => ( $article['image_id'] !== null) ? '/uploads/' . $article['image_id'] . '/conversions/square.jpg' : '/assets/frontend/build/img/placeholder/placeholder.jpg',
                'author' => $article['author'],
                'author_url' => ($article['author_slug'] !== null) ? '/autor/' . $article['author_slug'] : '/',
                'author_profile_image' => ($article['author_image_id'] !== null) ? '/uploads/' . $article['author_image_id'] . '/conversions/square.jpg' : 'https://via.placeholder.com/50',
                'category' => $article['category_title'],
                'description' => mb_substr(trim($article['description']), 0, 120) . '...',
                'category_url' => '/' . $article['category_slug'],
                'article_created_at' => $article['article_created_at']
            ]);
    }

    public function getAll()
    {
        return Article::get();
    }

    public function getArticles($filters, $page_size)
    {
        //get id of first donation of every user, who made a donate, necessary for count of new users
        $firstDonationOfUser = Donation::query()
            ->select(DB::raw('min(id) as first_user_donation_id'), 'portal_user_id')
            ->whereNotNull('payment_id')
            ->groupBy('portal_user_id');

        //return tracking_show_id,amount donation and first_donation,
        //first_donation value is 1 when this is first user's donation
        $donationSub = Donation::query()
            ->select('tracking_show_id', 'referral_tracking_show_id', 'amount',
                DB::raw('(CASE 
                        WHEN donations.id = first_user_donation_id THEN 1 
                        ELSE 0 
                        END) AS first_donation'))
            ->leftJoinSub($firstDonationOfUser, 'firstDonationOfUser', function ($join) {
                $join->on('donations.id', '=', 'firstDonationOfUser.first_user_donation_id');
            });

        //get tracking show subquery
        $trackingShowSub = TrackingShow::query()
            ->select('tracking_visit_id as tracking_visit_id', 'amount', 'first_donation')
            ->joinSub($donationSub, 'donationSub', function (JoinClause $join) {
                $join->on('tracking_show.id', '=', 'donationSub.tracking_show_id')
                     ->orOn('tracking_show.id', '=', 'donationSub.referral_tracking_show_id');
            });

        //get tracking show subquery, filter based on created_at
        $trackingVisitSub = TrackingVisit::query()
            ->select('article_id as visit_article_id', 'amount', 'first_donation', 'url')
            ->whereDate('created_at', '>=', $filters['date_from'])
            ->whereDate('created_at', '<=', $filters['date_to'])
            ->leftJoinSub($trackingShowSub, 'trackingShowSub', function ($join) {
                $join->on('tracking_visit.id', '=', 'trackingShowSub.tracking_visit_id');
            });

        //return articles
        return Article::filter($filters)
            ->select('articles.id', 'articles.title', 'articles.url',
                DB::raw('sum(amount) as amount_sum'),
                DB::raw('sum(first_donation) as new_users'),
                DB::raw('count(visit_article_id) as  visits'))
            ->joinSub($trackingVisitSub, 'trackingVisitSub', function ($join) {
                $join->on('articles.id', '=', 'trackingVisitSub.visit_article_id');
            })
            ->groupBy('articles.id', 'articles.title', 'articles.id', 'articles.url')
            ->paginate($page_size);

    }

    public function getNumberOfArticlesPortalUser($portalUserId)
    {
        return
            array('today' => $this->getNumberOfArticlesPortalUserSpecificDateInterval($portalUserId,
                [Carbon::now()->hour(0)->minute(0)->second(0)->millis(0), Carbon::now()]),
                'week' => $this->getNumberOfArticlesPortalUserSpecificDateInterval($portalUserId,
                    [Carbon::now()->subDays(7), Carbon::now()]),
                'month' => $this->getNumberOfArticlesPortalUserSpecificDateInterval($portalUserId,
                    [Carbon::now()->subMonth(), Carbon::now()]));
    }

    public function getNumberOfArticlesPortalUserSpecificDateInterval($portalUserId, $dateInterval)
    {

        return TrackingVisit::select(DB::raw('count(DISTINCT article_id) as count'))
            ->where(function ($query) use ($portalUserId) {
                $query->where('portal_user_id', $portalUserId)
                    ->orWhereIn('user_cookie', UserCookieCouple::select('user_cookie_id')->where('portal_user_id', $portalUserId));
            })
            ->whereBetween('created_at', $dateInterval)
            ->first()->count;
    }


    public function getNumberOfArticlesUserCookie($userCookie)
    {
        return
            array('today' => $this->getNumberOfArticlesUserCookieSpecificDateInterval($userCookie,
                [Carbon::now()->hour(0)->minute(0)->second(0)->millis(0), Carbon::now()]),
                'week' => $this->getNumberOfArticlesUserCookieSpecificDateInterval($userCookie,
                    [Carbon::now()->subDays(7), Carbon::now()]),
                'month' => $this->getNumberOfArticlesUserCookieSpecificDateInterval($userCookie,
                    [Carbon::now()->subMonth(), Carbon::now()]));
    }

    public function getNumberOfArticlesUserCookieSpecificDateInterval($userCookie, $dateInterval)
    {
        return TrackingVisit::select(DB::raw('count(DISTINCT article_id) as count'))
            ->where(function ($query) use ($userCookie) {
                $query->where('user_cookie', $userCookie)
                    ->orWhereIn('portal_user_id', UserCookieCouple::select('portal_user_id')->where('user_cookie_id', $userCookie))
                    ->orWhereIn('user_cookie',
                        UserCookieCouple::select('user_cookie_id')->whereIn('portal_user_id',
                            UserCookieCouple::select('portal_user_id')->where('user_cookie_id', $userCookie)));
            })
            ->whereBetween('created_at', $dateInterval)
            ->first()->count;
    }
}