<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * GET /configuracoes/parametros
     * Nome: config.settings.edit
     */
    public function edit()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('configuracoes.settings', compact('settings'));
    }

    /**
     * PUT /configuracoes/parametros
     * Nome: config.settings.update
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'settings' => 'array',
            'settings.*' => 'nullable',
            'brasao' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::transaction(function () use ($validatedData, $request) {
            // Processar o upload da imagem do brasão
            if ($request->hasFile('brasao')) {
                if ($oldBrasaoPath = Setting::where('key', 'casa.brasao_path')->first()) {
                    Storage::disk('public')->delete($oldBrasaoPath->value);
                    $oldBrasaoPath->delete();
                }

                $path = $request->file('brasao')->store('brasoes', 'public');
                Setting::updateOrCreate(
                    ['key' => 'casa.brasao_path'],
                    ['group' => 'casa', 'value' => $path]
                );
            }

            // Salvar os outros parâmetros
            $settingsToSave = $request->input('settings', []);
            
            // Lógica para o dropdown (sim ou não)
            $pauseOradorValue = $settingsToSave['temporizador.aparte.pausa_orador'] === '1' ? true : false;
            $settingsToSave['temporizador.aparte.pausa_orador'] = $pauseOradorValue;

            foreach ($settingsToSave as $key => $value) {
                if (in_array($key, ['_token', '_method'])) {
                    continue;
                }
                
                $group = explode('.', $key)[0] ?? 'geral';

                Setting::updateOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => $value]
                );
            }
        });

        return redirect()->back()->with('success', 'Parâmetros atualizados com sucesso.');
    }
}