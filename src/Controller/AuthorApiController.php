<?php

namespace App\Controller;

use App\Entity\Author;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthorApiController
 * @Rest\Route("/authors")
 */
class AuthorApiController extends FOSRestController
{
    /**
     * @Rest\Get("/", name="get_all_authors")
     *
     * @param Request $request
     * @return View
     */
    public function getAllAuthors(Request $request)
    {
        $authors = $this->getDoctrine()->getManager()->getRepository(Author::class)->findAll();

        if (!$authors) {
            throw new NotFoundHttpException("Authors not found");
        }

        return View::create($this->get('serializer')->normalize($authors, "", ["groups" => ["author"]]), Response::HTTP_OK);
    }
}