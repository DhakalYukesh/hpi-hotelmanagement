<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Models\Customer;
use Hash;
use Mail;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::all();
        return view('customer.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'number' => 'required|max:10',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:5|max:12',
        ]);

        // Generate a random 6-digit verification code
        $code = rand(100000, 999999);

        // Store the form data in a temporary array
        $tempData = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'number' => $request->number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $code
        ];

        // Save the customer's data to the database
        $data = new Customer;
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        $data->number = $request->number;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->verification_code = $code;

        // Store the temporary array as JSON data in a file
        $tempDataJson = json_encode($tempData);
        $tempDataFile = storage_path('app/temp-data.json');
        file_put_contents($tempDataFile, $tempDataJson);

        // Send a verification email to the customer
        Mail::to($request->email)->send(new VerifyEmail($code));

        $reg_ref = $request->reg_ref;
        if ($reg_ref == 'frontRegister') {
            return view('verify')->with('verification_code', $code);
        } else {
            $data->save();
            return redirect('admin/customer/create')->with('success', 'The customer has been added successfully!');
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
        $data = Customer::find($id);
        return view('customer.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Customer::find($id);
        return view('customer.edit', ['data' => $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'number' => 'required|max:10',
            'email' => 'required|email|unique:users',
        ]);

        $data = Customer::find($id);
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        $data->number = $request->number;
        $data->email = $request->email;
        $data->save();

        if ($data) {
            return redirect('admin/customer/' . $id . '/edit')->with('success', 'The room type has been updated successfully!');
        } else {
            return redirect('admin/customer/' . $id . '/edit')->with('fail', 'Something went wrong! Try again.');
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
        Customer::where('id', $id)->delete();

        return redirect('admin/customer')->with('success', 'The customer has been deleted successfully!');
    }

    //User login functionality
    public function login()
    {
        return view("home");
    }

    public function loginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12',
        ]);

        $data = Customer::where('email', '=', $request->email)->first();
        if ($data) {
            if (Hash::check($request->password, $data->password)) {
                $request->session()->put('loginId', $data->id);
                $request->session()->put('fname', $data->fname);
                return redirect('home');
            } else {
                return back()->with('fail', 'The password was not correct! Try again.');
            }
        } else {
            return back()->with('fail', 'The email was not correct! Try again.');
        }
    }

    public function registration()
    {
        return view("registration");
    }

    public function logout()
    {
        session()->forget(['loginId', 'data']);
        return redirect('home');
    }

    public function customerHome()
    {
        $customers = Customer::all();
        return view('home', ['customer' => $customers]);
    }

    public function verify(Request $request, $verification_code)
    {
        // Check if the JSON file exists
        $filename = storage_path('app/temp-data.json');
        if (!file_exists($filename)) {
            return redirect('registration')->with('fail', 'The email was not correct! Try again.');
        }

        // Read the customer's data from the JSON file
        $customer = json_decode(file_get_contents($filename));

        // Verify the customer's code
        if ($request->verification_code != $customer->verification_code) {
            return redirect('registration')->with('fail', 'The email was not correct! Try again.');
        }

        // Save the customer's data to the database
        $data = new Customer;
        $data->fname = $customer->fname;
        $data->lname = $customer->lname;
        $data->number = $customer->number;
        $data->email = $customer->email;
        $data->password = $customer->password;
        $data->verification_code = $customer->verification_code;

        if (!$data->save()) {
            return redirect('registration')->with('fail', 'The email was not correct! Try again.');
        }

        // Delete the temporary JSON file
        unlink($filename);

        // Redirect the customer to the login page
        return redirect('registration')->with('success', 'Your account has been created successfully. Please log in.');

    }

}