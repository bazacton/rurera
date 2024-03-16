<?php
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\Category;
use App\Models\Subscribe;
use App\Models\Comment;
use App\Models\Gift;
use App\Models\Meeting;
use App\Models\ReserveMeeting;
use App\Models\Sale;
use App\Models\Support;
use App\Models\UserAssignedTopics;
use App\Models\Webinar;
use App\Models\ParentsOrders;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class MembersController extends Controller
{

    public function index()
    {

        $user = getUser();
        $male_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"1","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"0","mustache":"0","beard":"0","nose":"0"},"avatar_color_settings":{"backs":"#000000","humanbody":"#f0c7b1","clothes":"#386e77","hair":"#2a232b","ears":"#f0c7b1","faceshape":"#f0c7b1","chinshadow":"#f0c7b1","facehighlight":"#f0c7b1","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#da7c87","nose":"#f0c7b1"}}';
        $female_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"8","chinshadow":"8","facehighlight":"0","humanbody":"0","clothes":"8","hair":"7","ears":"3","eyebrows":"2","eyesback":"2","eyesiris":"2","eyesfront":"2","glasses":"0","mouth":"2","nose":"5"},"avatar_color_settings":{"backs":"#40c0cb","humanbody":"#ecc4b8","clothes":"#152c5e","hair":"#4e4341","ears":"#ecc4b8","faceshape":"#ecc4b8","chinshadow":"#ecc4b8","facehighlight":"#ecc4b8","eyebrows":"#4e4341","eyesback":"#000000","eyesfront":"#0f190c","eyesiris":"#4d3623","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#c90433","nose":"#ecc4b8"}}';

        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isParent()) {
            return redirect('/panel');
        }
        if (auth()->user()->isParent()) {

            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->with([
                    'userSubscriptions' => function ($query) {
                        $query->with(['subscribe']);
                    }
                ])
                ->get();

            $Sales = Sale::where('buyer_id', $user->id)->whereIn('type', array(
                'subscribe',
                'plan_expiry_update',
                'plan_update'
            ))->get();


            $ParentsOrders = ParentsOrders::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();


            $time_zones = User::$timeZones;
            $frequencyArray = ParentsOrders::$frequencyArray;

            $data['userObj'] = $user;

            $data['childs'] = $childs;
            $data['time_zones'] = $time_zones;
            $data['countries_list'] = User::$countriesList;

            $data['ParentsOrders'] = $ParentsOrders;
            $data['frequencyArray'] = $frequencyArray;
            $data['Sales'] = $Sales;
            $frequency_discounts = array(
                1 => 0,
                3 => 5,
                6 => 10,
                12 => 20,
            );
            $data['frequency_discounts'] = $frequency_discounts;


            $categories = Category::where('parent_id' , null)
                       ->with('subCategories')
                       ->get();
            $subscribes = Subscribe::all();
            $data['subscribes'] = $subscribes ?? [];
            $data['pageTitle'] = 'Members';
            $data['categories'] = $categories;
            //pre($categories);

            return view(getTemplate() . '.panel.parent.dashboard', $data);
            //return view(getTemplate() . '.panel.dashboard.index', $data);
        }
    }

    public function billing()
    {

        $user = getUser();
        $male_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"1","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"0","mustache":"0","beard":"0","nose":"0"},"avatar_color_settings":{"backs":"#000000","humanbody":"#f0c7b1","clothes":"#386e77","hair":"#2a232b","ears":"#f0c7b1","faceshape":"#f0c7b1","chinshadow":"#f0c7b1","facehighlight":"#f0c7b1","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#da7c87","nose":"#f0c7b1"}}';
        $female_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"8","chinshadow":"8","facehighlight":"0","humanbody":"0","clothes":"8","hair":"7","ears":"3","eyebrows":"2","eyesback":"2","eyesiris":"2","eyesfront":"2","glasses":"0","mouth":"2","nose":"5"},"avatar_color_settings":{"backs":"#40c0cb","humanbody":"#ecc4b8","clothes":"#152c5e","hair":"#4e4341","ears":"#ecc4b8","faceshape":"#ecc4b8","chinshadow":"#ecc4b8","facehighlight":"#ecc4b8","eyebrows":"#4e4341","eyesback":"#000000","eyesfront":"#0f190c","eyesiris":"#4d3623","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#c90433","nose":"#ecc4b8"}}';

        if (auth()->user()->isParent()) {

            $Sales = Sale::where('buyer_id', $user->id)->whereIn('type', array(
                            'subscribe',
                            'plan_expiry_update',
                            'plan_update'
                        ))->get();
            $data['Sales'] = $Sales;
            $data['pageTitle'] = 'Billing';
            return view(getTemplate() . '.panel.parent.billing', $data);
        }
    }

    public function change_password()
    {

        $user = getUser();
        $male_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"1","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"0","mustache":"0","beard":"0","nose":"0"},"avatar_color_settings":{"backs":"#000000","humanbody":"#f0c7b1","clothes":"#386e77","hair":"#2a232b","ears":"#f0c7b1","faceshape":"#f0c7b1","chinshadow":"#f0c7b1","facehighlight":"#f0c7b1","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#da7c87","nose":"#f0c7b1"}}';
        $female_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"8","chinshadow":"8","facehighlight":"0","humanbody":"0","clothes":"8","hair":"7","ears":"3","eyebrows":"2","eyesback":"2","eyesiris":"2","eyesfront":"2","glasses":"0","mouth":"2","nose":"5"},"avatar_color_settings":{"backs":"#40c0cb","humanbody":"#ecc4b8","clothes":"#152c5e","hair":"#4e4341","ears":"#ecc4b8","faceshape":"#ecc4b8","chinshadow":"#ecc4b8","facehighlight":"#ecc4b8","eyebrows":"#4e4341","eyesback":"#000000","eyesfront":"#0f190c","eyesiris":"#4d3623","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#c90433","nose":"#ecc4b8"}}';

        if (auth()->user()->isParent()) {

           $data['pageTitle'] = 'Change Password';
           return view(getTemplate() . '.panel.parent.change_password', $data);

        }
    }


}
