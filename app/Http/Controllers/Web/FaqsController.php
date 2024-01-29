<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FaqsController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            'pageTitle'                  => 'FAQs',
        ];
        return view('web.default.faqs.index', $data);

    }


}
