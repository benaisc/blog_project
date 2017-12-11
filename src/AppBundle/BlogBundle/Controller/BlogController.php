<?php

namespace AppBundle\BlogBundle\Controller;

use AppBundle\Entity\BlogPost;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', array('posts' => $this->getAllBlogPost()));
    }

    /**
     * @Route("/post/{post_id}", name="blog_post", requirements={"post_id": "\d+"})
     */
    public function affichePostAction($post_id = 1)
    {
        return $this->render('Posts/post.html.twig', array('post' => $this->getBlogPost($post_id)));
    }


    public function getBlogPost($id){
        $blogPost = $this->getDoctrine()
            ->getRepository('AppBundle:BlogPost')
            ->find($id);

        if(! $blogPost ){
            throw $this->createNotFoundException('Aucun BlogPost pour cet id :'.$id.' !');
        }

        return $blogPost;
    }

    public function getAllBlogPost(){
        $blogPosts = $this->getDoctrine()
            ->getRepository('AppBundle:BlogPost')
            ->findAll();

        if(! $blogPosts ){
            throw $this->createNotFoundException('Aucun BlogPosts !');
        }

        return $blogPosts;
    }
}
