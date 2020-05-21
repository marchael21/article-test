<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;
use App\Models\VehicleStatistic;
use App\User;
use App\Models\Role;
use App\Http\Requests\StoreVehicle;
use App\Http\Requests\UpdateVehicle;
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon;
use Auth;

class VehicleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::id();

        $yearOpt = range(Carbon::now()->year, 1990);
        $statusOpt = DB::table('vehicle_statuses')->get();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = DB::table('vehicles');

        if (isset($request->id) && $request->id !=='') {
            $query->where('id', $request->id);
        }

        if (isset($request->brand) && $request->brand !=='') {
            $query->where('brand', 'LIKE', '%'.$request->brand.'%');
        }

        if (isset($request->model) && $request->model !=='') {
            $query->where('model', 'LIKE', '%'.$request->model.'%');
        }

        if (isset($request->year) && $request->year !=='') {
            $query->where('year', 'LIKE', '%'.$request->year.'%');
        }

        if (isset($request->plate_number) && $request->plate_number !=='') {
            $query->where('plate_number', 'LIKE', '%'.$request->plate_number.'%');
        }

        if (isset($request->cor_number) && $request->cor_number !=='') {
            $query->where('cor_number', 'LIKE', '%'.$request->cor_number.'%');
        }

        if (isset($request->status) && $request->status !=='') {
            $query->where('status', $request->status);
        }

        $vehicles = $query->paginate($pageLimit);

        // Search Filters
        $searchFilter = array();
        $searchFilter['id'] = isset($request->id) && $request->id !== '' ? $request->id : '';
        $searchFilter['brand'] = isset($request->brand) && $request->brand !== '' ? $request->brand : '';
        $searchFilter['model'] = isset($request->model) && $request->model !== '' ? $request->model : '';
        $searchFilter['year'] = isset($request->year) && $request->year !== '' ? $request->year : '';
        $searchFilter['plate_number'] = isset($request->plate_number) && $request->plate_number !== '' ? $request->plate_number : '';
        $searchFilter['cor_number'] = isset($request->cor_number) && $request->cor_number !== '' ? $request->cor_number : '';
        $searchFilter['status'] = isset($request->status) && $request->status !== '' ? $request->status : '';
        $searchFilter['page_limit'] = $pageLimit;

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/vehicle/list'),
                'name'  => 'Vehicle',
                'icon'  => 'fas fa-bus',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.admin.vehicles.list', ['vehicles' => $vehicles], compact('pageData', 'searchFilter', 'yearOpt', 'statusOpt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::id();

        $yearOpt = range(Carbon::now()->year, 1990);
        $statusOpt = DB::table('vehicle_statuses')->get();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/vehicle/list'),
                'name'  => 'Vehicle',
                'icon'  => 'fas fa-bus',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Create',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.admin.vehicles.create', compact('pageData', 'yearOpt', 'statusOpt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicle $request)
    {

        $authId = Auth::id();

        // Retrieve the validated input data...
        $validated = $request->validated();

        $vehicle = new Vehicle;
        $vehicle->brand = $request->brand;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->plate_number = $request->plate_number;
        $vehicle->cor_number = $request->cor_number;
        $vehicle->status = $request->status;
        $vehicle->created_by = $authId;
        $vehicle->updated_by = $authId;

        try {

            // save user
            if($vehicle->save()) {

                $vehicleStat = new VehicleStatistic;
                $vehicleStat->vehicle_id = $vehicle->id;
                $vehicleStat->remarks = 'newly registered vehicle';
                $vehicleStat->created_by = $authId;
                $vehicleStat->updated_by = $authId;
                $vehicleStat->save(); 

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Vehicle Created!.',
                    'text'  => 'Vehicle has been registered successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('vehicle/list')->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            // echo $e->getMessage();
            // die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('vehicle/create')->withInput()->with('alertMsg', $alertMsg);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authId = Auth::id();

        $yearOpt = range(Carbon::now()->year, 1990);
        $statusOpt = DB::table('vehicle_statuses')->get();

        $vehicle = Vehicle::with('vehicleStatistic.updatedBy')->find($id);

        if (!isset($vehicle->id))      
            Abort('404');

        $vehicleStat = VehicleStatistic::where('vehicle_id', $vehicle->id)->first();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/vehicle/list'),
                'name'  => 'Vehicle',
                'icon'  => 'fas fa-bus',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Edit',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.admin.vehicles.edit',['vehicle' => $vehicle, 'vehicleStat' => $vehicleStat], compact('pageData', 'yearOpt', 'statusOpt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicle $request, $id)
    {
        $authId = Auth::id();

        // Retrieve the validated input data...
        $validated = $request->validated();

        $vehicle = Vehicle::find($id);
        $vehicle->brand = $request->brand;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->plate_number = $request->plate_number;
        $vehicle->cor_number = $request->cor_number;
        $vehicle->status = $request->status;
        $vehicle->updated_by = $authId;

        try {

            // save vehicle
            if($vehicle->save()) {                
                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Vehicle Updated!.',
                    'text'  => 'Vehicle information has been updated successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                // return redirect(session('links')[2])->with('alertMsg', $alertMsg);
                return redirect('vehicle/edit/'.$id)->withInput()->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            // echo $e->getMessage();
            // die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('vehicle/edit/'.$id)->withInput()->with('alertMsg', $alertMsg);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStats(Request $request, $id)
    {
        $authId = Auth::id();

        $vehicleStat = VehicleStatistic::find($id);
        $vehicleStat->battery = $request->stat_battery;
        $vehicleStat->lights = $request->stat_lights;
        $vehicleStat->oil = $request->stat_oil;
        $vehicleStat->water = $request->stat_water;
        $vehicleStat->brake = $request->stat_brake;
        $vehicleStat->tire = $request->stat_tire;
        $vehicleStat->gas = $request->stat_gas;
        $vehicleStat->spare_tire = $request->stat_spare_tire;
        $vehicleStat->tool_set = $request->stat_tool_set;
        $vehicleStat->ewd = $request->stat_ewd;
        $vehicleStat->easytrip = $request->stat_easytrip;
        $vehicleStat->fleet_card = $request->stat_fleet_card;
        $vehicleStat->remarks = $request->stat_remarks;
        $vehicleStat->updated_by = $authId;

        try {

            // save vehicle
            if($vehicleStat->save()) {                
                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Vehicle Stats Updated!.',
                    'text'  => 'Vehicle statistics has been updated successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                // return redirect(session('links')[2])->with('alertMsg', $alertMsg);
                return redirect('vehicle/edit/'.$id)->withInput()->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            // echo $e->getMessage();
            // die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('vehicle/edit/'.$id)->withInput()->with('alertMsg', $alertMsg);

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
        $vehicle = Vehicle::find($id);

        try {

            $vehicle->delete();

            $alertMsg = array(
                'title' => 'Success!',
                'text'  => 'Vehicle "Plate No.: ' . $vehicle->plate_number . '/ Brand: ' . $vehicle->brand . '/ Model: ' . $vehicle->model . '" has been deleted successfully".' ,
                'icon'  => 'success'
            );
            return redirect('/user/list')->with('alertMsg', $alertMsg);

        } catch (\Exception $e) {

            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('/vehicle/list')->with('alertMsg', $alertMsg);
        }
    }
}
