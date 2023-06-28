<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EmployeeRequest;
use App\Http\Transformers\EmployeeTransformer;
use App\Models\Employee;
use App\Models\Skill;
use App\Models\UserSkill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class EmployeeController extends Controller
{

    protected $transformer;

    public function __construct(EmployeeTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json(
            $this->transformer->transformCollection($employees)
        );


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {

        $request->validated();

        $employee = new Employee();

        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->position = $request->input('position');
        $employee->date_of_birth = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'));
        $employee->address = $request->input('address');

        $res = $employee->save();

        if ($request->has('skills')) {
            $employeeSkills = $request->input('skills');


            foreach($employeeSkills as $index => $employeeSkill) {

                $skill = Skill::firstOrCreate([
                    'name' => ucfirst($employeeSkill['name'])
                ]);

                $employee->skills()->attach($skill->id, ['level' => $employeeSkill['level']]);
            }
        }



        if ($res) {
            return response()->json(['message' => 'Employee created succesfully'], 201);
        }
        return response()->json(['message' => 'Error creating employee'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee = $this->transformer->transform($employee);
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {

        $validated = $request->validate([
            'name' => 'max:255',
            'position' => 'max:255',
            'address' => 'max:500',
            'skills.*.name'  => 'string|distinct',
            'skills.*.level'  => 'integer|between:1,5',
        ]);

        $employee = Employee::find($employee)->first();

        if ($request->has('name')) {
            $employee->name = $request->input('name');
        }

        if ($request->has('position')) {
            $employee->position = $request->input('position');
        }

        if ($request->has('address')) {
            $employee->address = $request->input('address');
        }

        $res = $employee->save();

        if ($request->has('skills')) {
            $employeeSkills = $request->input('skills');

            $employee->skills()->detach();

            foreach($employeeSkills as $index => $employeeSkill) {

                $skill = Skill::firstOrCreate([
                    'name' => ucfirst($employeeSkill['name'])
                ]);

                $employee->skills()->attach($skill->id, ['level' => $employeeSkill['level']]);
            }
        }

        if ($res) {
            return response()->json([
                'message' => 'Employee info updated',
                'employee' => $this->transformer->transform($employee)
            ], 200);
        }
        return response()->json(['message' => 'Error updating employee'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(['message' => 'Employee deleted'], 201);
    }
}
