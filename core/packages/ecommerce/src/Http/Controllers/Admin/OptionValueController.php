<?php 

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Ecommerce\OptionValue;
use Validator;
use AdminController;

class OptionValueController extends AdminController
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OptionValue $value)
    {
        if ($value->products->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Giá trị đã có sản phẩm',
                ], 422);
            }
            
            return redirect()->back();
        }

        $value->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa giá trị',
            ], 200);
        }

        return redirect()->back();
    }
}
