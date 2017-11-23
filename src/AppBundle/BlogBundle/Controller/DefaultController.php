<?php

namespace AppBundle\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AppBundleBlogBundle:Default:index.html.twig');
    }

    /**
     * @Route("/post/{post_id}", name="blog_post", requirements={"post_id": "\d+"})
     */
    public function affichePostAction($post_id = 1)
    {
		// renders /Resources/views/Posts/post.html.twig
        return $this->render('Posts/post.html.twig', array('post_id' => $post_id));
    }

	/**
     * @Route("/luckynumber/{max}")
     */
    public function numberAction($max)
    {
        $number = mt_rand(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
