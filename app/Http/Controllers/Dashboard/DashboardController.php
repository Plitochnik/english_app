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

        return inertia('Statistic/Dashboard', compact('userName', 'userStatistic'));
    }

    public function create(DashboardRequest $request)
    {
        $users_test_info = $request->validated();

        Dashboard::create($users_test_info);
    }

    public function details($id)
    {
        $user_id = $this->getUserId();

        $test_details = Dashboard::all();

        $test_details = $test_details->where('user_id', $user_id);

        $test_details = $test_details->find($id);

        $details = $this->getDetailsOfSpecificTest($test_details->test_word, $test_details->true_answer, $test_details->user_answer, $test_details->true_ids);

        $test_word = $details[0];
        $true_answer = $details[1];
        $user_answer = $details[2];
        $true_ids = $details[3];
        $true_counts = $test_details->true_answers;

        return inertia('Statistic/ViewMore', compact('test_word', 'true_answer', 'user_answer', 'true_ids', 'true_counts'));
    }

    public function getDetailsOfSpecificTest($test_word, $true_answer, $user_answer, $true_ids): array
    {
        $test_word = explode(',', $test_word);
        $true_answer = explode(',', $true_answer);
        $user_answer = explode(',', substr($user_answer, 0, -1));
        $true_ids = explode(',', substr($true_ids, 0, -1));

        return array($test_word, $true_answer, $user_answer, $true_ids);
    }


}
