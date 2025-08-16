<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function edit()
    {
        // Carrega tudo agrupado por "group" (opcional para renderização)
        $groups = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('configuracoes.settings', compact('groups'));
    }

    public function update(SettingUpdateRequest $request)
    {
        $payload = $request->validated();

        DB::transaction(function () use ($payload) {
            foreach ($payload['settings'] as $key => $value) {
                \App\Models\Setting::set($key, $value);
            }
        });

        return redirect()->route('config.settings.edit')->with('success', 'Parâmetros salvos com sucesso.');
    }
}
