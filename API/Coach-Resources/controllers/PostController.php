<?php

namespace app\controllers;

use app\helpers\ExceptionHelper;
use app\helpers\Validation;
use app\models\Post;
use app\repositories\PostRepository;

class PostController extends Controller
{
    protected PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function index(): void
    {
        echo ExceptionHelper::getException(
            'posts', $this->postRepository->findAll(),
            [
                'response_code' => 404,
                'message' => 'Oops something is wrong'
            ]
        );
    }

    public function show(int $id): void
    {
        echo ExceptionHelper::getException(
            'posts', $this->postRepository->find($id),
                [
                    'response_code' => 404,
                    'message' => 'Oops something is wrong'
                ]
        );
    }

    public function create() : void
    {

        $request = app('request')->request->all();

        $post = new Post();

        $post->setTitle($request['title']);
        $post->setExcerpt($request['excerpt']);
        $post->setBody($request['body']);

        // Validation here

        echo ExceptionHelper::postException(
            'posts',
            'The post is added',
            $this->postRepository->save($post),
            [
                'response_code' => 500,
                'message' => 'Oops, something is wrong, post not added'
            ]
        );

    }

    /*
     * @param int $id
     * @param Request $request
     * @return void
     */
    /**
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        // Find the post by ID
        $existingPost = $this->postRepository->find($id);

        // get the request
        $request = app('request')->request->all();

        // Validation
        $validationHelper = new Validation($request);

        $validationHelper->min([
            'title' => 'The title requires at least 5 characters'
        ],5);

        // Todo : improve this part ...

        if($validationHelper->validate())
        {
            $this->postRepository->update($existingPost,$request);
            echo $this->toJson(['message' => 'Post edited']);
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id) : void
    {
        // Destroy the post
        $post = $this->postRepository->delete($id);
        if($post) echo $this->toJson(['message' => 'Post delete']);
    }
}