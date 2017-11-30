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
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/post/{post_id}", name="blog_post", requirements={"post_id": "\d+"})
     */
    public function affichePostAction($post_id = 1)
    {
        return $this->render('Posts/post.html.twig', array('post_id' => $post_id));
    }

    /**
     * @Route("/posts", name="all_posts")
     */
    public function afficheAllPosts()
    {
        return $this->render('Posts/posts.html.twig', array('posts' => $this->getAllBlogPost()));
    }

	/**
     * @Route("/luckynumber/{max}")
     */
    public function numberAction($max = 100)
    {
        $number = mt_rand(0, $max);

        return new Response(
            '<html><body>Lucky number: <p style="font-size:100px">'.$number.'</p></body></html>'
        );
    }

    public function createBlogPost(){
        $blogPost = new BlogPost();
        $blogPost->setTitle("Titre BlogPost!");
        $blogPost->getUrlAlias('');
        $blogPost->setContent("Contenu BlogPost!!");
        $blogPost->setPublished(null);

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return new Response('ID du BlogPost créé: '.$blogPost->getId());
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
