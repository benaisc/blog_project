<?php

namespace AppBundle\BlogBundle\Controller;

use AppBundle\Entity\BlogPost;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class BlogController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig',
                             array('posts' => $this->getAllBlogPost()));
    }

    /**
     * @Route("/about", name="about_me")
     */
    public function aboutAction()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/post/{post_id}", name="blog_post", requirements={"post_id": "\d+"})
     */
    public function affichePostID($post_id = 1)
    {
        return $this->render('Posts/post.html.twig',
                            array('post' => $this->getBlogPost($post_id)));
    }

    /**
     * @Route("/post/{alias}", name="show_post")
     */
    public function affichePostAlias($alias)
    {
        return $this->render('Posts/post.html.twig',
                            array('post' => $this->getBlogPostByAlias($alias)));
    }

    public function getBlogPost($id = 1){
        $blogPost = $this->getDoctrine()
            ->getRepository('AppBundle:BlogPost')
            ->find($id);

        if(! $blogPost ){
            throw $this->createNotFoundException('Aucun BlogPost pour cet id :'.$id.' !');
        }

        return $blogPost;
    }

    public function getBlogPostByAlias($alias){
        $blogPost = $this->getDoctrine()
            ->getRepository('AppBundle:BlogPost')
            ->findOneBy(['urlAlias' => $alias]);

        if(! $blogPost ){
            throw $this->createNotFoundException('Aucun BlogPost pour cet URL :'.$alias.' !');
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
