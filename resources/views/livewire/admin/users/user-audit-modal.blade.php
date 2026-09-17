<div>
    @if($show)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="portal-modal-panel relative inline-block max-h-[calc(100vh-2rem)] overflow-y-auto bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:align-middle">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="portal-modal-title mb-4" id="modal-title">
                        Audit : {{ $nom }}
                    </h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Période</label>
                        <select wire:model.live="period" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm p-2">
                            <option value="7">7 derniers jours</option>
                            <option value="30">30 derniers jours</option>
                            <option value="90">90 derniers jours</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <h4 class="text-blue-800 font-semibold text-sm uppercase">Connexions</h4>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $login_count }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <h4 class="text-green-800 font-semibold text-sm uppercase">Activités Ajoutées</h4>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $activities_count }}</p>
                        </div>
                    </div>

                    <h4 class="font-medium text-gray-900 mb-2">Dernières connexions</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-500">Date</th>
                                    <th class="px-4 py-2 text-left text-gray-500">IP</th>
                                    <th class="px-4 py-2 text-left text-gray-500">Agent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_logs as $log)
                                    <tr>
                                        <td class="px-4 py-2">{{ $log->login_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2">{{ $log->ip_address }}</td>
                                        <td class="px-4 py-2 truncate max-w-xs" title="{{ $log->user_agent }}">{{ Str::limit($log->user_agent, 40) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">Aucune connexion récente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="close" class="portal-button-secondary mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
