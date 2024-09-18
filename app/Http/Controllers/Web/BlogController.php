<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Page;
use App\Models\BlogCategory;
use App\Models\Translation\BlogTranslation;
use Illuminate\Http\Request;
use DOMDocument;

class BlogController extends Controller
{
    public function index(Request $request, $category = null)
    {
        $author = $request->get('author', null);
        $search = $request->get('search', null);

        $seoSettings = getSeoMetas('blog');
        $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('home.blog');
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('home.blog');
        $pageRobot = getPageRobot('blog');
		
		
		$requestData = array(
			'getPathInfo' => '/blog',
			'fullUrl' => url('/').'/blog',
		);
		putSitemap($requestData);

        $blogCategories = BlogCategory::all();

        $query = Blog::where('status', 'publish')
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc');

        if (!empty($category)) {
            $blogCategory = $blogCategories->where('slug', $category)->first();
            if (!empty($blogCategory)) {
                $query->where('category_id', $blogCategory->id);
                $pageTitle .= ' ' . $blogCategory->title;
                $pageDescription .= ' ' . $blogCategory->title;
            }
        }

        if (!empty($author) and is_numeric($author)) {
            $query->where('author_id', $author);
        }

        if (!empty($search)) {
            $query->whereTranslationLike('title', "%$search%");
        }

        $blogCount = $query->count();

        $blog = $query->with([
            'category',
            'author' => function ($query) {
                $query->select('id', 'full_name', 'avatar', 'role_id', 'role_name');
            }
        ])
            ->withCount('comments')
            ->paginate(35);

        $popularPosts = $this->getPopularPosts();
		$page = Page::where('link', '/blog')->where('status', 'publish')->first();
        $data = [
            'pageTitle'                  => isset( $page->title )? $page->title : '',
            'page_title'                  => isset( $page->page_title )? $page->page_title : '',
            'pageDescription'            => isset( $page->seo_description )? $page->seo_description : '',
            'pageRobot'                  => isset( $page->robot ) ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            'blog' => $blog,
            'blogCount' => $blogCount,
            'blogCategories' => $blogCategories,
            'popularPosts' => $popularPosts,
        ];

        return view(getTemplate() . '.blog.index', $data);
    }

    public function show($slug)
    {
        if (!empty($slug)) {
            $post = Blog::where('slug', $slug)
                ->where('status', 'publish')
                ->with([
                    'category',
                    'author' => function ($query) {
                        $query->select('id', 'full_name', 'role_id', 'avatar', 'role_name');
                        $query->with('role');
                    },
                    'comments' => function ($query) {
                        $query->where('status', 'active');
                        $query->whereNull('reply_id');
                        $query->with([
                            'user' => function ($query) {
                                $query->select('id', 'full_name', 'avatar', 'avatar_settings', 'role_id', 'role_name');
                            },
                            'replies' => function ($query) {
                                $query->where('status', 'active');
                                $query->with([
                                    'user' => function ($query) {
                                        $query->select('id', 'full_name', 'avatar', 'avatar_settings', 'role_id', 'role_name');
                                    }
                                ]);
                            }
                        ]);
                    }])
                ->first();

            if (!empty($post)) {
                $post->update(['visit_count' => $post->visit_count + 1]);

                $blogCategories = BlogCategory::all();
                $popularPosts = $this->getPopularPosts();
				
				$requestData = array(
					'getPathInfo' => '/blog/'.$slug,
					'fullUrl' => url('/').'/blog/'.$slug,
				);
				putSitemap($requestData);

                $pageRobot = getPageRobot('blog');
				
				
				$result = $this->addRandomIdToH3($post->content);
				$post->content = isset( $result['content'] )? $result['content'] : '';
				$headings_array = isset( $result['headings_array'] )? $result['headings_array'] : array();

                $data = [
                    'pageTitle' => $post->title,
                    'page_title' => $post->title,
                    'pageDescription' => $post->meta_description,
                    'blogCategories' => $blogCategories,
                    'popularPosts' => $popularPosts,
                    'pageRobot' => $pageRobot,
                    'post' => $post,
                    'headings_array' => $headings_array
                ];

                return view(getTemplate() . '.blog.show', $data);
            }
            if (!empty($translate)) {
                app()->setLocale($translate->locale);


            }
        }

        abort(404);
    }

    private function getPopularPosts()
    {
        return Blog::where('status', 'publish')
            ->orderBy('visit_count', 'desc')
            ->limit(5)
            ->get();
    }
	
	public function addRandomIdToH3($content) {
		// Load the HTML content into a DOMDocument
		$dom = new DOMDocument();
		// Suppress errors due to malformed HTML
		@$dom->loadHTML($content);

		// Get all h3 elements
		$h3Tags = $dom->getElementsByTagName('h3');
		$headings_array = [];

		// Loop through each h3 tag
		foreach ($h3Tags as $h3) {
			// Generate a random number for the ID
			$randomId = 'rurera-heading-' . rand(1000, 9999);

			// Set the ID attribute to the h3 element
			$h3->setAttribute('id', $randomId);

			// Store the h3 text with the random ID as the index
			$headings_array[$randomId] = $h3->nodeValue;
		}

		// Save the updated HTML content
		$updatedContent = $dom->saveHTML();

		return [
			'content' => $updatedContent,
			'headings_array' => $headings_array
		];
	}
}
