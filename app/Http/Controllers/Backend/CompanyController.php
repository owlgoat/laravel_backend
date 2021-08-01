<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Postcode;
use App\Models\Prefecture;
use Config;

class CompanyController extends Controller {

    /**
     * Get named route
     *
     */
    private function getRoute() {
        return 'companies';
    }

    /**
     * Validator for company
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data, $type) {
        // Determine if password validation is required depending on the calling
        return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|max:255',
                'postcode' => 'required|max:7',
                // 'prefecture' => 'required',
                'city' => 'required|string|max:255',
                'local' => 'required|string|max:255',
                // 'image' => 'required',
                // (update: not required, create: required)
        ]);
    }

    public function index() {
        $company = Company::paginate(10);

        return view('backend.companies.index', compact('company'));
    }

    public function getAddressByPostcode($postcode)
    {
        $prefecture = Postcode::where('postcode', $postcode)->groupBy('prefecture')->pluck('prefecture');
        $city = Postcode::where('postcode', $postcode)->groupBy('city')->pluck('city');
        $local = Postcode::where('postcode', $postcode)->groupBy('local')->pluck('local');
        $id = Prefecture::where('display_name', $prefecture)->groupBy('id')->pluck('id');

        return response()->json([$id, $prefecture, $city, $local], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function add() {
        $company = new Company();
        $company->form_action = $this->getRoute() . '.create';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';

        // $postcode = new Postcode();
        // $postcode = $this->getAddressByPostalCode();

        return view('backend.companies.form', [
            'company' => $company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $newCompany = $request->all();

        // // Validate input, indicate this is 'create' function
        $this->validator($newCompany, 'create')->validate();

        try {
            $company = Company::create($newCompany);
            $filename = 'Image_' . $company->id . '.png';
            $request->file('image')->storeAs('', $filename, 'public_uploads');
            $company->image = $filename;
            $company->save();
            // $filename = $request->file('image')->getClientOriginalName();
            // $newCompany['image'] = $filename;
            // $request->file('image')->storeAs('/public/uplods/files', $filename);
            if ($company) {
                // Create is successful, back to list
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {
                // Create is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // Create is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $company = Company::findOrFail($id);
        $company->form_action = $this->getRoute() . '.update';
        $company->page_title = 'Company Edit Page';
        // Add page type here to indicate that the form.blade.php is in 'edit' mode
        $company->page_type = 'edit';
        return view('backend.companies.form', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $newCompany = $request->all();
        try {
            $currentCompany = Company::find($request->get('id'));
            
            if ($currentCompany) {
                // Validate input only after getting password, because if not validator will keep complaining that password does not meet validation rules
                // Hashed password from DB will always have length of 60 characters so it will pass validation
                // Also indicate this is 'update' function
                $this->validator($newCompany, 'update')->validate();

                $request->file('image')->storeAs('', $currentCompany->image, 'public_uploads');
                // Only hash the password if it needs to be hashed
                // Update user
                $currentCompany->update($newCompany);
                // If update is successful
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_UPDATE_MESSAGE'));
            } else {
                // If update is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // If update is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
        }
    }

    public function delete(Request $request) {
        try {
            // Get company by id
            $company = Company::find($request->get('id'));
            Storage::disk('public_uploads')->delete($company->image);
            // If to-delete user is not the one currently logged in, proceed with delete attempt
            if (Auth::id() != $company->id) {

                // Delete user
                $company->delete();

                // If delete is successful
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
            }
            // Send error if logged in user trying to delete himself
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_SELF_MESSAGE'));
        } catch (Exception $e) {
            // If delete is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }
}
