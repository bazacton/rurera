<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\User;
use App\Models\QuestionAuthorPoints;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AuthorPointsController extends Controller {

    
    public function author_points(Request $request, $id) {
        $user = auth()->user();
        if($user->role_name == 'teachers' && $user->id != $id){
            $toastData = [
                'title' => 'Request not completed',
                'msg' => 'You dont have permissions to perform this action.',
                'status' => 'error'
            ];
            return redirect()->back()->with(['toast' => $toastData]);
        }
        $author_points = QuestionAuthorPoints::where('author_id', $id)->with('questions')->paginate(20);
        $author = User::find($id);
        $data = [
            'pageTitle' => 'Author Points',
            'author_points' => $author_points,
            'author' => $author,
        ];

        return view('admin.author_permissions.author_points', $data);
    }
}
        