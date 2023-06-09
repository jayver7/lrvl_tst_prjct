<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ipcrform as Form;
use App\Models\Schedule;
use App\Models\Input;
use App\Models\Accounts as User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ipcr_form = Form::get();

        return view("hr.index", compact('ipcr_form'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $account = User::get();

        return view("hr.create", compact('account'));
    }

    /**
     * Get employees for the specified office.
     */
    public function getEmployees()
    {
        $account = User::get();

        return response()->json($account);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check the selected office
        if ($request->office == "CMIO") {
            // Get the division chief and director for CMIO office
            $division_chief = User::where('office', 'CMIO')->where('position', 'Division Chief')->first();
            $director = User::where('office', 'CMIO')->where('position', 'Director')->first();

            // Extract relevant information from retrieved data
            $division_chief_name = $division_chief->first_name . " " . $division_chief->last_name;
            $division_chief_email = $division_chief->email;
            $director_name = $director->first_name . " " . $director->last_name;
            $director_email = $director->email;

            // Create a new schedule form with the provided data
            $schedule_form = Schedule::create([
                'type' => $request->type,
                'purpose' => $request->purpose,
                'covered_period' => $request->covered_period,
                'office' => $request->office,
                'employees' => $request->input('employees'),
                'division_chief' => $division_chief_name,
                'director' => $director_name,
                'duration_from' => $request->duration_from,
                'duration_to' => $request->duration_to
            ]);

            // Retrieve selected employee options
            $selectedOptions = $request->input('employees');

            foreach ($request->input('employees') as $first_name) {
                if (in_array('CMIO_All', $selectedOptions)) {
                    // "CMIO_All" is selected
                    // Perform the desired logic for "CMIO_All"
                    $user = User::where('office', 'CMIO')->where('Position', 'Employee')->get();
                    foreach ($user as $users) {
                        $email = $users['email'];
                        // Prepare data for email template
                        $data = [
                            'duration_from' => $request->duration_from,
                            'duration_to' => $request->duration_to,
                            'purpose' => $request->purpose,
                            'covered_period' => $request->covered_period,
                            'hr' => Auth::user()->first_name
                        ];
                        // Send the email
                        Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                            $message->to($email);
                            $message->subject('Notification for Scheduling');
                            $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                        });
                    }
                    break;
                } else {
                    // Other options are selected
                    // Perform the logic for other options
                    $user = User::where('first_name', $first_name)->first();
                    $email = $user['email'];
                    $data = [
                        'duration_from' => $request->duration_from,
                        'duration_to' => $request->duration_to,
                        'purpose' => $request->purpose,
                        'covered_period' => $request->covered_period,
                        'hr' => Auth::user()->first_name
                    ];
                    Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                        $message->to($email); 
                        $message->subject('Notification for Scheduling');
                        $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                    });
                }
            };
        } else if ($request->office == "PSD") {
            $division_chief = User::where('office', 'PSD')->where('position', 'Division Chief')->first();
            $director = User::where('office', 'PSD')->where('position', 'Director')->first();

            $division_chief_name = $division_chief->first_name . " " . $division_chief->last_name;
            $director_name = $director->first_name . " " . $director->last_name;
            $schedule_form = Schedule::create([
                'type' => $request->type,
                'purpose' => $request->purpose,
                'covered_period' => $request->covered_period,
                'office' => $request->office,
                'employees' => $request->input('employees'),
                'division_chief' => $division_chief_name,
                'director' => $director_name,
                'duration_from' => $request->duration_from,
                'duration_to' => $request->duration_to
            ]);

            $selectedOptions = $request->input('employees');

            foreach ($request->input('employees') as $first_name) {
                if (in_array('PSD_All', $selectedOptions)) {
                    // "CMIO_All" is selected
                    // Perform the desired logic for "PSD_All"
                    $user = User::where('office', 'PSD')->where('Position', 'Employee')->get();
                    foreach ($user as $users) {
                        $email = $users['email'];
                        $data = [
                            'duration_from' => $request->duration_from,
                            'duration_to' => $request->duration_to,
                            'purpose' => $request->purpose,
                            'covered_period' => $request->covered_period,
                            'hr' => Auth::user()->first_name
                        ];
                        Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                            $message->to($email);
                            $message->subject('Notification for Scheduling');
                            $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                        });
                    }
                    break;
                } else {
                    // Other options are selected
                    // Perform the logic for other options
                    $user = User::where('first_name', $first_name)->first();
                    $email = $user['email'];
                    $data = [
                        'duration_from' => $request->duration_from,
                        'duration_to' => $request->duration_to,
                        'purpose' => $request->purpose,
                        'covered_period' => $request->covered_period,
                        'hr' => Auth::user()->first_name
                    ];
                    Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                        $message->to($email);
                        $message->subject('Notification for Scheduling');
                        $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                    });
                }
            };
        } else if ($request->office == "All") {
            $division_chief = "DC1";
            $director = "D1";
            $schedule_form = Schedule::create([
                'type' => $request->type,
                'purpose' => $request->purpose,
                'covered_period' => $request->covered_period,
                'office' => $request->office,
                'employees' => $request->input('employees'),
                'division_chief' => $division_chief,
                'director' => $director,
                'duration_from' => $request->duration_from,
                'duration_to' => $request->duration_to
            ]);

            $selectedOptions = $request->input('employees');

            foreach ($request->input('employees') as $first_name) {
                if(in_array('CMIO_All', $selectedOptions) && in_array('PSD_All', $selectedOptions)){
                    $user = User::where('Position', 'Employee')->get();
                    foreach ($user as $users) {
                        $email = $users['email'];
                        $data = [
                            'duration_from' => $request->duration_from,
                            'duration_to' => $request->duration_to,
                            'purpose' => $request->purpose,
                            'covered_period' => $request->covered_period,
                            'hr' => Auth::user()->first_name
                        ];
                        Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                            $message->to($email);
                            $message->subject('Notification for Scheduling');
                            $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                        });
                    }
                    break;
                } else if (in_array('CMIO_All', $selectedOptions)) {
                    // "CMIO_All" is selected
                    // Perform the desired logic for "CMIO_All"
                    $user = User::where('office', 'CMIO')->where('Position', 'Employee')->get();
                    foreach ($user as $users) {
                        $email = $users['email'];
                        $data = [
                            'duration_from' => $request->duration_from,
                            'duration_to' => $request->duration_to,
                            'purpose' => $request->purpose,
                            'covered_period' => $request->covered_period,
                            'hr' => Auth::user()->first_name
                        ];
                        Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                            $message->to($email);
                            $message->subject('Notification for Scheduling');
                            $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                        });
                    }
                    break;
                } else if (in_array('PSD_All', $selectedOptions)) {
                    // "CMIO_All" is selected
                    // Perform the desired logic for "PSD_All"
                    $user = User::where('office', 'PSD')->where('Position', 'Employee')->get();
                    foreach ($user as $users) {
                        $email = $users['email'];
                        $data = [
                            'duration_from' => $request->duration_from,
                            'duration_to' => $request->duration_to,
                            'purpose' => $request->purpose,
                            'covered_period' => $request->covered_period,
                            'hr' => Auth::user()->first_name
                        ];
                        Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                            $message->to($email);
                            $message->subject('Notification for Scheduling');
                            $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                        });
                    }
                    break;
                } else {
                    // Other options are selected
                    // Perform the logic for other options
                    $user = User::where('first_name', $first_name)->first();
                    $email = $user['email'];
                    $data = [
                        'duration_from' => $request->duration_from,
                        'duration_to' => $request->duration_to,
                        'purpose' => $request->purpose,
                        'covered_period' => $request->covered_period,
                        'hr' => Auth::user()->first_name
                    ];
                    Mail::send('mail.schedule', $data, function ($message) use ($data, $email) {
                        $message->to($email);
                        $message->subject('Notification for Scheduling');
                        $message->from('jcuevas@finance.gov.ph', 'Notification for Scheduling'); // Get HR email when?
                    });
                }
            };
        }

        $dv_info = User::where('first_name', $division_chief);
        $dir_info = User::where('first_name', $director);

        // return response()->json($schedule_form);
        return response()->json([$schedule_form, "success" => true, "message" => "Successfully created a schedule!"]);
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

        return view("hr.edit", compact(['ipcr_form', 'id', 'add_input']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ipcr_form = Form::find($id);
        $email = $ipcr_form->email;

        // send email that he/she was verified
        Mail::send('mail.verified', function ($message) use ($email) {
            $message->to($email);
            $message->subject('HR received your form');
            $message->from(Auth::user()->email, 'IPCR HR');
        });

        // change the status of the form to "Verified"
        $ipcr_form->status = "Verified";
        $ipcr_form->save();

        return response()->json(["success" => true, "message" => "Successfully verified the form!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
