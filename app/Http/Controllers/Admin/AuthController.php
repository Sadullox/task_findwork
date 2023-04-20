<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends AdminController
{

    public function login(Request $request) {

        $admin = Admin::where('login', $request->login)->first();

        if (!$admin || !Hash::check($request->password, $admin->password))
            $this->sendError([],"Bu login mavjudemas", 401);


        $tokenResult = $admin->createToken('admin', ['admin']);
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addHours(env('PANEL_JWT_TTL', 10080));
        $token->save();

        $tokens = $admin->tokens;

        foreach ($tokens as $value) {
            if ($tokenResult->token->id != $value->id && $value->name === 'admin') {
                $value->delete();
            }
        }

        $admin = $admin->selectRaw(" 
            id,
            given_names,
            sur_name,
            login,
            TO_CHAR(created_at, 'MM.DD.YYYY') created_date
        ")->first();

        return $this->sendResponse([
            "token_type"    => "Bearer ",
            'access_token' => $tokenResult->accessToken,
            "expires_in"    => (int) env('PANEL_JWT_TTL', 10080),
            'user' => $admin
        ],
            __("messages.login_success"),
            200
        );
    }

    public function me(Request $request)
    {
        $user = auth("admin")->user()
        ->selectRaw("   
            id,
            given_names,
            sur_name,
            login,
            TO_CHAR(created_at, 'MM.DD.YYYY') created_date
        ")
        ->first();

        return $this->sendResponse($user);
    }
}
