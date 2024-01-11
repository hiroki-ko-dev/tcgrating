<?php

namespace App\Repositories;

use App\Models\Blog;

class BlogRepository
{
    public function composeSaveClause(Blog $blog, array $attrs)
    {
        if (isset($attrs['game_id'])) {
            $blog->game_id = $attrs['game_id'];
        }
        if (isset($attrs['user_id'])) {
            $blog->user_id = $attrs['user_id'];
        }
        $blog->title   = $attrs['title'];
        $blog->thumbnail_image_url = $attrs['thumbnail_image_url'];
        if (isset($attrs['affiliate_url'])) {
            $blog->affiliate_url = $attrs['affiliate_url'];
        }
        $blog->body = $attrs['body'];
        $blog->is_released = $attrs['is_released'];
        $blog->save();
        return $blog;
    }

    public function create(array $attrs)
    {
        $blog = new Blog();
        return $this->composeSaveClause($blog, $attrs);
    }

    public function update(int $blogId, array $attrs)
    {
        $blog = $this->find($blogId);
        return $this->composeSaveClause($blog, $attrs);
    }

    public function composeWhereClause(array $filters)
    {
        $query = Blog::query();

        if (isset($filters['game_id'])) {
            $query->where('game_id', $filters['game_id']);
        }
        if (isset($filters['is_released'])) {
            $query->where('is_released', $filters['is_released']);
        }
        return $query;
    }

    public function find($id): ?Blog
    {
        return Blog::find($id);
    }

    public function findByPreview($id): ?Blog
    {
        return Blog::where('id', '<=', $id)
            ->where('is_released', 1)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function findByNext($id): ?Blog
    {
        return Blog::where('id', '>=', $id)
            ->where('is_released', 1)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function findAll($filters)
    {
        $query = $this->composeWhereClause($filters);
        return $query->get();
    }

    public function paginate($filters, $row)
    {
        $query = $this->composeWhereClause($filters);
        return $query->withCount('blogComment')
            ->OrderBy('updated_at', 'desc')
            ->paginate($row);
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}
