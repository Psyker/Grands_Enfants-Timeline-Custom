<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tweet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($request->cookies->get('daily_req') == null || $this->getDoctrine()->getRepository('AppBundle:Tweet')->findAll() == null){
            setcookie('daily_req', 1, time()+86400, "/");
            $tweets = $this->get('app.twitter')->get('statuses/user_timeline', [
                'screen_name' => 'grands_enfants',
                'exclude_replies' => true
            ]);
            foreach ($tweets as $tweet) {
                $myTweet = new Tweet();
                $myTweet->setCreatedAt(new \DateTime($tweet->created_at));
                $myTweet->setTweetUrl("https://twitter.com/" .  $tweet->user->screen_name ."/status/" . $tweet->id_str);
                $myTweet->setLikes($tweet->favorite_count);
                $myTweet->setRetweets($tweet->retweet_count);
                $myTweet->setImageUrl($tweet->entities->media[0]->media_url);
                $mentions = [];
                foreach ($tweet->entities->user_mentions as $mention) {
                    array_push($mentions, $mention->screen_name);
                }
                $myTweet->setMentions($mentions);
                preg_match_all('/\[([^\]]*)\]/', $tweet->text, $matches);
                $category = str_replace(']', '', str_replace('[', '', $matches[0]))[0];
                $myTweet->setCategory($category);
                $hashtags = [];
                foreach ($tweet->entities->hashtags as $hashtag) {
                    array_push($hashtags, $hashtag->text);
                }
                $myTweet->setHashtags($hashtags);
                $myTweet->setTitle(str_replace('[' . $category . '] ', '', $tweet->text));
                $myTweet->setUrl($tweet->entities->urls[0]->expanded_url);
                if ($this->getDoctrine()->getRepository('AppBundle:Tweet')->findOneBy(['imageUrl' => $myTweet->getImageUrl()]) == null) {
                    $this->getDoctrine()->getManager()->persist($myTweet);
                    $this->getDoctrine()->getManager()->flush();
                }
            }
        }

        return $this->render('default/index.html.twig', ['subtitle' => 'Last tweets', 'tweets' => $this->getDoctrine()->getRepository('AppBundle:Tweet')->findAll()]);


    }

        /**
         * @Route("/hashtag/{hashtag}", name="hashtag")
         */
        public function hashtagAction($hashtag)
        {
            return $this->render('default/index.html.twig', ['subtitle' => '#'.$hashtag,'tweets' => $this->getDoctrine()->getRepository('AppBundle:Tweet')->findByHasgtag($hashtag)]);
        }

        /**
         * @Route("/category/{category}", name="view_by_category")
         */

        public function viewCategoryAction($category)
        {
            return $this->render('default/index.html.twig', ['subtitle' => ucfirst($category) . ' category' ,'tweets' => $this->getDoctrine()->getRepository('AppBundle:Tweet')->findBy(['category' => $category])]);
        }

        /**
         * @Route(name="categories")
         */
        public function getAllCategoriesAction(){
            return $this->render('default/categories.html.twig', ['categories'=>$this->getDoctrine()->getRepository('AppBundle:Tweet')->findAllCategories()]);
        }

        /**
         * @Route("/stats/", name="statistics")
         */
        public function viewStatsAction()
        {

            return $this->render('default/statistics.html.twig',
                ['most_used_categories'=> $this->getDoctrine()->getRepository('AppBundle:Tweet')->findNthCategories(10), 'most_used_hashtags' => $this->getDoctrine()->getRepository('AppBundle:Tweet')->findNthHashtags(10)
            ]);
        }
}
