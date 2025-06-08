<?php

namespace App\Http\Controllers\Web\BackEnd\Setting;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\UpdateGeneralSettingRequest;
use App\Models\Setting;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class GeneralSettingController extends Controller
{
    public function index(): View
    {
        $setting = Setting::pluck('value', 'key');

        return view('pages.settings.general.index', [
            'title' => 'Setting',
            'setting' => $setting,
        ]);
    }

    public function update(UpdateGeneralSettingRequest $request)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_SETTING_GENERAL->value);

            $settings = $request->validated()['settings'];

            foreach ($settings as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            return redirect()->back()->with('success', 'General settings updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error('Authorization failed for updating general settings', [
                'user_id' => Auth::id(),
                'error' => $authorizationException->getMessage()
            ]);
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Failed to update general settings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'Failed to update general settings. ' . $e->getMessage());
        }
    }
}
