<?php

namespace app\controllers;

use app\helpers\Validation;
use app\models\Post;
use app\repository\PostRepository;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    /**
     * @return void
     */
    public function index(): void
    {
        echo $this->ToJson($this->postRepository->findAll());
    }

    /**
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
        echo $this->ToJson($this->postRepository->find($id));
    }

    /**
     * @param array $request
     * @return self
     */
    public function create(array $request) : self
    {
        $post = new Post();

        $post->setTitle($request['title']);
        $post->setExcerpt($request['excerpt']);
        $post->setBody($request['body']);

        // Validation
        $validationHelper = new Validation($request);

        $validationHelper->required([
            'title' => 'The title is required',
            'excerpt' => 'The excerpt is required',
            'body' => 'The body is required'
        ]);

        $validationHelper->min([
            'title' => 'The title requires at least 5 characters'
        ],5);

        if($validationHelper->validate())
        {
            $this->postRepository->save($post);
            echo $this->toJson(['message' => 'Post added']);
        }

        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function destroy(int $id) : self
    {
        // Destroy the post
        $post = $this->postRepository->delete($id);

        if($post) echo $this->toJson(['message' => 'Post delete']);

        return $this;
    }
}