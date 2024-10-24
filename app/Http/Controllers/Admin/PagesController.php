<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Translation\PageTranslation;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        removeContentLocale();

        $this->authorize('admin_pages_list');

        $pages = Page::orderBy('created_at', 'desc')->paginate(100);

        $data = [
            'pageTitle' => trans('admin/pages/setting.pages'),
            'pages' => $pages
        ];

        return view('admin.pages.lists', $data);
    }

    public function create()
    {
        $this->authorize('admin_pages_create');

        $data = [
            'pageTitle' => trans('admin/pages/setting.new_pages')
        ];

        return view('admin.pages.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_pages_create');

        $this->validate($request, [
            'locale' => 'required',
            'name' => 'required',
            'title' => 'required|min:50|max:60',
            'page_title' => 'required|min:50|max:60',
            //'link' => 'required|unique:pages,link',
            'link' => 'required',
            'seo_description' => 'nullable|string|min:150|max:160',
            'content' => 'required',
        ]);

        $data = $request->all();

        $firstCharacter = substr($data['link'], 0, 1);
        if ($firstCharacter !== '/') {
            $data['link'] = '/' . $data['link'];
        }

        $data['robot'] = (!empty($data['robot']) and $data['robot'] == '1');
        $subheader = isset( $data['subheader'] )? $data['subheader'] : 0;
        $page = Page::create([
            'link' => $data['link'],
            'name' => $data['name'],
            'robot' => $data['robot'],
            'status' => $data['status'],
            'created_at' => time(),
            'subheader'    => $subheader,
            'include_xml' => isset( $data['include_xml'] )? $data['include_xml'] : 0,

        ]);

        PageTranslation::updateOrCreate([
            'page_id' => $page->id,
            'locale' => mb_strtolower($data['locale'])
        ], [
            'title' => $data['title'],
            'seo_description' => $data['seo_description'] ?? null,
            'content' => $data['content'],
			'page_title' => isset( $data['page_title'] )? $data['page_title'] : '',
        ]);

        return redirect(getAdminPanelUrl().'/pages');
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_pages_edit');

        $locale = $request->get('locale', app()->getLocale());

        $page = Page::findOrFail($id);


        storeContentLocale($locale, $page->getTable(), $page->id);

        $data = [
            'pageTitle' => trans('admin/pages/setting.edit_pages') . $page->name,
            'page' => $page
        ];

        return view('admin.pages.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_pages_edit');

        $page = Page::findOrFail($id);

        $this->validate($request, [
            'locale' => 'required',
            'name' => 'required',
            //'link' => 'required|unique:pages,link,' . $page->id,
            'link' => 'required',
            'title' => 'required|min:50|max:60',
            'page_title' => 'required|min:50|max:60',
            'seo_description' => 'nullable|string|min:150|max:160',
            'content' => 'required',
        ]);

        $data = $request->all();

        $firstCharacter = substr($data['link'], 0, 1);
        if ($firstCharacter !== '/') {
            $data['link'] = '/' . $data['link'];
        }

        $data['robot'] = (!empty($data['robot']) and $data['robot'] == '1');
        $subheader = isset( $data['subheader'] )? $data['subheader'] : 0;
        $page->update([
            'link' => $data['link'],
            'name' => $data['name'],
            'robot' => $data['robot'],
            'status' => $data['status'],
            'created_at' => time(),
            'subheader'    => $subheader,
            'country_location'  => json_encode($data['country_location']),
            'include_xml' => isset( $data['include_xml'] )? $data['include_xml'] : 0,
        ]);

        PageTranslation::updateOrCreate([
            'page_id' => $page->id,
            'locale' => mb_strtolower($data['locale'])
        ], [
            'title' => $data['title'],
            'seo_description' => $data['seo_description'] ?? null,
            'content' => $data['content'],
			'page_title' => isset( $data['page_title'] )? $data['page_title'] : '',
        ]);

        removeContentLocale();

        return redirect(getAdminPanelUrl().'/pages');
    }

    public function delete($id)
    {
        $this->authorize('admin_pages_delete');

        $page = Page::findOrFail($id);

        $page->delete();

        return redirect(getAdminPanelUrl().'/pages');
    }

    public function statusTaggle($id)
    {
        $this->authorize('admin_pages_toggle');

        $page = Page::findOrFail($id);

        $page->update([
            'status' => ($page->status == 'draft') ? 'publish' : 'draft'
        ]);

        return redirect(getAdminPanelUrl().'/pages');
    }
}
