<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Repositories\StationRepository;
use App\Repositories\TripRepository;
use Validator;

class ApiController extends Controller
{
    protected $tripRepo;
    protected $stationRepo;

    public function __construct(TripRepository $tripRepository, StationRepository $stationRepository)
    {
        $this->tripRepo = $tripRepository;
        $this->stationRepo = $stationRepository;
    }

    public function validateRequest($request, $rule, $message = [])
    {
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            foreach ($errors as $key => $error) {
                $errorArray[$key] = $error[0];

            }
            $data['status']=0;
            $data['errors']=$errorArray;
            throw new HttpResponseException(response()->json($data, 422));
        }
        return true;
    }

    public function throwCustomError($errorsArray)
    {
        $data['status']=0;
        $data['errors']=$errorsArray;
        throw new HttpResponseException(response()->json($data, 422));
    }
}
