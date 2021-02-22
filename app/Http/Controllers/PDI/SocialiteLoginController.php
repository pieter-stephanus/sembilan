<?php
/*
 * This controller was modified from:
 * Source: https://andyyou.medium.com/laravel-8-integrate-jetstream-socialite-in-30-mins-8db0287a387f
 */

namespace App\Http\Controllers\PDI;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

use Laravel\Jetstream\Jetstream;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Team;
use Exception;

class SocialiteLoginController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Redirect to authentication page based on $provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(string $provider)
    {
        try {
            $scopes = config("services.$provider.scopes") ?? [];
            if (count($scopes) === 0) {
                return Socialite::driver($provider)->redirect();
            } else {
                return Socialite::driver($provider)->scopes($scopes)->redirect();
            }
        } catch (\Exception $e) {
            // abort(404);
            return redirect('/')->withErrors(['authentication_deny' => 'Unable to contact' . ucfirst($provider) . '. Please try again.']);
        }
    }

    /**
     * Obtain the user information from $provider
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(string $provider)
    {
        try {
            $data = Socialite::driver($provider)->user();
            return $this->handleSocialUser($provider, $data);
        } catch (\Exception $e) {
            dd($e);
            return redirect('/')->withErrors(['authentication_deny' => 'Login with ' . ucfirst($provider) . ' failed. Please try again.']);
        }
    }

    /**
     * Handles the user's information and creates/updates
     * the record accordingly.
     *
     * @param string $provider
     * @param object $data
     * @return \Illuminate\Http\Response
     */
    public function handleSocialUser(string $provider, object $data)
    {
        $user = User::where([
            "social->{$provider}->id" => $data->id,
        ])->first();

        if (!$user) {
            $user = User::where([
                'email' => $data->email,
            ])->first();
        }

        if (!$user) {
            return $this->createUserWithSocialData($provider, $data);
        }

        // update social id and token
        $social = (array) json_decode($user->social);
        $social[$provider] = [
            'id' => $data->id,
            'token' => $data->token
        ];
        $user->social = json_encode($social);
        // update profile pictures
        if (Jetstream::managesProfilePhotos()) {
            $input = $this->getSocialAvatar($data);
            if (isset($input)) {
                $user->profile_photo_path = $input;
            }
        }
        $user->save();

        return $this->socialLogin($user);
    }

    /**
     * Create user
     *
     * @param string $provider
     * @param object $data
     * @return \Illuminate\Http\Response
     */
    public function createUserWithSocialData(string $provider, object $data)
    {
        try {
            $user = new User;
            $user->email = $data->email;
            $user->name = $data->name;
            $user->password = Hash::make('Nusantara17!*');
            // encode id and token into json column type
            $user->social = json_encode([
                $provider => [
                    'id' => $data->id,
                    'token' => $data->token,
                ],
            ]);
            // update profile pictures
            if (Jetstream::managesProfilePhotos()) {
                $input = $this->getSocialAvatar($data);
                if (isset($input)) {
                    $user->profile_photo_path = $input;
                }
            }
            // markEmailAsVerified() contains save() behavior
            $user->markEmailAsVerified();
            if (Jetstream::hasTeamFeatures()) {
                $team = Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => $user->name . "'s Team",
                    'personal_team' => true,
                ]);
                $user->current_team_id = $team->id;
            }
            $user->save();
            return $this->socialLogin($user);
        } catch (Exception $e) {
            return redirect('/')->withErrors(['authentication_deny' => 'User registration with ' . ucfirst($provider) . ' failed. Please try again.']);
        }
    }

    protected function getSocialAvatar(object $data)
    {
        $fileContents = file_get_contents($data->getAvatar());
        if (isset($fileContents)) {
            $filename = $data->getId();
            $path = "\\public\\profile-photos\\" . $filename;
            $result = Storage::put($path, $fileContents);
            if (isset($result)) {
                return 'profile-photos/' . $filename;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Log the user in
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function socialLogin(User $user)
    {
        auth()->loginUsingId($user->id);
        if ($user->two_factor_secret) {
            return view('auth.two-factor-challenge');
        } else {
            return redirect($this->redirectTo);
        }
    }
}
