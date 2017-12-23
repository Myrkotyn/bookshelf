<?php

namespace App\Controller;

use App\Entity\Genre;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class GenreApiController
 * @Rest\Route("/genres")
 */
class GenreApiController extends FOSRestController
{
    /**
     * @Rest\Get("/", name="get_all_genres")
     *
     * @param Request $request
     * @return View
     */
    public function getAllGenres(Request $request)
    {
        $genres = $this->getDoctrine()->getManager()->getRepository(Genre::class)->findAll();

        if (!$genres) {
            throw new NotFoundHttpException('Genres not found!');
        }

        return View::create($this->get('serializer')->normalize($genres, "", ["groups" => ["genre"]]), Response::HTTP_OK);
    }
}