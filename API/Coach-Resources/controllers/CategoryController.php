<?php

namespace app\controllers;

use app\repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = new categoryRepository();
    }

    public function index(): void
    {
        $this->response->execute($this->categoryRepository->findAll(),[
            'success_title' => 'categories'
        ]);
    }

    public function show($id): void
    {
        // Show all the posts linked to this category
        $this->response->execute($this->categoryRepository->hasMany('category_id','posts',$id),[
            'success_title' => 'posts',
        ]);
    }
}
