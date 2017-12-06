<?php

namespace App\Http\Controllers;

use App\Incident;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    protected $type, $incident;
    function __construct(Type $type, Incident $incident)
    {
        $this->type = $type;
        $this->incident = $incident;
    }

    public function index()
    {
        $data['title'] = 'View Graphs';
        $data['onGraph'] = 1;
        $data['paras'] = 1;
        $data['types'] = $this->type->getTypes();
        switch (session('type'))
        {
            case 'admin':
                $data['username'] = Auth::user()->username;
                $data['user_type'] = Auth::user()->type;
                $data['template'] = 'templates.admin_template';
                break;
            case 'user':
                $data['username'] = Auth::user()->username;
                $data['type'] = Auth::user()->type;
                $data['template'] = 'templates.user_template';
                break;
            default:
                $data['template'] = 'templates.public_template';
                break;
        }
        return view('public.view_graph', $data);
    }

    public function filterPosts(Request $request)
    {
        $data['title'] = 'View Graphs';
        $data['onGraph'] = 1;
//        $data['paras'] = 1;
        $data['types'] = $this->type->getTypes();
        switch (session('type'))
        {
            case 'admin':
                $data['username'] = Auth::user()->username;
                $data['user_type'] = Auth::user()->type;
                $data['template'] = 'templates.admin_template';
                break;
            case 'user':
                $data['username'] = Auth::user()->username;
                $data['type'] = Auth::user()->type;
                $data['template'] = 'templates.user_template';
                break;
            default:
                $data['template'] = 'templates.public_template';
                break;
        }

        if($request->radioButton == 'overall')
        {
            $incidents_array = $this->incident->select(DB::raw('district, status, count(*) as number_of_incidents'))
                                                ->where('status','approved')
                                                ->groupBy('district')
//                                                ->having('status', 'approved')
                                                ->get();
            if(count($incidents_array) > 0)
            {
                $incidents = [];
                $i = 0;
                foreach ($incidents_array as $incident)
                {
                    $incidents[$i]['district'] = ucfirst($incident['district']);
                    $incidents[$i]['number_of_incidents'] = $incident['number_of_incidents'];
                    $i++;
                }
                $data['incidents'] = $incidents;
//                dd($incidents);
                return view('public.view_graph', $data);
            }
        }
        else
        {
            if($request->isMethod('post'))
            {
                $request->validate(
                    [
                        'startDate' => 'required|before:endDate',
                        'endDate' => 'required|after:startDate',
                    ]
                );
            }
        }

        return view('public.view_graph', $data);
    }

    public function sortByDistrict($district)
    {
        $data['title'] = $district;
        $data['onGraph'] = 1;
        switch (session('type'))
        {
            case 'admin':
                $data['username'] = Auth::user()->username;
                $data['user_type'] = Auth::user()->type;
                $data['template'] = 'templates.admin_template';
                break;
            case 'user':
                $data['username'] = Auth::user()->username;
                $data['type'] = Auth::user()->type;
                $data['template'] = 'templates.user_template';
                break;
            default:
                $data['template'] = 'templates.public_template';
                break;
        }
        $district_incidents = $this->incident->select(DB::raw('city, type, status, count(*) as number_of_incidents'))
            ->where('district',$district)
            ->where('status','approved')
            ->groupBy('city')
            ->get();
//        dd($district_incidents->toArray());
        if($district == 'Colombo')
        {
            $data['cities']['Colombo']['Landslide'] = $this->getIncidentByCityAndType('Colombo', 'Landslide');
            $data['cities']['Colombo']['Flood'] = $this->getIncidentByCityAndType('Colombo', 'Flood');
            $data['cities']['Colombo']['Thunderstorm'] = $this->getIncidentByCityAndType('Colombo', 'Thunderstorm');
            $data['cities']['Colombo']['Fire'] = $this->getIncidentByCityAndType('Colombo', 'Fire');
            $data['cities']['Colombo']['Other'] = $this->getIncidentByCityAndType('Colombo', 'Other');

            $data['cities']['Dehiwela']['Landslide'] = $this->getIncidentByCityAndType('Dehiwela', 'Landslide');
            $data['cities']['Dehiwela']['Flood'] = $this->getIncidentByCityAndType('Dehiwela', 'Flood');
            $data['cities']['Dehiwela']['Thunderstorm'] = $this->getIncidentByCityAndType('Dehiwela', 'Thunderstorm');
            $data['cities']['Dehiwela']['Fire'] = $this->getIncidentByCityAndType('Dehiwela', 'Fire');
            $data['cities']['Dehiwela']['Other'] = $this->getIncidentByCityAndType('Dehiwela', 'Other');

            $data['cities']['Moratuwa']['Landslide'] = $this->getIncidentByCityAndType('Moratuwa', 'Landslide');
            $data['cities']['Moratuwa']['Flood'] = $this->getIncidentByCityAndType('Moratuwa', 'Flood');
            $data['cities']['Moratuwa']['Thunderstorm'] = $this->getIncidentByCityAndType('Moratuwa', 'Thunderstorm');
            $data['cities']['Moratuwa']['Fire'] = $this->getIncidentByCityAndType('Moratuwa', 'Fire');
            $data['cities']['Moratuwa']['Other'] = $this->getIncidentByCityAndType('Moratuwa', 'Other');

            $data['cities']['Sri Jayawardenepura Kotte']['Landslide'] = $this->getIncidentByCityAndType('Sri Jayawardenepura Kotte', 'Landslide');
            $data['cities']['Sri Jayawardenepura Kotte']['Flood'] = $this->getIncidentByCityAndType('Sri Jayawardenepura Kotte', 'Flood');
            $data['cities']['Sri Jayawardenepura Kotte']['Thunderstorm'] = $this->getIncidentByCityAndType('Sri Jayawardenepura Kotte', 'Thunderstorm');
            $data['cities']['Sri Jayawardenepura Kotte']['Fire'] = $this->getIncidentByCityAndType('Sri Jayawardenepura Kotte', 'Fire');
            $data['cities']['Sri Jayawardenepura Kotte']['Other'] = $this->getIncidentByCityAndType('Sri Jayawardenepura Kotte', 'Other');
            $data['district'] = 'Colombo';
        }
        else if($district == 'Gampaha')
        {
            $data['cities']['Gampaha']['Landslide'] = $this->getIncidentByCityAndType('Gampaha', 'Landslide');
            $data['cities']['Gampaha']['Flood'] = $this->getIncidentByCityAndType('Gampaha', 'Flood');
            $data['cities']['Gampaha']['Thunderstorm'] = $this->getIncidentByCityAndType('Gampaha', 'Thunderstorm');
            $data['cities']['Gampaha']['Fire'] = $this->getIncidentByCityAndType('Gampaha', 'Fire');
            $data['cities']['Gampaha']['Other'] = $this->getIncidentByCityAndType('Gampaha', 'Other');

            $data['cities']['Negombo']['Landslide'] = $this->getIncidentByCityAndType('Negombo', 'Landslide');
            $data['cities']['Negombo']['Flood'] = $this->getIncidentByCityAndType('Negombo', 'Flood');
            $data['cities']['Negombo']['Thunderstorm'] = $this->getIncidentByCityAndType('Negombo', 'Thunderstorm');
            $data['cities']['Negombo']['Fire'] = $this->getIncidentByCityAndType('Negombo', 'Fire');
            $data['cities']['Negombo']['Other'] = $this->getIncidentByCityAndType('Negombo', 'Other');
            $data['district'] = 'Gampaha';
        }
        else if($district == 'Kalutara')
        {
            $data['cities']['Kalutara']['Landslide'] = $this->getIncidentByCityAndType('Kalutara', 'Landslide');
            $data['cities']['Kalutara']['Flood'] = $this->getIncidentByCityAndType('Kalutara', 'Flood');
            $data['cities']['Kalutara']['Thunderstorm'] = $this->getIncidentByCityAndType('Kalutara', 'Thunderstorm');
            $data['cities']['Kalutara']['Fire'] = $this->getIncidentByCityAndType('Kalutara', 'Fire');
            $data['cities']['Kalutara']['Other'] = $this->getIncidentByCityAndType('Kalutara', 'Other');
            $data['district'] = 'Kalutara';
        }
        else
        {
            dd('error district not found');
        }
//        dd($data);
        return view('public.district', $data);
    }

    public function getIncidentByCityAndType($city, $type)
    {
        $city_incidents = $this->incident->select(DB::raw('city, type, status, count(*) as number_of_incidents'))
            ->where('city',$city)
            ->where('status','approved')
            ->where('type', $type)
            ->groupBy('type')
            ->get();
        if(count($city_incidents) > 0)
        {
            return $city_incidents->toArray()[0]['number_of_incidents'];
        }
    }
}
