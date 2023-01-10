<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\IndexController;
use App\Http\Requests\DashboardRequest;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getUserId()
    {
        $user_id = auth()->user()->id;

        return $user_id;
    }

    public function dashboard()
    {
        $userStatus = new IndexController();

        $userName = $userStatus->getUserStatus();

        $user_id = $this->getUserId();

        $user_data = Dashboard::all();

        $userStatistic = $user_data->where('user_id', $user_id);

        return inertia('Statistic/Dashboard', compact('userName', 'userStatistic', 'user_data'));
    }

    public function create(DashboardRequest $request)
    {
        $users_test_info = $request->validated();
        dd($users_test_info);
        Dashboard::create($users_test_info);
    }

    public function details($id)
    {
        $user_id = $this->getUserId();

        $test_details = Dashboard::all();

        $test_details = $test_details->where('user_id', $user_id);

        $test_details = $test_details->find($id);

        $details = $this->getDetailsOfSpecificTest($test_details->words_ids, $test_details->true_ids);

        return inertia('Statistic/ViewMore', compact('test_details'));
    }

    public function getDetailsOfSpecificTest($words_ids, $true_ids)
    {
        $words_ids = explode(',', $words_ids);
        $true_ids = explode(',', $true_ids);

        return array($words_ids, $true_ids);
    }


}
