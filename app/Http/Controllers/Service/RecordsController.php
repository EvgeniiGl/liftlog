<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Policies\ServicePolicy;
use App\User;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Type;

class RecordsController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function types()
    {
        return view('service.records.types')->with('types', Type::all());
    }

    public function destroy_type(Request $request, int $id)
    {
        try {
            $type = Type::findOrFail($id);
            $type->delete();
        } catch (Exception $e) {
            //TODO rewrite to custom exception
            throw new Exception('Данный тип нельзя удалить, так как он используется в журнале записей!');
        }
        Session::flash('message', 'Тип записи удален!');
        Session::flash('alert-class', 'alert-success');
        return redirect('service/records/types');
    }

    public function edit_type(Request $request, int $id)
    {
        $type = Type::findOrFail($id);
        $data = ['type' => $type];
        return view('service.records.edit_type', $data);
    }

    public function update_type(Request $request, int $id)
    {
        $type = Type::find($id);
        $type->title = $request->title;
        $type->save();
        Session::flash('message', 'Изменения сохранены!');
        Session::flash('alert-class', 'alert-success');
        return redirect('service/records/types');
    }

}
