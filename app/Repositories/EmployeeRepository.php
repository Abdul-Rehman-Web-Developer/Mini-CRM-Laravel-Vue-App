<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Employee;
use DB;

class EmployeeRepository
{
	public function find($id){
		return Employee::find($id);
	}
	public function findAll($companyId=null){
		$query = Employee::query();

		$query->when(request('company_id', false), function ($q, $companyId) { 
		    return $q->where('company_id', $companyId);
		});

		$employees = $query
						->orderBy('first_name')
						->paginate(10);
			
		return $employees;
	}

	public function save(array $data){
		    return Employee::create($data);		
	}

	public function update(array $data){
		$employee = Employee::find($data['employee_id']);

		$employee->first_name = $data['first_name'];
		$employee->last_name = $data['last_name'];
		$employee->email = $data['email'];
		$employee->phone = $data['phone'];
		$employee->company_id = $data['company_id'];

		return $employee->save();
	}
	

	public function delete($id){
		return Employee::destroy($id);
		
	}
		
		
	
}