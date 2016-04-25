<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $tweets = $this->get('app.twitter')->get('statuses/user_timeline', [
            'screen_name' => 'grands_enfants',
            'exclude_replies' => true
        ]);
        return $this->render('default/index.html.twig', ['tweets' => $tweets]);
    }
}
