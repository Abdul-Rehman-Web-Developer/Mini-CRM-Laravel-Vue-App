<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Company;
use App\Notifications\CompanyAdded;
use Auth;
use DB;

class CompanyRepository
{
	public function find($id){
		$url =str_replace("/public","",url('/'))."/storage/app/public/company_logos/";

		return Company::select(
								'id',
								'name',
								'email',
								DB::raw("CONCAT('$url', companies.logo) as logo"),
								'website'
							)
						->where('id',$id)
						->first();
	}
	
	public function findAll($all = false){
		$url =str_replace("/public","",url('/'))."/storage/app/public/company_logos/";
        $query = Company::query();
		$companies = $query
							->orderBy('name')
							->select(
								'id',
								'name',
								'email',
								DB::raw("CONCAT('$url', companies.logo) as logo"),
								'website'
							);
		if($all){
			$companies = $query->get();
		}else{
			$companies = $query->paginate(10);
		}
			
		return $companies;
	}

	public function save(array $data,$logo){
		    // Get file name with ext
            $filenameWithExt = $logo->getClientOriginalName();
            // Get  ext
            $extension = $logo->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = Str::random(40).'_'.time().'.'.$extension;
            // store file
            $logo->storeAs('public/company_logos',$fileNameToStore);

            $company['name'] = $data['name'];
            $company['email'] = $data['email'];
            $company['logo'] = $fileNameToStore;
            $company['website'] = $data['website'];

            $newCompany= Company::create($company);           

            $admin=Auth::user();
            // send email notification to admin
            $admin->notify(new CompanyAdded($newCompany));

		    return $newCompany;
		
	}

	public function update(array $data){
		$company = Company::find($data['company_id']);

		$company->name = $data['name'];
		$company->email = $data['email'];
		$company->website = $data['website'];

		return $company->save();
	}

	public function updateLogo(array $data, $logo){
		$company = Company::find($data['company_id']);

		// Get file name with ext
        $filenameWithExt = $logo->getClientOriginalName();
        // Get  ext
        $extension = $logo->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = Str::random(40).'_'.time().'.'.$extension;
        // store file
        $logo->storeAs('public/company_logos',$fileNameToStore);

        // delete previous file
        @unlink(storage_path('app/public/company_logos/'.$company->logo));

		$company->logo = $fileNameToStore;
		
		return $company->save();
	}

	public function delete($id){
		$company=Company::find($id);
		$company->employees()->delete(); 
		// delete company logo
        @unlink(storage_path('app/public/company_logos/'.$company->logo));
		return $company->delete();		
	}
		
		
	
}