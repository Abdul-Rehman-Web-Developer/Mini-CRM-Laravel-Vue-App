<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\AddEmployeeRequest;
use App\Http\Requests\EditEmployeeRequest;

class EmployeeController extends Controller
{
    private $employeeRepository;

    function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    } 
    
    /**
     * Display all Employees
     */
    public function index(Request $request)
    {
  
        $company_id= $request->has('company_id') == true ? $request->company_id:null;
        return $this->employeeRepository->findAll($request->company_id);  
    }

    /**
     * Store an Employee 
     */
    public function store(AddEmployeeRequest $request)
    {
        return $this->employeeRepository->save($request->validated());
    }

    /**
     * Find the Employee
     *
     */
    public function show($id)
    {
        return $this->employeeRepository->find($id);
    }

    /**
     * Update the Employee
     */
    public function update(EditEmployeeRequest $request, $id)
    {
        return $this->employeeRepository->update($request->validated());
    }
    
    /**
     * Remove an employee
     */
    public function destroy($id)
    {
        return $this->employeeRepository->delete($id);
    }
}
