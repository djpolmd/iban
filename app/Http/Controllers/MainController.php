<?php

namespace App\Http\Controllers;

use App\Locality;
use App\RoleUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Illuminate\Support\Str;


class MainController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = User::all();

        return view('index')->withUsers($users);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function iban(Request $request)
    {
        $token = Auth()->user()->getToken();

        JavaScript::put([
            'api_token' => $token
        ]);

        return view('form');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post_form()
    {
        $user = Auth()->user();

        if ($user->getUserRole() !== 'admin')
            return redirect('home', 302);

        $token = $user->getToken();

        JavaScript::put([
            'api_token' => $token
        ]);

        return view('post');
    }

    public function new_user()
    {

        return view('users');
    }

    public function add_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required',
                'email',
                'unique:users'],
            'nume' => 'required',
            'prenume' => 'required',
            'locality' => 'required',
            'roles' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator->getMessageBag());
        }

        $new_user = new  User();
        $new_user->nume = $request->get('nume');
        $new_user->locality_id = Locality::where('cod3', '=', $request->get('locality'))->pluck('id')->first();
        $new_user->api_token = Str::random(60);
        $new_user->email = $request->get('email');
        $new_user->password = bcrypt($request->get('password'));
        $new_user->prenume = $request->get('prenume');
        $new_user->save();

        $new_role_users = new RoleUsers();
        $new_role_users->user_id = $new_user->id;
        $new_role_users->role_id = $request->get('roles');
        $new_role_users->updated_by = Auth()->user()->getAuthIdentifier();
        $new_role_users->save();

        $users = User::all();

        return view('index')->withUsers($users);
    }

    public function destroy(Request $request, $id)
    {
        if (User::find($id)->delete()) {
            $role = RoleUsers::where('user_id', $id);
            $role->delete();
            $url = '<a href="' . url('/') . '"> Go back </a>';
            return response('User a fost șters!'. $url ,200)
                ->header('Content-Type', 'text/html');
        } else
            return response('User - nu poate fi procesat!' . $url, 422)
                ->header('Content-Type', 'text/html');

            return response('User - cu acest id nu exista !'.  $url, 422)
            ->header('Content-Type', 'text/html');
    }

    public function edit_user(Request $request, $id)
    {
        $url = '<a href="' . url('/') . '"> Go back </a>';

        if ($user = User::find($id)) {
            $role = RoleUsers::where('user_id', $id);
        }
        return response('User - nu poate fi procesat!' . $url, 422)
            ->header('Content-Type', 'text/html');

        $validator = Validator::make($request->all(), [
            'email' => ['required',
                'email',
                'unique:users'],
            'nume' => 'required',
            'prenume' => 'required',
            'locality' => 'required',
            'roles' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails())
        {
            return back()->withInput()
                ->withErrors($validator->getMessageBag());
        }

        $user->nume = $request->get('nume');
        $user->locality_id = Locality::where('cod3', '=', $request->get('locality'))->pluck('id')->first();
        $user->api_token = Str::random(60);
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->prenume = $request->get('prenume');
        $user->save();

        $role_users = $role;
        $role_users->user_id = $new_user->id;
        $role_users->role_id = $request->get('roles');
        $role_users->updated_by = Auth()->user()->getAuthIdentifier();
        $role_users->save();
    }

    public function get_user(Request $request, $id)
    {
        $user = User::find($id);
        $role = $user->getUserRole();

        return view('users')
            ->withNume($user->nume)
            ->withPrenume($user->prenume)
            ->withLocality($user->locality)
            ->withApi_token($user->api_token)
            ->withEmail($user->email)
            ->withPassword($user->password)
            ->withUserid($user->id)
            ->withRoleid($role);
    }
}
