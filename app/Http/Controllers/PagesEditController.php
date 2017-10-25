<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request)
    {
        //$page = Page::find($id);

        if($request->isMethod('delete')) {
            $page->delete();

            return redirect('admin/pages')->with('status', 'Страница удалена');
        }

        if($request->isMethod('post')) {
            $input = $request->except('_token');

            $message = [
                'required' => 'Поле :attribute обязательно для заполнения',
                'unique' => 'Поле :attribute должно быть уникальным',
            ];

            $validator = \Validator::make($input, [
                'name' => 'required|max:255',
                'alias' => 'required|unique:pages,alias,'.$input['id'].'|max:255',
                'text' => 'required',
            ], $message);

            if($validator->fails()) {
                return redirect()
                    ->route('pagesEdit', ['page' => $input['id']])
                    ->withErrors($validator);
            }

            if($request->hasFile('images')) {
                $file = $request->file('images');
                $file->move(public_path().'/assets/img', $file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();
            } else {
                $input['images'] = $input['old_images'];
            }

            unset($input['old_images']);

            $page->fill($input);

            if($page->update()) {
                return redirect('admin')->with('status', 'Страница обновлена');
            }
        }

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
