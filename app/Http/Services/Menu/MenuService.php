<?php


namespace App\Http\Services\Menu;


use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class MenuService
{
    public function getAll()
    {
        $response = Http::get('webservice.test/admin/menus/add');
        return $response->json();
    }

    public function getParent($id)
    {
        $response = Http::get('webservice.test/admin/menus/edit'.$id);
        return $response->json();
    }

    // public function getAll()
    // {
    //     return Menu::orderbyDesc('id')->paginate(10);
    // }

    public function create($request)
    {
        try {
            $data = $request->except('_token');
            $response = Http::get('webservice.test/admin/menus/store',$data);
            // dd($response->json());
            // Menu::create([
            //     'name' => (string)$request->input('name'),
            //     'parent_id' => (int)$request->input('parent_id'),
            //     'description' => (string)$request->input('description'),
            //     'content' => (string)$request->input('content'),
            //     'active' => (string)$request->input('active')
            // ]);

            Session::flash('success', 'Tạo Danh Mục Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }

        return true;

    }

    public function update($request, $menu): bool
    {
        if ($request->input('parent_id') != $menu->id) {
            $menu->parent_id = (int)$request->input('parent_id');
        }

        $menu->name = (string)$request->input('name');
        $menu->description = (string)$request->input('description');
        $menu->content = (string)$request->input('content');
        $menu->active = (string)$request->input('active');
        $menu->save();

        Session::flash('success', 'Cập nhật thành công Danh mục');
        return true;
    }

    public function destroy($request)
    {
        $id = (int)$request->input('id');
        $menu = Menu::where('id', $id)->first();
        if ($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }

        return false;
    }
    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }

    public function getProduct($menu, $request)
    {
        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        
    }
}
