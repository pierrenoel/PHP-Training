<?php

namespace app\controllers;

use app\helpers\Response;
use app\helpers\Validation;
use app\models\Post;
use app\repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = new categoryRepository();
    }

    public function index()
    {
        // Show all the categories
        $this->response->execute($this->categoryRepository->findAll(),[
            'success_title' => 'Categories',
        ]);
    }

}
