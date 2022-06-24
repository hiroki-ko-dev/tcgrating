<?php

namespace App\Services;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCommentRepository;

use Illuminate\Http\Request;

class BlogService
{
    protected $blogRepository;
    protected $blogCommentRepository;

    public function __construct(BlogRepository $blogRepository,
                                BlogCommentRepository $blogCommentRepository)
    {
        $this->blogRepository         = $blogRepository;
        $this->blogCommentRepository = $blogCommentRepository;
    }

    /**
     * @param $request
     * @return \App\Repositories\Post
     */
    public function makeBlog($request)
    {
        return $this->blogRepository->create($request);

    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveBlog($request)
    {
        return $this->blogRepository->update($request);
    }

    /**
     * @param $blog_id
     * @return mixed
     */
    public function getBlog($blog_id)
    {
        return $this->blogRepository->find($blog_id);
    }

    /**
     * @param $blog_id
     * @return mixed
     */
    public function getPreviewBlog($blog_id)
    {
        return $this->blogRepository->findByPreview($blog_id);
    }

    /**
     * @param $blog_id
     * @return mixed
     */
    public function getNextBlog($blog_id)
    {
        return $this->blogRepository->findByNext($blog_id);
    }

    public function getBlogByPaginate($request, $paginate)
    {
        return $this->blogRepository->findAllByPaginate($request, $paginate);
    }


}
