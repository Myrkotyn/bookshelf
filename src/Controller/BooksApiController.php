<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ApiController
 * @Rest\Route("/books")
 */
class BooksApiController extends FOSRestController
{
    /**
     * @Rest\Get("/", name="get_all_books")
     *
     * @param Request $request
     * @return View
     */
    public function getAllBooks(Request $request)
    {
        $books = $this->getDoctrine()->getManager()->getRepository(Book::class)->findAll();

        if (!$books) {
            throw new NotFoundHttpException("Books not found");
        }

        return View::create($this->get('serializer')->normalize($books, 'json', ["groups" => ["default"]]), Response::HTTP_OK);
    }
}