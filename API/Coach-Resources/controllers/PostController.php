<?php

namespace app\controllers;

use app\helpers\Response;
use app\helpers\Validation;
use app\models\Post;
use app\repositories\PostRepository;

class PostController extends Controller
{
    protected PostRepository $postRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository();
    }

    public function index(): void
    {
        $this->response->execute($this->postRepository->findAll(),[
            'title' => 'posts'
        ]);
    }

    public function show(int $id): void
    {
        $this->response->execute($this->postRepository->find($id),[
            'success_title' => 'post',
            'error_message' => 'The post is not found',
            'error_code' => 404
        ]);
    }

    public function create() : void
    {

        $post = new Post();
        $validation = new Validation($this->request);

        $post->setTitle($this->request['title']);
        $post->setExcerpt($this->request['excerpt']);
        $post->setBody($this->request['body']);

        $validation->required([
            'title' => 'The title is required',
            'excerpt' => 'The excerpt is required',
            'body' => 'The body is required'
        ]);

        if($validation->validate())

            $this->response->execute($this->postRepository->save($post), [
                'success_title' => 'message',
                'success_message' => 'The post is added'
            ]);
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
        $post = $this->postRepository->find($id);
        $validation = new Validation($this->request);

        $validation->min([
            'title' => 'The title requires at least 5 characters'
        ],5);

        if($validation->validate())

            $this->response->execute($this->postRepository->update($post,$this->request), [
                'success_title' => 'message',
                'success_message' => 'The post is edited'
            ]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id) : void
    {
        $post = $this->postRepository->find($id);

        if($post['id'])
        {
            $this->response->execute($this->postRepository->delete($post['id']), [
                'success_title' => 'message',
                'success_message' => 'The post is delete'
            ]);
        }
        else $this->response->setError('The post is not found',404);
    }
}