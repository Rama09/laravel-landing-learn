<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request)
    {
        //$page = Page::find($id);

        $old = $page->toArray();
        if(view()->exists('admin.pages_edit')) {
            $data = [
                'title' => 'Редактирование страницы - '.$old['name'],
                'data' => $old,
            ];

            return view('admin.pages_edit', $data);
        }

        abort(404);
    }
}
