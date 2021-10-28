<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCompanyRequest;
use App\Http\Requests\CompanyBasicInfoRequest;
use App\Http\Requests\CompanyLogoRequest;
use App\Repositories\CompanyRepository;


class CompanyController extends Controller
{
    
    private $companyRepository;

    function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    } 
    
    /**
     * Display all Companies
     */
    public function index(Request $request)
    {
        $all= $request->has('all') == true ? true:false;
        return $this->companyRepository->findAll($all);
       
    }


    /**
     * Store a Company
     */
    public function store(AddCompanyRequest $request)
    {          
        return $this->companyRepository->save($request->validated(), $request->file('logo'));
    }

    /**
     * Find the Company
     *
     */
    public function show($id)
    {
        return $this->companyRepository->find($id);
    }

    
    /**
     * Update the company
     */
    public function update(CompanyBasicInfoRequest $request, $id)
    {
        return $this->companyRepository->update($request->validated());
    }

    /**
     * Update the company logo
     */
    public function updateLogo(CompanyLogoRequest $request)
    {
        return $this->companyRepository->updateLogo($request->validated(), $request->file('logo'));            
    }

    /**
     * Remove an company
     */
    public function destroy($id)
    {
        return $this->companyRepository->delete($id);
    }
}
