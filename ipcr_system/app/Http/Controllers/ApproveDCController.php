<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ipcrform as Form;
use App\Models\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApproveDCController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ipcr_form = Form::where('status', 'Pending')->get();

        return view('dc.applist', compact('ipcr_form'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ipcr_form = Form::find($id);

        $add_input = Input::where('employee_id', $id)->get();

        return view("dc.appedit", compact(['ipcr_form', 'id', 'add_input']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ipcr_form = Form::find($id);
        $email = $ipcr_form->email;
        $status = $request->status;

        if($status == "Approved by DC"){
            $data = [ ];
            Mail::send('mail.approvedc', $data, function ($message) use ($email) {
                $message->to($email);
                $message->subject('Division Chief approved your form');
                $message->from(Auth::user()->email, 'IPCR Division Chief');
            });

            $ipcr_form->status = $request->status;
            $ipcr_form->save();

            return response()->json(["success" => true, "message" => "Successfully approved!"]);
        }else if($status == "Rejected by DC"){
            $data = [
                'reason' => $request->reason,
            ];
            Mail::send('mail.rejectdc', $data, function ($message) use ($data, $email) {
                $message->to($email);
                $message->subject('Division Chief rejected your form');
                $message->from(Auth::user()->email, 'IPCR Division Chief');
            });

            $ipcr_form->status = $request->status;
            $ipcr_form->save();

            return response()->json(["success" => true, "message" => "Successfully rejected!"]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
