<?php


namespace App\Http\Controllers\Admin;


use App\Models\Client;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;





class UsersController extends CRUDController {
    /*public function __construct(Request $request) {
        parent::__construct();

        $permissions = Permission::pluck('name', 'id');
        $roles       = Role::pluck('name', 'id');

        $this->inject['permissions'] = $permissions;
        $this->inject['roles']       = $roles;

        $this->sync = [
            'permissions',
            'roles'
        ];

        if($request->input('password')) {
            $inputs = $request->input();
            $inputs['password'] = \Hash::make($request->input('password'));
            $request->replace($inputs);
        }
    }*/

    public function __construct(Request $request)
{
    parent::__construct();

    $permissions = Permission::pluck('name', 'id');
    $roles = Role::pluck('name', 'id');

    $this->inject['permissions'] = $permissions;
    $this->inject['roles'] = $roles;

    $this->sync = ['permissions', 'roles'];

    if ($request->filled('password')) {
        $plainPassword = $request->input('password');
        $inputs = $request->all();
        $inputs['password'] = \Hash::make($plainPassword);
        $inputs['_password_plain_for_email'] = $plainPassword;
        $request->replace($inputs);
    }
}


    public function create() {
        $this->inject['clients'] = Client::where('user_id', \Auth::id())->pluck('name', 'id');
        $this->inject['isCreate'] = true;
        return parent::create();
    }

    /*public function edit($id, $readonly = false) {

        $this->inject['clients'] = Client::where('user_id', \Auth::id())->pluck('name', 'id');
        return parent::edit($id, $readonly);
    }*/

    public function edit($id, $readonly = false)
{
    $user = \App\Models\User::findOrFail($id);
    $authUser = \Auth::user();


    if (!$authUser->hasRole('admin') && $authUser->id !== $user->id) {
        abort(403, 'Unauthorized action.');
    }


    $this->inject['clients'] = \App\Models\Client::where('user_id', $authUser->id)->pluck('name', 'id');


    if ($authUser->hasRole('admin')) {
        $this->inject['roles'] = \App\Models\Role::pluck('name', 'id');
        $this->inject['permissions'] = \App\Models\Permission::pluck('name', 'id');
    } else {
        // Hide roles/permissions from non-admins
        $this->inject['roles'] = collect(); // empty collection
        $this->inject['permissions'] = collect();
    }

    $this->inject['isCreate'] = false;

    return parent::edit($id, $readonly);
}

public function update(Request $request, $id)
{
    $request->request->remove('id');

    $authUser = \Auth::user();

    if (!$authUser->hasRole('admin')) {
        // Strip out sensitive fields for normal users
        $request->request->remove('roles');
        $request->request->remove('permissions');
    }

    // When admin sets a new password, email it to the user so they can log in
    if ($authUser->hasRole('admin') && $request->has('_password_plain_for_email')) {
        $user = User::findOrFail($id);
        $plainPassword = $request->input('_password_plain_for_email');
        $request->request->remove('_password_plain_for_email');

        try {
            $messageText =
                "Bonjour " . $user->name . ",\n\n" .
                "Votre mot de passe a été mis à jour par l'administrateur.\n\n" .
                "Votre nouveau mot de passe : " . $plainPassword . "\n\n" .
                "Vous pouvez vous connecter ici : " . url('/login') . "\n\n" .
                "Pour des raisons de sécurité, nous vous recommandons de le modifier après votre première connexion.";

            Mail::raw($messageText, function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Votre nouveau mot de passe - ' . config('app.name'));
                if (config('mail.from.address')) {
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                }
            });
        } catch (\Exception $e) {
            \Log::warning('Could not send new-password email to user ' . $user->id, [
                'error' => $e->getMessage(),
            ]);
        }
    }

    return parent::update($request, $id);
}

function getRedirectUrl()
{
    $authUser = \Auth::user();

    if (!$authUser) {
        // fallback
        return route('login');
    }

    if (!$authUser->hasRole('admin')) {
        return url('/admin'); // redirect normal users
    }

    // admin default
    return parent::getRedirectUrl();
}

 public function requestPasswordUpdateOld(Request $request)
{
    // try {
        $data = $request->validate([
            'url' => 'required|url'
        ]);

        $url = $data['url'];

        // Compose email body (simple, safe HTML)
        $body = '<p>Bonjour administrateur,</p>';
        $body .= '<p>Un utilisateur a demandé une mise à jour de son mot de passe. ';
        $body .= 'Cliquez sur le lien ci-dessous pour ouvrir la fiche :</p>';
        $body .= '<p><a href="' . e($url) . '">' . e($url) . '</a></p>';
        $body .= '<p>Envoyé par : ' . (Auth::check() ? e(Auth::user()->email) : 'Utilisateur non connecté') . '</p>';

        // Recipient (adjust to real admin email or lookup from DB)
        $adminEmail = config('mail.admin_address', 'danybergeron@courriersubitopresto.com');



        // }
}


public function requestPasswordUpdate(Request $request)
{
    $user = auth()->user();

    // Only non-admin users (e.g. clients, drivers) can request a password update
    if ($user->hasRole('admin')) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 403);
    }

    $suggestedPassword = trim((string) $request->input('suggested_password', ''));

    try {
        // $editUrl = url('/admin/users/' . $user->id . '/edit');

        $user->password = Hash::make($suggestedPassword);
        $user->save();
        $messageText =
            "Password mis à jour avec succès\n\n" .
            "Utilisateur: " . $user->name . "\n" .
            "Email: " . $user->email . "\n\n" .
            "L'utilisateur a mis à jour son mot de passe avec succès.";

        if ($suggestedPassword !== '') {
            $messageText .= "\n\nMot de passe indiqué par l'utilisateur : " . $suggestedPassword;
        }

        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name', config('app.name'));

        Mail::raw($messageText, function ($message) use ($fromAddress, $fromName) {
            $message->to('danybergeron@courriersubitopresto.com')
                ->bcc('jskrta@gmail.com')
                ->subject('Mise à jour du mot de passe');
            if ($fromAddress) {
                $message->from($fromAddress, $fromName);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Mise à jour du mot de passe réussie',
        ]);
    } catch (\Exception $e) {
        \Log::error('Password update request email failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        $message = 'Email failed';
        if (config('app.debug')) {
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => false,
            'message' => $message,
        ], 500);
    }

}



}
