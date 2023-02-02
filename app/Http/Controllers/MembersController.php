<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Miembro $model)
    {

        $query = $model->query();

        $query->when($request->has('s'), function($query) use($request){
            $search = trim($request->s);
            $query->where('first_name', 'like', '%' . $search . '%')
            ->orWhere('second_name', 'like', $search . '%')
            ->orWhere('first_surname', 'like', $search . '%')
            ->orWhere('second_surname', 'like', $search . '%');

        });
        // ->with(['factura.usuario','user']);

        return $request->has('per_page')
        ? $query->paginate($request->per_page)
        : $query->get();
    }

    public function data_source_member(Request $request)
    {
        $s = $request->s;

        $members = Miembro::selectRaw('id, concat("",first_name," ",second_name," ",first_surname," ",second_surname) as text')
            ->where('first_name', 'like', '%' . $s . '%')
            ->orWhere('second_name', 'like', $s . '%')
            ->orWhere('first_surname', 'like', $s . '%')
            ->orWhere('second_surname', 'like', $s . '%')
            ->limit(3)
            ->get();

        return response()->json(['results' => $members]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $members = Miembro::create([
                'first_name' => strtoupper($request->first_name),
                'second_name' => strtoupper($request->second_name),
                'first_surname' => strtoupper($request->first_surname),
                'second_surname' => strtoupper($request->second_surname),
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'phone' => $request->phone,
                'address' => strtoupper($request->address),
                'email' => $request->email,
                'birthday' => $request->birthday,
            ]);

            DB::commit();

            return response()->json($members);

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member=Miembro::where('id', $id)->first();
        return response()->json($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            DB::beginTransaction();

            $member=Miembro::find($request->id);
            $member->first_name=strtoupper($request->first_name);
            $member->second_name=strtoupper($request->second_name);
            $member->first_surname=strtoupper($request->first_surname);
            $member->second_surname=strtoupper($request->second_surname);
            $member->document_type=$request->document_type;
            $member->document_number=$request->document_number;
            $member->birthday=$request->birthday;
            $member->email=$request->email;
            $member->address=strtoupper($request->address);
            $member->phone=$request->phone;
            $member->save();

            DB::commit();

            return response()->json($member);

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
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
}
