<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Language;
use App\Form\BookType;
use App\Form\BookUpdateType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BooksApiController
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
    public function getAllBooksAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $search = $request->query->get('search', null);
        if ($search) {
            $books = $repository->search($search);
        } else {
            $books = $repository->findAll();
        }

        if (!$books) {
            throw new NotFoundHttpException("Books not found");
        }
        $paginatorCount = count($books) % 5;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return View::create($this->get('serializer')->normalize(["books" => $pagination, "paginatorCount" => $paginatorCount], '', ["groups" => ["default"]]), Response::HTTP_OK);
    }

    /**
     * Get book by id
     *
     * @Rest\Get("/{id}", name="get_book")
     *
     * @param Request $request
     * @param Book    $book
     * @return View
     */
    public function getBookAction(Request $request, Book $book)
    {
        return View::create($this->get('serializer')->normalize($book, '', ["groups" => ["default"]]), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/{author_id}/{genre_id}/{language_id}", name="create_new_book")
     * @ParamConverter("author", class="App:Author", options={"id" = "author_id"})
     * @ParamConverter("genre", class="App:Genre", options={"id" = "genre_id"})
     * @ParamConverter("language", class="App:Language", options={"id" = "language_id"})
     * @param Request  $request
     * @param Author   $author
     * @param Genre    $genre
     * @param Language $language
     * @return View
     */
    public function createAction(Request $request, Author $author, Genre $genre, Language $language)
    {
        $book = new \App\Form\Model\Book();

        $form = $this->createForm(BookType::class, $book, [
            'method' => Request::METHOD_POST
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $book = $form->getData();

            $bookEntity = (new Book())
                ->setTitle($book->getTitle())
                ->setPublicationDate($book->getPublicationDate())
                ->setISBNNumber($book->getISBNNumber())
                ->setImageFile($book->getImageFile())
                ->setTitle($book->getTitle())
                ->setAuthor($author)
                ->setGenre($genre)
                ->setLanguage($language);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bookEntity);
            $em->flush();

            return View::create($this->get('serializer')->normalize($bookEntity, '', ['groups' => ['default']]), Response::HTTP_CREATED);
        }

        return View::create($form, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @Rest\Put("/{id}", name="update_book")
     *
     * @param Request $request
     * @param Book    $book
     * @return View
     */
    public function updateAction(Request $request, Book $book)
    {
        $form = $this->createForm(BookUpdateType::class, $book, [
            'method' => Request::METHOD_PUT
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return View::create($this->get('serializer')->normalize($book, '', ['groups' => ['default']]), Response::HTTP_CREATED);
        }

        return View::create($form, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}