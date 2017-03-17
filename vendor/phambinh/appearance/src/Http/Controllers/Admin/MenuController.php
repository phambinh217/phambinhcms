<?php

namespace Phambinh\Appearance\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Phambinh\Appearance\Menu;
use Phambinh\Appearance\MenuItem;

class MenuController extends AdminController
{
    public function index()
    {
        $menus = Menu::get();
        $this->data['menus'] = $menus;

        \Metatag::set('title', trans('menu.list-menu'));
        return view('Appearance::admin.menu.index', $this->data);
    }

    public function menuEdit(Menu $menu)
    {
        $this->data['menu'] = $menu;
        $this->data['menu_id'] = $menu->id;
        
        \Metatag::set('title', trans('menu.edit-menu'));
        return view('Appearance::admin.menu.edit', $this->data);
    }

    public function menuUpdate(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'menu.name' => 'required',
            'menu.slug' => '',
            'menu.location' => '',
        ]);

        $menu->fill($request->input('menu'));

        if (empty($menu->slug)) {
            $menu->slug = str_slug($menu->name);
        }
        
        $menu->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('menu.update-menu-success'),
            ]);
        }

        return redirect()->back();
    }

    public function menuUpdateStruct(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'menu.struct' => 'required',
        ]);
        
        $menu->updateStruct(json_decode($request->input('menu.struct'), true));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('menu.update-menu-struct'),
            ]);
        }

        return redirect()->back();
    }

    public function menuStore(Request $request)
    {
        $this->validate($request, [
            'menu.name' => 'required',
            'menu.slug' => '',
        ]);

        $menu = new Menu();
        $menu->fill($request->input('menu'));
        
        if (empty($menu->slug)) {
            $menu->slug = str_slug($menu->name);
        }

        $menu->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('menu.create-success-menu'),
                'redirect' => route('admin.appearance.menu.index', ['menu_id' => $menu->id]),
            ]);
        }

        return reidrect()->back();
    }

    public function menuAdd(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'object_id' => 'required',
            'type' => 'required',
        ]);

        $type = $request->input('type');
        $objects = $type::whereIn('id', $request->input('object_id'))->get();

        foreach ($objects as $object) {
            $object->addToMenu($menu->id);
        }

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('menu.add-menu-success'),
                'redirect' => route('admin.appearance.menu.edit', ['menu_id' => $menu->id]),
            ]);
        }

        return redirect()->back();
    }

    public function menuAddByDefault(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'menu_item.title' => 'required',
            'menu_item.url' => '',
        ]);

        $menu->items()->create($request->input('menu_item'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('menu.add-menu-success'),
                'redirect' => route('admin.appearance.menu.edit', ['menu_id' => $menu->id]),
            ]);
        }

        return redirect()->back();
    }

    public function menuDestroy(Request $request, Menu $menu)
    {
        $menu->items()->delete();
        $menu->delete();

        return response()->json([
            'title' => trans('cms.success'),
            'message' => trans('menu.destroy-menu-success'),
        ]);

        return redirect()->back();
    }

    public function menuItemUpdate(Request $request, MenuItem $menu_item)
    {
        $this->validate($request, [
            'menu_item.title' => 'required',
            'menu_item.url' => '',
        ]);

        $menu_item->fill($request->input('menu_item'))->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('menu.update-success-menu'),
            ]);
        }

        return redirect()->back();
    }

    public function menuItemDestroy(Request $request, MenuItem $menu_item)
    {
        MenuItem::where('parent_id', $menu_item->id)->update(['parent_id' => $menu_item->parent_id]);
        $menu_item->delete();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('menu.destroy-menu-success'),
                'redirect' => route('admin.appearance.menu.edit', ['id' => $menu_item->menu_id])
            ]);
        }

        return redirect()->back();
    }
}
