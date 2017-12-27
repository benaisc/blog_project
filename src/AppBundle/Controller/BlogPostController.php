<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Blogpost controller.
 *
 * @Route("admin")
 */
class BlogPostController extends Controller
{
    /**
     * Lists all blogPost entities.
     *
     * @Route("/", name="blogpost_index")
     * @Method("GET")
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogPosts = $em->getRepository('AppBundle:BlogPost')->findAll();

        return $this->render('blogpost/index.html.twig', array(
            'blogPosts' => $blogPosts,
        ));
    }

    /**
     * Creates a new blogPost entity.
     *
     * @Route("/new", name="blogpost_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blogPost = new Blogpost();
        $blogPost->setPublished(new \DateTime('now'));
        $form = $this->createForm('AppBundle\Form\BlogPostType', $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($blogPost->getImage() != null) {
                // $file stores the uploaded PNG file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $blogPost->getImage();

                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                // Move the file to the directory where images are stored
                $file->move(
                    $this->getParameter('images_directory'), $fileName
                );

                // Update the 'image' property to store the PNG file name
                // instead of its contents
                $blogPost->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($blogPost);
            $em->flush();

            return $this->redirectToRoute('blogpost_show', array('id' => $blogPost->getId()));
        }

        return $this->render('blogpost/new.html.twig', array(
            'blogPost' => $blogPost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blogPost entity.
     *
     * @Route("/{id}", name="blogpost_show")
     * @Method("GET")
     */
    public function showAction(BlogPost $blogPost)
    {
        $deleteForm = $this->createDeleteForm($blogPost);

        return $this->render('blogpost/show.html.twig', array(
            'blogPost' => $blogPost,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blogPost entity.
     *
     * @Route("/{id}/edit", name="blogpost_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlogPost $blogPost)
    {
        $oldImage = $blogPost->getImage();

        // Charge l'image
        if($blogPost->getImage() != null){
            try {
                $blogPost->setImage(
                    new File($this->getParameter('images_directory') . '/' . $blogPost->getImage())
                );
            }
            catch (FileNotFoundException $fnf){
                $blogPost->setImage(null);
                $oldImage = null;
            }
        }

        $deleteForm = $this->createDeleteForm($blogPost);
        $editForm = $this->createForm('AppBundle\Form\BlogPostType', $blogPost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if($blogPost->getImage() != null) {
                //Handle la suppression de l'image correspondant au post
                if($oldImage != null) {
                    $img = new File($this->getParameter('images_directory') . '/' . $oldImage);
                    unlink($img);
                }

                // $file stores the uploaded PNG file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $blogPost->getImage();

                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                // Move the file to the directory where images are stored
                $file->move(
                    $this->getParameter('images_directory'), $fileName
                );

                // Update the 'image' property to store the PNG file name
                // instead of its contents
                $blogPost->setImage($fileName);
            }
            else{
                $blogPost->setImage($oldImage);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_post', array('alias' => $blogPost->getUrlAlias()));
        }

        return $this->render('blogpost/edit.html.twig', array(
            'blogPost' => $blogPost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blogPost entity.
     *
     * @Route("/{id}", name="blogpost_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlogPost $blogPost)
    {
        $form = $this->createDeleteForm($blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Handle la suppression de l'image correspondant au post
            $img = new File($this->getParameter('images_directory').'/'.$blogPost->getImage());
            unlink($img);

            $em = $this->getDoctrine()->getManager();
            $em->remove($blogPost);
            $em->flush();
        }

        return $this->redirectToRoute('blogpost_index');
    }

    /**
     * Creates a form to delete a blogPost entity.
     *
     * @param BlogPost $blogPost The blogPost entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlogPost $blogPost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blogpost_delete', array('id' => $blogPost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
