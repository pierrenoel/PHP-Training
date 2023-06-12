<?php

namespace app\controllers;

use app\helpers\Validation;
use app\models\Post;
use app\repositories\PostRepository;
use Symfony\Component\HttpFoundation\Request;

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
     * @return void
     */
    public function create(array $request) : void
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
    }

    /*
     * @param int $id
     * @param Request $request
     * @return void
     */
    /**
     * @param int $id
     * @param Request $request
     * @return void
     */
    public function edit(int $id, Request $request): void
    {
        // Find the post by ID
        $existingPost = $this->postRepository->find($id);

        // get the request
        $request = $request->request->all();

        // Validation
        $validationHelper = new Validation($request);

        $validationHelper->min([
            'title' => 'The title requires at least 5 characters'
        ],5);

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