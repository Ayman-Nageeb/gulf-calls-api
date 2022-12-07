<?php

namespace App\Http\Controllers;

use App\Models\BnPatient;
use App\Models\KtPatient;
use App\Models\Om1Patient;
use App\Models\Om2Patient;
use App\Models\QrPatient;
use App\Models\Uae1Patient;
use App\Models\Uae2Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientsController extends Controller
{
    public function store(Request $request, string $center)
    {
        $request->validate([
            'data' => 'required|json'
        ]);
        $centerModel = null;
        $center = strtoupper($center);
        switch ($center) {
            case 'ON1':
                $centerModel = new Om1Patient();
                break;
            case 'ON2':
                $centerModel = new Om2Patient();
                break;
            case 'UE1':
                $centerModel = new Uae1Patient();
                break;
            case 'UE2':
                $centerModel = new Uae2Patient();
                break;
            case 'KW1':
                $centerModel = new KtPatient();
                break;
            case 'QR1':
                $centerModel = new QrPatient();
                break;
            case 'BN1':
                $centerModel = new BnPatient();
                break;
            default:
                return new Response([
                    'has_error' => true,
                    'message' => 'unknown center ' . $center
                ], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->input('data'), true);

        $centerModel->data = $request->input('data');
        $centerModel->save();

        $id = intval($centerModel->id);

        $code = $center . str_pad($id, 4, "0", STR_PAD_LEFT);
        $data['code'] = $code;

        $centerModel->data = json_encode($data);
        $centerModel->save();

        return  Response([
            'has_error' => false,
            'message' => 'added successfully ',
            'data' => $centerModel
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $center, int $id)
    {
        $request->validate([
            'data' => 'required|json'
        ]);
        $centerModel = null;
        $center = strtoupper($center);
        switch ($center) {
            case 'ON1':
                $centerModel = new Om1Patient();
                break;
            case 'ON2':
                $centerModel = new Om2Patient();
                break;
            case 'UE1':
                $centerModel = new Uae1Patient();
                break;
            case 'UE2':
                $centerModel = new Uae2Patient();
                break;
            case 'KW1':
                $centerModel = new KtPatient();
                break;
            case 'QR1':
                $centerModel = new QrPatient();
                break;
            case 'BN1':
                $centerModel = new BnPatient();
                break;
            default:
                return new Response([
                    'has_error' => true,
                    'message' => 'unknown center ' . $center
                ], Response::HTTP_BAD_REQUEST);
        }


        $centerModel = $centerModel->where(['id' => $id])->first();

        if (!$centerModel) {
            return new Response([
                'has_error' => true,
                'message' => 'unknown patient' . $id
            ], Response::HTTP_BAD_REQUEST);
        };

        $centerModel->data = $request->input('data');
        $centerModel->save();

        return  Response([
            'has_error' => false,
            'message' => 'updated successfully ',
            'data' => $centerModel
        ], Response::HTTP_OK);
    }

    public function getCenterPatients(string $center)
    {
        $centerModel = null;
        $center = strtoupper($center);
        switch ($center) {
            case 'ON1':
                $centerModel = new Om1Patient();
                break;
            case 'ON2':
                $centerModel = new Om2Patient();
                break;
            case 'UE1':
                $centerModel = new Uae1Patient();
                break;
            case 'UE2':
                $centerModel = new Uae2Patient();
                break;
            case 'KW1':
                $centerModel = new KtPatient();
                break;
            case 'QR1':
                $centerModel = new QrPatient();
                break;
            case 'BN1':
                $centerModel = new BnPatient();
                break;
            default:
                return new Response([
                    'has_error' => true,
                    'message' => 'unknown center ' . $center
                ], Response::HTTP_BAD_REQUEST);
        }

        $patients = $centerModel->all();

        return  Response([
            'has_error' => false,
            'message' => 'retrieved successfully',
            'data' => $patients
        ], Response::HTTP_OK);
    }

    public function indexPatients()
    {
        $patients = array_merge(
            (array)Om1Patient::all()->toArray(),
            (array)Om2Patient::all()->toArray(),
            (array)Uae1Patient::all()->toArray(),
            (array)Uae2Patient::all()->toArray(),
            (array)KtPatient::all()->toArray(),
            (array)QrPatient::all()->toArray(),
            (array)BnPatient::all()->toArray(),
        );

        return  Response([
            'has_error' => false,
            'message' => 'retrieved successfully',
            'data' => $patients
        ], Response::HTTP_OK);
    }
}
