<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoriesController extends Controller
{
    public function index()
    {
        $this->authorize('admin_blog_categories');

        $blogCategories = BlogCategory::withCount('blog')->get();

        $data = [
            'pageTitle' => trans('admin/pages/blog.blog_categories'),
            'blogCategories' => $blogCategories
        ];

        return view('admin.blog.categories', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_blog_categories_create');

        $this->validate($request, [
            'title' => 'required|string|unique:blog_categories',
        ]);
		
		$slug = ($request->get('slug') != '')? strtolower($request->get('slug')) : BlogCategory::makeSlug(strtolower($request->get('title')));

        BlogCategory::create([
            'title' => $request->get('title'),
            'slug' => $slug
        ]);

        return redirect(getAdminPanelUrl().'/blog/categories');
    }

    public function edit($category_id)
    {
        $this->authorize('admin_blog_categories_edit');

        $editCategory = BlogCategory::findOrFail($category_id);

        $data = [
            'pageTitle' => trans('admin/pages/blog.blog_categories'),
            'editCategory' => $editCategory
        ];

        return view('admin.blog.categories', $data);
    }

    public function update(Request $request, $category_id)
    {
        $this->authorize('admin_blog_categories_edit');

        $this->validate($request, [
            'title' => 'required',
        ]);
		
		
		$slug = ($request->get('slug') != '')? strtolower($request->get('slug')) : BlogCategory::makeSlug(strtolower($request->get('title')));

        $editCategory = BlogCategory::findOrFail($category_id);

        $editCategory->update([
            'title' => $request->get('title'),
            'slug' => $slug
        ]);

        return redirect(getAdminPanelUrl().'/blog/categories');
    }

    public function delete($category_id)
    {
        $this->authorize('admin_blog_categories_delete');

        $editCategory = BlogCategory::findOrFail($category_id);

        $editCategory->delete();

        return redirect(getAdminPanelUrl().'/blog/categories');
    }
}
