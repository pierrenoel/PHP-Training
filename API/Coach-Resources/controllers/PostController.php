<?php

namespace app\controllers;

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
        echo $this->ToJson($this->postRepository->show($id));
    }
}