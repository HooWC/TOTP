<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Models\Authenticator;
use App\Models\ProjectName;
use App\Models\User;
use App\Services\TOTPService;
use Illuminate\Http\Request;
use OTPHP\TOTP;

class AccountController extends Controller
{
    public static function getApiAuthenticator()
    {
        $dbs = User::with('authenticators')->get();

        $data = [];
        if ($dbs) {
            foreach ($dbs as $db) {
                $db->authenticators->each(function ($item) use ($db, &$data) {
                    $totp = TOTP::create($item->secret_key);
                    $item->authenticator_code = str_pad($totp->now(), 6, '0', STR_PAD_LEFT);
                    $data[] = [
                        'user' => $db,
                        'authenticatorCode' => $item,
                    ];
                });
            }
        }

        return $data;
    }

    public function getNewAuthenticator(Request $request)
    {
        $user_id = $request->input('user_id');
        $data = AccountController::getApiAuthenticator();

        usort($data, function ($a, $b) {
            return $b['authenticatorCode']->id - $a['authenticatorCode']->id;
        });

        $filteredData = array_filter($data, function ($item) use ($user_id) {
            return $item['user']->id === (int)$user_id;
        });

        return response()->json($filteredData);
    }

    public function getKeyCode()
    {
        // 要删除的代码  （生成虚拟密钥）
        // 获取虚拟的key

        $secret = TOTPService::generateSecret();
        return response()->json($secret);
    }

    public function deleteAuthenticatorFunction(Request $request)
    {
        try {
            $authenticatorID = $request->input('authenticatorID');
            $authenticator_code = Authenticator::find($authenticatorID);
            $authenticator_code->delete();
            return true;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function filterProjectName(Request $request)
    {
        $user_id = $request->input('user_id');

        $user = User::with('authenticators')->find($user_id);

        if ($user) {
            $existingNames = $user->authenticators->pluck('account_name')->toArray();

            $data = array_diff(ProjectName::pluck('name')->toArray(), $existingNames);
        } else {
            $data = ProjectName::pluck('name')->toArray();
        }

        return response()->json($data);
    }
}
