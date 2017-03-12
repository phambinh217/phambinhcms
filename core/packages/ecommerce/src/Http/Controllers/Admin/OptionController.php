<?php 

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Ecommerce\Option;
use Packages\Ecommerce\OptionValue;
use Validator;
use AdminController;

class OptionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = Option::getRequestFilter();
        $options = Option::applyFilter($filter)->get();
        $this->data['filter'] = $filter;
        $this->data['options'] = $options;

        \Metatag::set('title', 'Tùy chọn');
        return view('Ecommerce::admin.option.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $option = new Option();
        $this->data['option'] = $option;
        
        \Metatag::set('title', 'Thêm tùy chọn mới');
        return view('Ecommerce::admin.option.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = new Option();
        $type = $option->getTypeAble()->implode('id', ',');

        $this->validate($request, [
            'option.name' => 'required',
            'option.type' => 'required|in:' . $type,
            'values.*'      => 'required_if:option.type,select,checkbox,radio'
        ]);

        $option->fill($request->input('option'));

        $option->save();

        if ($option->hasManyValues()) {
            $index = 0;
            foreach ($request->input('values') as $value_id => $value_data) {
                OptionValue::create(array_merge([
                    'option_id' => $option->id,
                    'order' => $index,
                ], $value_data));
                $index++;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm tùy chọn mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.option.edit', ['id' => $option->id]) :
                    route('admin.ecommerce.option.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.ecommerce.option.edit', ['id' => $option->id]);
        }

        return redirect()->route('admin.ecommerce.option.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        $this->data['option'] = $option;
        $this->data['option_id'] = $option->id;

        \Metatag::set('title', 'Thêm tùy chọn mới');
        return view('Ecommerce::admin.option.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        $type = $option->getTypeAble()->implode('id', ',');

        $this->validate($request, [
            'option.name' => 'required',
            'option.type' => 'required|in:' . $type,
            'values.*' => 'required_if:option.type,select,checkbox,radio'
        ]);

        $option->fill($request->input('option'));
        $option->save();

        if ($option->hasManyValues()) {
            $index = 0;
            foreach ($request->input('values') as $value_id => $value_data) {
                if ($value_id > 0) {
                    OptionValue::find($value_id)->fill(array_merge(['order' => $index], $value_data))->save();
                } else {
                    OptionValue::create(array_merge([
                        'option_id' => $option->id,
                        'order' => $index,
                    ], $value_data));
                }
                $index++;
            }
        }

        if ($request->ajax()) {
            $res = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.option.index');
            }
            return response()->json($res, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.option.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function multipleDestroy()
    {
    }
}
