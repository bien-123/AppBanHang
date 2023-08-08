<?php


namespace App\Http\Services\Slider;


use App\Models\Menu;
use App\Models\Slider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    public function insert($request)
    {
        try {
            Slider::create($request->input());
            Session::flash('success', 'Thêm Slider mới thành công!');
        } catch (\Exception $err)
        {
            Session::flash('error', 'Thêm Slider lỗi!');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function get()
    {
        return Slider::orderByDesc('id')->paginate(15);
    }

    public function update($request, $slider)
    {
        try {

            $slider->fill($request->input());
            $slider->save();
            Session::flash('success', 'Cập Nhật Slider Thành Công!');
        } catch (\Exception $err)
        {
            Session::flash('error', 'Cập Nhật Slider Lỗi!');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function destroy($request)
    {
        $slider = Slider::where('id', $request->input('id'))->first();
        if ($slider)
        {
            $path = str_replace('storage', 'public', $slider->thumb); // thay thế đường dẫn ảnh từ storage thành public
            Storage::delete($path);
            $slider->delete();
            return true;
        }

        return false;
    }


    public function show()
    {
        return Slider::where('active', 1)
            ->orderbyDesc('sort_by')
            ->get();
    }
}
